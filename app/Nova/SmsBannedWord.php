<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Http\Requests\NovaRequest;

class SmsBannedWord extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SmsBannedWord::class;
    public static $group = 'SMS';

    public static function label()
    {
        return 'Banned Words';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'word';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'word', 'section',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->hideFromDetail(),
            Text::make('Word', 'word')->sortable()->rules('required', 'max:255', function($attribute, $value, $fail) {
                if(preg_match('/[^a-z0-9 _]+/i', $value)) {
                    return $fail('Special Characters Are Not Allowed.');
                }
            }),
            Select::make('Section')->searchable()->options([
                'inbound' => 'Inbound',
                'outbound' => 'OutBound',
            ])->filterable()->sortable(),
            // BelongsTo::make('User')->sortable(),
            Hidden::make('user_id', 'user_id')->default($request->user()->id),
            // BelongsTo::make('Company')->sortable(),
            Hidden::make('company_', 'company_id')->default($request->user()->company_id),
            Date::make('Created At', 'created_at')->sortable()->hideWhenCreating()->hideWhenUpdating(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
