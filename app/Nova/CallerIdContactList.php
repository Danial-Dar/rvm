<?php

namespace App\Nova;

use Carbon\Carbon;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\CallerIdContactList\CallerIdDownloadList;
use Rvm\ReputationCheckProgressBar\ReputationCheckProgressBar;

class CallerIdContactList extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CirContact::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'number';

    public static function label()
    {
        return 'Manage Caller ID';
    }

    public static function name()
    {
        return 'Reputation Checked Contact List';
    }

    public static $with = ['contactList', 'user', 'company'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'number', 'raw_number', 'status',
    ];
    public static $group = 'Caller Id';

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
                ID::make()->sortable()->hideWhenUpdating(),
                // Text::make('Group Key', 'name')->sortable()->rules('required', 'max:255')
                // ->hideWhenCreating()->hideWhenUpdating(),
                 Text::make('Number', 'number')->sortable()->rules('required', 'max:255')
                ->hideWhenCreating()->hideWhenUpdating(),

                ReputationCheckProgressBar::make('Reputation', function () {
                    return ($this->reputation_score) / 100;
                })->hideWhenCreating()->hideWhenUpdating()->withMeta(['data' => $this->toArray()]),

                // BelongsTo::make('User')->sortable()->hideWhenCreating()->hideWhenUpdating()->canSee(function ($request) {
                //     return $request->user()->hasRole('super-admin');
                // }),

                BelongsTo::make('Company')->canSee(function ($request) {
                    return $request->user()->hasRole('super-admin');
                })->sortable()->hideWhenCreating()->hideWhenUpdating(),
                Text::make('Uploaded By', function () {
                    return $this->user->first_name.' '.$this->user->last_name;
                })->canSee(function ($request) {
                    return $request->user()->hasRole('super-admin');
                })->sortable()->hideWhenCreating()->hideWhenUpdating(),

                Text::make('Created At', 'created_at', function () {
                    return Carbon::parse($this->updated_at)->format('Y-m-d');
                })->hideWhenCreating()->hideWhenUpdating(),
                // Text::make('Updated At', 'updated_at', function () {
                //     return Carbon::parse($this->updated_at)->format('Y-m-d');
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
            (new CallerIdDownloadList())->confirmText('Are you sure you want to export!')->canRun(function ($request) {
                return true;
            }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == 'user') {
            $query->where('user_id', $request->user()->id);
        }

        return $query->where('type','cir');
    }

    public static function additionalButtons()
    {
        if (auth()->check() && auth()->user()->can('create-cir-contact')) {
            return [['component' => 'NewUploadCallerIdContactList'], ['component' => 'NewUploadCallerIdContact']];
        } else {
            return [];
        }
    }
}
