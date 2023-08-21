<?php

namespace App\Nova;

use Carbon\Carbon;
use App\Models\Bot;
use Laravel\Nova\Panel;
use Rvm\TestNow\TestNow;
use App\Models\ContactList;
use App\Nova\Actions\Campaign\PauseCampaign;
use App\Nova\Actions\Campaign\ResetCampaign;
use App\Nova\Actions\Campaign\ResumeCampaign;
use App\Nova\Actions\Campaign\UpdateSendSpeed;
use App\Nova\Actions\Campaign\ViewStat;
use App\Nova\Metrics\CampaignActiveTotal;
use App\Nova\Metrics\CampaignPausedTotal;
use App\Nova\Metrics\CampaignSendRate;
use Campaign\ContactListUpload\ContactListUpload;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\ID;
use App\Models\CampaignStats;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use App\Models\CampaignContact;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;
use Rvm\AudioFields\AudioFields;
use Rvm\ProgressBar\ProgressBar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MultiSelect;
use Rvm\RecordingsWithPlay\RecordingsWithPlay;
use Rvm\SendSpeed\SendSpeed as SendSpeedField;
use Alexwenzel\DependencyContainer\HasDependencies;
use Alexwenzel\DependencyContainer\DependencyContainer;
use App\Models\CampaignScript;
use App\Models\DNCTime;
use App\Models\LeadList;
use App\Models\Team;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Nova;
use Rvm\ContactListUpload\ContactListUpload as ContactListUploadContactListUpload;
use Rvm\NovaPhoneNumber\NovaPhoneNumber;

