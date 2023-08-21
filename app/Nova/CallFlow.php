<?php

namespace App\Nova;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class CallFlow extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CallFlow::class;

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
            Text::make('Title'),
            Text::make('Attached Numbers')->onlyOnIndex(),
            Text::make('Calls')->onlyOnIndex(),
            Boolean::make('Record Calls', 'record_calls')->hideFromIndex(),
            DependencyContainer::make([
                Text::make('Recording Dissclaimer Message', 'recording_disclaimer'),
            ])->dependsOn('record_calls', true),
            Boolean::make('Forward SMS Messages Via Email', 'forward_sms_messages')->hideFromIndex(),
            DependencyContainer::make([
                Text::make('Email Address', 'forward_sms_email'),
            ])->dependsOn('forward_sms_messages', true),
            Boolean::make('Add a Whisper Message', 'whisper_message')->hideFromIndex(),
            DependencyContainer::make([
                Text::make('Call Whisper Text', 'call_whisper_text'),
            ])->dependsOn('whisper_message', true),
            Boolean::make('Send a Missed Call Notification', 'send_missed_call_notification')->hideFromIndex(),
            DependencyContainer::make([
                Text::make('Email Address', 'send_missed_call_email'),
                Text::make('Notification Message', 'send_missed_call_notification_message'),
                Boolean::make('Include caller number in the body? This is helpful if you are sending the notification text to your client instead of the caller.', 'send_missed_call_notification_include_caller_number'),
            ])->dependsOn('send_missed_call_notification', true),
            Boolean::make('Email Call Details', 'email_call_details')->hideFromIndex(),
            DependencyContainer::make([
                Boolean::make('Dont include the link to the call recording', 'include_link_call_recording'),
                Boolean::make('Send email if call is over 90 seconds', 'send_email_call_duration'),
                Text::make('Email Notifications Recipients', 'email_notification_recipients'),
            ])->dependsOn('email_call_details', true),
            Boolean::make('Press 1 To Connect', 'press_1_to_connect')->hideFromIndex(),
            DependencyContainer::make([
                Select::make('Select Option', 'press_1_to_connect_option')->options([
                    'Text To Speech' => 'Text To Speech',
                    'MP3 File' => 'MP3 File',
                ]),
                DependencyContainer::make([
                    Text::make('Enter Text', 'text_to_speech'),
                ])->dependsOn('press_1_to_connect_option', 'Text To Speech'),
                DependencyContainer::make([
                    Text::make('Enter Mp3 file Path', 'mp3_file_path'),
                ])->dependsOn('press_1_to_connect_option', 'MP3 File'),
            ])->dependsOn('press_1_to_connect', true),
            Boolean::make('Tracking Number Caller ID', 'tracking_number_caller_id')->hideFromIndex(),
            BelongsToMany::make('CallFlowNumber', 'numbers'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public static function additionalActions()
    {
        return [
            [
                'component' => 'add-step-button',
            ]
        ];
    }

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
