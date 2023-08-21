<?php

namespace App\Http\Controllers\Nova\Campaign;

use App\Exports\IncomingCallLogsExport;
use App\Exports\IvrIncomingCallLogsExport;
use App\Http\Controllers\Controller;
use App\Jobs\CampaignReset;
use App\Jobs\CampaignResetDisp;
use App\Jobs\PauseCampaign;
use App\Jobs\ResumeCampaign;
use App\Mail\CampaignFinishedMail;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignStats;
use App\Models\Cdr;
use App\Models\DNCTime;
use App\Models\IncomingCallLog;
use App\Models\IvrIncomingCallLog;
use App\Models\MyNumber;
use App\Models\User;
use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function change_status($status, $id)
    {
        $campaign = Campaign::Where('id', $id)->first();
        if ($status == "resume") {

            $campaign->status = "played";
        } elseif ($status == "pause") {

            $campaign->status = "paused";
        } elseif ($status == "inactive") {

            $campaign->status = "inactive";
        } elseif ($status == "reset") {

            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            CampaignReset::dispatchAfterResponse($id);
        }

        $campaign->save();

        return response()->json(
            [
                'data' => ['message' => 'Campaign ' . $status . ' Successfully'],
            ],
            200
        );
    }


    public function getStats($id)
    {
        $campaign = Campaign::with('campaignStats')->Where('id',$id)->first();

        // dd($campaign);

        $sql = sprintf("SELECT user_id FROM dnc_time WHERE  day = TRIM(TO_CHAR(NOW(), 'Day')) AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME");

        $dnc_time_of_users =  DB::select(DB::raw($sql));

        $dnc_time_of_users_ids = collect($dnc_time_of_users)->where('user_id',$campaign->user_id)->toArray();
        $campaign->dnc_time_exists  = (count($dnc_time_of_users_ids) > 0 ? 0 : 1);

        $dailyLimitSql =  "SELECT c.id,
            NULLIF(us.value, 'daily_max_limit')::INT AS daily_max_limit,
            NULLIF(c.drops_per_hour, '')::INT        AS drops_per_hour,
            c.user_id,
            c.company_id,
            t.this_hour_sent                         AS this_hour_sent,
            t.this_day_sent                          AS this_day_sent
                FROM campaigns c
                        LEFT OUTER JOIN user_settings us ON c.user_id = us.user_id AND us.key = 'daily_max_limit'
                        LEFT JOIN (
                    SELECT ccc.campaign_id,
                        SUM(CASE
                                WHEN DATE_TRUNC('hour', ccc.updated_at) = DATE_TRUNC('hour', NOW()) THEN 1
                                ELSE 0 END)                                                                           AS this_hour_sent,
                        SUM(CASE
                                WHEN DATE_TRUNC('day', ccc.updated_at) = DATE_TRUNC('day', NOW()) THEN 1
                                ELSE 0 END)                                                                           AS this_day_sent
                    FROM campaign_contacts ccc
                    WHERE (ccc.is_processing = true OR ccc.status = 'posted' OR ccc.status = 'initiated')
                    GROUP BY ccc.campaign_id
                ) t ON t.campaign_id = c.id

                WHERE c.id = $campaign->id;
        ";
        $dailyLimit = collect(DB::select(DB::raw($dailyLimitSql)))->first();
        $dailyLimitReached = 0;
        $dropPerHourLimitReached = 0;
        if($dailyLimit != null){
            if($dailyLimit->daily_max_limit !== null && $dailyLimit->daily_max_limit !== 0){
                if($dailyLimit->this_day_sent !==  null && $dailyLimit->this_day_sent > $dailyLimit->daily_max_limit){
                    $dailyLimitReached = 1;
                }else{
                    $dailyLimitReached = 0;
                }
            }

            if($dailyLimit->drops_per_hour !== null && $dailyLimit->drops_per_hour !== 0){
                if($dailyLimit->this_hour_sent !==  null && $dailyLimit->this_hour_sent > $dailyLimit->drops_per_hour){
                    $dropPerHourLimitReached = 1;
                }else{
                    $dropPerHourLimitReached = 0;
                }
            }
        }
        $campaign->daily_limit = $dailyLimitReached;
        $campaign->drop_limit = $dropPerHourLimitReached;


        return Response::json([
            'campaign' => $campaign
        ], 200);
    }

    public function getSendSpeed(Request $request)
    {
        $id = $request->id;
        $campaign = Campaign::findorFail($id);

        return Response::json([
            'campaign' => $campaign
        ], 200);
    }

    public function updateSendSpeed(Request $request)
    {
        $id = $request->id;
        $campaign = Campaign::findorFail($id);
        $campaign->drops_per_hour = $request->drops_per_hour;
        $campaign->save();

        Response::json([
            'message' => 'Saved successfully'
        ], 200);
    }

    public function getIvrLogs(Request $request ,$id)
    {
        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $logs = DB::table('ivr_incoming_call_logs')
            ->join('campaign_contacts', 'campaign_contacts.id', '=', 'ivr_incoming_call_logs.campaign_contact_id')
            ->where('campaign_contacts.campaign_id', '=', $id)
            ->Where('ivr_incoming_call_logs.created_at', '>=' , $start_date)->Where('ivr_incoming_call_logs.created_at', '<=', $end_date)
            ->paginate($request->per_page);
        } else{
            $logs = DB::table('ivr_incoming_call_logs')
                ->join('campaign_contacts', 'campaign_contacts.id', '=', 'ivr_incoming_call_logs.campaign_contact_id')
                ->where('campaign_contacts.campaign_id', '=', $id)->paginate($request->per_page);
        }
        // dd($logs);
        return response()->json([
            'logs' => $logs
        ], 200);
    }

    public function getCallBackLogs(Request $request ,$id)
    {
        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

            $call_backs = IncomingCallLog::where('campaign_id', '=', $id)
            ->Where('created_at', '>=' , $start_date)->Where('created_at', '<=', $end_date)
            ->paginate($request->per_page);
        } else{
            $call_backs = IncomingCallLog::Where('campaign_id', '=', $id)->paginate($request->per_page);
        }
        // dd($logs);
        return response()->json([
            'call_backs' => $call_backs
        ], 200);
    }

    public function getIncomingLogs(Request $request ,$id)
    {
        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';

            $logs = DB::table('incoming_call_logs')
            ->join('campaign_contacts', 'incoming_call_logs.campaign_contact_id', '=', 'campaign_contacts.id')
            ->where('incoming_call_logs.campaign_id', $id)
            ->Where('incoming_call_logs.created_at', '>=' , $start_date)->Where('incoming_call_logs.created_at', '<=', $end_date)
            ->selectRaw("incoming_call_logs.\"To\", incoming_call_logs.\"From\", incoming_call_logs.created_at, TO_CHAR((incoming_call_logs.duration || 'second')::interval, 'HH24:MI:SS') as my_duration, campaign_contacts.alpha_number, campaign_contacts.caller_id_number")->paginate($request->per_page);

        }else{
            $logs = DB::table('incoming_call_logs')
                ->join('campaign_contacts', 'incoming_call_logs.campaign_contact_id', '=', 'campaign_contacts.id')
                ->where('incoming_call_logs.campaign_id', $id)
                ->selectRaw("incoming_call_logs.\"To\", incoming_call_logs.\"From\", incoming_call_logs.created_at, TO_CHAR((incoming_call_logs.duration || 'second')::interval, 'HH24:MI:SS') as my_duration, campaign_contacts.alpha_number, campaign_contacts.caller_id_number")
                ->paginate($request->per_page);
        }

        return response()->json([
            'logs' => $logs
        ], 200);
    }

    public function exportIvrLogs($id, $page, $per_page)
    {
        $limit = $per_page;
        if($page != 1)
        {
            $offset = ($page - 1) * ($per_page) + 1;
        }
        else {
            $offset = 0;
        }
        return Excel::download(new IvrIncomingCallLogsExport($id, $offset, $limit), 'ivr_logs.csv');
        // return response()->json([
        //     'logs' => $logs
        // ], 200);
    }

    public function exportIncomingLogs($id, $page, $per_page)
    {
        $limit = $per_page;
        if($page != 1)
        {
            $offset = ($page - 1) * ($per_page) + 1;
        }
        else {
            $offset = 0;
        }
        $val = 'incoming';
        return Excel::download(new IncomingCallLogsExport($id, $val, $offset, $limit), 'incoming_logs.csv');
        // return response()->json([
        //     'logs' => $logs
        // ], 200);
    }

    public function exportCallBackLogs($id, $page, $per_page)
    {
        $val = 'call_back';
        $limit = $per_page;
        if($page != 1)
        {
            $offset = ($page - 1) * ($per_page) + 1;
        }
        else {
            $offset = 0;
        }
        return Excel::download(new IncomingCallLogsExport($id, $val, $offset, $limit) , 'call_backs.csv');
        // return response()->json([
        //     'logs' => $logs
        // ], 200);
    }

    public function getCallSentToDestination(Request $request, $id)
    {
        $dateWhere = "";

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);

            $dateWhere = sprintf("AND cc.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

        }

        $sql = "SELECT
        COUNT(*) AS value,
        CONCAT('US-',acl.location_code) as id
        from campaign_contacts cc
        LEFT JOIN area_code_location acl on TRIM(SUBSTRING(cc.number, 3, 3)) = acl.area_code
        WHERE cc.number IS NOT NULL AND acl.location_code IS NOT NULL
        AND cc.campaign_id = $id
        $dateWhere
        GROUP BY acl.location_code";

        $data = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $data],200);
    }

    public function getCampaignSendRates(Request $request, $id)
    {
        $dateWhere = "";

        $date = Carbon::now()->format('Y-m-d');
        // $val = CampaignContact::first();
        // $date = Carbon::parse($val->updated_at)->format('Y-m-d');
        // return $date;

        if ($request->new_date !== null) {
            $date = Carbon::parse($request->new_date)->format('Y-m-d');
            $dateWhere = sprintf("AND cc.updated_at::Date = ".$date);

        }
        // return $date;
        $sql = "SELECT COUNT(*) as value, to_char(cc.updated_at::DATE,'Month') as month,cc.updated_at as date from campaign_contacts cc
            LEFT JOIN campaigns c ON cc.campaign_id = c.id
            WHERE cc.status = 'initiated'
            AND cc.campaign_id = $id
            AND cc.updated_at::Date = '".$date."'
            GROUP BY cc.updated_at
        ";
        $campaignSendRates = collect(DB::select(DB::raw($sql)))->toArray();

        //$periods = CarbonPeriod::create(Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay());
        $range = [];


        return response()->json(['query' => [
            'campaignSendRates' => $campaignSendRates,
            'dateRange' => $range,
            ],
        ],200);

    }

    public function getCallback(Request $request, $id)
    {
        $dateWhere = "";

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }
        $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            WHERE icl.area_code IS NOT NULL
            AND icl.campaign_id = $id
            $dateWhere
            GROUP BY acl.location_code";

        $callbacks = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $callbacks],200);
    }

    public function getOptIn(Request $request, $id)
    {
        $dateWhere = "";

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }
        $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from ivr_incoming_call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE icl.area_code IS NOT NULL
            AND cc.campaign_id = $id
            AND icl.disposition = 'CONTINUE'
            $dateWhere
            GROUP BY acl.location_code";

        $optin = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $optin],200);
    }

    public function getOptOut(Request $request, $id)
    {
        $dateWhere = "";

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }
        $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from ivr_incoming_call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE icl.area_code IS NOT NULL
            AND cc.campaign_id  = $id
            AND icl.disposition = 'OPTOUT'
            $dateWhere
            GROUP BY acl.location_code";

        $optout = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $optout],200);
    }

    public function getCampaignStats(Request $request, $id)
    {
        $call_back_percentage = 0;
        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
            $calls_back = IncomingCallLog::Where('campaign_id', $id)->Where('created_at', '>=', $start_date)->Where('created_at', '<=', $end_date)->count();
            $avg_calls_duration = IncomingCallLog::Where('campaign_id', $id)->Where('created_at', '>=', $start_date)->Where('created_at', '<=', $end_date)->avg('duration');
            $cs_count = CampaignStats::Where('campaign_id', $id)->Where('created_at', '>=', $start_date)->Where('created_at', '<=', $end_date)->sum('initiated_count');

            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
            $optIn = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            $dateWhere
            AND icl.disposition = 'CONTINUE'";
            $optIn = collect(DB::select(DB::raw($optIn)))->toArray();
            $optIn_count = $optIn[0]->value;

            $optOut = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            $dateWhere
            AND icl.disposition = 'OPTOUT'";
            $optOut = collect(DB::select(DB::raw($optOut)))->toArray();
            $optOut_count = $optOut[0]->value;

            $vm = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            $dateWhere
            AND icl.disposition = 'OPTOUT'";
            $vm = collect(DB::select(DB::raw($vm)))->toArray();
            $vm_count = $vm[0]->value;

            $ivr = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            $dateWhere";
            $ivr = collect(DB::select(DB::raw($ivr)))->toArray();
            $ivr_count = $ivr[0]->value;
        } else {
            $calls_back = IncomingCallLog::Where('campaign_id', $id)->count();
            $avg_calls_duration = IncomingCallLog::Where('campaign_id', $id)->avg('duration');
            $cs_count = CampaignStats::Where('campaign_id', $id)->sum('initiated_count');

            $optIn = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            AND icl.disposition = 'CONTINUE'";
            $optIn = collect(DB::select(DB::raw($optIn)))->toArray();
            $optIn_count = $optIn[0]->value;

            $optOut = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            AND icl.disposition = 'OPTOUT'";
            $optOut = collect(DB::select(DB::raw($optOut)))->toArray();
            $optOut_count = $optOut[0]->value;

            $vm = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id
            AND icl.disposition = 'VM'";
            $vm = collect(DB::select(DB::raw($vm)))->toArray();
            $vm_count = $vm[0]->value;

            $ivr = "SELECT COUNT(*) AS value from ivr_incoming_call_logs icl
            JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
            WHERE cc.campaign_id = $id";
            $ivr = collect(DB::select(DB::raw($ivr)))->toArray();
            $ivr_count = $ivr[0]->value;
        }
        $avg_calls_duration = number_format($avg_calls_duration, 2, '.', '');
        if ($cs_count != 0 && $calls_back != 0) {
            $call_back_percentage = ($calls_back / $cs_count) * 100;
        }
        // dd($calls_back);
        return response()->json([
            'calls_back' => $calls_back,
            'avg_calls_duration' => gmdate("H:i:s", ($avg_calls_duration !== null) ? $avg_calls_duration : 0),
            'call_back_percentage' => number_format($call_back_percentage, 2)    ,
            'optIn_count' => $optIn_count,
            'optOut_count' => $optOut_count,
            'ivr_count' => $ivr_count,
            'vm_count' => $vm_count,
        ], 200);
    }

    public function getMyNumberCallBack(Request $request, $id) {
        $dateWhere = "";

        $number = MyNumber::findOrFail($id);

        $formated_number = formatNumber($number->number);

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }
        $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            WHERE icl.area_code IS NOT NULL
            AND icl.\"To\" = '$formated_number'
            $dateWhere
            GROUP BY acl.location_code";

        $callbacks = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $callbacks],200);
    }

    public function getMyNumberCallSendRate(Request $request, $id) {
        $dateWhere = "";

        $number = MyNumber::findOrFail($id);

        $formated_number = formatNumber($number->number);

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }

        $sql = "SELECT COUNT(*) AS value, to_char(icl.updated_at::DATE,'Month') as month, icl.updated_at::DATE as date from incoming_Call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            WHERE icl.area_code IS NOT NULL
            AND icl.\"To\" = '$formated_number'
            $dateWhere
            GROUP BY icl.updated_at::DATE";

        $callbacks = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => [
            'numberReceivedRates' => $callbacks
            ],
        ],200);
    }

    public function getMyNumberCallLogs(Request $request, $id) {
        $dateWhere = "";

        $number = MyNumber::findOrFail($id);

        $formated_number = formatNumber($number->number);

        // if ($request->start_date !== null && $request->end_date !== null) {
        //     $start_date = Carbon::parse($request->start_date);
        //     $end_date = Carbon::parse($request->end_date);
        //     $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        // }

        // $sql = "SELECT * from incoming_Call_logs icl
        //     WHERE icl.area_code IS NOT NULL
        //     AND icl.\"To\" = '$formated_number'
        //     $dateWhere";
            $query = DB::table('incoming_call_logs')->whereNotNull('area_code')->where('To',$formated_number);

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $query->whereBetween('created_at',[$start_date,$end_date]);
            // $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }

        // $callbacks = collect(DB::select(DB::raw($sql)))->toArray();
        $callbacks = $query->paginate();

        return response()->json(['logs' => $callbacks,],200);
    }

    public function getMyNumberCardsData(Request $request, $id) {
        $dateWhere = "";

        $number = MyNumber::findOrFail($id);

        $formated_number = formatNumber($number->number);

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }
        $created_date = Carbon::parse($number->created_at);
        $current_date = Carbon::now();

        $active_since = $created_date->diffInDays($current_date);

        $sql = "SELECT COUNT(*) AS value, AVG(duration) As duration from incoming_Call_logs icl
            WHERE icl.type = 'CUSTOMER'
            AND icl.\"To\" = '$formated_number'
            $dateWhere";

        $query = collect(DB::select(DB::raw($sql)))->toArray();
        $calls_count = $query[0]->value;
        $avg_call_duration = gmdate("H:i:s", ($query[0]->duration !== null) ? $query[0]->duration : 0);



        return response()->json([
            'active_since' => $active_since,
            'calls_count' => $calls_count,
            'avg_call_duration' => $avg_call_duration,
        ],200);
    }

    public function getRvmCallBackData(Request $request, $id)
    {
        $dateWhere = "";

        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);

            $dateWhere = sprintf("AND created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        }

        $sql = "SELECT TRIM(LEADING '0' FROM to_char( created_at::timestamp , 'HH12pm' )) as hour, to_char( created_at::timestamp , 'Day') as weekday, count(*) as value
                FROM incoming_call_logs icl
                WHERE icl.campaign_id = $id
                $dateWhere
                GROUP BY hour,weekday
            ";
        $call_back_data = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json([
            'query' => $call_back_data
        ], 200);
    }

    public function campaignFinishedMail(){
        $campaigns =  Campaign::where('status', 'finished')->get();

        foreach ($campaigns as $campaign) {


            $userEmailadresses =DB::table('campaigns')
                ->join('users', 'campaigns.user_id', '=', 'users.id')
                ->where('campaigns.id', $campaign->id )
                ->select('users.email')
                ->get();


            foreach ($userEmailadresses as $userEmailadress) {
                echo $campaign->id ." ". $campaign->status ." ".$campaign->user_id ." ". $userEmailadress->email;
                echo "<br>";

                $details = [
                    "campaign_id" => $campaign->id
                ];

                Mail::to($userEmailadress->email)->send(new CampaignFinishedMail($details));
            }


            // dd($userEmailadresses->toArray());
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $params = $request->json()->all();
        // dd(count($params['disposition']));

        $rules = [
            'status' => 'required|in:played,paused,reset,reset-disp'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($params, $rules, []);

        $validator->validate();

        $campaign->status = $request->status;

        if ($params['status'] == 'reset' && $params['disp'] == false) {
            // dd('HELLO');
            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            CampaignReset::dispatchAfterResponse($campaign->id);
        }

        if ($params['status'] == 'reset' && $params['disp'] == true && count($params['disposition']) != 0) {
            // dd("Hello");
            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            foreach ($params['disposition'] as $disposition) {
                CampaignResetDisp::dispatchAfterResponse($campaign->id, $disposition);
            }
        }

        if ($request->status == "paused") {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vos-api.voslogic.com/api/callqueues/'.$campaign->id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            echo $response;

            $queue_name =  Str::random(10);
            PauseCampaign::dispatch($campaign->id)->onQueue($queue_name);

                $curl = curl_init();
                  curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://vos-api.voslogic.com/api/callqueues/1572',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'DELETE',

                ));
                $response = curl_exec($curl);

                // echo "<pre>";print_r($response );
                curl_close($curl);
        }

        if ($request->status == "played") {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vos-api.voslogic.com/api/callqueues/'.$campaign->id,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = curl_exec($curl);

            echo $response;

            curl_close($curl);
        }

        // if ($request->status == 'played') {
        //     $user_id = $request->user()->id;
        //     $times = DNCTime::where('user_id', $user_id)->select('from_time', 'to_time', 'day')->get()->toArray();
        //     //   dd($times);
        //     if ($times) {
        //         $day = Carbon::now()->format('l');

        //         $checkDay = array_search($day, array_column($times, 'day'));

        //         if ($checkDay !== false) {
        //             $from = Carbon::createFromTimeString($times[$checkDay]['from_time']);
        //             $to = Carbon::createFromTimeString($times[$checkDay]['to_time']);
        //             $now = Carbon::now();

        //             if ($now->between($from, $to)) {
        //                 $campaign->run_type = 'inside';
        //             } else {
        //                 $campaign->run_type = 'outside';
        //             }
        //         } else {
        //             $campaign->run_type = 'outside';
        //         }
        //     } else {
        //         $campaign->run_type = 'outside';
        //     }
        // }
        // if ($request->status == 'played') {
        //     // $queue_name =  Str::random(10);
        //     // ResumeCampaign::dispatch($campaign->id)->onQueue($queue_name);
        // }

        $campaign->save();

        return Response::json([
            'message' => 'Saved successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRadioFileName(Request $request, Campaign $campaign)
    {
        $id = $request->id;
        $recording = Recording::findorFail($id);
        if ($recording) {
            return Response::json([
                'filename' => $recording->filename,
                'success' => true
            ], 200);
        } else {
            return Response::json([
                'filename' => null,
                'success' => false
            ], 400);
        }
    }

    public function test()
    {
        $users = User::get();
        return Response::json(['users' => $users]);
        //$audio = Audio::Find($this->id);
        $base_url = "https://api.assemblyai.com/v2";

        $headers = array(
        "authorization: 0f341c7ced404fe08908ec5e1eceebb8" ,
        "content-type: application/json"
        );

        $path = "https://rvm.nyc3.digitaloceanspaces.com/RVM/1684247437.wav";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $base_url . "/upload");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        $upload_url = $response_data["upload_url"];

        curl_close($ch);

        $data = array(
            "audio_url" => $upload_url, // You can also use a URL to an audio or video file on the web
            "speaker_labels" => True,
            "sentiment_analysis" => True
        );

        $url = $base_url . "/transcript";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        $transcript_id = $response['id'];
        $polling_endpoint = "https://api.assemblyai.com/v2/transcript/" . $transcript_id;

        while (true) {
            $polling_response = curl_init($polling_endpoint);

            curl_setopt($polling_response, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($polling_response, CURLOPT_RETURNTRANSFER, true);

            $transcription_result = json_decode(curl_exec($polling_response), true);

            if ($transcription_result['status'] === "completed") {
                $utterances = $transcription_result['utterances'];
                $sentiment_analysis_results = $transcription_result['sentiment_analysis_results'];


                echo json_encode($utterances);

                echo json_encode($sentiment_analysis_results);
                die();

            } else if ($transcription_result['status'] === "error") {
                throw new Exception("Transcription failed: " . $transcription_result['error']);
            } else {
                sleep(3);
            }
        }
    }
}
