<?php

namespace App\Http\Controllers\Nova\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Campaign;
use App\Models\CompanyCampaign;
use App\Models\ContactList;
use App\Models\StateSpecifcStats;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Config;

class ReportController extends Controller
{
    public function getAverageCallbackDuration(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug.'get_average_call_back_duration_heat_map.'.$user_id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate){
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;
            // $currentDate = Carbon::now();
            // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            // $end = $currentDate;
            // $start_date = $start;
            // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $start_date = $startDate;
            $end_date = $endDate;

            $campaign_id = '';
            // $list_id = $request->list_id;
            $campaignIdWhere = '';

            $userConditionicl = '';
            $compConditionicl = '';
            if ($role == 'user') {
                $userConditionicl = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
            } elseif ($role == 'company') {
                $compConditionicl = "AND icl.company_id = $company_id";
            }

            $campConditionicl = '';
            if ($campaign_id != '') {
                $campConditionicl = "AND icl.campaign_id = $campaign_id";
            }

            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
            $sql = "SELECT count(icl.duration) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
                LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
                WHERE icl.area_code IS NOT NULL
                $dateWhere
                $userConditionicl
                $compConditionicl
                $campConditionicl
                GROUP BY acl.location_code";

            $callbacks = collect(DB::select(DB::raw($sql)))->toArray();
            return $callbacks;
        });

        return response()->json(['query' => $data],200);
    }

    public function getCallback(Request $request){
        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug.'get_call_back_heatmap.'.$user_id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate){

            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            // $currentDate = Carbon::now();
            // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            // $end = $currentDate;
            // $start_date = $start;
            // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $start_date = $startDate;
            $end_date = $endDate;
            $campaign_id = '';
            // $list_id = $request->list_id;
            $campaignIdWhere = '';

            $userConditionicl = '';
            $compConditionicl = '';
            if ($role == 'user') {
                $userConditionicl = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
            } elseif ($role == 'company') {
                $compConditionicl = "AND icl.company_id = $company_id";
            }

            $campConditionicl = '';
            if ($campaign_id != '') {
                $campConditionicl = "AND icl.campaign_id = $campaign_id";
            }

            $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

            $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
                LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
                WHERE icl.area_code IS NOT NULL
                $dateWhere
                $userConditionicl
                $compConditionicl
                $campConditionicl
                GROUP BY acl.location_code";

            $callbacks = collect(DB::select(DB::raw($sql)))->toArray();
            return $callbacks;
        });

        // $data2 = [['id'=>'US-AL','value'=>23]];

        return response()->json(['query' => $data],200);
    }

    public function getCallSentToDestination(Request $request){

        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $debug = Config ::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $userConditionicl = '';
        $compConditionicl = '';
        $company_id = $user->company_id;
        if ($role == 'user') {
            $userConditionicl = "AND state_specific_stats.user_id = $user_id AND state_specific_stats.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionicl = "AND state_specific_stats.company_id = $company_id";
        }

        $sql = "SELECT
        MAX(campaign_contact_count) AS value,
        CONCAT('US-',location_code) as id
        from state_specific_stats
        where 1 = 1
        $userConditionicl
        $compConditionicl
        GROUP BY CONCAT('US-',location_code)";
        $data = collect(DB::select(DB::raw($sql)))->toArray();

        // $data2 = [['id'=>'US-AL','value'=>23]];

        return response()->json(['query' => $data],200);
    }

    public function getSendRatesPerDay(Request $request){

        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug .'get_send_rates_per_day.'.$user_id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate){

            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;
            $start_date = $startDate;
            $end_date = $endDate;
            // $currentDate = Carbon::now();

            // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            // $end = $currentDate;
            // // $start_date = $start;
            // // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $campaign_id = '';
            $list_id = '';
            $campaignIdWhere = '';

            if($campaign_id != null || $campaign_id != ''){
                $campaignIdWhere = 'and campaign_id='.$campaign_id.'';
            }
            $userIdWhere = '';
            $companyIdWhere = '';
            if($role == "user"){
                $userIdWhere = 'AND user_id ='.$user_id.' AND company_id= '.$company_id.'';

            }else if($role == "company"){
                $companyIdWhere = 'AND company_id= '.$company_id.'';
            }

            $dateWhere = sprintf("AND created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

            $campaignContact = "SELECT TRIM(LEADING '0' FROM to_char( updated_at::timestamp , 'HH12pm' )) as hour, to_char( updated_at::timestamp , 'Day') as weekday, count(*) as value
                FROM campaign_contacts
                where updated_at::date BETWEEN '$start_date'::DATE AND '$end_date'::DATE
                AND status = 'initiated'
                $dateWhere
                $campaignIdWhere
                $userIdWhere
                $companyIdWhere
                GROUP BY hour,weekday
            ";
            $campaignContactPerDay = collect(DB::select(DB::raw($campaignContact)))->toArray();
            // dd($campaignContact);

            return $campaignContactPerDay;
        });

        return response()->json(['query' => $data],200);
    }

    public function getCallsPerCampaign(Request $request){

        $user = Auth::user();

        $user_id = $user->id;

        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug.'get_calls_per_campaign'.$user_id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate){

            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;
            $start_date = $startDate;
            $end_date = $endDate;
            // $currentDate = Carbon::now();

            // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            // $end = $currentDate;
            // // $start_date = $start;
            // // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $campaign_id = '';

            $noOfCallsPerCampaignWhere = '';
            $noOfCallsPerCampaignIdWhere = '';
            $avgCallDurationCampaignWhere = '';
            $avgCallDurationCampaignIdWhere = '';

            if ($role == 'user') {
                $noOfCallsPerCampaignWhere = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT = '.$company_id.'';
                $avgCallDurationCampaignWhere = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT = '.$company_id.'';
            } elseif ($role == 'company') {
                $noOfCallsPerCampaignWhere = 'AND c.company_id::BIGINT= '.$company_id.'';
                $avgCallDurationCampaignWhere = 'AND c.company_id::BIGINT= '.$company_id.'';
            }
            if ($campaign_id != null) {
                $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
                $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            }


            $noOfCallsPerCampaignPieChartSql = "SELECT  c.name,  count(*) AS call_backs FROM incoming_call_logs icl
                LEFT JOIN campaign_contacts cc on icl.campaign_contact_id::BIGINT = cc.id
                LEFT JOIN campaigns c on c.id = icl.campaign_id::BIGINT
                WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
                $noOfCallsPerCampaignWhere
                $noOfCallsPerCampaignIdWhere
                AND icl.campaign_id IS NOT NULL
                GROUP BY icl.campaign_id, c.name;
            ";
            $noOfCallsPerCampaign = collect(DB::select(DB::raw($noOfCallsPerCampaignPieChartSql)))->all();

            return $noOfCallsPerCampaign;
        });

        return response()->json(['query' => $data],200);
    }

    public function getAverageCallsPerCampaign(Request $request){
        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null &&  $request->start_date !== "" ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null &&  $request->end_date !== "" ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug.'averageCallsPerCampaign.'.$user_id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate) {
            $user_id = $user->id;

            $company_id = $user->company_id;
            $role = $user->role;

            $start_date = $startDate;
            $end_date = $endDate;

            // $currentDate = Carbon::now();

            // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            // $end = $currentDate;
            // // $start_date = $start;
            // // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $campaign_id = '';

            $noOfCallsPerCampaignWhere = '';
            $noOfCallsPerCampaignIdWhere = '';
            $avgCallDurationCampaignWhere = '';
            $avgCallDurationCampaignIdWhere = '';

            if ($role == 'user') {
                $noOfCallsPerCampaignWhere = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT = '.$company_id.'';
                $avgCallDurationCampaignWhere = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT = '.$company_id.'';
            } elseif ($role == 'company') {
                $noOfCallsPerCampaignWhere = 'AND c.company_id::BIGINT= '.$company_id.'';
                $avgCallDurationCampaignWhere = 'AND c.company_id::BIGINT= '.$company_id.'';
            }
            if ($campaign_id != null) {
                $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
                $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            }

            $avgCallDurationPerCampaignPieChartSql = "SELECT  c.name,  AVG(icl.duration) AS avg_duration FROM incoming_call_logs icl
            LEFT JOIN campaign_contacts cc on icl.campaign_contact_id::BIGINT = cc.id
            LEFT JOIN campaigns c on c.id = icl.campaign_id::BIGINT
            WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            $avgCallDurationCampaignWhere
            $avgCallDurationCampaignIdWhere
            AND icl.campaign_id IS NOT NULL
            GROUP BY icl.campaign_id, c.name;
        ";
            $avgCallDurationPerCampaign = collect(DB::select(DB::raw($avgCallDurationPerCampaignPieChartSql)))->all();

            return $avgCallDurationPerCampaign;
        });

        return response()->json(['query' => $data],200);
    }

    public function getCampaignStats(Request $request){
        $user = Auth::user();
        $role = $user->role;
        $debug = Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->startOfYear();// gives 2016-01-31
        $end = Carbon::now();

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;


        $data = Cache::remember($debug.'campaignStat.'.$user->id.$request->page,60000, function() use($user,$request,$startDate,$endDate) {
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            $start_date = $startDate;
            $end_date = $endDate;

            $userCondition = '';

            if ($role == 'user') {
                $userCondition = "AND campaigns.user_id = $user_id AND campaigns.company_id = $company_id ";
            }

            $dateWhere = "campaigns.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE ";

            $sql = DB::table("campaigns")
            ->join("incoming_call_logs", function($join){
                $join->on("incoming_call_logs.campaign_id", "=", "campaigns.id");
            })
            ->join("campaign_stats", function($join){
                $join->on("campaign_stats.campaign_id", "=", "campaigns.id");
            })
            ->select("campaigns.name", "campaigns.campaign_type", DB::raw('sum(campaign_stats.sent_count) as sent_count'), DB::raw('count (incoming_call_logs.id) as calls_back_count'), DB::raw('cast (avg(incoming_call_logs.duration) as decimal (10, 2)) as avg_calls_duration'))
            ->whereRaw(
            $dateWhere.
            $userCondition)
            ->groupByRaw("campaigns.name, campaigns.campaign_type")
            ->havingRaw('sum(campaign_stats.sent_count) > 0')
            ->orderByRaw('sent_count desc')
            ->paginate(10);


            return $sql;
        });

        return response()->json([
            'query' => $data
        ],200);
    }

    public function getListStats(Request $request){
        $user = Auth::user();

        $sql = DB::table('incoming_call_logs')
                ->leftJoin('campaigns', 'incoming_call_logs.campaign_id', '=', 'campaigns.id')
                ->leftJoin('campaign_stats', 'campaigns.id', '=', 'campaign_stats.campaign_id')
                ->join('contact_lists', 'campaigns.contact_list_id', 'like', DB::raw("CONCAT('[%',contact_lists.id, '%]')"))
                ->when($user->role == 'user', function($query) use ($user) {
                    $query->Where('campaigns.user_id', $user->id);
                    $query->Where('campaigns.company_id', $user->company_id);
                })
                ->where('campaigns.name', '!=', null)
                ->select(DB::raw('contact_lists.name as list_name, MAX(campaign_stats.sent_count) as sent_count, count(*) AS calls_back_count, AVG(incoming_call_logs.duration) AS avg_calls_duration'))
                ->groupBy('contact_lists.name')
                ->orderByDesc('contact_lists.name')
                ->havingRaw('MAX(campaign_stats.sent_count) > 0')
                ->paginate(10);
                
        return response()->json([
            'query' => $sql
        ],200);

        // $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        // $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        // $data = Cache::remember($debug.'listSpecificStat.'.$user->id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate) {
        //     $user_id = $user->id;
        //     $company_id = $user->company_id;
        //     $role = $user->role;

        //     // $end_date = Carbon::now();

        //     // $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth();// gives 2016-01-31
        //     // $currentDate = Carbon::now();
        //     // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        //     // $end = $currentDate;
        //     // // $start_date = $start;
        //     // // $end_date = $end;
        //     // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        //     // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
        //     $start_date = $startDate;
        //     $end_date = $endDate;
        //     $userCondition = '';
        //     $compCondition = '';

        //     $campaign = Campaign::where('user_id', $user_id)->first();
        //     $campaign_id = '';
        //     if($campaign)
        //     $campaign_id = $campaign->id;
        //     $list = ContactList::Where('user_id', $user_id)->first();
        //     $list_id = '';
        //     if($list)
        //         $list_id = $list->id;

        //     if ($role == 'user') {
        //         $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        //     } elseif ($role == 'company') {
        //         $compCondition = "AND c.company_id = $company_id";
        //     }

        //     $campCondition = '';
        //     if ($campaign_id != '') {
        //         $campCondition = "AND c.id = $campaign_id";
        //     }

        //     $listCondition = '';
        //     if ($list_id != '') {
        //         $listCondition = "AND cc.contact_list_id = $list_id";
        //     }

        //     $dateWhere = "WHERE icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        //     $sql = "SELECT c.id, c.name, c.campaign_type,cl.name as list_name, MAX(cs.sent_count) as sent_count, count(*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
        //     FROM incoming_call_logs icl
        //     LEFT JOIN campaigns c ON icl.campaign_id = c.id
        //     LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
        //     LEFT JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
        //     LEFT JOIN contact_lists cl on cl.id = cc.contact_list_id
        //         $dateWhere
        //         $campCondition
        //         $userCondition
        //         $compCondition
        //         AND c.name IS NOT NULL
        //         GROUP BY c.id, c.name, c.campaign_type,cl.name
        //         ORDER BY c.id desc;
        //     ";

        //     $listStats = collect(DB::select(DB::raw($sql)))->toArray();
        //     return $listStats;
        // });

        // return response()->json(['query' => $data],200);
    }

    public function getRecordingStats(Request $request){
        $user = Auth::user();
        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = Carbon::now()->subDays(Carbon::now()->dayOfYear)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND campaigns.user_id = $user->id AND campaigns.company_id = $user->company_id ";
        } elseif ($role == 'company') {
            $compCondition = "AND campaigns.company_id = $user->company_id ";
        }
        $dateWhere = "campaigns.created_at::Date BETWEEN '$startDate'::DATE AND '$endDate'::DATE ";


        $sql = DB::table('incoming_call_logs')
        ->select('campaigns.recording_id', 'recordings.name', DB::raw("count(*) as calls_back_count"), DB::raw("CAST(AVG(incoming_call_logs.duration) AS DECIMAL(10,2)) as avg_calls_duration"), DB::raw("sum(campaign_stats.initiated_count) as avg_call_backs
        "))
        ->leftJoin('campaigns','incoming_call_logs.campaign_id','=','campaigns.id')
        ->join('recordings','recordings.id','=','campaigns.recording_id')
        ->join('campaign_stats','campaign_stats.campaign_id','=','incoming_call_logs.campaign_id')
        ->whereRaw(''.$dateWhere.'
        '.$userCondition.'
        '.$compCondition.'')
        ->groupBy('campaigns.recording_id','recordings.name')
        ->paginate(10);

        return response()->json([
            'query' => $sql
        ],200);

    }

    public function getStateStats(Request $request){
        $user = Auth::user();
        $role = $user->role;

        if ($role == 'admin') {
            $stats = StateSpecifcStats::Where('user_id', null)->paginate(10);
        }elseif ($role == 'user') {
            $stats = StateSpecifcStats::Where('user_id', $user->id)->paginate(10);
        }elseif ($role == 'company') {
            $stats = StateSpecifcStats::Where('company_id', $user->company_id)->paginate(10);
        }

        return response()->json(['query' => $stats],200);



        // $currentDate = Carbon::now();
        // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        // $end = $currentDate;

        // $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        // $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;



        // $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        // $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        // $data = Cache::remember($debug.'stateSpecificStat.'.$user->id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate) {
        //     $user_id = $user->id;
        //     $company_id = $user->company_id;
        //     $role = $user->role;

        //     // $end_date = Carbon::now();
        //     // $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth(); // gives 2016-01-31
        //     // $currentDate = Carbon::now();
        //     // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        //     // $end = $currentDate;
        //     // // $start_date = $start;
        //     // // $end_date = $end;
        //     // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        //     // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
        //     $start_date = $startDate;
        //     $end_date = $endDate;

        //     $campaign = Campaign::where('user_id', $user_id)->first();
        //     $campaign_id = '';
        //     if($campaign)
        //         $campaign_id = $campaign->id;
        //     $list = ContactList::Where('user_id', $user_id)->first();
        //     if($list)
        //         $list_id = $list->id;

        //     $userCondition = '';
        //     $userConditionCC = '';
        //     $compCondition = '';
        //     $compConditionCC = '';

        //     if ($role == 'user') {
        //         $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        //         $userConditionCC = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
        //     } elseif ($role == 'company') {
        //         $compCondition = "AND c.company_id = $company_id";
        //         $compConditionCC = "AND cc.company_id = $company_id";
        //     }

        //     $campCondition = '';
        //     $campConditionCC = '';
        //     if ($campaign_id != '') {
        //         $campCondition = "AND c.id = $campaign_id";
        //         $campConditionCC = "AND cc.campaign_id = $campaign_id";
        //     }



        //     $dateWhereIcl = "WHERE icl.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";
        //     $dateWhereCC = "WHERE cc.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        //     $sql = "SELECT acl.area_code, acl.location_code,MAX(c.name) as campaign_name,
        //     MAX(t.contact_count) as contact_count, COUNT(icl.*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
        //     FROM incoming_call_logs icl
        //     LEFT JOIN campaigns c ON icl.campaign_id = c.id
        //     LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
        //     LEFT JOIN area_code_location acl on TRIM(SUBSTRING(icl.\"From\", 3, 3)) = TRIM(acl.area_code)
        //     LEFT JOIN (
        //     SELECT TRIM(SUBSTRING(cc.number, 3, 3)) AS area_code, COUNT(*) as contact_count
        //     FROM campaign_contacts cc
        //     $dateWhereCC
        //     $campConditionCC
        //     $userConditionCC
        //     $compConditionCC
        //     AND cc.status = 'initiated'
        //     GROUP BY TRIM(SUBSTRING(cc.number, 3, 3))
        //     ) t  ON TRIM(acl.area_code) = t.area_code
        //     $dateWhereIcl
        //     $campCondition
        //     $userCondition
        //     $compCondition
        //     AND acl.area_code is not null
        //     GROUP BY acl.area_code, acl.location_code;";
        //     $stateStats = collect(DB::select(DB::raw($sql)))->toArray();

        //     return $stateStats;
        // });

        // return response()->json(['query' => $data],200);
    }

    public function getCampaignSendRates(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $role = $user->role;
        $debug = \Config::get('app.env');

        $start = Carbon::now()->subDays(14)->startOfDay()->format('Y-m-d H:i:s');
        $end = Carbon::now()->format('Y-m-d H:i:s');

        $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $data = Cache::remember($debug.'send_rates'.$user_id.$role,900, function() use($user,$request,$start_date,$end_date){
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            $campaign = Campaign::where('user_id', $user_id)->first();
            $campaign_id = '';
            if($campaign)
                $campaign_id = $campaign->id;
            $list_id = '';
            $list = ContactList::Where('user_id', $user_id)->first();
            if($list)
                $list_id = $list->id;

            $userCondition = '';
            $compCondition = '';

            if ($role == 'user') {
                $userCondition = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
            } elseif ($role == 'company') {
                $compCondition = "AND cc.company_id = $company_id";
            }

            $campCondition = '';
            if ($campaign_id != '') {
                $campCondition = "AND cc.campaign_id = $campaign_id";
            }

            $listCondition = '';
            if ($list_id != '') {
                $listCondition = "AND cc.contact_list_id = $list_id";
            }

            $dateWhere = "AND cc.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

            $sql = "SELECT COUNT(*) as value, to_char(cc.updated_at::DATE,'Month') as month,cc.updated_at::DATE as date from campaign_contacts cc
                LEFT JOIN campaigns c ON cc.campaign_id = c.id
                WHERE cc.status = 'initiated'
                $dateWhere
                $campCondition
                $userCondition
                $compCondition
                GROUP BY cc.updated_at::DATE
            ";
            $campaignSendRates = collect(\DB::select(\DB::raw($sql)))->toArray();

            $periods = CarbonPeriod::create(Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay());
            $range = [];
            foreach ($periods as $period) {
                $date = $period->format('Y-m-d');
                $dataX = [
                    'date' => $date,
                    'value' => 0,
                ];
                array_push($range, $dataX);
            }


            return [$campaignSendRates,$range];
        });
        // return response()->json(['query' => [
        //     'campaignSendRates' => $campaignSendRates,
        //     'dateRange' => $range,
        //     ],
        // ],200);
        return response()->json(['query' => [
            'campaignSendRates' => $data[0],
            'dateRange' => $data[1],
            ],
        ],200);
    }

    public function getIvrDnc(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug.'ivr_dnc_heatmap.'.$user_id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate){
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            // $start_date = Carbon::now()->startOfMonth();
            // $end_date = Carbon::now()->endOfMonth();

            // $currentDate = Carbon::now();
            // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            // $end = $currentDate;
            // // $start_date = $start;
            // // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $start_date = $startDate;
            $end_date = $endDate;

            $campaign = Campaign::where('user_id', $user_id)->first();
            $campaign_id = '';
            if($campaign)
                $campaign_id = $campaign->id;
            $list = ContactList::Where('user_id', $user_id)->first();
            if($list)
                $list_id = $list->id;

            $userConditionCC = '';
            $compConditionCC = '';

            if ($role == 'user') {
                $userConditionCC = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
            } elseif ($role == 'company') {
                $compConditionCC = "AND cc.company_id = $company_id";
            }

            $campConditionCC = '';
            if ($campaign_id != '') {
                $campConditionCC = "AND cc.campaign_id = $campaign_id";
            }

            $dateWhere = "WHERE ps.date::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";
            $statusWhere = "AND ps.status = 'optout'";
            $sql = "SELECT
                CONCAT('US-',acl.location_code) as id,
                COUNT(ps.*) as value
                FROM area_code_location acl
                    INNER JOIN press1_status ps on TRIM(acl.area_code) = TRIM(SUBSTRING(ps.ddi, 2, 3))
                    INNER JOIN campaign_contacts cc ON cc.id = ps.tid::BIGINT
                    INNER JOIN campaigns c ON c.id = cc.campaign_id
                $dateWhere
                $statusWhere
                $userConditionCC
                $compConditionCC
                $campConditionCC
                GROUP BY acl.area_code, acl.location_code
            ";

            $ivrDncHeatMap = collect(\DB::select(\DB::raw($sql)))->toArray();
            return $ivrDncHeatMap;
        });

        return response()->json(['query' => $data],200);
    }

    public function getDnc(Request $request){
        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $userConditionCC = '';
        $compConditionCC = '';

        if ($role == 'user') {
            $userConditionCC = "AND state_specific_stats.user_id = $user_id AND state_specific_stats.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionCC = "AND state_specific_stats.company_id = $company_id";
        }

        $sql = "SELECT
                CONCAT('US-',state_specific_stats.location_code) as id,
                MAX(dnc_count) as value
                FROM state_specific_stats
                where 1 = 1
                $userConditionCC
                $compConditionCC
           GROUP BY CONCAT('US-',state_specific_stats.location_code);
        ";
        $dncHeatmap = collect(DB::select(DB::raw($sql)))->toArray();
        return response()->json(['query' => $dncHeatmap],200);
    }

    public function getCampaignRatio(Request $request){
        $user = Auth::user();

        $role = $user->role;

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $start = Carbon::now()->subDays(Carbon::now()->dayOfWeek)->subMonth()->format('Y-m-d H:i:s');// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $dateWhere = "WHERE created_at::Date BETWEEN '$startDate'::DATE AND '$endDate'::DATE";

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND user_id = $user->id AND company_id = $user->company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND company_id = $user->company_id";
        }

        $sql = "SELECT COUNT(*) as total,campaign_type
            from campaigns
            $dateWhere
            $userCondition
            $compCondition
            GROUP BY campaign_type
        ";

        $campaignRatio = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $campaignRatio],200);





        // $user = Auth::user();

        // $role = $user->role;
        // $debug = \Config::get('app.env');

        // $currentDate = Carbon::now();
        // $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        // $end = $currentDate;

        // $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        // $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        // $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        // $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        // $data = Cache::remember($debug.'campaignRatio.'.$user->id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate) {
        //     $user_id = $user->id;
        //     $company_id = $user->company_id;
        //     $role = $user->role;

        //     // $end_date = Carbon::now();
        //     // $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth(); // gives 2016-01-31
        //     // $start = Carbon::now()->startOfMonth();
        //     // $end = Carbon::now()->endOfMonth();
        //     // // $start_date = $start;
        //     // // $end_date = $end;
        //     // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        //     // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        //     $start_date = $startDate;
        //     $end_date = $endDate;

        //     $campaign = Campaign::where('user_id', $user_id)->first();
        //     $campaign_id = '';
        //     if($campaign)
        //         $campaign_id = $campaign->id;
        //     $list = ContactList::Where('user_id', $user_id)->first();
        //     if($list)
        //         $list_id = $list->id;

        //     $userCondition = '';
        //     $compCondition = '';

        //     if ($role == 'user') {
        //         $userCondition = "AND user_id = $user_id AND company_id = $company_id";
        //     } elseif ($role == 'company') {
        //         $compCondition = "AND company_id = $company_id";
        //     }

        //     $campCondition = '';
        //     if ($campaign_id != '') {
        //         $campCondition = "AND id = $campaign_id";
        //     }
        //     // dd($campCondition);

        //     // $listCondition = '';
        //     // if($list_id != ""){
        //     //     $listCondition = "AND cc.contact_list_id = $list_id";
        //     // }

        //     $dateWhere = "WHERE created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        //     $sql = "SELECT COUNT(*) as total,campaign_type
        //         from campaigns
        //         $dateWhere
        //         $campCondition
        //         $userCondition
        //         $compCondition
        //         GROUP BY campaign_type
        //     ";
        //     $campaignRatio = collect(DB::select(DB::raw($sql)))->toArray();

        //     return $campaignRatio;
        // });
        // return response()->json(['query' => $data],200);
    }

    public function getInboundCall(Request $request){

        $user = Auth::user();

        $role = $user->role;
        $debug = \Config::get('app.env');

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';

        $data = Cache::remember($debug.'inbounuudCallOvertime1.'.$user->id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate) {
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            // $end_date = Carbon::now();
            // // $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth(); // gives 2016-01-31
            // $start_date = Carbon::now()->startOfMonth();

            // $start = Carbon::now()->startOfMonth();
            // $end = Carbon::now()->endOfMonth();
            // // $start_date = $start;
            // // $end_date = $end;
            // $start_date = $request->start_date !== null ? $request->start_date : $start;
            // $end_date = $request->start_date !== null ? $request->end_date : $end;

            // dd($end_date);
            $start_date = $startDate;
            $end_date = $endDate;

            $campaign = Campaign::where('user_id', $user_id)->first();
            $campaign_id = '';
            if($campaign)
                $campaign_id = $campaign->id;
            $list = ContactList::Where('user_id', $user_id)->first();
            if($list)
                $list_id = $list->id;

            $userCondition = '';
            $compCondition = '';

            if ($role == 'user') {
                $userCondition = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
            } elseif ($role == 'company') {
                $compCondition = "AND icl.company_id = $company_id";
            }

            $campCondition = '';
            if ($campaign_id != '') {
                $campCondition = "AND icl.campaign_id = $campaign_id";
            }

            // $listCondition = '';
            // if($list_id != ""){
            //     $listCondition = "AND cc.contact_list_id = $list_id";
            // }
            $dateWhere = "WHERE icl.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

            $sql = "SELECT COUNT(*) as value, icl.updated_at::DATE as date from incoming_call_logs icl
                LEFT JOIN campaigns c ON icl.campaign_id = c.id
                $dateWhere
                $campCondition
                $userCondition
                $compCondition
                GROUP BY icl.updated_at::DATE
            ";
            $inboundCall = collect(DB::select(DB::raw($sql)))->toArray();

            $periods = CarbonPeriod::create(Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay());
            $range = [];
            foreach ($periods as $period) {
                $date = $period->format('Y-m-d');
                $dataX = [
                    'date' => $date,
                    'value' => 0,
                ];
                array_push($range, $dataX);
            }


            return [$inboundCall,$range];
        });
        return response()->json(['query' => [
            'inboundCall' => $data[0],
            'range' => $data[1]
        ]],200);
    }

    public function getOutboundOptin(Request $request){
        $user = Auth::user();
        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $start = $request->start_date !== null ? Carbon::parse($request->start_date): '';
        $end = $request->end_date !== null ? Carbon::parse($request->end_date): '';
        $data = Cache::remember($debug.'outboundOptinHeatmap.'.$user->id.$role.$start.$end,60000, function() use($user,$request,$startDate,$endDate) {
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            // $end_date = Carbon::now();
            // $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth(); // gives 2016-01-31

            // $start = Carbon::now()->startOfMonth();
            // $end = Carbon::now()->endOfMonth();
            // // $start_date = $start;
            // // $end_date = $end;
            // $start_date = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
            // $end_date = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;
            $start_date = $startDate;
            $end_date = $endDate;

            $campaign = Campaign::where('user_id', $user_id)->first();
            $campaign_id = '';
            if($campaign)
                $campaign_id = $campaign->id;
            $list = ContactList::Where('user_id', $user_id)->first();
            if($list)
                $list_id = $list->id;

            $userConditionCC = '';
            $compConditionCC = '';

            if ($role == 'user') {
                $userConditionCC = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
            } elseif ($role == 'company') {
                $compConditionCC = "AND cc.company_id = $company_id";
            }

            $campConditionCC = '';
            if ($campaign_id != '') {
                $campConditionCC = "AND cc.campaign_id = $campaign_id";
            }

            $dateWhere = "WHERE ps.date::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";
            $statusWhere = "AND ps.status = 'transfered'";
            $sql = "SELECT
                CONCAT('US-',acl.location_code) as id,
                COUNT(ps.*) as value
                FROM area_code_location acl
                    INNER JOIN press1_status ps on TRIM(acl.area_code) = TRIM(SUBSTRING(ps.ddi, 2, 3))
                    INNER JOIN campaign_contacts cc ON cc.id = ps.tid::BIGINT
                    INNER JOIN campaigns c ON c.id = cc.campaign_id
                $dateWhere
                $statusWhere
                $userConditionCC
                $compConditionCC
                $campConditionCC
                GROUP BY acl.area_code, acl.location_code
            ";

            $outboundOptin = collect(DB::select(DB::raw($sql)))->toArray();
            return $outboundOptin;
        });
        // $data2 = [['id'=>'US-AL','value'=>23]];
        return response()->json(['query' => $data],200);
    }

    public function GetSpendPerDay(Request $request)
    {
        $companyIdQuery = '';
        if(!is_null($request->company_id)) {
            $companyIdQuery = 'and companies.id = '.$request->company_id;
        }

        if(!is_null($request->from_date)) {
            $spendings = DB::select("select sum(-1 *balances.amount) as spendings, REPLACE(a.name, ' ', '') as name, created::DATE from ( WITH compras AS ( select generate_series('".Carbon::parse($request->from_date)->format('Y-m-d')."'::date, '".Carbon::parse($request->to_date)->format('Y-m-d')."'::date, '1 day'::interval) AS created) select created, w.id, w.name from compras C CROSS JOIN (select * from companies where deleted_at is null ".$companyIdQuery." order by id asc) as w) a left JOIN balances on balances.company_id = a.id and balances.created_at::DATE = created::DATE and balances.type != 'PAYMENT' group by name, created;");

            $payments = DB::select("select sum(balances.amount) as payments, REPLACE(a.name, ' ', '') as name, created::DATE from ( WITH compras AS ( select generate_series('".Carbon::parse($request->from_date)->format('Y-m-d')."'::date, '".Carbon::parse($request->to_date)->format('Y-m-d')."'::date, '1 day'::interval) AS created) select created, w.id, w.name from compras C CROSS JOIN (select * from companies where deleted_at is null ".$companyIdQuery." order by id asc) as w) a left JOIN balances on balances.company_id = a.id and balances.created_at::DATE = created::DATE and balances.type = 'PAYMENT' group by name, created;");

            $spendings = collect($spendings);
            $spendings->transform(function($spending, $index) use($payments){
                $spending->spendings = (int)$spending->spendings;
                if(isset($payments[$index])){
                    $spending->payments = (int)$payments[$index]->payments;
                    return $spending;
                }
                $spending->payment = 0;
                return $spending;
            });

            return $spendings;
        }
        $data = Cache::remember('reports-balances', 120000, function() use ($request, $companyIdQuery){
            $spendings = DB::select("select sum(-1 *balances.amount) as spendings, REPLACE(a.name, ' ', '') as name, created::DATE from ( WITH compras AS ( SELECT ( NOW() + (s::TEXT || ' day')::INTERVAL )::TIMESTAMP(0) AS created FROM generate_series(-6, 0, 1) AS s) select created,w.name, w.id from compras C CROSS JOIN (select * from companies where deleted_at is null ".$companyIdQuery." order by id asc) as w) a left JOIN balances on balances.company_id = a.id and balances.created_at::DATE = created::DATE and balances.type != 'PAYMENT' group by name, created;");

            $payments = DB::select("select sum(balances.amount) as payments, REPLACE(a.name, ' ', '') as name, created::DATE from ( WITH compras AS ( SELECT ( NOW() + (s::TEXT || ' day')::INTERVAL )::TIMESTAMP(0) AS created FROM generate_series(-6, 0, 1) AS s) select created,w.name, w.id from compras C CROSS JOIN (select * from companies where deleted_at is null ".$companyIdQuery." order by id asc) as w) a left JOIN balances on balances.company_id = a.id and balances.created_at::DATE = created::DATE and balances.type = 'PAYMENT' group by name, created;");

            $spendings = collect($spendings);
            $spendings->transform(function($spending, $index) use($payments){
                $spending->spendings = (int)$spending->spendings;
                if(isset($payments[$index])){
                    $spending->payments = (int)$payments[$index]->payments;
                    return $spending;
                }
                $spending->payment = 0;
                return $spending;
            });

            return $spendings;
        });

        return $data;
    }

    public function spendingByCategory(Request $request)
    {
        $companyIdQuery = '';
        if(!is_null($request->company_id)) {
            $companyIdQuery = 'and company_id = '.$request->company_id;
        }
        $balances = DB::select("select sum(-1 * balances.amount) as total, type from balances where type != 'PAYMENT' ".$companyIdQuery." group by type");

        return $balances;
    }

    public function spendingByCompany(Request $request)
    {
        $companyIdQuery = '';
        if(!is_null($request->company_id)) {
            $companyIdQuery = 'and company_id = '.$request->company_id;
        }
        $balances = DB::select("select sum(-1 * balances.amount) as total, companies.name from balances
        join companies on companies.id = balances.company_id
        where type != 'PAYMENT' ".$companyIdQuery." group by companies.name");

        return $balances;
    }

    public function paymentsByCompany(Request $request)
    {
        $companyIdQuery = '';
        if(!is_null($request->company_id)) {
            $companyIdQuery = 'and company_id = '.$request->company_id;
        }
        $balances = DB::select("select sum(balances.amount) as total, companies.name from balances
        join companies on companies.id = balances.company_id
        where type = 'PAYMENT' ".$companyIdQuery." group by companies.name");

        return $balances;
    }

    public function companyCampaignData(Request $request)
    {
        // $user = Auth::user();
        // $role = $user->role;
        // $debug = \Config::get('app.env');

        // $date = Carbon::now()->startOfDay();
        // // $dateWhere = "WHERE companies.created_at::Date BETWEEN '$startDate'::DATE AND '$endDate'::DATE";

        // $sql = [];
        // $sql = DB::table('companies')
        //         ->leftJoin('campaigns', 'companies.id', DB::Raw(' "campaigns"."company_id" and "campaigns"."updated_at" >= \''.$date.'\' '))
        //         ->leftJoin('campaign_contacts', 'companies.id', DB::Raw(' "campaign_contacts"."company_id" and "campaign_contacts"."updated_at" >= \''.$date.'\' and "campaign_contacts"."status" = \'initiated\' '))
        //         ->leftJoin('incoming_call_logs', 'companies.id', DB::Raw(' "incoming_call_logs"."company_id" and "incoming_call_logs"."updated_at" >= \''.$date.'\' '))
        //         ->leftJoin('balances as b1', 'companies.id', DB::Raw(' "b1"."company_id" and "b1"."updated_at" >= \''.$date.'\' and "b1"."type" = \'PAYMENT\' '))
        //         ->leftJoin('balances as b2', 'companies.id', DB::Raw(' "b2"."company_id" and "b2"."updated_at" >= \''.$date.'\' and "b2"."type" != \'PAYMENT\' '))
        //         ->Select(DB::raw(
        //                 'companies.name as company_name, count(campaigns) AS campaign_count, count(campaign_contacts) AS calls_sent, count(incoming_call_logs) AS call_backs, SUM(b1.amount) as money_spent,
        //                 SUM(b2.amount) as total_payment'
        //         ))
        //         ->havingRaw('count(campaign_contacts) > 0')
        //         ->groupBy('companies.name')->paginate(10);

        // return response()->json([
        //     'query' => $sql
        // ],200);


        $date = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');

        $data = CompanyCampaign::with('company')/*->Where('created_at', '>=', $date)*/->paginate(10);

        return response()->json([
            'query' => $data
        ],200);
    }

    public function getDashboardCallBackData(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $data = Cache::remember($debug.'get_call_back_heatmap.'.$user_id.$role.$startDate.$endDate,60000, function() use($user,$request,$startDate,$endDate){

            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            $start_date = $startDate;
            $end_date = $endDate;

            $userConditionicl = '';
            if ($role == 'user') {
                $userConditionicl = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
            }
            $dateWhere = sprintf("WHERE icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

            $sql = "SELECT TRIM(LEADING '0' FROM to_char( created_at::timestamp , 'HH12pm' )) as hour, to_char(             created_at::timestamp , 'Day') as weekday, count(*) as value
                FROM incoming_call_logs icl
                WHERE icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE
                $userConditionicl
                GROUP BY hour,weekday
            ";

            $callbacks = collect(DB::select(DB::raw($sql)))->toArray();
            return $callbacks;
        });

        // $data2 = [['id'=>'US-AL','value'=>23]];

        return response()->json(['query' => $data],200);
    }

    public function getDashboardCallOutData(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $role = $user->role;
        $debug = \Config::get('app.env');

        $currentDate = Carbon::now();
        $start = $currentDate->subMonth();// gives 2016-01-31
        $end = $currentDate;

        $startDate = $request->start_date !== null ? Carbon::parse($request->start_date) : $start;
        $endDate = $request->end_date !== null ? Carbon::parse($request->end_date) : $end;

        $data = Cache::remember($debug.'get_dashboard_call_out.'.$user_id.$role.$startDate.$endDate,60000, function() use($user,$request,$startDate,$endDate){

            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            $start_date = $startDate;
            $end_date = $endDate;

            $userConditionicl = '';
            if ($role == 'user') {
                $userConditionicl = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
            }

            $dateWhere = sprintf("AND cc.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

            $sql = "SELECT TRIM(LEADING '0' FROM to_char( created_at::timestamp , 'HH12pm' )) as hour, to_char(             created_at::timestamp , 'Day') as weekday, count(*) as value
                FROM campaign_contacts cc
                WHERE cc.status = 'initiated'
                $dateWhere
                $userConditionicl
                GROUP BY hour,weekday
            ";

            $callouts = collect(DB::select(DB::raw($sql)))->toArray();
            return $callouts;
        });

        // $data2 = [['id'=>'US-AL','value'=>23]];

        return response()->json(['query' => $data],200);
    }

    function thousandsCurrencyFormat($num) {

        if($num>1000) {

              $x = round($num);
              $x_number_format = number_format($x);
              $x_array = explode(',', $x_number_format);
              $x_parts = array('k', 'm', 'b', 't');
              $x_count_parts = count($x_array) - 1;
              $x_display = $x;
              $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
              $x_display .= $x_parts[$x_count_parts - 1];

              return $x_display;

        }

        return $num;
      }
}
