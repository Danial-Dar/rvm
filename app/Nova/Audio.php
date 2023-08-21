<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Nova;

class Audio extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Audio::class;

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

    public static function additionalActions()
    {
        $user = Nova::user();
        if ($user && $user->can('edit-campaign')) {
            return [
                [
                    'component' => 'AudioButton',
                ],
            ];
        }
        return  [ 
            'component' => 'AudioButton',
        ];
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
            ID::make()->sortable(),
            BelongsTo::make('Agent')->withoutTrashed(),
            BelongsTo::make('Topic')->withoutTrashed(),
            Text::make('Filename', 'filename')->sortable()->hideWhenCreating()->hideWhenUpdating(),
            File::make('Upload Audio')->store(new StoreQaAudio)->hideFromDetail()->
            rules('required', function($attribute, $value, $fail) {
                $name = $value->getClientOriginalName();
                $ext = explode('.',$value->getClientOriginalName());
                if(strlen($name) > 30){
                    return $fail('The file name must be less than 30 characters ');
                }
                if (end($ext) != "mp3" && end($ext) != "wav") {
                    return $fail('The file must be of type .mp3 or .wav');
                }
                if($value->getSize() > 10000000){
                    return $fail('The file size must be less than 10 MB');
                }
            })->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
            Text::make('Length', 'length')->onlyOnIndex()->sortable(),
            Select::make('Status')->options([
                'pending' => 'Pending',
                'success' => 'Success',
                'failed' => 'Failed',
            ])->hideFromIndex()->displayUsingLabels()->readonly()->default('pending'),
            Badge::make('Status')->addTypes([
                'success' => 'badge-success',
                'failed' => 'badge-danger',
                'pending' => 'badge-info',
            ])->onlyOnIndex(),
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
}
