<?php

namespace App\Nova;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Armincms\Json\Json;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use YieldStudio\NovaPhoneField\PhoneNumber;

class CallFlowStep extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CallFlowStep::class;

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
            Text::make('Name'),
            BelongsTo::make('Call Flow', 'callFlow', 'App\Nova\CallFlow'),
            Select::make('Step', 'step')->options([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ]),
            Select::make('Call Flow Type', 'call_flow_type')->options([
                'greeting' => 'Greeting',
                'forward-call' => 'Forward Call',
                'voicemail' => 'Voicemail',
                'multi-ringing' => 'Multi Ringing',
                'call-tree-menu' => 'Call Tree Menu',
            ]),

            DependencyContainer::make([
                Select::make('Type', 'greeting_type')
                    ->options([
                        'text_to_speech' => 'Text To Speech',
                        'audio' => 'Play Audio',
                    ]),
                DependencyContainer::make([
                    Text::make('Text To Speech Message', 'greeting_text_to_speech_message'),
                ])->dependsOn('greeting_type', 'text_to_speech'),

                DependencyContainer::make([
                    Text::make('Greeting Audio File Path', 'greeting_audio_file_path'),
                ])->dependsOn('greeting_type', 'audio'),
            ])->dependsOn('call_flow_type', 'greeting'),

            DependencyContainer::make([

                PhoneNumber::make('Number', 'forward_call_number')->sortable()->rules('required', function($attribute, $value, $fail) {

                    $raw_number = preg_replace('/[^0-9]/', '', $value);

                    if (strlen($raw_number) <= 10  || strlen($raw_number) < 11) {
                        return $fail('The '.$attribute.' field is not complete.');
                    }
                }),

            ])->dependsOn('call_flow_type', 'forward-call'),

            DependencyContainer::make([
                Select::make('Type', 'voicemail_type')
                    ->options([
                        'text_to_speech' => 'Text To Speech',
                        'audio' => 'Play Audio',
                    ]),
                Text::make('Email For Notification', 'voicemail_email'),
                DependencyContainer::make([
                    Text::make('Text To Speech Message', 'voicemail_text_to_speech_message'),
                ])->dependsOn('voicemail_type', 'text_to_speech'),

                DependencyContainer::make([
                    Text::make('Greeting Audio File Path', 'voicemail_audio_file_path'),
                ])->dependsOn('voicemail_type', 'audio'),
            ])->dependsOn('call_flow_type', 'voicemail'),

            DependencyContainer::make([
                Select::make('Type', 'voicemail_type')
                    ->options([
                        'simul-ringing' => 'Simul Ringing',
                        'round-robin' => 'Round Robin',
                    ]),
                Text::make('Phone Numbers', 'multi_ringing_phone_numbers'),

            ])->dependsOn('call_flow_type', 'multi-ringing'),

            DependencyContainer::make([
                Select::make('Type', 'call-tree-menu_type')
                    ->options([
                        'text_to_speech' => 'Text To Speech',
                        'audio' => 'Play Audio',
                    ]),
                DependencyContainer::make([
                    Text::make('Text To Speech Message', 'call_tree_text_to_speech_message'),
                ])->dependsOn('call-tree-menu_type', 'text_to_speech'),

                DependencyContainer::make([
                    Text::make('Audio File Path', 'call_tree_audio_file_path'),
                ])->dependsOn('call-tree-menu_type', 'audio'),

                PhoneNumber::make('Forward To Number', 'forward_number_one')->sortable()->rules('required', function($attribute, $value, $fail) {

                    $raw_number = preg_replace('/[^0-9]/', '', $value);

                    if (strlen($raw_number) <= 10  || strlen($raw_number) < 11) {
                        return $fail('The '.$attribute.' field is not complete.');
                    }
                }),

                PhoneNumber::make('Second Forward To Number', 'forward_number_two')->sortable()->rules('required', function($attribute, $value, $fail) {

                    $raw_number = preg_replace('/[^0-9]/', '', $value);

                    if (strlen($raw_number) <= 10  || strlen($raw_number) < 11) {
                        return $fail('The '.$attribute.' field is not complete.');
                    }
                }),

            ])->dependsOn('call_flow_type', 'call-tree-menu'),
            // Json::make("ColumnName", [
            //     Select::make(__("Discount Type"), "type")
            //         ->options([
            //             'percent' => __('Percent'),
            //             'amount' => __('Amount'),
            //         ])->rules('required')->default('percent'),
            //     Number::make(__("Discount Value"), "value")
            //         ->rules("min:0")
            //         ->withMeta([
            //             'min' => 0
            //         ]),
            // ]),

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

    public static function additionalButtons()
    {

        return [
            [
                //'component' => 'UploadContactList',
                'component' => 'CallFlowStep',
            ],
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
