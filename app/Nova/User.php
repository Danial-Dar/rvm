<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Hidden;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphToMany;
use App\Nova\Actions\Users\UserStats;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Actions\Users\ActivateUser;
use App\Nova\Actions\Users\UpdateSendLimit;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

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

    // public static function additionalButtons()
    // {
    //     return [['component' => 'ImportCsv'], ['component' => 'ExportCsv']];
    // }

    public function title()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == 'company') {
            return $query->where('company_id', $request->user()->company_id)->Where('role','user');
        }

        return $query->where('role','user');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make('Avatar', 'user_image_path')->maxWidth(50),

            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255'),

                Text::make('Last Name', 'last_name')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Company', 'company', Company::class),

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
            Text::make('Role', 'role')->hideWhenCreating()->hideWhenUpdating()->default('user'),
            Hidden::make('Role', 'role')->default('user'),
            Hidden::make('Status', 'status')->default('1'),
            MorphToMany::make('Roles', 'roles', Role::class),
            BelongsToMany::make('Teams','teams', Team::class),
            // Text::make('Status','status',function(){
            //     return $this->status === "0" ? 'Inactive' : 'Active';
            // })->hideWhenCreating()->hideWhenUpdating(),
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
        return [
            (new ActivateUser())->showInline()->withoutConfirmation()->canSee(function ($request) {
                return $request->user()->role == 'admin';
            })->canRun(function ($request, $model) {
                return $model->status == '0';
            }),
            (new UpdateSendLimit())->showInline()->canSee(function ($request) {
                return $request->user()->role == 'admin';
            })->canRun(function ($request, $model) {
                return $model->status == '1';
            }),
            (new UserStats())->withoutConfirmation()->showInline()->canSee(function ($request) {
                return $request->user()->role == 'admin';
            })->canRun(function ($request, $model) {
                return true;
            }),
        ];
    }
}
