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
use Laravel\Nova\Fields\File;
use Laravel\Nova\Nova;
//
//use Alvinhu\ChildSelect\ChildSelect;
use App\Models\Address;
use App\Models\City;
use App\Models\State;


class PostCard extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PostCard::class;

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

            Select::make('Use Type', 'use_type')->searchable()->options([
                'marketing' => 'Marketing',
                'operational' => 'Operational',
            ])->size('w-full')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),

            Text::make('Description', 'description')->size('w-1/2')->sortable()->rules('required'),

            Select::make('Size', 'size')->searchable()->options([
                '4x6' => '4x6',
                '6x9' => '6x9',
                '6x11' => '6x11',
            ])->size('w-1/2')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),

          /* Select::make('To', 'to')->searchable()
            ->options(Address::all()->mapWithKeys(function ($country) {
                    return [$country->id => $country->description];
                }))->size('w-1/2')->filterable()->sortable(),*/



                 Select::make('To', 'Tooo->address')->searchable()
            ->options(Address::all()->pluck('description', 'id'),
                    function () {
                        return $this->to;
                    })->size('w-1/2')->filterable()->sortable(),


            // BelongsTo::make('User')->sortable(),

            Select::make('From', 'Fromd->address')->searchable()
            ->options(Address::all()->mapWithKeys(function ($country) {
                    return [$country->id => $country->description];
                }))->size('w-1/2')->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),


            /*Text::make('Name','name')->sortable()->rules('required', 'min:3', 'max:30', function($attribute, $value, $fail) {
                if(preg_match('/[^a-z0-9 _]+/i', $value)) {
                    return $fail('Special Characters Are Not Allowed.');
                }
            }),*/

            File::make('Front','front')->disk('public')->size('w-1/2')->acceptedTypes('image/png'),
            File::make('Back','back')->disk('public')->size('w-1/2')->acceptedTypes('image/png'),


            
            
            Hidden::make('user_id', 'user_id')->default($request->user()->id),
            // BelongsTo::make('Company')->sortable(),
            Hidden::make('company_id', 'company_id')->default($request->user()->company_id),
            Date::make('Created At', 'created_at')->sortable()->hideWhenCreating()->hideWhenUpdating(),

             File::make('postcard','pdf')->disk('public')->sortable()->hideWhenCreating()->hideWhenUpdating(),


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
        return [
            /*(new CallerIdDownloadList())->confirmText('Are you sure you want to export!')->canRun(function ($request) {
                return true;
            }),*/
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        // return $query->where('to', $request->id);
    }

    public function update(NovaRequest $request)
    {
        
            return false;
        
    }
}
