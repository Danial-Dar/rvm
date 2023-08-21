<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\ContactList;
use App\Models\Contact;
use App\Models\User;
use App\Models\DNC;
use App\Models\Recording;
use App\Models\CampaignContact;
use App\Models\CampaignStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon;
use Carbon\CarbonPeriod;
use DB;

class ReportController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $campaignQ = Campaign::query();
        $listQ = ContactList::query();

        if ($role == 'user') {
            $campaignQ->where('user_id', $user_id)->where('company_id', $company_id);
            $listQ->where('user_id', $user_id)->where('company_id', $company_id);
        } elseif ($role == 'company') {
            $campaignQ->where('company_id', $company_id);
            $listQ->where('company_id', $company_id);
        }
        $campaigns = $campaignQ->where('status', '!=', 'inactive')->get();

        $contactLists = $listQ->where('status', '!=', 'inactive')->get();

        // $users = User::Where('id', '!=', '1')->where('role','user')->with('company')->get();
        // $users_counter = User::select('role', \DB::raw('count(*) as total'))
        //                 ->groupBy('role')
        //                 ->get()->toArray();
        // // $users_count = 0;
        // $adminCount = 0;
        // $companyCount = 0;

        // if(count($users_counter)> 0){
        //     foreach($users_counter as $user){
        //         // if($user['role'] == "user"){
        //         //     $users_count = $user['total'];
        //         // }
        //         if($user['role'] == "company"){
        //             $companyCount = $user['total'];
        //         }
        //         if($user['role'] == "admin"){
        //             $adminCount = $user['total'];
        //         }
        //     }
        // }
        // // dd($users_counter);
        // $user = Auth::user();
        // $user_id = $user->id;

        // $contact_lists = ContactList::count();
        // $campaignsCounter = Campaign::with('user','campaignStats')
        //     //->withCount('campaignContacts')
        //     // ->withCount([
        //     //     'campaignContacts',
        //     //     'campaignContacts as success' => function ($query) {
        //     //         $query->where('status', 'success');
        //     //     },
        //     //     'campaignContacts as fail' => function ($query) {
        //     //         $query->where('status', 'fail');
        //     //     },
        //     //     'campaignContacts as pending' => function ($query) {
        //     //         $query->where('status', 'pending');
        //     //     },
        //     //     'campaignContacts as initiated' => function ($query) {
        //     //         $query->where('status', 'initiated');
        //     //     },
        //     //     ])
        //     ->get();

        // $totalPending=0;
        // $totalSent=0;
        // // $totalDNC = 0;
        // // $totalContacts = 0;
        // $sqlQuery = sprintf("select sum(contact_count) as contact_count, sum(sent_count) as sent_count, sum(dnc_count) as dnc_count from campaign_stats");
        // $countersArray = collect(\DB::select(\DB::raw($sqlQuery)))->first();
        // if($countersArray != null){
        //     $totalPending = $countersArray->contact_count != 0 ? $countersArray->contact_count - $countersArray->sent_count - $countersArray->dnc_count : 0;
        //     $totalSent=$countersArray->sent_count;
        //     // $totalDNC = $countersArray->dnc_count;
        // }
        // // dd($countersArray->contact_count);

        // // if($campaignsCounter->isNotEmpty()){
        // //     foreach($campaignsCounter as $key => $value)
        // //      {
        // //         // if($value->initiated != 0 && $value->campaign_contacts_count != 0){
        // //         //     $totalSent++;
        // //         // }
        // //         // if($value->pending != 0 && $value->campaign_contacts_count != 0){
        // //         //     $totalPending++;
        // //         // }
        // //         if($value->campaignStats != null){
        // //             if($value->campaignStats->sent_count != null){
        // //                 $totalSent += $value->campaignStats->sent_count;
        // //             }
        // //             if($value->campaignStats->contact_count != 0 || $value->campaignStats->sent_count != null){
        // //                 $pending = $value->campaignStats->sent_count != null ? $value->campaignStats->contact_count - $value->campaignStats->sent_count : 0;
        // //                 $totalPending += $pending;
        // //             }
        // //             if($value->campaignStats->dnc_count != null){
        // //                 $totalDNC += $value->campaignStats->dnc_count;
        // //             }
        // //             if($value->campaignStats->contact_count != null){
        // //                 $totalContacts += $value->campaignStats->contact_count;
        // //             }
        // //         }

        // //      }
        // // }
        // $totalDNC = DNC::count();
        // $total_recording = Recording::count();
        // dd($totalContacts,$totalPending,$totalSent,$totalDNC);
        // return view('admin.reports.index', compact('users','campaignsCounter', 'contact_lists','totalPending','totalSent','totalDNC','total_recording','adminCount','companyCount'));
        return view('admin.reports.index', compact('campaigns', 'contactLists'));
    }

    public function counterIndex(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $campaignQ = Campaign::query();
        $listQ = ContactList::query();

        if ($role == 'user') {
            $campaignQ->where('user_id', $user_id)->where('company_id', $company_id);
            $listQ->where('user_id', $user_id)->where('company_id', $company_id);
        } elseif ($role == 'company') {
            $campaignQ->where('company_id', $company_id);
            $listQ->where('company_id', $company_id);
        }
        $campaigns = $campaignQ->where('status', '!=', 'inactive')->get();

        $contactLists = $listQ->where('status', '!=', 'inactive')->get();

        return view('admin.reports.counters', compact('campaigns', 'contactLists'));
    }

    public function getCounters(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $recordingQ = Recording::query();
        $listQ = ContactList::query();
        $contactQ = Contact::query();
        $statsUserWhere = '';
        $statsCompanyWhere = '';
        $campaignIdWhere = '';
        // $listIdWhere = '';
        // $noOfCallsPerCampaignWhere = '';
        // $noOfCallsPerCampaignIdWhere = '';
        // $avgCallDurationCampaignWhere = '';
        // $avgCallDurationCampaignIdWhere = '';

        $inboundCallsPerSecond = '';
        $outgoingCallsPerSecond = '';

        if ($role == 'user') {
            $statsUserWhere = sprintf('and user_id::BIGINT ='.$user_id.' and company_id::BIGINT= '.$company_id.'');
            $recordingQ->where('user_id', $user_id)->where('company_id', $company_id);
            $listQ->where('user_id', $user_id)->where('company_id', $company_id);
            $contactQ->where('user_id', $user_id)->where('company_id', $company_id);

            // $noOfCallsPerCampaignWhere ='AND c.user_id ='.$user_id.' AND c.company_id= '.$company_id.'';
            // $avgCallDurationCampaignWhere ='AND c.user_id ='.$user_id.' AND c.company_id= '.$company_id.'';

            $inboundCallsPerSecond = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT= '.$company_id.'';
            $outgoingCallsPerSecond = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT= '.$company_id.'';
        } elseif ($role == 'company') {
            $statsCompanyWhere = 'and company_id::BIGINT='.$company_id.'';
            $recordingQ->where('company_id::BIGINT', $company_id);
            $listQ->where('company_id::BIGINT', $company_id);
            $contactQ->where('company_id::BIGINT', $company_id);
            //  $noOfCallsPerCampaignWhere ='AND c.company_id= '.$company_id.'';
            //  $avgCallDurationCampaignWhere ='AND c.company_id= '.$company_id.'';

            $inboundCallsPerSecond = ' AND c.company_id::BIGINT= '.$company_id.'';
            $outgoingCallsPerSecond = ' AND c.company_id::BIGINT= '.$company_id.'';
        }
        $inboundCampaignIdWhere = '';
        $outgoingCampaignIdWhere = '';
        if ($campaign_id != null) {
            $campaignIdWhere = 'and campaign_id::BIGINT='.$campaign_id.'';
            $campaign = Campaign::find($campaign_id);
            $contactQ->whereIn('contact_list_id', json_decode($campaign->contact_list_id));
            //  $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            //  $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';

            $inboundCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            $outgoingCampaignIdWhere = 'AND c.id='.$campaign_id.'';
        }

        $dateWhere = sprintf("where created_at::Date between '$start_date'::DATE AND '$end_date'::DATE");
        // dd($campaignIdWhere );
        $campaignConter = sprintf('select sum(contact_count) as contact_count, sum(sent_count) as sent_count,sum(dnc_count) as dnc_count from campaign_stats %s %s %s %s', $dateWhere, $campaignIdWhere, $statsUserWhere, $statsCompanyWhere);
        $campaignConterData = collect(\DB::select(\DB::raw($campaignConter)))->first();

        $totalRecordings = $recordingQ->where('status', true)->whereBetween('created_at', [$start_date, $end_date])->count();
        $totalLists = $listQ->where('status', 'active')->whereBetween('created_at', [$start_date, $end_date])->count();
        if ($list_id != null) {
            $contactQ->where('contact_list_id', $list_id);
        }
        $totalContacts = $contactQ->where('status', 'active')->whereBetween('created_at', [$start_date, $end_date])->count();

        $billing = $this->billingData($start_date, $end_date, $campaign_id);

        $inboundDateWhere = sprintf("WHERE icl.updated_at::Date between '$start_date'::DATE AND '$end_date'::DATE");
        $outgoingDateWhere = sprintf("WHERE cc.updated_at::Date between '$start_date'::DATE AND '$end_date'::DATE");

        $inboundCall = "SELECT icl.\"Direction\" as call_type, count(*) AS call_count FROM incoming_call_logs icl
            LEFT JOIN campaigns c on c.id = icl.campaign_id::BIGINT
            $inboundDateWhere
            $inboundCallsPerSecond
            $inboundCampaignIdWhere
            AND icl.campaign_id IS NOT NULL AND icl.\"Direction\" IS NOT NULL
            GROUP BY icl.\"Direction\";
        ";
        $inboundCallData = collect(\DB::select(\DB::raw($inboundCall)))->first();
        $outgoingCall = "SELECT cc.status as call_type, count(*) AS call_count FROM campaign_contacts cc
            LEFT JOIN campaigns c on c.id = cc.campaign_id::BIGINT
            $outgoingDateWhere
            $outgoingCallsPerSecond
            $outgoingCampaignIdWhere
            AND cc.campaign_id IS NOT NULL AND cc.status = 'initiated'
            GROUP BY cc.status;
        ";
        $outgoingCallData = collect(\DB::select(\DB::raw($outgoingCall)))->first();
        $start = new \Carbon\Carbon($start_date);
        $end = new \Carbon\Carbon($end_date);
        $totalDuration = $end->diffInSeconds($start);

        return response()->json(
            [
                'campaignCounters' => $campaignConterData,
                'totalRecordings' => $totalRecordings,
                'totalLists' => $totalLists,
                'totalContacts' => $totalContacts,
                'billingPrice' => $billing,
                'inboundCall' => $inboundCallData,
                'outgoingCall' => $outgoingCallData,
                'totalDuration' => $totalDuration,
                // 'testsql'=>$outgoingCall,
            ]
        );
    }

    public function getSendRatesPerDay(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        // $list_id = $request->list_id;
        $campaignIdWhere = '';
        if ($campaign_id != null) {
            $campaignIdWhere = 'and campaign_id='.$campaign_id.'';
        }
        $userIdWhere = '';
        $companyIdWhere = '';
        if ($role == 'user') {
            $userIdWhere = 'AND user_id ='.$user_id.' AND company_id= '.$company_id.'';
        } elseif ($role == 'company') {
            $companyIdWhere = 'AND company_id= '.$company_id.'';
        }

        $campaignContact = "SELECT TRIM(LEADING '0' FROM to_char( updated_at::timestamp , 'HH12pm' )) as hour, to_char( updated_at::timestamp , 'Day') as weekday, count(*) as value
            FROM campaign_contacts
            where updated_at::date BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            AND status = 'initiated'
            $campaignIdWhere
            $userIdWhere
            $companyIdWhere
            GROUP BY hour,weekday
        ";
        $campaignContactPerDay = collect(\DB::select(\DB::raw($campaignContact)))->toArray();
        dd($campaignContact);

        return response()->json(
            [
                'sendRatesPerDay' => $campaignContactPerDay,
                // 'testsql'=>$campaignContact,
            ]
        );
    }

    public function getReportResults(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $recordingQ = Recording::query();
        $listQ = ContactList::query();
        $contactQ = Contact::query();
        $statsUserWhere = '';
        $statsCompanyWhere = '';
        $campaignIdWhere = '';
        // $listIdWhere = '';
        $noOfCallsPerCampaignWhere = '';
        $noOfCallsPerCampaignIdWhere = '';
        $avgCallDurationCampaignWhere = '';
        $avgCallDurationCampaignIdWhere = '';
        if ($role == 'user') {
            $statsUserWhere = sprintf('and user_id ='.$user_id.' and company_id= '.$company_id.'');
            $recordingQ->where('user_id', $user_id)->where('company_id', $company_id);
            $listQ->where('user_id', $user_id)->where('company_id', $company_id);
            $contactQ->where('user_id', $user_id)->where('company_id', $company_id);

            $noOfCallsPerCampaignWhere = 'AND c.user_id ='.$user_id.' AND c.company_id= '.$company_id.'';
            $avgCallDurationCampaignWhere = 'AND c.user_id ='.$user_id.' AND c.company_id= '.$company_id.'';
        } elseif ($role == 'company') {
            $statsCompanyWhere = 'and company_id='.$company_id.'';
            $recordingQ->where('company_id', $company_id);
            $listQ->where('company_id', $company_id);
            $contactQ->where('company_id', $company_id);
            $noOfCallsPerCampaignWhere = 'AND c.company_id= '.$company_id.'';
            $avgCallDurationCampaignWhere = 'AND c.company_id= '.$company_id.'';
        }
        if ($campaign_id != null) {
            $campaignIdWhere = 'and campaign_id='.$campaign_id.'';
            $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';
        }
        $dateWhere = sprintf("where created_at::Date between '$start_date'::DATE AND '$end_date'::DATE");
        // dd($campaignIdWhere );
        $campaignConter = sprintf('select sum(contact_count) as contact_count, sum(sent_count) as sent_count,sum(dnc_count) as dnc_count from campaign_stats %s %s %s %s', $dateWhere, $campaignIdWhere, $statsUserWhere, $statsCompanyWhere);
        $campaignConterData = collect(\DB::select(\DB::raw($campaignConter)))->first();

        $totalRecordings = $recordingQ->where('status', true)->whereBetween('created_at', [$start_date, $end_date])->get();
        $totalLists = $listQ->where('status', 'active')->whereBetween('created_at', [$start_date, $end_date])->get();
        $totalContacts = $contactQ->where('status', 'active')->whereBetween('created_at', [$start_date, $end_date])->get();

        $billing = $this->billingData($start_date, $end_date, $campaign_id);

        $noOfCallsPerCampaignPieChartSql = "SELECT icl.campaign_id, c.name,  count(*) AS call_backs FROM incoming_call_logs icl
            LEFT JOIN campaign_contacts cc on icl.campaign_contact_id = cc.id
            LEFT JOIN campaigns c on c.id = icl.campaign_id
            WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            $noOfCallsPerCampaignWhere
            $noOfCallsPerCampaignIdWhere
            AND icl.campaign_id IS NOT NULL
            GROUP BY icl.campaign_id, c.name;
        ";
        $noOfCallsPerCampaign = collect(\DB::select(\DB::raw($noOfCallsPerCampaignPieChartSql)))->all();

        $avgCallDurationPerCampaignPieChartSql = "SELECT icl.campaign_id, c.name,  AVG(icl.duration) AS avg_duration FROM incoming_call_logs icl
            LEFT JOIN campaign_contacts cc on icl.campaign_contact_id = cc.id
            LEFT JOIN campaigns c on c.id = icl.campaign_id
            WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            $avgCallDurationCampaignWhere
            $avgCallDurationCampaignIdWhere
            AND icl.campaign_id IS NOT NULL
            GROUP BY icl.campaign_id, c.name;
        ";
        $avgCallDurationPerCampaign = collect(\DB::select(\DB::raw($avgCallDurationPerCampaignPieChartSql)))->all();

        return response()->json(
            [
                'campaignCounters' => $campaignConterData,
                'totalRecordings' => count($totalRecordings),
                'totalLists' => count($totalLists),
                'totalContacts' => count($totalContacts),
                'billingPrice' => $billing,
                'noOfCallsPerCampaign' => $noOfCallsPerCampaign,
                'avgCallDurationPerCampaign' => $avgCallDurationPerCampaign,
                // 'testsql'=>$avgCallDurationPerCampaignPieChartSql
            ]
        );
    }

    public function billingData($start_date, $end_date, $campaign_id)
    {
        $startDate = $start_date;
        $endDate = $end_date;

        $userConditionCC = '';
        $userConditionMN = '';
        $userConditionICL = '';
        $compConditionCC = '';
        $compConditionMN = '';
        $compConditionICL = '';

        if (auth()->user()->role == 'user') {
            $compId = auth()->user()->company_id;
            $userId = auth()->user()->id;

            $compConditionCC = "AND cc.company_id = $compId";
            $compConditionMN = "AND mn.company_id = $compId";
            $compConditionICL = "AND icl.company_id = $compId";
            $userConditionCC = "AND cc.user_id = $userId";
            $userConditionMN = "AND mn.user_id = $userId";
            $userConditionICL = "AND icl.user_id = $userId";
        } elseif (auth()->user()->role == 'company') {
            $compId = auth()->user()->company_id;
            $compConditionCC = "AND cc.company_id = $compId";
            $compConditionMN = "AND mn.company_id = $compId";
            $compConditionICL = "AND icl.company_id = $compId";
        }

        $campaignIdCC = '';

        if ($campaign_id !== null) {
            $campaignIdCC = "AND c.id = $campaign_id";
        }

        $sql = sprintf("
        (
            SELECT -- cc.updated_at::DATE,
                -- cc.user_id,
                -- (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
                -- MAX(comp.name) AS company_name,
                -- cc.company_id,
                -- COUNT(*)                                AS quantity,
                UPPER(c.campaign_type) AS type,
                -- 'Campaign'   AS name,
                -- MAX(us.value::DECIMAL)        AS unit_price,
               SUM(price)::DECIMAL      AS price
            FROM campaign_contacts cc
                    LEFT JOIN campaigns c ON c.id = cc.campaign_id
                    LEFT JOIN users u ON u.id = cc.user_id
                    LEFT JOIN companies comp ON comp.id = cc.company_id
                    LEFT JOIN company_settings us ON cc.company_id = us.company_id AND us.key = (CONCAT(c.campaign_type, '_call_price'))
                    LEFT JOIN api_settings s ON s.slug = c.campaign_type
            WHERE cc.status = 'initiated'
            $compConditionCC
            $userConditionCC
            $campaignIdCC
            AND cc.updated_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
            GROUP BY cc.user_id, cc.company_id, c.campaign_type
            ORDER BY cc.user_id, cc.company_id, type
        )
        UNION
        (
            SELECT -- mn.created_at::DATE,
            -- mn.user_id,
            -- (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
            -- MAX(comp.name) AS company_name,
            --  mn.company_id,
            -- COUNT(*)                                AS quantity,
             'PHONE'                                 AS type,
            -- 'Number Purchase'                       AS name,
            -- MAX(us.value::DECIMAL)                       AS unit_price,
                (COUNT(*)::DECIMAL * MAX(us.value::DECIMAL))::DECIMAL AS price
            FROM my_numbers mn
                    LEFT JOIN company_settings us ON mn.company_id = us.company_id AND us.key = 'number_price'
                    LEFT JOIN users u ON u.id = mn.user_id
                    LEFT JOIN companies comp ON comp.id = mn.company_id
            WHERE mn.created_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
            $compConditionMN
            $userConditionMN
            GROUP BY mn.user_id, mn.company_id
            ORDER BY mn.user_id, mn.company_id, type
        )
        UNION
        (
            SELECT -- icl.created_at::DATE,
            --  icl.user_id,
            -- (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
            -- MAX(comp.name) AS company_name,
            -- icl.company_id,
            -- COUNT(*)                                AS quantity,
            'INCOMING'                              AS type,
            -- 'Incoming Call Price'                   AS name,
            --  MAX(us.value::DECIMAL)                      AS unit_price,
                SUM(icl.call_price::DECIMAL)                          AS price
            FROM incoming_call_logs icl
                LEFT JOIN company_settings us ON icl.company_id = us.company_id AND us.key = 'per_minute_call_price'
                LEFT JOIN users u ON u.id = icl.user_id
                LEFT JOIN companies comp ON comp.id = icl.company_id
            WHERE icl.created_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
            $compConditionICL
            $userConditionICL
            AND icl.user_id IS NOT NULL
            GROUP BY icl.user_id, icl.company_id
            ORDER BY icl.user_id, icl.company_id, type
        )

        ");
        // return $sql;

        $billableItems = DB::select(DB::raw($sql));
        $pricesSum = 0;

        if (count($billableItems) > 0) {
            foreach ($billableItems as $billing) {
                $pricesSum = (float) $pricesSum + (float) $billing->price;
            }
        }

        return $pricesSum;
    }

    public function callbackPieChart(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $campaignQ = Campaign::query();

        if ($role == 'user') {
            $campaignQ->where('user_id', $user_id)->where('company_id', $company_id);
        } elseif ($role == 'company') {
            $campaignQ->where('company_id', $company_id);
        }
        $campaigns = $campaignQ->where('status', '!=', 'inactive')->get();

        return view('admin.reports.callback_piechart', compact('campaigns'));
    }

    public function getCallbackPieChart(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

        $noOfCallsPerCampaignWhere = '';
        $noOfCallsPerCampaignIdWhere = '';
        $avgCallDurationCampaignWhere = '';
        $avgCallDurationCampaignIdWhere = '';

        if ($role == 'user') {
            $noOfCallsPerCampaignWhere = 'AND c.user_id ='.$user_id.' AND c.company_id= '.$company_id.'';
            $avgCallDurationCampaignWhere = 'AND c.user_id ='.$user_id.' AND c.company_id= '.$company_id.'';
        } elseif ($role == 'company') {
            $noOfCallsPerCampaignWhere = 'AND c.company_id= '.$company_id.'';
            $avgCallDurationCampaignWhere = 'AND c.company_id= '.$company_id.'';
        }
        if ($campaign_id != null) {
            $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';
        }

        $noOfCallsPerCampaignPieChartSql = "SELECT icl.campaign_id, c.name,  count(*) AS call_backs FROM incoming_call_logs icl
            LEFT JOIN campaign_contacts cc on icl.campaign_contact_id = cc.id
            LEFT JOIN campaigns c on c.id = icl.campaign_id
            WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            $noOfCallsPerCampaignWhere
            $noOfCallsPerCampaignIdWhere
            AND icl.campaign_id IS NOT NULL
            GROUP BY icl.campaign_id, c.name;
        ";
        $noOfCallsPerCampaign = collect(\DB::select(\DB::raw($noOfCallsPerCampaignPieChartSql)))->all();

        $avgCallDurationPerCampaignPieChartSql = "SELECT icl.campaign_id, c.name,  AVG(icl.duration) AS avg_duration FROM incoming_call_logs icl
            LEFT JOIN campaign_contacts cc on icl.campaign_contact_id = cc.id
            LEFT JOIN campaigns c on c.id = icl.campaign_id
            WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            $avgCallDurationCampaignWhere
            $avgCallDurationCampaignIdWhere
            AND icl.campaign_id IS NOT NULL
            GROUP BY icl.campaign_id, c.name;
        ";
        $avgCallDurationPerCampaign = collect(\DB::select(\DB::raw($avgCallDurationPerCampaignPieChartSql)))->all();

        return response()->json(
            [
                'noOfCallsPerCampaign' => $noOfCallsPerCampaign,
                'avgCallDurationPerCampaign' => $avgCallDurationPerCampaign,
                // 'testsql'=>$avgCallDurationPerCampaignPieChartSql
            ]
        );
    }

    public function callback(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $campaignQ = Campaign::query();

        if ($role == 'user') {
            $campaignQ->where('user_id', $user_id)->where('company_id', $company_id);
        } elseif ($role == 'company') {
            $campaignQ->where('company_id', $company_id);
        }
        $campaigns = $campaignQ->where('status', '!=', 'inactive')->get();

        return view('admin.reports.callback', compact('campaigns'));
    }

    public function getCallback(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

        $userConditionICL = '';
        $compConditionICL = '';

        if ($role == 'user') {
            $userConditionICL = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionICL = "AND icl.company_id = $company_id";
        }

        $campConditionICL = '';
        if ($campaign_id != '') {
            $campConditionICL = "AND icl.campaign_id = $campaign_id";
        }

        $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

        $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            WHERE icl.area_code IS NOT NULL
            $dateWhere
            $userConditionICL
            $compConditionICL
            $campConditionICL
            GROUP BY acl.location_code";

        $callbacks = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'callbacks' => $callbacks,
            // 'testSQL'=>$sql,
        ]);
    }

    public function callSentToDestination(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $campaignQ = Campaign::query();

        if ($role == 'user') {
            $campaignQ->where('user_id', $user_id)->where('company_id', $company_id);
        } elseif ($role == 'company') {
            $campaignQ->where('company_id', $company_id);
        }
        $campaigns = $campaignQ->where('status', '!=', 'inactive')->get();

        return view('admin.reports.call_sent_to_destination', compact('campaigns'));
    }

    public function getCallSentToDestination(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

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

        $dateWhere = sprintf("AND cc.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        $statusWhere = "AND cc.status IN('pending','initiated')";
        $sql = "SELECT
            COUNT(*) AS value,
            CONCAT('US-',acl.location_code) as id
            from campaign_contacts cc
            LEFT JOIN area_code_location acl on TRIM(SUBSTRING(cc.number, 3, 3)) = acl.area_code
            WHERE cc.number IS NOT NULL AND acl.location_code IS NOT NULL
            $dateWhere
            $statusWhere
            $userConditionCC
            $compConditionCC
            $campConditionCC
            GROUP BY acl.location_code";

        $callbacks = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'callbacks' => $callbacks,
            // 'testSQL'=>$sql,
        ]);
    }

    public function callBackDuration(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $campaignQ = Campaign::query();

        if ($role == 'user') {
            $campaignQ->where('user_id', $user_id)->where('company_id', $company_id);
        } elseif ($role == 'company') {
            $campaignQ->where('company_id', $company_id);
        }
        $campaigns = $campaignQ->where('status', '!=', 'inactive')->get();

        return view('admin.reports.call_back_duration', compact('campaigns'));
    }

    public function getCallBackDuration(Request $request)
    { 
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

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
        $sql = "SELECT SUM(icl.duration) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            WHERE icl.area_code IS NOT NULL
            $dateWhere
            $userConditionicl
            $compConditionicl
            $campConditionicl
            GROUP BY acl.location_code";

        $callbacks = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'callbacks' => $callbacks,
            // 'testSQL'=>$sql,
        ]);
    }

    public function getCampaignStats(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
        }

        $dateWhere = "WHERE c.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT c.name, c.campaign_type, cs.sent_count,
            (SELECT count(*) FROM incoming_call_logs icl WHERE icl.campaign_id = c.id) AS calls_back_count,
            (SELECT AVG(icl.duration) FROM incoming_call_logs icl WHERE icl.campaign_id = c.id) AS avg_calls_duration
                -- calls_back_count / cs.contact_count * 100 AS call_back_percentage
            FROM campaigns c
            LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            ORDER BY c.id desc;
        ";
        $campaginStats = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'campaginStats' => $campaginStats,
            // 'campaginStatsSQL'=>$sql,
        ]);
    }

    public function getListStats(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
        }

        $listCondition = '';
        if ($list_id != '') {
            $listCondition = "AND cc.contact_list_id = $list_id";
        }

        $dateWhere = "WHERE icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT c.id, c.name, c.campaign_type,cl.name as list_name, MAX(cs.sent_count) as sent_count, count(*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
        FROM incoming_call_logs icl
        LEFT JOIN campaigns c ON icl.campaign_id = c.id
        LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
        LEFT JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
        LEFT JOIN contact_lists cl on cl.id = cc.contact_list_id
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            AND c.name IS NOT NULL
            GROUP BY c.id, c.name, c.campaign_type,cl.name
            ORDER BY c.id desc;
        ";
        $listStats = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'listStats' => $listStats,
            // 'listStatsSQL'=>$sql,
        ]);
    }

    public function getRecordingStats(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhere = "WHERE c.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT r.name,
                   SUM(cs.sent_count) as sent_count,
                   MAX(t.calls_back_count)   AS calls_back_count,
                   MAX(t.avg_calls_duration) AS avg_calls_duration
                FROM recordings r
                         LEFT JOIN campaigns c on r.id = c.recording_id
                         LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
                         LEFT JOIN (
                    SELECT c.recording_id, count(*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
                    FROM incoming_call_logs icl
                             LEFT JOIN campaigns c on icl.campaign_id = c.id
                            $dateWhere
                            $campCondition
                            $userCondition
                            $compCondition
                    GROUP BY c.recording_id
                ) t ON t.recording_id = r.id
                $dateWhere
                $campCondition
                $userCondition
                $compCondition
                GROUP BY r.name";
        $recordingStats = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'recordingStats' => $recordingStats,
            // 'recordingStatsSQL'=>$sql,
        ]);
    }

    public function getStateStats(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $userCondition = '';
        $userConditionCC = '';
        $compCondition = '';
        $compConditionCC = '';

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
            $userConditionCC = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
            $compConditionCC = "AND cc.company_id = $company_id";
        }

        $campCondition = '';
        $campConditionCC = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
            $campConditionCC = "AND cc.campaign_id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhereIcl = "WHERE icl.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";
        $dateWhereCC = "WHERE cc.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT acl.area_code, acl.location_code,
       MAX(t.contact_count) as contact_count, COUNT(icl.*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
FROM incoming_call_logs icl
LEFT JOIN campaigns c ON icl.campaign_id = c.id
LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
LEFT JOIN area_code_location acl on TRIM(SUBSTRING(icl.\"From\", 3, 3)) = TRIM(acl.area_code)
LEFT JOIN (
    SELECT TRIM(SUBSTRING(cc.number, 3, 3)) AS area_code, COUNT(*) as contact_count
        FROM campaign_contacts cc
        $dateWhereCC
        $campConditionCC
        $userConditionCC
        $compConditionCC
        AND cc.status = 'initiated'
        GROUP BY TRIM(SUBSTRING(cc.number, 3, 3))
    ) t  ON TRIM(acl.area_code) = t.area_code
    $dateWhereIcl
    $campCondition
    $userCondition
    $compCondition
AND acl.area_code is not null
GROUP BY acl.area_code, acl.location_code;


        ";
        $stateStats = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'stateStats' => $stateStats,
            // 'stateStatsSQL'=>$sql,
        ]);
    }

    public function getCampaignTypeRatio(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND user_id = $user_id AND company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhere = "WHERE created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT COUNT(*) as total,campaign_type
            from campaigns
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            GROUP BY campaign_type
        ";
        $campaignRatio = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'campaignRatio' => $campaignRatio,
            // 'campaignRatioSQL'=>$sql,
        ]);
    }

    public function getCampaignSendRates(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

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

        $periods = CarbonPeriod::create(Carbon\Carbon::parse($request->start_date)->startOfDay(), Carbon\Carbon::parse($request->end_date)->endOfDay());
        $range = [];
        foreach ($periods as $period) {
            $date = $period->format('Y-m-d');
            $dataX = [
                'date' => $date,
                'value' => 0,
            ];
            array_push($range, $dataX);
        }

        return response()->json([
            'campaignSendRates' => $campaignSendRates,
            'dateRange' => $range,
            // 'campaignSendRatesSQL'=>$sql,
        ]);
    }

    public function getInboundCallOvertime(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

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
        $inboundCall = collect(\DB::select(\DB::raw($sql)))->toArray();

        $periods = CarbonPeriod::create(Carbon\Carbon::parse($request->start_date)->startOfDay(), Carbon\Carbon::parse($request->end_date)->endOfDay());
        $range = [];
        foreach ($periods as $period) {
            $date = $period->format('Y-m-d');
            $dataX = [
                'date' => $date,
                'value' => 0,
            ];
            array_push($range, $dataX);
        }

        return response()->json([
            'inboundCall' => $inboundCall,
            'dateRange' => $range,
            // 'inboundCallSQL'=>$sql,
        ]);
    }

    public function getIvrOutboundStats(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhere = "WHERE ps.date::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT count(*) as total,
            SUM(CASE WHEN ps.status = 'noinput' THEN 1 ELSE 0 END) AS noinput_count,
            SUM(CASE WHEN ps.status = 'transfered' THEN  1 ELSE 0 END) AS transfered_count,
            SUM(CASE WHEN ps.status = 'optout' THEN  1 ELSE 0 END) AS optout_count,
            c.name as campaign_name
            FROM press1_status ps
            LEFT JOIN campaign_contacts cc ON cc.id = ps.tid::BIGINT
            LEFT JOIN campaigns c ON cc.campaign_id = c.id
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            AND c.name is NOT NULL
            GROUP BY c.name
        ";
        $ivrOutboundCalls = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'ivrOutboundCalls' => $ivrOutboundCalls,
            // 'ivrOutboundCallsSQL'=>$sql,
        ]);
    }

    public function getOutboundOptinHeatmap(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

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

        $outboundOptin = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'outboundOptin' => $outboundOptin,
            // 'testSQL'=>$sql,
        ]);
    }

    public function getIvrDncHeatmap(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

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

        $ivrDncOptout = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'ivrDncOptout' => $ivrDncOptout,
            // 'testSQL'=>$sql,
        ]);
    }

    public function getDncHeatmap(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;

        $userConditionCC = '';
        $compConditionCC = '';

        if ($role == 'user') {
            $userConditionCC = "AND dc.user_id = $user_id AND dc.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionCC = "AND dc.company_id = $company_id";
        }

        // $campConditionCC = '';
        // if($campaign_id != ""){
        //     $campConditionCC = "AND cc.campaign_id = $campaign_id";
        // }

        $dateWhere = "WHERE dc.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT
                CONCAT('US-',acl.location_code) as id,
                COUNT(dc.*) as value
                FROM area_code_location acl
                        INNER JOIN dnc dc on TRIM(acl.area_code) = TRIM(SUBSTRING(dc.raw_number, 3, 3))
                $dateWhere
                $userConditionCC
                $compConditionCC
            GROUP BY acl.area_code, acl.location_code
        ";

        $dncHeatmap = collect(\DB::select(\DB::raw($sql)))->toArray();

        return response()->json([
            'dncHeatmap' => $dncHeatmap,
            // 'testSQL'=>$sql,
        ]);
    }

    public function reports_results(Request $request, $id)
    {
        if ($request->start_date !== null && $request->end_date !== null) {
            $start_date = Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
            $periods = CarbonPeriod::create(Carbon\Carbon::parse($request->start_date)->startOfDay(), Carbon\Carbon::parse($request->end_date)->endOfDay());
        } else {
            $start_date = Carbon\Carbon::now()->format('Y-m-d');
            $end_date = Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $periods = CarbonPeriod::create(Carbon\Carbon::now()->subDays(30), Carbon::now());
        }

        $user = User::Where('id', $id)->first();

        $played_campaigns = Campaign::Where('user_id', $user->id)->Where('status', 'played')->whereBetween('created_at', [$start_date, $end_date])->count();
        $paused_campaigns = Campaign::Where('user_id', $user->id)->Where('status', 'paused')->whereBetween('created_at', [$start_date, $end_date])->count();
        $inactive_campaigns = Campaign::Where('user_id', $user->id)->Where('status', 'inactive')->whereBetween('created_at', [$start_date, $end_date])->count();
        $finished_campaigns = Campaign::Where('user_id', $user->id)->Where('status', 'finished')->whereBetween('created_at', [$start_date, $end_date])->count();

        $campaigns = Campaign::with('user')
            ->Where('user_id', $id)
            //->withCount('campaignContacts')
            ->withCount([
                'campaignContacts',
                'campaignContacts as success' => function ($query) {
                    $query->where('status', 'success');
                },
                'campaignContacts as fail' => function ($query) {
                    $query->where('status', 'fail');
                },
                'campaignContacts as pending' => function ($query) {
                    $query->where('status', 'pending');
                },
                'campaignContacts as initiated' => function ($query) {
                    $query->where('status', 'initiated');
                },
                ])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();
        // dd($campaigns);
        $datesArray = [];
        $campaignInitiated = [];
        foreach ($periods as $period) {
            $date = $period->format('Y-m-d');
            array_push($datesArray, $date);

            $campaignInit = CampaignContact::select(\DB::raw('Date(updated_at)'), \DB::raw('count(*) as count'))
                                                ->Where('user_id', $id)
                                                ->Where('status', 'initiated')
                                                ->whereDate('updated_at', '=', $date)
                                                // ->whereBetween('updated_at', [$start_date, $end_date])
                                                ->groupBy(\DB::raw('Date(updated_at)'))
                                                ->first();
            if ($campaignInit == null) {
                array_push($campaignInitiated, 0);
            } else {
                array_push($campaignInitiated, $campaignInit->count);
            }
        }
        // $campaignInitiated = CampaignContact::select(\DB::raw('Date(updated_at)'),\DB::raw('count(*) as count'))
        //     ->Where('user_id', $id)
        //     ->Where('status', 'initiated')
        //     ->whereBetween('updated_at', [$start_date, $end_date])
        //     ->groupBy(\DB::raw('Date(updated_at)'))
        //     ->get();

        if ($request->drops_per_hour_date !== null) {
            $drops_per_hour_date = Carbon\Carbon::parse($request->drops_per_hour_date)->format('Y-m-d');
        } else {
            $drops_per_hour_date = Carbon\Carbon::now()->format('Y-m-d');
        }

        $campaignInitiatedPerHour = [];
        $dropsPerHourArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];

        foreach ($dropsPerHourArray as $array) {
            // dd($array);
            $campaignInitiatedHour = CampaignContact::select(\DB::raw('EXTRACT(HOUR FROM updated_at) as hour'), \DB::raw('count(*) as count'))
            ->Where('user_id', $id)
            ->Where('status', 'initiated')
            ->whereDate('updated_at', '=', $drops_per_hour_date)
            ->where(\DB::raw('EXTRACT(HOUR FROM updated_at)'), '=', $array)
            ->groupBy(\DB::raw('EXTRACT(HOUR FROM updated_at)'))
            ->first();

            if ($campaignInitiatedHour == null) {
                array_push($campaignInitiatedPerHour, 0);
            } else {
                array_push($campaignInitiatedPerHour, $campaignInitiatedHour->count);
            }
        }

        // if($campaigns != null){
        //     $contact_lists = json_decode($campaigns->contact_list_id);

        //     foreach ($contact_lists as $list_id) {
        //         $contact_list = ContactList::Where('id', $list_id)->first();
        //         $contact_list_contacts[] = $contact_list->total_contacts;
        //         $contact_list_names[] = $contact_list->name;
        //     }
        // }else{
        //     $contact_list_contacts=[];
        //     $contact_list_names=[];
        // }
        $successful = [];
        $initiated = [];
        $pending = [];
        $fail = [];
        $campaignNames = [];
        $contact_list_contacts = [];
        $contact_list_names = [];
        if ($campaigns->isNotEmpty()) {
            foreach ($campaigns as $camp) {
                $contact_lists = json_decode($camp->contact_list_id);
                array_push($campaignNames, $camp->name);
                array_push($successful, $camp->success);
                array_push($initiated, $camp->initiated);
                array_push($pending, $camp->pending);
                array_push($fail, $camp->fail);

                foreach ($contact_lists as $list_id) {
                    $contact_list = ContactList::Where('id', $list_id)->first();
                    if ($contact_list !== null) {
                        $contact_list_contacts[] = $contact_list->total_contacts;
                        $contact_list_names[] = $contact_list->name;
                    }
                }
            }
        } else {
            $contact_list_contacts = [];
            $contact_list_names = [];
        }

        // $contact_lists = ContactList::Where('user_id', $user->id)->whereBetween('created_at', [$start_date, $end_date])->get();
        $total_campaigns = Campaign::Where('user_id', $user->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        // foreach ($contact_lists as $list) {
        //     $contact_list_contacts[] = $list->total_contacts;
        //     $contact_list_names[] = $list->name;
        // }

        // dd($contact_list_contacts);
        return response()->json([
            'total_campaigns' => $total_campaigns,
            'campaigns' => $campaigns,
            'played_campaigns' => $played_campaigns,
            'paused_campaigns' => $paused_campaigns,
            'inactive_campaigns' => $inactive_campaigns,
            'finished_campaigns' => $finished_campaigns,
            // 'successful' => ($campaigns !== null ? $campaigns->success : 0),
            // 'initiated' => ($campaigns !== null ? $campaigns->initiated : 0),
            // 'pending' => ($campaigns !== null ? $campaigns->pending : 0),
            // 'fail' => ($campaigns !== null ? $campaigns->fail: 0),
            'successful' => $successful,
            'initiated' => $initiated,
            'pending' => $pending,
            'fail' => $fail,
            'contact_list_contacts' => isset($contact_list_contacts) ? $contact_list_contacts : '',
            'contact_list_names' => isset($contact_list_names) ? $contact_list_names : '',
            'campaignInitiated' => $campaignInitiated,
            'datesArray' => $datesArray,
            'dropsPerHourArray' => $dropsPerHourArray,
            'campaignInitiatedPerHour' => $campaignInitiatedPerHour,
            'campaignNames' => $campaignNames,
        ]);
    }

    public function reports_campaign_per_hour_results(Request $request)
    {
        if ($request->drops_per_hour_date !== null) {
            $drops_per_hour_date = Carbon\Carbon::parse($request->drops_per_hour_date)->format('Y-m-d');
        } else {
            $drops_per_hour_date = Carbon\Carbon::now()->format('Y-m-d');
        }

        // $user = Auth::user();
        $user_id = $request->user_id;

        $campaign_id = $request->campaign_id;

        $campaignInitiatedPerHour = [];
        $dropsPerHourArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];

        foreach ($dropsPerHourArray as $array) {
            // dd($array);
            $campaignInitiatedHour = CampaignContact::select(\DB::raw('EXTRACT(HOUR FROM updated_at) as hour'), \DB::raw('count(*) as count'))
            ->Where('user_id', $user_id)
            ->Where('status', 'initiated')
            ->whereDate('updated_at', '=', $drops_per_hour_date)
            ->where(\DB::raw('EXTRACT(HOUR FROM updated_at)'), '=', $array)
            ->groupBy(\DB::raw('EXTRACT(HOUR FROM updated_at)'))
            ->first();

            if ($campaignInitiatedHour == null) {
                array_push($campaignInitiatedPerHour, 0);
            } else {
                array_push($campaignInitiatedPerHour, $campaignInitiatedHour->count);
            }
        }

        // $campaignInitiatedPerHour = CampaignContact::select(\DB::raw('EXTRACT(HOUR FROM updated_at) as hour'),\DB::raw('count(*) as count'))
        //  ->Where('campaign_id', $campaign_id)
        //  ->Where('status', 'initiated')
        //  ->whereDate('updated_at', '=', $drops_per_hour_date)
        //  // ->whereBetween('updated_at', [$start_date, $end_date])

        //  ->groupBy(\DB::raw('EXTRACT(HOUR FROM updated_at)'))
        //  // \DB::raw('TO_CHAR(updated_at,"%Y-%M-%d")')

        //  //  ->groupBy(function($date) {
        //  //     return Carbon\Carbon::parse($date->updated_at)->format('Y-m-d'); // grouping by years
        //  //     //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        //  // })
        //  ->get();
        return response()->json([
            'campaignInitiatedPerHour' => $campaignInitiatedPerHour,
            'dropsPerHourArray' => $dropsPerHourArray,
        ]);
    }
}
