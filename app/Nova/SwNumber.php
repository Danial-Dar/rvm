<?php

namespace App\Nova;

use App\Models\IncomingCallLog;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use YieldStudio\NovaPhoneField\PhoneNumber;

class SwNumber extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SwNumber::class;

    public static $group = 'Voice';

    public static function label() {
        return 'Callzy Numbers';
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
        'id','friendly_name','phone_number',
    ];

    public static function additionalButtons(){
        if(request()->user()){
            if (request()->user()->can('upload-callzy-number') && request()->user()->can('purchase-callzy-number')) {
                return [['component' => 'ImportCallzyNumberCsvBox'], ['component' => 'PurchaseNumber']];
            }
            if (request()->user()->can('purchase-callzy-number')){
                return [['component' => 'PurchaseNumber']];
            }
            if (request()->user()->can('upload-callzy-number')){
                return [['component' => 'ImportCallzyNumberCsvBox']];
            }
        }
        return [];
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
            Text::make('Name'),
            Text::make('Description'),
            // Text::make('Caller Id', 'friendly_name'),
            PhoneNumber::make('Caller Id', 'friendly_name'),
            Select::make('Status')->options([
                'active' => 'Active',
                'deleted' => 'Deleted',
            ])->displayUsingLabels()->hideFromIndex()->rules('required'),

            Number::make('Number of calls', 'number_of_calls')->sortable(true),
            // Text::make('Number of calls', function() {
            //     return IncomingCallLog::where("To", $this->phone_number)->count();
            // })->sortable(function() {
            //     return IncomingCallLog::where("To", $this->phone_number)->count();
            // }),
            Badge::make('Status')->map([
                'active' => 'success',
                'deleted' => 'danger'
            ])->sortable(),
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
        return [];
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
        return $query->orderBy('number_of_calls', 'desc');
    }
}
