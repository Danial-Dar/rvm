<?php

namespace App\Nova;

use App\Nova\Filters\Category;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use YieldStudio\NovaPhoneField\PhoneNumber;

class Contact extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contact::class;

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
        'id',
    ];

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
            PhoneNumber::make('Number', 'number')->rules('required'),
            Select::make('Category', 'category')->options([
                'CAP = FIXED'=>'CAP = FIXED',
                'CLEC = FIXED'=>'CLEC = FIXED',
                'GENERAL = FIXED'=>'GENERAL = FIXED',
                'IC = FIXED'=>'IC = FIXED',
                'ILEC = FIXED'=>'ILEC = FIXED',
                'INTL = International'=>'INTL = International',
                'IPES = VOIP'=> 'IPES = VOIP',
                'L RESELLER'=>'L RESELLER',
                'PCS = FIXED'=>'PCS = FIXED',
                'RBOC = FIXED'=>'RBOC = FIXED',
                'ULEC = FIXED'=>'ULEC = FIXED',
                'W RESELLER = Mobile'=>'W RESELLER = Mobile',
                'WIRELESS = Mobile'=>'WIRELESS = Mobile'
            ])->rules('required'),
            // Badge::make('Status', 'status')->map([
            //     'active' => 'success',
            //     'deleted' => 'danger'
            // ])->required(),
            Hidden::make('status', 'status')->default('active'),
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
        return [new Category()];
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
}
