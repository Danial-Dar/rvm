<?php

namespace App\Nova;

use App\Nova\Actions\UploadDNC;
use App\Nova\Metrics\TotalDnc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use YieldStudio\NovaPhoneField\PhoneNumber;

class DNC extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\DNC::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $group = 'Voice';


    public static function label(){
        return 'DNC';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','number','company_id','user_id','user_type',
    ];

    public static function additionalButtons()
    {
        $user = Nova::user();
        if($user && $user->can('upload-dnc')) {
            return [[
                // 'component' => 'UploadDnc'
                'component' => 'UploadDncCsvBox'
            ]];
        }
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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            // Text::make('Number', 'number')
            //     ->sortable()
            //     ->rules('required', 'max:11', 'min:10'),

            PhoneNumber::make('Number', 'number')->sortable()->rules('required', function($attribute, $value, $fail) {
                // if (strtoupper($value) !== $value) {
                //     return $fail('The '.$attribute.' field must be uppercase.');
                // }
                $raw_number = preg_replace('/[^0-9]/', '', $value);

                if (strlen($raw_number) <= 10  || strlen($raw_number) < 11) {
                    return $fail('The '.$attribute.' field is not complete.');
                }
            }),

            // BelongsTo::make('User'),

            // BelongsTo::make('Company'),

            Badge::make('Method', 'upload_type')->map([
                'CSV Upload' => 'success',
                'IVR' => 'warning',
                'API' => 'info',
                'Individual' => 'info'
            ]),

            Hidden::make('Upload type','upload_type')->default('Individual'),

            BelongsTo::make('User')->default($request->user()->id)->onlyOnIndex()->canSee(function ($request) {
                return $request->user()->type == 'admin';
            }),

            BelongsTo::make('Company')->default($request->user()->company_id)->onlyOnIndex()->canSee(function ($request) {
                return $request->user()->type == 'admin';
            }),

            Text::make('Created', function () {
                return Carbon::createFromFormat('Y-m-d H:i:s', date($this->created_at))->format('m/d/Y h:i:s a');
            })->onlyOnIndex(),
            Date::make('Created At')->hideFromIndex()->filterable()->hideWhenCreating()

            // Select::make('User Type')->options([
            //     'user' => 'User',
            //     'admin' => 'Admin',
            //     'company' => 'Company Admin',
            // ])->displayUsingLabels(),
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
            (new TotalDnc)
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
        // return [new UploadDNC];
        return [];
    }
}
