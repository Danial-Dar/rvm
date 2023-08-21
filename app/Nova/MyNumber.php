<?php

namespace App\Nova;

use App\Models\IncomingCallLog;
use App\Nova\Metrics\NumbersTotal;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use YieldStudio\NovaPhoneField\PhoneNumber;
use Illuminate\Support\Facades\Cache;

class MyNumber extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MyNumber::class;

    public static $group = 'Voice';

    public static function label() {
        return 'Numbers';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','number','name',
    ];

    public static function additionalButtons(){
        if(request()->user() && request()->user()->can('purchase-number'))
            return [['component' => 'PurchaseNumber']];
        return [];
    }
    public static function additionalActions()
    {
        // if(request()->user() && request()->user()->can('edit-number'))
        //     // return [['component' => 'number-config']];
            return [['component' => 'edit-number-button']];
        // return [];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            // Text::make('Caller ID', 'number'),
            // Text::make('Forward Number', 'forward_to_number'),
            Text::make('Name')->onlyOnIndex(),
            Text::make('Description')->onlyOnIndex(),
            PhoneNumber::make('Caller ID', 'number'),
            PhoneNumber::make('Forward Number', 'forward_to_number'),
            Text::make('Number Of Calls', function(){
                $debug = \Config::get('app.env');
                $id = $this->id;
                $raw_number = $this->raw_number;
                $number = Cache::remember($debug.'number'.$this->id,60000, function() use($raw_number, $id){
                    return IncomingCallLog::where('To', $raw_number)->count();
                });
                return $number;
            }),

            // Hidden::make('Forward to number', 'forward_to_number'),
            Badge::make('Status', 'status')->map([
                'active' => 'success',
                'deleted' => 'danger'
            ]),
            Boolean::make('Ivr Status', 'ivr_enabled'),
            // Date::make('Created At', function () {
            //     return Carbon::createFromFormat('Y-m-d H:i:s', date($this->created_at))->format('m-d-y H:i:s');
            // }),
            Date::make('Created At','created_at')->hideWhenCreating()->hideWhenUpdating(),
            // Badge::make('Type', 'type')->map(
            //     [
            //         'CallzyOwned' => 'success',
            //         'uploaded' => 'success',
            //         'csv' => 'warning',
            //         'ClientNumber' => 'warning',
            //         'CALLZY OWNED' => 'success',
            //         'individual' => 'info'
            //     ]
            // )
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new NumbersTotal,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == "company") {
            return $query->where('company_id', $request->user()->company_id);
        }
        if ($request->user()->role == "user") {
            return $query->where('user_id', $request->user()->id);
        }
        return $query;
    }
}
