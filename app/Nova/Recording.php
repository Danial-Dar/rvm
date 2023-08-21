<?php

namespace App\Nova;

use App\Models\Recording as ModelsRecording;
use App\Nova\Actions\Audio\DownloadRecording;
use App\Nova\Actions\Audio\ListenRecording;
use App\Nova\Metrics\RecordingsTotal;
use App\Rules\RecordingUploadRule;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rvm\Downloadaudio\Downloadaudio;
use Rvm\Playaudio\Playaudio;
use Rvm\UploadAudio\UploadAudio;
use Carbon\Carbon;
class Recording extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Recording::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $group = 'Voice';

    public static function label() {
        return 'Recordings';
    }

    // public static function createButtonLabel()
    // {
    //     return 'Upload Recording';
    // }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'user_id', 'filename'
    ];

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

            // Text::make('Name', 'name')
            //     ->sortable()
            //     ->rules('required', function($attribute, $value, $fail) {
            //         if(preg_match('/[^a-z0-9 _]+/i', $value)) {
            //             return $fail('Special Characters Are Not Allowed.');
            //         }
            //         if(strlen($value) >255){
            //         return $fail('The file name must be less than 255 characters ');
            //         }

            //         $checkName = ModelsRecording::where('name',$value)->first();

            //         if($checkName){
            //         return $fail('File name already exists.');

            //         }

            //     }),

                Text::make('Name', 'name')
                ->sortable()
                ->rules('required', function($attribute, $value, $fail) {
                    if(preg_match('/[^a-z0-9 _]+/i', $value)) {
                        return $fail('Special Characters Are Not Allowed.');
                    }
                    if(strlen($value) >255){
                    return $fail('The file name must be less than 255 characters ');
                    }

                    // $checkName = ModelsRecording::where('name',$value)->first();

                    // if($checkName){
                    // return $fail('File name already exists.');

                    // }

                })
                ->creationRules('unique:recordings,name')
                ->updateRules('unique:recordings,name,{{resourceId}}'),

            BelongsTo::make('User')->default($request->user()->id)->hideWhenCreating()->hideWhenUpdating(),

            // BelongsTo::make('Company')->default($request->user()->company_id)->hideFromIndex(),

            // BelongsTo::make('User')->default($request->user()->id)->onlyOnIndex(),
            // BelongsTo::make('User')->default($request->user()->company_id)->hideFromIndex()->hideWhenUpdating()->hideWhenCreating(),

            // Select::make('Status')->options([
            //     '1' => 'Active',
            //     '0' => 'InActive',
            // ])->displayUsingLabels()->hideWhenUpdating(),

            Hidden::make('user_id', 'user_id')->default($request->user()->id),
            Hidden::make('company_id', 'company_id')->default($request->user()->company_id),
            Hidden::make('status', 'status')->default(1),

            // UploadAudio::make('Upload','filename')->hideFromIndex(),

            // File::make('Recording', 'recording_path')
            //     ->disk('s3')
            //     ->storeOriginalName('filename')
            //     ->path('asset')->hideFromDetail(),

            // File::make('Recording Path')->store(new StoreS3Audio)->hideFromDetail()->rules('required'),
            File::make('Recording Path')->store(new StoreS3Audio)->hideFromDetail()->hideWhenUpdating()->
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
            }),

            Playaudio::make('Play Audio', 'filename')->onlyOnIndex(),

            Text::make('Created At', function () {
                return Carbon::createFromFormat('Y-m-d H:i:s', date($this->created_at))->format('m/d/Y h:i:s a');
            })->onlyOnIndex(),

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
        return [
            (new RecordingsTotal),
        ];
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
