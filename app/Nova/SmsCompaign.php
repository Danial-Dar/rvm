<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Select;
use App\Models\SmsCampaignStats;
use App\Nova\Actions\Campaign\SmsViewState;
use Rvm\ProgressBar\ProgressBar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;


class SmsCompaign extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SmsCampaign::class;
    public static $group = 'SMS';

    public static function label()
    {
        return 'Campaigns';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function additionalButtons()
    {
        if (auth()->check() && auth()->user()->role === 'user') {
            return [['component' => 'compaign-create-button']];
        } else {
            return [];
        }
    }


    public static function additionalActions()
    {
        /*$user = Nova::user();
        if ($user && $user->can('edit-campaign')) {
            return [
                [
                    'component' => 'sms-view-state-button',
                ],
                [
                    'component' => 'campaign-button',
                ]
            ];
        }*/
        return [['component' => 'sms-view-state-button']];
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'campaign_name',
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
            Select::make('Campaign Type', 'campaign_type')->options([
                'Unregistered' => 'Unregistered',
                '10dlc_group' => '10DLC Group',
                'toll_free_group_name' => 'Toll Free Group Name',
            ])->rules('required')->displayUsingLabels(),

            Text::make('Name', 'campaign_name')->sortable()->rules('required', 'max:255'),
            BelongsTo::make('User'),
            BelongsTo::make('Company'),
            Text::make('Start Date', 'start_date')->hideWhenCreating()->hideWhenUpdating(),
            Badge::make('Status')->map([
                'played' => 'success',
                'paused' => 'warning',
                'preprocessing' => 'info',
                'finished' => 'success',
                'flagged' => 'info',
                'inactive' => 'danger',
                'pending' => 'info',
            ])->hideWhenCreating()->hideWhenUpdating(),
            Select::make('Status')->searchable()->options([
                'preprocessing' => 'Preprocessing',
                'played' => 'Playing',
                'paused' => 'Paused',
                'flagged' => 'Flagged',
                'finished' => 'Finished',
                'inactive' => 'Inactive',
                'pending' => 'pending',
            ])->hideFromIndex()->hideWhenCreating()->hideWhenUpdating()->filterable()->displayUsingLabels()->hideFromDetail(),

            // MultiSelect::make('Contact List', 'contact_list_id')->options(
            //     \App\Models\SmsContactList::all()->pluck('name', 'id'),
            //     function () {
            //         return $this->contact_list_id;
            //     }
            // )->hideFromIndex()->displayUsingLabels()->rules('required'),

            // Text::make('Caller Id Forward', 'ci_forward_number')->hideFromIndex()->rules('required'),
            // Text::make('Voice Mail Forward', 'vm_forward_number')->hideFromIndex()->rules('required'),
            // Text::make('Transfer To Number','transfer_to_number')->dependsOn(
            //     ['campaign_type'],
            //     function (Text $field, NovaRequest $request, FormData $formData) {
            //         if ($formData->campaign_type === 'press-1') {
            //             $field->rules(['required']);
            //         }else{
            //             $field->showOnCreating(function(){
            //                 return $this->campaign_type !== 'press-1';
            //             });
            //         }
            //     }
            // ),
            ProgressBar::make('Progress', function () {
                $campaign_stat = SmsCampaignStats::where('sms_campaign_id', $this->id)->first();
                if ($campaign_stat != null) {
                    if ($campaign_stat->initiated_count > 0) {
                        return number_format((float) ($campaign_stat->initiated_count / $campaign_stat->contact_count), 2);
                    }
                }

                return 0;
            })->hideWhenCreating()->hideWhenUpdating(),
            Text::make('Total Contacts', function () {
                $campaign_contats = $this->SmsCampaignContacts;

                return $campaign_contats ? $campaign_contats->count() : 0;
            })->hideWhenCreating()->hideWhenUpdating(),
            Text::make('Pending Contacts', function () {
                $campaign_stat = $this->campaignStats;

                return $campaign_stat ? ($campaign_stat->contact_count - $campaign_stat->initiated_count) : 0;
            })->hideWhenCreating()->hideWhenUpdating(),

            Select::make('Response Type', 'receive_response')->options([
               'two_way_chat' => 'Two Way Chat In Portal',
                'email' => 'Email',
                'webhook' => 'Webhook',
            ])->rules('required')->searchable()->displayUsingLabels(),

            Text::make('Forward To Number', 'forward_to_sms_number')->sortable()->rules('required'),
            // Text::make('Drops Per Hour', 'drops_per_hour')->sortable()->rules('required'),
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
}
