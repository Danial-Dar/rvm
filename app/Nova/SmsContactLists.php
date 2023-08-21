<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\SmsContactList\SmsDownloadList;

class SmsContactLists extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SmsContactList::class;
    public static $group = 'SMS';

    public static function label()
    {
        return 'Contact Lists';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'status',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')->sortable()->rules('required', 'max:255'),

            BelongsTo::make('User')->sortable()->canSee(function ($request) {
                return auth()->user()->hasRole('super-admin');
            }),

            BelongsTo::make('Company')->sortable()->canSee(function ($request) {
                return auth()->user()->hasRole('super-admin');
            }),

            Text::make('Total Recipients', 'total_contacts')->hideWhenCreating()->hideWhenUpdating(),

            Text::make('Uploaded By', function () {
                return $this->user->first_name.' '.$this->user->last_name;
            })->hideWhenCreating()->hideWhenUpdating(),

            Text::make('Success', 'success', function () {
                return is_null($this->success) ? '0' : $this->success;
            })->hideWhenCreating()->hideWhenUpdating(),

            Text::make('Fail', 'failed', function () {
                return is_null($this->failed) ? '0' : $this->failed;
            })->hideWhenCreating()->hideWhenUpdating(),

            // Text::make('Status', 'status')->hideWhenCreating()->hideWhenUpdating(),
            // File::make('Filename', 'filename')->hideFromIndex()->rules('required')->acceptedTypes('.csv'),

            Badge::make('Status', 'status')->map([
                'active' => 'success',
                'preprocessing' => 'info',
            ])->hideWhenCreating()->hideWhenUpdating(),
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

    public static function additionalButtons()
    {
        if (auth()->check() && auth()->user()->can('create-sms-contactlist')) {
            return [['component' => 'UploadSmsContactList']];
        } else {
            return [];
        }
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new SmsDownloadList())->showInline()->confirmText('Are you sure you want to export!')->canRun(function ($request) {
                return true;
            }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (!$request->user()->hasRole('super-admin')) {
            $query->where('user_id', $request->user()->id);
        }

        return $query;
    }

    // protected static function afterCreationValidation(NovaRequest $request, $validator)
    // {
    //     dd($request->all(), $validator);
    // }

    // public static function afterCreate(NovaRequest $request, Model $model)
    // {
    //     //
    // }
}
