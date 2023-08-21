<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\ContactList;
use App\Models\Recording;
use App\Models\CampaignContact;
use App\Models\User;
use App\Models\DNC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon;
use Carbon\CarbonPeriod;
class DashboardController extends Controller
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
        if (!$company_id){
//            TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }

//        $company = auth()->user()->company_id;
//        $company_users = User::where('company_id', $company)->get();
//        foreach ($company_users as $user) {
//            $user_id[] = $user->id;
//        }
        // if (auth()->user()->role == "user") {
        //     $campaigns = Campaign::Where('user_id', $user_id)->get();
        // }
        // elseif (auth()->user()->role == "company") {
        //     $campaigns = Campaign::Where('company_id', $company_id)->get();
        // }

        //----------------commented By Danial Start--------------------
        // $count_campaigns = count($campaigns);
        // $contact_lists = ContactList::Where('company_id', $company_id)->get();
        // $count_contact_lists = count($contact_lists);

        // $campaignsCounter = Campaign::with('user')
        //     ->Where('company_id', $company_id)
        //     //->withCount('campaignContacts')
        //     ->withCount([
        //         'campaignContacts',
        //         'campaignContacts as success' => function ($query) {
        //             $query->where('status', 'success');
        //         },
        //         'campaignContacts as fail' => function ($query) {
        //             $query->where('status', 'fail');
        //         },
        //         'campaignContacts as pending' => function ($query) {
        //             $query->where('status', 'pending');
        //         },
        //         'campaignContacts as initiated' => function ($query) {
        //             $query->where('status', 'initiated');
        //         },
        //         ])
        //     ->get();


        // $totalPending=0;
        // $totalSent=0;
        // if($campaignsCounter->isNotEmpty()){
        //     foreach($campaignsCounter as $key => $value)
        //      {
        //         if($value->initiated != 0 && $value->campaign_contacts_count != 0){
        //             $totalSent++;
        //         }
        //         if($value->pending != 0 && $value->campaign_contacts_count != 0){
        //             $totalPending++;
        //         }

        //      }
        // }

        // $totalDNC = DNC::Where('user_id', $user_id)->count();
        // -----------------Commented By Danial End----------------



        // $campaigns = Campaign::Where('user_id', auth()->user()->id)->get();
        // $count_campaigns = count($campaigns);
        // $contact_lists = ContactList::Where('user_id', auth()->user()->id)->get();
        // $count_contact_lists = count($contact_lists);
        // , 'count_campaigns', 'contact_lists', 'count_contact_lists','totalPending','totalSent','totalDNC'
        if (auth()->user()->role == "user") {
            $campaigns = Campaign::Where('user_id', $user_id)->get();
            $q = User::query();
            $q = $q->with('company')->withCount([
                'campaignStats as total_contact_count' => function ($query) {
                    $query->select(\DB::raw('SUM(contact_count) AS total_contact_count'));
                },
                'campaignStats as total_sent_count' => function ($query) {
                    $query->select(\DB::raw('SUM(sent_count) AS total_sent_count'));
                },
                // 'campaignStats as total_pending_count' => function ($query) {
                //     $query->select(\DB::raw('SUM(contact_count) - SUM(sent_count) AS total_pending_count'));
                // },
                // 'campaignStats as total_dnc_count' => function ($query) {
                //     $query->select(\DB::raw('SUM(dnc_count) AS total_dnc_count'));
                // },
            ]);
            $users = $q->where('company_id', $company_id)->where('id', $user_id)->first();
            // dd($users);
            $totalRecording = Recording::Where('company_id', $company_id)->where('user_id', $user_id)->count();
            $contact_lists = ContactList::Where('company_id', $company_id)->where('user_id', $user_id)->count();
            $totalDNC = DNC::Where('user_id', $user_id)->count();
            return view('user.dashboard.index', compact('campaigns','totalRecording','contact_lists','totalDNC','users'));
        }
        elseif (auth()->user()->role == "company") {
            $users = User::Where('role', 'user')->Where('company_id', auth()->user()->company_id)->get();
            $campaignsCounter = Campaign::with('user','campaignStats');
            // $campaigns = Campaign::Where('company_id', $company_id)->get();
            $campaignsCounter = $campaignsCounter->Where('company_id', $company_id);
            // $campaignsCounter =  $campaignsCounter->withCount([
            //     'campaignContacts',
            //     'campaignContacts as success' => function ($query) {
            //         $query->where('status', 'success');
            //     },
            //     'campaignContacts as fail' => function ($query) {
            //         $query->where('status', 'fail');
            //     },
            //     'campaignContacts as pending' => function ($query) {
            //         $query->where('status', 'pending');
            //     },
            //     'campaignContacts as initiated' => function ($query) {
            //         $query->where('status', 'initiated');
            //     },
            //     ])
            //     ->get();
            $campaignsCounter = $campaignsCounter->get();
            // dd($campaignsCounter);
            $count_campaigns = count($campaignsCounter);
            $totalPending=0;
            $totalSent=0;
            // $totalDNC = 0;
            $sqlQuery = sprintf("select sum(contact_count) as contact_count, sum(sent_count) as sent_count, sum(dnc_count) as dnc_count from campaign_stats where company_id=$company_id");
            $countersArray = collect(\DB::select(\DB::raw($sqlQuery)))->first();
            if($countersArray != null){
                $totalPending = $countersArray->contact_count != 0 ? $countersArray->contact_count - $countersArray->sent_count - $countersArray->dnc_count : 0;
                $totalSent=$countersArray->sent_count;
                // $totalDNC = $countersArray->dnc_count;
            }
            // if($campaignsCounter->isNotEmpty()){
            //     foreach($campaignsCounter as $key => $value)
            //      {
            //          if($value->campaignStats != null){
            //             if($value->campaignStats->sent_count != null){
            //                 $totalSent += $value->campaignStats->sent_count;
            //             }
            //             if($value->campaignStats->contact_count != 0 || $value->campaignStats->sent_count != null){
            //                 $pending = $value->campaignStats->sent_count != null ? $value->campaignStats->contact_count - $value->campaignStats->sent_count : 0;
            //                 $totalPending += $pending;
            //             }
            //             if($value->campaignStats->dnc_count != null){
            //                 $totalDNC += $value->campaignStats->dnc_count;
            //             }
            //          }
            //         // if($value->initiated != 0 && $value->campaign_contacts_count != 0){
            //         //     $totalSent++;
            //         // }
            //         // if($value->pending != 0 && $value->campaign_contacts_count != 0){
            //         //     $totalPending++;
            //         // }

            //      }
            // }

            $totalDNC = DNC::Where('company_id', $company_id)->count();
            $totalRecording = Recording::Where('company_id', $company_id)->count();
            $count_contact_lists = ContactList::Where('company_id', $company_id)->count();

            // $count_contact_lists = count($contact_lists);

            return view('company.dashboard.index', compact('campaignsCounter','users',
            'count_campaigns','totalPending','totalSent','count_contact_lists',
            'totalRecording','totalDNC'));
        }

    }
    public function getCompanyUserCampaigns(Request $request,$id){
        $user_id = $id;
        $user_campaigns = Campaign::select('id','name')->Where('user_id', $user_id)->get();
        return response()->json(['user_campaigns'=>$user_campaigns]);
    }
    public function ajaxDashboard(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id){
                //TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }

        if($request->start_date !== null && $request->end_date !== null){

            $start_date = Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

            // $campaigns = Campaign::Where('company_id', $company_id)->whereBetween('created_at', [$start_date, $end_date])->get();
            // $count_campaigns = count($campaigns);

            $campaignsCounter = Campaign::with('user');

            if (auth()->user()->role == "user") {
                $campaignsCounter = $campaignsCounter->Where('user_id', $user_id);
                $contact_lists = ContactList::Where('user_id', $user_id)->whereBetween('created_at', [$start_date, $end_date])->get();

                $count_contact_lists = count($contact_lists);
                $totalDNC = DNC::Where('user_id', $user_id)->whereBetween('created_at', [$start_date, $end_date])->count();
                $totalRecording = Recording::Where('user_id', $user_id)->whereBetween('created_at', [$start_date, $end_date])->count();
            }
            elseif (auth()->user()->role == "company") {
                $campaignsCounter = $campaignsCounter->Where('company_id', $company_id);
                // $contact_lists = ContactList::Where('company_id', $company_id)->whereBetween('created_at', [$start_date, $end_date])->get();

                // $count_contact_lists = count($contact_lists);

            }

            // $campaignsCounter->Where('company_id', $company_id);

            //->withCount('campaignContacts')
            $campaignsCounter =  $campaignsCounter->withCount([
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
                    // dd($campaignsCounter);
            $count_campaigns = count($campaignsCounter);

            $totalPending=0;
            $totalSent=0;
            if($campaignsCounter->isNotEmpty()){
                foreach($campaignsCounter as $key => $value)
                 {
                    if($value->initiated != 0 && $value->campaign_contacts_count != 0){
                        $totalSent++;
                    }
                    if($value->pending != 0 && $value->campaign_contacts_count != 0){
                        $totalPending++;
                    }

                 }
            }


        }else{
            $count_campaigns = 0;
            $totalPending =0;
            $count_contact_lists=0;
            $totalSent=0;
            $totalDNC=0;
            $start_date='';
            $end_date='';
            $totalRecording=0;
        }

        return response()->json(['count_campaigns'=>$count_campaigns,
            'totalPending'=>$totalPending,'count_contact_lists'=>$count_contact_lists,
            'totalSent'=>$totalSent,'totalDNC'=>$totalDNC,
            'start_date'=>$start_date,'end_date'=>$end_date,'total_recording'=>$totalRecording]);
    }

    public function dashboard_results(Request $request,$id)
    {
        if($request->start_date !== null && $request->end_date !== null){
            $start_date = Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
            $periods = CarbonPeriod::create(Carbon\Carbon::parse($request->start_date)->startOfDay(), Carbon\Carbon::parse($request->end_date)->endOfDay());
        }else{
            $start_date = Carbon\Carbon::now()->format('Y-m-d');
            $end_date = Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $periods = CarbonPeriod::create(Carbon\Carbon::now()->subDays(30), Carbon::now());
        }

        if($request->drops_per_hour_date !== null){
            $drops_per_hour_date = Carbon\Carbon::parse($request->drops_per_hour_date)->format('Y-m-d');
        }else{
            $drops_per_hour_date = Carbon\Carbon::now()->format('Y-m-d');
        }

        $campaigns = Campaign::with('user')
            ->Where('id', $id)
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
            // ->withCount([
            //     'campaignStats',
            //     'campaignStats as success' => function ($query) {
            //         $query->select('sent_count as success');
            //     },
            //     'campaignStats as fail' => function ($query) {
            //         $query->select('failed_count as fail');
            //     },
            //     'campaignStats as pending' => function ($query) {
            //         $query->select(\DB::raw('contact_count - sent_count AS pending'));
            //     },
            //     'campaignStats as initiated' => function ($query) {
            //         $query->select('initiated_count as initiated');
            //     },
            //     ])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->first();
        // dd($campaigns);
        $datesArray = [];
        $totalCampaignInitiated = [];

        foreach($periods as $period){
            $date = $period->format('Y-m-d');
            array_push($datesArray, $date );
            $campaignInit = CampaignContact::select(\DB::raw('Date(updated_at)'),\DB::raw('count(*) as count'))
                ->Where('campaign_id', $id)
                ->Where('status', 'initiated')
                // ->whereBetween('updated_at', [$start_date, $end_date])
                ->whereDate('updated_at', '=',$date)
                ->groupBy(\DB::raw('Date(updated_at)'))
                ->first();

            if($campaignInit == null){
                array_push($totalCampaignInitiated, 0 );
            }else{
                array_push($totalCampaignInitiated,$campaignInit->count);
            }
        }

        $campaignInitiatedPerHour = [];
        $dropsPerHourArray = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];

        foreach($dropsPerHourArray as $array){
            // dd($array);
            $campaignInitiatedHour = CampaignContact::select(\DB::raw('EXTRACT(HOUR FROM updated_at) as hour'),\DB::raw('count(*) as count'))
            ->Where('campaign_id', $id)
            ->Where('status', 'initiated')
            ->whereDate('updated_at', '=', $drops_per_hour_date)
            ->where(\DB::raw('EXTRACT(HOUR FROM updated_at)'), '=',$array)
            ->groupBy(\DB::raw('EXTRACT(HOUR FROM updated_at)'))
            ->first();

            if($campaignInitiatedHour == null){
                array_push($campaignInitiatedPerHour, 0 );
            }else{
                array_push($campaignInitiatedPerHour,$campaignInitiatedHour->count);
            }
        }
        // dd($campaignInitiatedPerHour);
        // $campaignInitiated = CampaignContact::select(\DB::raw('Date(updated_at)'),\DB::raw('count(*) as count'))
        //     ->Where('campaign_id', $id)
        //     ->Where('status', 'initiated')
        //     ->whereBetween('updated_at', [$start_date, $end_date])
        //     ->groupBy(\DB::raw('Date(updated_at)'))
        //     ->get();

        // $campaignInitiatedPerHour = CampaignContact::select(\DB::raw('EXTRACT(HOUR FROM updated_at) as hour'),\DB::raw('count(*) as count'))
        //     ->Where('campaign_id', $id)
        //     ->Where('status', 'initiated')
        //     ->whereDate('updated_at', '=', $drops_per_hour_date)
        //     // ->whereBetween('updated_at', [$start_date, $end_date])

        //     ->groupBy(\DB::raw('EXTRACT(HOUR FROM updated_at)'))
        //     // \DB::raw('TO_CHAR(updated_at,"%Y-%M-%d")')

        //     //  ->groupBy(function($date) {
        //     //     return Carbon\Carbon::parse($date->updated_at)->format('Y-m-d'); // grouping by years
        //     //     //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        //     // })
        //     ->get();
        $contact_list_contacts = [];
        $contact_list_names = [];
        if($campaigns != null){
            $contact_lists = json_decode($campaigns->contact_list_id);
            foreach ($contact_lists as $list_id) {
                $contact_list = ContactList::Where('id', $list_id)->first();
                if($contact_list !== null){
                    $contact_list_contacts[] = $contact_list->total_contacts;
                    $contact_list_names[] = $contact_list->name;
                }

            }
        }else{
            $contact_list_contacts=[];
            $contact_list_names=[];
        }


        // dd($contact_list_contacts);
        return response()->json([
            'campaigns' => $campaigns,
            'contact_list_contacts' => $contact_list_contacts,
            'contact_list_names' => $contact_list_names,
            'successful' => ($campaigns !== null ? $campaigns->success : 0),
            'initiated' => ($campaigns !== null ? $campaigns->initiated : 0),
            'pending' => ($campaigns !== null ? $campaigns->pending : 0),
            'fail' => ($campaigns !== null ? $campaigns->fail: 0),
            'totalCampaignContacts' => array_sum($contact_list_contacts),
            // 'campaignInitiated'=>$campaignInitiated,
            'campaignInitiatedPerHour'=>$campaignInitiatedPerHour,
            'periods'=>$datesArray,
            'totalCampaignInitiated'=>$totalCampaignInitiated,
            'dropsPerHourArray'=>$dropsPerHourArray,
        ]);
    }

    public function dashboard_campaign_per_hour_results(Request $request)
    {
        if($request->drops_per_hour_date !== null){
            $drops_per_hour_date = Carbon\Carbon::parse($request->drops_per_hour_date)->format('Y-m-d');
        }else{
            $drops_per_hour_date = Carbon\Carbon::now()->format('Y-m-d');
        }

        $campaign_id = $request->campaign_id;

        $campaignInitiatedPerHour = [];
        $dropsPerHourArray = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];

        foreach($dropsPerHourArray as $array){
            // dd($array);
            $campaignInitiatedHour = CampaignContact::select(\DB::raw('EXTRACT(HOUR FROM updated_at) as hour'),\DB::raw('count(*) as count'))
            ->Where('campaign_id', $campaign_id)
            ->Where('status', 'initiated')
            ->whereDate('updated_at', '=', $drops_per_hour_date)
            ->where(\DB::raw('EXTRACT(HOUR FROM updated_at)'), '=',$array)
            ->groupBy(\DB::raw('EXTRACT(HOUR FROM updated_at)'))
            ->first();

            if($campaignInitiatedHour == null){
                array_push($campaignInitiatedPerHour, 0 );
            }else{
                array_push($campaignInitiatedPerHour,$campaignInitiatedHour->count);
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
            'campaignInitiatedPerHour'=>$campaignInitiatedPerHour,
            'dropsPerHourArray'=>$dropsPerHourArray,
        ]);
    }
}
