<?php

namespace App\Nova;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Cdr extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Cdr::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
            Text::make('Cdr UUID', 'cdr_uuid')->hideFromIndex(),
            Text::make('Channel Data Direction', 'direction')->hideFromIndex(),
            Text::make('Audio Inbound jitter Min Variance', 'jitter_min_variance')->hideFromIndex(),
            Text::make('Audio Inbound jitter Max Variance', 'jitter_max_variance')->hideFromIndex(),
            Text::make('Audio Inbound Quality Percentage', 'quality_percentage')->hideFromIndex(),
            Text::make('Variable Direction', 'direction')->hideFromIndex(),
            Text::make('Variable UUID', 'uuid')->hideFromIndex(),
            Text::make('Sip from User/From Number', 'sip_from_user'),
            Text::make('Variable Sip From Port', 'sip_from_port')->hideFromIndex(),
            Text::make('Variable Sip From URI', 'sip_from_uri')->hideFromIndex(),
            Text::make('Sip Host', 'sip_from_host'),
            Text::make('Variable Channel Name', 'channel_name')->hideFromIndex(),
            Text::make('Variable Sip Local Network Addr', 'sip_local_network_addr')->hideFromIndex(),
            Text::make('Variable Sip Network Ip', 'sip_network_ip')->hideFromIndex(),
            Text::make('Variable Sip Received Ip', 'sip_received_ip')->hideFromIndex(),
            Text::make('Variable Core-UUID', 'Core-UUID')->hideFromIndex(),
            Text::make('Variable Event-Date-Local', 'Event-Date-Local')->hideFromIndex(),
            Text::make('Variable Event-Date-GMT', 'Event-Date-GMT')->hideFromIndex(),
            Text::make('Variable Domain Name', 'domain_name')->hideFromIndex(),
            Text::make('Variable Call-Uuid', 'call_uuid')->hideFromIndex(),
            Text::make('Variable Local Media Ip', 'local_media_ip')->hideFromIndex(),
            Text::make('Variable Advertised Media Ip', 'advertised_media_ip')->hideFromIndex(),
            Text::make('Variable Remote Media Ip', 'remote_media_ip')->hideFromIndex(),
            Text::make('Variable Sip Term Status', 'sip_term_status'),
            Text::make('Variable Hangup Cause', 'hangup_cause')->hideFromIndex(),
            Text::make('Variable Hangup Cause q850', 'hangup_cause_q850')->hideFromIndex(),
            Text::make('Variable Digits Dialed', 'digits_dialed')->hideFromIndex(),
            Text::make('Variable Caller ID', 'caller_id')->hideFromIndex(),
            Text::make('Variable Flow Billsec', 'flow_billsec')->hideFromIndex(),
            Text::make('Variable Mduration', 'mduration'),
            Text::make('Variable Billmsec', 'billmsec')->hideFromIndex(),
            Text::make('Variable Progressmsec', 'progressmsec')->hideFromIndex(),
            Text::make('Variable Answer Msec', 'answermsec')->hideFromIndex(),
            Text::make('Variable Flow Billmsec', 'flow_billmsec')->hideFromIndex(),
            Text::make('Caller Profile Dial Plan', 'dialplan')->hideFromIndex(),
            Text::make('Destination Number/ To Number', 'destination_number'),
            Text::make('Caller Profile Uuid', 'uuid')->hideFromIndex(),
            Text::make('Created Time', 'created_time',
            function () {
                $value = floor($this->created_time / 1000000);
                return Carbon::createFromTimestamp($value)->toDateTimeString();

            }),
            Text::make('Profile Created Time', 'profile_created_time')->hideFromIndex(),
            Text::make('Progress Time', 'progress_time')->hideFromIndex(),
            Text::make('Progress Media Time', 'progress_media_time')->hideFromIndex(),
            Text::make('Answered Time', 'answered_time')->hideFromIndex(),
            Text::make('Bridged Time', 'bridged_time')->hideFromIndex(),
            Text::make('Last Hold Time', 'last_hold_time')->hideFromIndex(),
            Text::make('Hold Accum Time', 'hold_accum_time')->hideFromIndex(),
            Text::make('Hangup Time', 'hangup_time')->hideFromIndex(),
            Text::make('Resurrect Time', 'resurrect_time')->hideFromIndex(),
            Text::make('Transfer Time', 'transfer_time')->hideFromIndex(),
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        // return null;
        // $val = DB::connection('pgsql2')
        //     ->table('cdrs')
        //     ->join('channel_data', 'cdrs.id', '=', 'channel_data.cdr_id')
        //     // ->join('orders', 'users.id', '=', 'orders.user_id')
        //     // ->select('users.*', 'contacts.phone', 'orders.price')
        //     ->get();
        // return $val;
       // return "test";
        return $query->join('channel_data', 'cdrs.id', '=', 'channel_data.cdr_id')
        ->join('variables', 'cdrs.id', '=', 'variables.cdr_id')
        ->join('call_flows', 'cdrs.id', '=', 'call_flows.cdr_id')
        ->join('caller_profiles', 'call_flows.id', 'caller_profiles.call_flow_id')
        ->join('times', 'call_flows.id', 'times.call_flow_id')
        ->whereRaw("variables.sip_from_user ~ '[0-9]'")
        ->select(DB::raw('cdrs.core_uuid as cdr_uuid, cdrs.*, variables.*, channel_data.*, caller_profiles.*, times.*'));
        // return $query->Where('switch_name', '!=', 'testlab');
    }
}
