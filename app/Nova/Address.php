<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Place;
use Rvm\Scripts\Scripts;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\DynamicSelect;
use Laravel\Nova\Nova;
//
//use Alvinhu\ChildSelect\ChildSelect;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
//use NovaAjaxSelect\AjaxSelect;
//use Manmohanjit\BelongsToDependency\BelongsToDependency;



class Address extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Address::class;

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

           /* DynamicSelect::make('Country', 'country')
                ->options(['US' => 'United States', 'UK' => 'United Kingdom'])
                ->rules('required')
            ,

            DynamicSelect::make('Provider', 'provider')
                ->options(['PR' => 'Premium', 'ST' => 'Standard'])
                ->rules('required')
            ,

            DynamicSelect::make('Product', 'product')
                ->dependsOn(['country', 'provider'])
                ->options(function($values) { 
                    if($values['country'] === 'UK' && $values['provider'] === 'PR') {
                        return ['A' => 'Fast shipping', 'B' => 'Normal shipping', 'C' => 'Free shipping'];
                    } else {
                        return ['A' => 'Fast shipping', 'B' => 'Normal shipping'];
                    }
                })
                ->rules('required')
            ,*/

           /* Select::make('Country')
                ->options(Country::all()->mapWithKeys(function ($country) {
                    return [$country->id => $country->name];
                }))
                ->rules('required'),*/
/*
                BelongsToDependency::make('Sate')
        ->dependsOn('country', 'country_id'),
*/
            /*ChildSelect::make('State')
                ->parent('state')
                ->options(function ($value) { 
                   // return [1 => "dd"];
                    State::where("country_id",1)->get()->mapWithKeys(function ($city) {
                        return [$city->id => $city->name];
                    });
                })
                ->rules('required'),*/
/*Select::make('Country')
    ->options([]),*/
               // AjaxSelect::make('State'),
    //->get('api/country/1/states')
    //->parent('country'),

//AjaxSelect::make('City'),
   // ->get('/api/state/{state}/cities')
   // ->parent('state'),
//Gravatar::make()->maxWidth(50),
Text::make('Description', 'description')->size('w-full')->sortable()->rules('required')->hideFromIndex(),

            Text::make('First Name', 'first_name')->size('w-1/2')->filterable()->sortable(),
            Text::make('Last Name', 'last_name')->size('w-1/2')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),

            Text::make('Company', 'company_name')->size('w-full')->sortable()->rules('required', 'alpha'),




            Text::make('Address Line 1', 'address')->size('w-full')->sortable()->rules('required')->hideFromIndex(),
            Text::make('Address Line 2', 'address2')->size('w-full')->sortable()->hideFromIndex(),


            Text::make('City', 'city')->size('w-1/2')->filterable()->sortable(),
            Text::make('State', 'state')->size('w-1/2')->filterable()->sortable()->hideFromIndex(),

            Select::make('Country')
                ->options(Country::all()->mapWithKeys(function ($country) {
                    return [$country->id => $country->name];
                }))
                ->rules('required')->size('w-1/2')->searchable()->hideFromIndex(),

                Text::make('Zip code', 'zip')->size('w-1/2')->filterable()->sortable()->hideFromIndex(),

                Text::make('Phone Number', 'phone_number')->size('w-1/2')->filterable()->sortable(),
            Text::make('Email Address', 'email')->size('w-1/2')->filterable()->sortable(),

            /*Select::make('Size', 'size')->searchable()->options([
                '4x6' => '4x6',
                '6x9' => '6x9',
                '6x11' => '6x11',
            ])->size('w-1/4')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),

            Select::make('TO', 'to')->searchable()->options([
                '4x6' => '4x6',
                '6x9' => '6x9',
                '6x11' => '6x11',
            ])->size('w-1/4')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),

            Select::make('From', 'from')->searchable()->options([
                '4x6' => '4x6',
                '6x9' => '6x9',
                '6x11' => '6x11',
            ])->size('w-1/4')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),


            Text::make('Name','name')->sortable()->rules('required', 'min:3', 'max:30', function($attribute, $value, $fail) {
                if(preg_match('/[^a-z0-9 _]+/i', $value)) {
                    return $fail('Special Characters Are Not Allowed.');
                }
            }),*/


            
            
            Hidden::make('user_id', 'user_id')->default($request->user()->id),
            // BelongsTo::make('Company')->sortable(),
            Hidden::make('company_id', 'company_id')->default($request->user()->company_id),
            Date::make('Created At', 'created_at')->sortable()->hideWhenCreating()->hideWhenUpdating(),
            // Textarea::make('Body','body')->rules(['required', 'min:20', 'max:1000'])
            //Scripts::make('Body', 'body'),
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
}
