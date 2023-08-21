<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Hidden;

class Phrase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Phrase::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
       
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

            Text::make('Phrase', 'title')->rules('required'),

            // BelongsTo::make('Scorecard')->rules('required'),

            Text::make('Minimum Count', 'min_count')->rules('required'),

            Select::make('Speaker')->options([
                'agent' => 'Agent',
                'contact' => 'Contact',
                'both' => 'Both',
            ])->displayUsingLabels()->hideFromIndex()->rules('required'),

            Select::make('Flag Type')->options([
                'banned' => 'Banned',
                'required' => 'Required',
                'good' => 'Good',
                'nsfw' => 'NSFW'
            ])->displayUsingLabels()->hideFromIndex()->rules('required'),

            Boolean::make('Reviewable', 'is_reviewable')->hideFromIndex(),
            Boolean::make('Non Scoreable', 'is_non_scrolable')->hideFromIndex(),
            Boolean::make('Force Review', 'is_force_review')->hideFromIndex(),
            
            Text::make('First X', 'first_x')->hideFromIndex()->rules('required'),
            Text::make('Last X', 'last_x')->hideFromIndex()->rules('required'),

            Select::make('Time')->options([
                'seconds' => 'Seconds',
                'percent' => 'Percent'
            ])->displayUsingLabels()->hideFromIndex()->rules('required'),

            // MorphToMany::make('Component'),
            // BelongsToMany::make('Component','component'),

            Hidden::make('userid', 'user_id')->default($request->user()->id)

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
    public static function additionalButtons()
    {
        // if (auth()->check() && Nova::user()->can('create-contact-list')) {

        // return [
        //     [
        //         'component' => 'CreatePhrase',
        //     ],
        // ];
        // }
        // else {
        //     return [
        //         [
        //             'component' => 'CreatePhrase',
        //         ],
        //     ];
        // }
    }
}