class Campaign extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Campaign::class;

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
        'id', 'name', 'company.name', 'user.first_name', 'user.last_name'
    ];

    public static function additionalActions()
    {
        $user = Nova::user();
        if ($user && $user->can('edit-campaign')) {
            return [
                [
                    'component' => 'view-stat-button',
                ],
                [
                    'component' => 'campaign-button',
                ]
            ];
        }
        return [['component' => 'view-stat-button']];
    }

    public static $tableStyle = 'tight';

    public static $group = 'Voice';

    public static function label()
    {
        return 'Campaigns';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $campaign_type = [
            'rvm' => 'RVM',
            'press-1' => 'IVR',
            'bot' => 'AI Bot',
            'predictive' => 'Predictive Dialer'
        ];
        if ($request->user()->can('test-campaign')) {
            $campaign_type = [
                'rvm-test' => 'RVM',
                'ivr-test' => 'IVR'
            ];
        }
        $arr = [];
        for ($i = 1; $i <= 100; $i++) {
            $arr[] = $i;
        }
        return [
            ID::make()->sortable(),
            Text::make('Campaign Type', function () {
                return $this->campaign_type == 'rvm' ? 'RVM' : ($this->campaign_type == 'press-1' ? 'IVR' : ($this->campaign_type == 'bot' ? 'AI Bot' : ($this->campaign_type == 'rvm-test' ? 'RVM' : ($this->campaign_type == 'ivr-test' ? 'IVR' : 'Predictive Dialer')) ));
            })->onlyOnIndex(),

            Select::make('Campaign Type', 'campaign_type')->options($campaign_type)->hideFromIndex()->hideWhenUpdating()->hideFromDetail()->help('Vos Logic has a large selection of campaign types, RVM – Is ringless voicemail this call is designed to just leave a voicemail on the recipients phone without their phone ringing, AI Bot – This is a call designed to call the recipient have an AI bot talk to the recipient and once the recipient meets a certain set of criteria connect the call out. IVR – This is an outbound call where the user is prompted to input a digit to opt in or opt out once that’s completed the call is routed based on the recipients decision')->rules('required'),
            Select::make('Campaign Type', 'campaign_type')->options($campaign_type)->hideFromIndex()->hideWhenCreating()->hideFromDetail()->help('Vos Logic has a large selection of campaign types, RVM – Is ringless voicemail this call is designed to just leave a voicemail on the recipients phone without their phone ringing, AI Bot – This is a call designed to call the recipient have an AI bot talk to the recipient and once the recipient meets a certain set of criteria connect the call out. IVR – This is an outbound call where the user is prompted to input a digit to opt in or opt out once that’s completed the call is routed based on the recipients decision')->readonly(),
            Text::make('Campaign Type', function () {
                return $this->campaign_type == 'rvm' ? 'RVM' : ($this->campaign_type == 'press-1' ? 'IVR' : ($this->campaign_type == 'bot' ? 'AI Bot' : ($this->campaign_type == 'rvm-test' ? 'RVM' : ($this->campaign_type == 'ivr-test' ? 'IVR' : 'Predictive Dialer')) ));
            })->hideFromIndex()->hideWhenCreating()->hideWhenUpdating(),

            Text::make('Name', 'name')->hideWhenUpdating()->rules('required', 'max:255', function($attribute, $value, $fail) {
                if(preg_match('/[^a-z0-9 _]+/i', $value)) {
                    return $fail('Special Characters Are Not Allowed.');
                }
            })->help('This is the name that will be shown on the dashboard in reference to this campaign.'),
            Text::make('Name', 'name')->hideWhenCreating()->readonly()->hideFromIndex()->hideFromDetail()->help('This is the name that will be shown on the dashboard in reference to this campaign.'),
            DependencyContainer::make([
                Select::make('Team', 'team_id')->options(
                    Team::all()->pluck('name', 'id'),
                    function () {
                        return $this->team_id;
                    }
                )->hideFromIndex()->help('')->rules('required'),
                Select::make('Scripts', 'campaign_script_id')->options(
                    CampaignScript::all()->pluck('name', 'id'),
                    function () {
                        return $this->campaign_script_id;
                    }
                )->hideFromIndex()->help('')->rules('required'),
                Select::make('Lead List', 'lead_list_id')->options(
                    LeadList::all()->Where('company_id', $request->user()->company_id)->pluck('name', 'id'),
                    function () {
                        return $this->lead_list_id;
                    }
                )->hideFromIndex()->help('')->rules('required'),
                Select::make('Dial Speed Per Agent', 'dial_speed')->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ]),
            ])->dependsOn('campaign_type', 'predictive'),
            DependencyContainer::make([
                Select::make('Bot', 'bot_id')->options(
                    Bot::all()->Where('company_id', $request->user()->company_id)->pluck('bot_name', 'id'),
                    function () {
                        return $this->bot_id;
                    }
                )->hideFromIndex()->help('This is the bot you’ve designed or had our team build on your behalf.')->rules('required'),
                NovaPhoneNumber::make('Transfer To', 'transfer_to')->hideFromIndex()->help('This is the transfer to destination once someone meets the criteria.'),
                RecordingsWithPlay::make('Voicemail', 'voicemail_id')->hideFromIndex()->help('This is the voicemail that is left in the event that a recipient does not answer the phone.')->rules('required'),
                // AudioFields::make('Voicemail', 'voicemail_id')->hideFromIndex(),
            ])->dependsOn('campaign_type', 'bot'),
            DependencyContainer::make([
                Select::make('Opt In Number', 'opt_in_number')->options(
                    [
                        0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                    ]
                )->hideFromIndex()->help('The opt in number is the digit someone presses on their phones keypad to be connected to the transfer to number.')->rules('required'),
                NovaPhoneNumber::make('Transfer to number', 'transfer_to_number')->hideFromIndex()->help('The Transfer to Number or Sip Endpoint is where you want to send the call to once someone has opted in.')->rules('required'),
                Select::make('Opt Out Number', 'opt_out_number')->options(
                    [
                        0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                    ]
                )->hideFromIndex()->help('The opt out number is the digit a user inputs on their phones keypad to opt out of the offer and terminate the call.')->rules('required'),
                RecordingsWithPlay::make('Survey Audio', 'recording_id')->hideFromIndex()->help('The survey audio is the audio that’s initially played when a recipient answers the phone this audio generally includes the opt in opt out options and the questions, you’re interested in asking')->rules('required')->withMeta(['recordingName' => ( (!is_null($this->recording_id) && $this->recording_id !== null && isset($this->recording)) ? $this->recording->name : '-'),'type'=>'output']),
                // RecordingsWithPlay::make(' Audio', 'recording_output_id')->hideFromIndex()->rules('required')->withMeta(['recordingName' => (!is_null($this->recording_output_id) && $this->recording_output_id !== null ? $this->recordingOutput->name : '-'),'type'=>'output']),
                RecordingsWithPlay::make('Opt In Audio', 'recording_optin_id')->hideFromIndex()->help('The opt in audio is the audio that’s played when the user inputs the opt in digit on their phone and is played before connecting them to the transfer endpoint.')->rules('required')->withMeta(['recordingName' => (!is_null($this->recording_optin_id) && $this->recording_optin_id !== null ? $this->recordingOptin->name : '-'),'type'=>'optin']),
                RecordingsWithPlay::make('Opt Out Audio', 'optout_recording_id')->hideFromIndex()->help('The opt out audio is the audio that’s played when the recipient inputs the opt out digit on their keypad, once it’s finalized playing it hangs up the call.')->rules('required')->withMeta(['recordingName' => (!is_null($this->optout_recording_id) && $this->optout_recording_id !== null ? $this->recordingOptout->name : '-'),'type'=>'optout']),

                Select::make('Voicemail enabled', 'voice_mail_enabled')->options(
                    [1 => 'yes', 0 => 'no'])->hideFromIndex()->displayUsingLabels()->hideWhenUpdating()->help('When voicemail is enabled if no one answers the phone your selected recording will be left into their voicemail when they fail to answer the phone.'),

                    DependencyContainer::make([
                        RecordingsWithPlay::make('Voicemail', 'voicemail_id')->hideFromIndex()->rules('required')->withMeta(['recordingName' => (!is_null($this->voicemail_id) && $this->voicemail_id !== null ? $this->Voicemail->name : '-'),'type'=>'optout'])->rules('required'),
                    ])->dependsOn('voice_mail_enabled', 1)->hideFromDetail(),
            ])->dependsOn('campaign_type', 'press-1'),
            DependencyContainer::make([
                Select::make('Opt In Number', 'opt_in_number')->options(
                    [
                        0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                    ]
                )->hideFromIndex()->help('The opt in number is the digit someone presses on their phones keypad to be connected to the transfer to number.')->rules('required'),
                NovaPhoneNumber::make('Transfer to number', 'transfer_to_number')->hideFromIndex()->help('The Transfer to Number or Sip Endpoint is where you want to send the call to once someone has opted in.')->rules('required'),
                Select::make('Opt Out Number', 'opt_out_number')->options(
                    [
                        0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                    ]
                )->hideFromIndex()->help('The opt out number is the digit a user inputs on their phones keypad to opt out of the offer and terminate the call.')->rules('required'),
                RecordingsWithPlay::make('Survey Audio', 'recording_id')->hideFromIndex()->help('The survey audio is the audio that’s initially played when a recipient answers the phone this audio generally includes the opt in opt out options and the questions, you’re interested in asking')->rules('required')->withMeta(['recordingName' => ( (!is_null($this->recording_id) && $this->recording_id !== null && isset($this->recording)) ? $this->recording->name : '-'),'type'=>'output']),
                // RecordingsWithPlay::make(' Audio', 'recording_output_id')->hideFromIndex()->rules('required')->withMeta(['recordingName' => (!is_null($this->recording_output_id) && $this->recording_output_id !== null ? $this->recordingOutput->name : '-'),'type'=>'output']),
                RecordingsWithPlay::make('Opt In Audio', 'recording_optin_id')->hideFromIndex()->help('The opt in audio is the audio that’s played when the user inputs the opt in digit on their phone and is played before connecting them to the transfer endpoint.')->rules('required')->withMeta(['recordingName' => (!is_null($this->recording_optin_id) && $this->recording_optin_id !== null ? $this->recordingOptin->name : '-'),'type'=>'optin']),
                RecordingsWithPlay::make('Opt Out Audio', 'optout_recording_id')->hideFromIndex()->help('The opt out audio is the audio that’s played when the recipient inputs the opt out digit on their keypad, once it’s finalized playing it hangs up the call.')->rules('required')->withMeta(['recordingName' => (!is_null($this->optout_recording_id) && $this->optout_recording_id !== null ? $this->recordingOptout->name : '-'),'type'=>'optout']),

                Select::make('Voicemail enabled', 'voice_mail_enabled')->options(
                    [1 => 'yes', 0 => 'no'])->hideFromIndex()->displayUsingLabels()->hideWhenUpdating()->help('When voicemail is enabled if no one answers the phone your selected recording will be left into their voicemail when they fail to answer the phone.'),

                    DependencyContainer::make([
                        RecordingsWithPlay::make('Voicemail', 'voicemail_id')->hideFromIndex()->rules('required')->withMeta(['recordingName' => (!is_null($this->voicemail_id) && $this->voicemail_id !== null ? $this->Voicemail->name : '-'),'type'=>'optout'])->rules('required'),
                    ])->dependsOn('voice_mail_enabled', 1)->hideFromDetail(),
            ])->dependsOn('campaign_type', 'ivr-test'),
            DependencyContainer::make([
                NovaPhoneNumber::make('Voice Mail Forward', 'vm_forward_number')->hideFromIndex()->help('The voicemail forward number is used as it’s the number displayed within the visual voicemail alongside the number within their voicemail.')->rules('required'),
                RecordingsWithPlay::make('Recordings', 'recording_id')->hideFromIndex()->help('The recording is the recording that will be left in the voicemail of the recipient’s phone.')->required(true)->withMeta(['recordingName' => (!is_null($this->recording) && $this->recording !== null ? $this->recording->name : '-'),'type'=>'main']),
            ])->dependsOn('campaign_type', 'rvm'),
            BelongsTo::make('User')->default($request->user()->id)->onlyOnIndex()->canSee(function ($request) {
                return $request->user()->role == 'admin';
            }),

            DependencyContainer::make([
                NovaPhoneNumber::make('Voice Mail Forward', 'vm_forward_number')->hideFromIndex()->help('The voicemail forward number is used as it’s the number displayed within the visual voicemail alongside the number within their voicemail.')->rules('required'),
                RecordingsWithPlay::make('Recordings', 'recording_id')->hideFromIndex()->help('The recording is the recording that will be left in the voicemail of the recipient’s phone.')->required(true)->withMeta(['recordingName' => (!is_null($this->recording) && $this->recording !== null ? $this->recording->name : '-'),'type'=>'main']),
            ])->dependsOn('campaign_type', 'rvm-test'),


            // BelongsTo::make('Company'),
            BelongsTo::make('Company')->default($request->user()->company_id)->onlyOnIndex()->canSee(function ($request) {
                return $request->user()->role == 'admin';
            }),

            Text::make('Start Date', function () {
                return Carbon::createFromFormat('Y-m-d H:i:s', date($this->start_date))->format('m/d/Y');
            })->hideWhenCreating()->hideWhenUpdating(),


            // Text::make('Last Send Date', function () {
            //     $stats = \App\Models\CampaignContact::where('campaign_id', $this->id)->where('status','initiated')->orderBy('created_at','DESC')->first();
            //     if ($stats) {
            //         $lastsenddate = $stats->created_at;
            //         //return number_format($lastsenddate);
            //         return Carbon::createFromFormat('Y-m-d H:i:s', date($lastsenddate))->format('m/d/Y');
            //     }
            //     return '';
            // })->sortable()->onlyOnIndex(),




            Badge::make('Status')->addTypes([
                'played' => 'badge-success',
                'paused' => 'badge-warning',
                'preprocessing' => 'badge-info',
                'finished' => 'badge-finished',
                'initiated' => 'badge-warning',
                'inactive' => 'badge-danger',
                'pending' => 'badge-info',
                'outside of hours' => 'badge-warning'
            ]),
            // Badge::make('Status')->addTypes([
            //     'finished' => 'badge-success',
            // ]),
            Select::make('Status')->searchable()->options([
                'preprocessing' => 'Preprocessing',
                'played' => 'Playing',
                'paused' => 'Paused',
                'finished' => 'Finished',
                'inactive' => 'Inactive',
                'pending' => 'pending',
                'outside of hours' => 'outside of hours'
            ])->hideFromIndex()->hideWhenCreating()->hideWhenUpdating()->hideFromDetail()->filterable(),
            NovaPhoneNumber::make('Caller Id Forward', 'ci_forward_number')->hideFromIndex()->help('This is where calls that come in on the missed call will route to.')->rules('required'),
            // Badge::make('Run Type' ,function() {
            //     DB::statement("SELECT user_id FROM dnc_time WHERE  day = TRIM(TO_CHAR(NOW(), 'Day')) AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME;");
            //     if ($this->run_type == 'success') {
            //         $value = 'Inside Campaign Hours';
            //     }else {
            //         $value = 'Out Of Hours';
            //     }
            //     return $value;
            // })->map([
            //    'Inside Campaign Hours' => 'success',
            //     'Out Of Hours' => 'warning'
            // ])->onlyOnIndex(),

            Text::make('Send Rate Per Hour', function () {
                return number_format($this->drops_per_hour);
            })->sortable()->rules('required'),

            Text::make('Total Contacts', function () {
                $stats = \App\Models\CampaignStats::where('campaign_id', $this->id)->first();
                if ($stats) {
                    $contacts = $stats->contact_count;
                    return number_format($contacts);
                }
                return number_format(0);
            })->sortable()->onlyOnIndex(),
            Text::make('Pending Contacts', function () {
                $stats = \App\Models\CampaignStats::where('campaign_id', $this->id)->first();

                if ($stats) {
                    $contacts = $stats->contact_count - $stats->sent_count - $stats->dnc_count;
                    return ($contacts >=0 ) ? number_format($contacts) :    0;
                }
                return number_format(0);
            })->sortable()->onlyOnIndex(),

            // Select::make('Run Type', 'run_type')->searchable()->options([
            //     'Inside Campaign Hours' => 'Inside Campaign Hours',
            //     'Out Of Hours' => 'Out Of Hours',
            // ])->hideFromIndex()->hideWhenCreating()->hideWhenUpdating()->hideFromDetail()->filterable(),
            // Badge::make('Run Type')->map([
            //     'Inside Campaign Hours' => 'success',
            //     'Out Of Hours' => 'warning',
            // ])->hideWhenCreating()->hideWhenUpdating()->hideFromDetail(),
            new Panel('List Contacts', $this->listContacts($request->user())),
            // new Panel('Recording', $this->recordMessage($this)),
            new Panel('Send Speed', $this->sendSpeed()),
            new Panel('Schedule Delivery', $this->scheduleDelivery()),

            // ProgressBar::make('Progress', function() {
            //     $campaign_stat = CampaignStats::where('campaign_id', $this->id)->first();
            //     if($campaign_stat->initiated_count > 0) {
            //         return (float)($campaign_stat->initiated_count / $campaign_stat->contact_count);
            //     }
            //     return 0;
            // }),
            ProgressBar::make('Progress', function () {
                $campaign_stat = CampaignStats::where('campaign_id', $this->id)->first();
                if ($campaign_stat != null) {
                    if ($campaign_stat->initiated_count > 0) {
                        return number_format((float) ($campaign_stat->initiated_count / ($campaign_stat->contact_count - $campaign_stat->dnc_count)) * 100, 2, '.', '');
                        // return (float) ($campaign_stat->initiated_count / $campaign_stat->contact_count) * 100;
                    }
                }

                return 0;
            })->withMeta([
                'campaign' => [
                    'id' => $this->id,
                ],
            ]),
            Text::make('Cost', function () {
                $stat = CampaignStats::where('campaign_id', $this->id)->first();
                if($stat !== null)
                    return '$' . number_format((float) $stat->price_sum);
                else
                    return '$ 0';
            })->sortable()->rules('required'),
            Select::make('Caller Id Settings', 'different_number_types')->options([
                '1' => 'National Caller ID Presence',
                '2' => 'Custom Number Pool'
            ])->default(1)->canSee(function ($request) {
                return $request->user()->can('custom-caller-id');
            }),

            DependencyContainer::make([
                Select::make('State of caller id pool', 'state')->options([
                    "AL" => "Alabama",
                    "AK" => "Alaska",
                    "AS" => "American Samoa",
                    "AZ" => "Arizona",
                    "AR" => "Arkansas",
                    "CA" => "California",
                    "CO" => "Colorado",
                    "CT" => "Connecticut",
                    "DE" => "Delaware",
                    "DC" => "District Of Columbia",
                    "FM" => "Federated States Of Micronesia",
                    "FL" => "Florida",
                    "GA" => "Georgia",
                    "GU" => "Guam",
                    "HI" => "Hawaii",
                    "ID" => "Idaho",
                    "IL" => "Illinois",
                    "IN" => "Indiana",
                    "IA" => "Iowa",
                    "KS" => "Kansas",
                    "KY" => "Kentucky",
                    "LA" => "Louisiana",
                    "ME" => "Maine",
                    "MH" => "Marshall Islands",
                    "MD" => "Maryland",
                    "MA" => "Massachusetts",
                    "MI" => "Michigan",
                    "MN" => "Minnesota",
                    "MS" => "Mississippi",
                    "MO" => "Missouri",
                    "MT" => "Montana",
                    "NE" => "Nebraska",
                    "NV" => "Nevada",
                    "NH" => "New Hampshire",
                    "NJ" => "New Jersey",
                    "NM" => "New Mexico",
                    "NY" => "New York",
                    "NC" => "North Carolina",
                    "ND" => "North Dakota",
                    "MP" => "Northern Mariana Islands",
                    "OH" => "Ohio",
                    "OK" => "Oklahoma",
                    "OR" => "Oregon",
                    "PW" => "Palau",
                    "PA" => "Pennsylvania",
                    "PR" => "Puerto Rico",
                    "RI" => "Rhode Island",
                    "SC" => "South Carolina",
                    "SD" => "South Dakota",
                    "TN" => "Tennessee",
                    "TX" => "Texas",
                    "UT" => "Utah",
                    "VT" => "Vermont",
                    "VI" => "Virgin Islands",
                    "VA" => "Virginia",
                    "WA" => "Washington",
                    "WV" => "West Virginia",
                    "WI" => "Wisconsin",
                    "WY" => "Wyoming"
                ]),
                Select::make('Number of Caller IDs', 'number_of_caller_id')->options($arr)
            ])->dependsOn('different_number_types', '2'),
            Text::make('Total Contacts', function () {
                $stats = \App\Models\CampaignStats::where('campaign_id', $this->id)->first();
                if ($stats) {
                    $contacts = $stats->contact_count;
                    return number_format($contacts);
                }
                return number_format(0);
            })->hideWhenCreating()->onlyOnDetail()->hideWhenUpdating(),
            Text::make('Pending Contacts', function () {
                $campaign_stat = $this->campaignStats;
                $contacts = $campaign_stat ? ($campaign_stat->contact_count - $campaign_stat->sent_count - $campaign_stat->dnc_count) : 0;
                return number_format($contacts);
            })->onlyOnDetail()->hideWhenCreating()->hideWhenUpdating(),
            Hidden::make('start_date', 'start_date')->default(Carbon::now()),
            Hidden::make('callerId', 'caller_id')->default('222-222-2222')
        ];
    }

    protected function listContacts($user)
    {
        if($user->role == 'user')
            $options = ContactList::where('user_id', $user->id)->Where('status', '!=', 'deleted')->where(function($query) {
                $query->whereNull('type')->orWhere('type','=', '');
            })->get()->pluck('name','id');
        else if($user->role == 'admin')
            $options = ContactList::where('status', '!=', 'deleted')->where(function($query) {
                $query->whereNull('type')->orWhere('type','=', '');
            })->get()->pluck('name','id');

        return [
            //Select::make('Contact List', 'contact_list_id')->searchable()->options($arr)->hideFromIndex()->hideWhenCreating()->hideWhenUpdating()->filterable(),
            DependencyContainer::make([
                MultiSelect::make('Contact List', 'contact_list_id')->options(
                    $options)->hideFromIndex()->displayUsingLabels()->hideWhenUpdating()->help('You can select one list or multiple lists to send calls to from this section.')
                    ->rules('required', function($attribute, $value, $fail) {

                        if (strlen($value) < 3) {
                            return $fail('PLease Select Contact List');
                        }
                    }),
                    // ->rules('required'),
            ])->dependsOnNot('campaign_type', 'predictive'),

                MultiSelect::make('Contact List', 'contact_list_id')->options(
                    ContactList::where('user_id', $user->id)->get()->pluck('name', 'id'),
                    function () {
                        return $this->contact_list_id;
                    }
                )->hideFromIndex()->displayUsingLabels()->hideWhenCreating()->hideFromDetail()->help('You can select one list or multiple lists to send calls to from this section.')->readonly(),
                //ContactListUploadContactListUpload::make('Contact List','contact_list_id'),
        ];
    }

    protected function recordMessage($campaign)
    {
        return [
            // BelongsTo::make('Recordings', 'recording', Recording::class)->withoutTrashed(),

            RecordingsWithPlay::make('Recordings', 'recording_id')->hideFromIndex()->required(true)->withMeta(['recordingName' => (!is_null($campaign->recording) && $campaign->recording !== null ? $campaign->recording->name : '-'),'type'=>'main']),
        ];
    }

    protected function sendSpeed()
    {
        return [
            DependencyContainer::make([
                SendSpeedField::make('Send Speed', 'drops_per_hour')->help('Your send speed is on a per hour basis you can select anywhere from 1,000 to 250,000 calls per hour per campaign.')->default(1000)->hideFromIndex(),
            ])->dependsOnNot('campaign_type', 'predictive')
        ];
    }

    protected function scheduleDelivery()
    {
        return [
            Select::make('Schedule Delivery', 'schedule_delivery')->options([
                'now' => 'Send Now',
                'later' => 'Send later',
                'test' => 'Test Now',
            ])->help('You can choose to send your campaign immediately, alternatively you can schedule it for a time in the future. All campaigns and time are in Central Standard Time.')->hideFromIndex()->hideWhenUpdating()->hideFromDetail(),

            Date::make('Campaign Date', 'start_date')->hideFromIndex()->hideWhenCreating()->readonly(),

            DependencyContainer::make([
                Date::make('Future Date', 'start_date')->hideFromIndex()->rules('required')->min(Carbon::now()),
            ])->dependsOn('schedule_delivery', 'later')->hideFromDetail(),

            DependencyContainer::make([
                Date::make('Current Date', 'start_date')->hideFromIndex()->withMeta(['value' => Carbon::now()])->rules('required'),
            ])->dependsOn('schedule_delivery', 'now')->hideFromDetail(),

            DependencyContainer::make([
                // PhoneNumber::make('From','from_number')->hideFromIndex()->rules('required'),
                // PhoneNumber::make('To','to_number')->hideFromIndex()->rules('required'),
                // NovaPhoneNumber::make('From Number', '')->hideFromIndex(),
                NovaPhoneNumber::make('To Number', '')->hideFromIndex(),
                TestNow::make('Test Now', '')->hideFromIndex(),

            ])->dependsOn('schedule_delivery', 'test')->hideFromDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new CampaignActiveTotal,
            new CampaignPausedTotal,
            new CampaignSendRate
        ];
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
            (new ResumeCampaign())->showInline()->withoutConfirmation()->canSee(function ($request) {
                return $request->user()->role == 'user';
            })->canRun(function ($request, $model) {
                return $model->status == 'paused';
            }),
            (new PauseCampaign())->showInline()->withoutConfirmation()->canSee(function ($request) {
                return $request->user()->role == 'user';
            })->canRun(function ($request, $model) {
                // return $model->status == 'played' || $model->status == 'pending';
                return $model->status == 'played';
            }),
            (new ResetCampaign())->showInline()->confirmText('Are you sure you want to reset this campaign?')
                ->confirmButtonText('Reset')
                ->cancelButtonText("Don't Reset")->canSee(function ($request) {
                    return $request->user()->role == 'user' || $request->user()->role == 'admin';
                })->canRun(function ($request, $model) {
                    return $model->status == 'preprocessing' || $model->status == 'played';
                }),
            (new ViewStat())->showInline()->withoutConfirmation()->canSee(function ($request) {
                return true;
            })->canRun(function ($request, $model) {
                if ($model->status != 'preprocessing')
                    return true;

                return false;
            }),
            (new UpdateSendSpeed($this->drops_per_hour))->showInline()->canSee(function ($request) {
                return true;
            })->canRun(function ($request, $model) {
                return true;
            }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == 'company') {
            return $query->where('company_id', $request->user()->company_id);
        }
        if ($request->user()->role == 'user') {
            return $query->where('user_id', $request->user()->id);
        }

        return $query;
    }

     /*public function preview(Resource $resource){

        return false;
     }*/
}
