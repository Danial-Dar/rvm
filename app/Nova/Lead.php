<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rvm\NovaPhoneNumber\NovaPhoneNumber;

class Lead extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Lead::class;

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
            Hidden::make('userid', 'user_id')->default($request->user()->id),
            Hidden::make('companyid', 'company_id')->default($request->user()->company_id),
            Text::make('Name', 'name')->rules('required', 'max:255'),
            BelongsTo::make('List', 'list', LeadList::class),
            Text::make('email', 'email'),
            Text::make('Address', 'address')->hideFromIndex(),
            Text::make('Second Address', 'address_2')->hideFromIndex(),
            NovaPhoneNumber::make('Phone Number', 'phone_number')->hideFromIndex(),
            Text::make('City', 'city')->hideFromIndex(),
            Text::make('State', 'state')->hideFromIndex(),
            Textarea::make('Custom Fields', 'custom_fields'),
        ];
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

    public static function additionalButtons(){
        // if(request()->user() && request()->user()->can('create-lead')){
        //     return [['component' => 'CreateLead']];
        // }
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
}
