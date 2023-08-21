<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Hidden;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PredictiveAgent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Predictive\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'first_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'email', 'last_name',
    ];
    public static function label() {
        return 'Agents';
    }
    public function title()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == 'company') {
            return $query->where('company_id', $request->user()->company_id)->Where('role', 'agent');
        }

        return $query->where('role','agent');
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
            // ID::make()->sortable(),
            // BelongsTo::make('User'),
            // Text::make('Current Token', 'current_token')->hideFromIndex(),
            // BelongsTo::make('Campaign')->withoutTrashed(),
            // Select::make('Status')->options([
            //     'active' => 'Active',
            //     'paused' => 'Paused',
            //     'incall' => 'Incall',
            //     'onhold' => 'Onhold',
            //     'dead' => 'Dead'
            // ])->displayUsingLabels(),
            // Text::make('Reporting Message', 'reporting_message'),


            ID::make()->sortable(),

            Gravatar::make('Avatar', 'user_image_path')->maxWidth(50),

            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255', 'alpha_num'),

                Text::make('Last Name', 'last_name')
                ->sortable()
                ->rules('required', 'max:255'),

            // BelongsTo::make('Company', 'company', Company::class),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
            Badge::make('Status', function () {
                return $this->status === '0' ? 'Inactive' : 'Active';
            })->map([
                'Inactive' => 'danger',
                'Active' => 'success',
            ])->hideWhenCreating()->hideWhenUpdating(),
            Text::make('Role', 'role')->hideWhenCreating()->hideWhenUpdating()->default('agent'),
            Hidden::make('Role', 'role')->default('agent'),
            Hidden::make('Status', 'status')->default('1'),
            Hidden::make('Company', 'company_id')->default($request->user()->company_id),
            // MorphToMany::make('Roles', 'roles', Role::class),
            BelongsToMany::make('Teams','teams', Team::class),
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
