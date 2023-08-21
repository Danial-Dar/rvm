<?php

namespace App\Http\Controllers\User;

use App\Exports\CampaignExport;
use App\Http\Controllers\Controller;
use App\Jobs\PauseCampaign;
use App\Jobs\ResumeCampaign;
use App\Jobs\StartCampaign;
use App\Jobs\CampaignReset;
use App\Models\Call;
use App\Models\CallData;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignList;
use App\Models\Contact;
use App\Models\ContactList;
use App\Models\DNC;
use App\Models\DNCTime;
use App\Models\MyNumber;
use App\Models\PressOneLog;
use App\Models\Recording;
use App\Models\Bot;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ApiSetting;
use App\Http\Helpers\Aws;
use Aws\S3\S3Client;
use App\Models\MyGroup;
use App\Models\MyGroupNumber;
use App\Models\CampaignCallerId;
use App\Jobs\CampaignUploadContactList;
use App\Jobs\CampaignUploadExistingContactList;
use App\Jobs\CampaignJob;
use App\Jobs\CampaignUpdateJob;
use Illuminate\Pagination\LengthAwarePaginator;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id){
//            TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }

        $search = $request->search;
        $q = Campaign::query();
        $q = $q->with('user','campaignStats');
        if ($search != null) {
            $q->whereHas('user', function ($query) use($search) {
                $query->where('first_name', 'ilike', '%'.$search.'%');
            })->orwhereHas('user', function ($query) use($search) {
                $query->where('last_name', 'ilike', '%'.$search.'%');
            })->orWhere('created_at', 'like','%'.$search.'%')->orWhere('name', 'ilike','%'.$search.'%');;
        }
        if(auth()->user()->role == "user"){
            $q->Where('user_id', $user_id);
        }
        $campaigns = $q
             ->Where('company_id', $company_id)
            //  ->withCount('campaignContacts')
            // ->withCount([
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
                ->orderBy('id', 'desc')
            ->paginate(10);
        return view('user.campaigns.index', compact('campaigns'));
    }

    public function getStats(Request $request){

        $campaignId = $request->id;

        // $campaign = Campaign::where('id',$campaignId)->withCount([
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
        //     ])->first();
        $campaign = Campaign::where('id',$campaignId)->with('campaignStats')->first();

        // $sql = sprintf("select user_id from dnc_time where day = '%s' and '%s' not between from_time and to_time",Carbon::now()->format('l'), Carbon::Now()->format('H:i:s'));
        $sql = sprintf("SELECT user_id FROM dnc_time WHERE  day = TRIM(TO_CHAR(NOW(), 'Day')) AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME");
        // dd($sql);
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

                WHERE c.id = $campaignId;
        ";
        $dailyLimit = collect(\DB::select(\DB::raw($dailyLimitSql)))->first();
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

        dd($campaign);
        return response()->json($campaign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        // return view('user.campaigns.create');
        return view('user.campaigns.wizard');
    }

    public function getAllCallerIds(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $q = MyNumber::query();
        if($request->exists('type') && $request->type =="callzy"){
            $q->where('type','CallzyOwned');
        }
        if($request->exists('type') && $request->type =="client"){
            $q->where('type','ClientNumber')->where('company_id',$company_id)->Where('user_id', $user_id);
        }
        if($request->exists('type') && $request->type =="testcall"){
            $numberList = $q->where('type','ClientNumber')->Where('status', 'active')->first();
        }else{
            $numberList = $q->select('id','number')->Where('status', 'active')->get();
        }
        // ->Where('is_group', false)
        return response()->json($numberList);

    }
    public function getAllCallerGroups(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $myGroups = MyGroup::select('id','name')->where('user_id', $user_id)->get();

        return response()->json($myGroups);
    }

    public function getCampaignContactList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $contact_lists = ContactList::select('id','name')->Where('company_id', $company_id)->Where('type', '<>','cir')->Where('status','!=', 'deleted')->get();

        return response()->json($contact_lists);
    }

    public function getCampaignRecordings(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $recordings = Recording::select('id','name')->Where('company_id', $company_id)->get();

        return response()->json($recordings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBot(Request $request)
    {
        $bots = Bot::all();

        return response()->json($bots);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        // $request->validate([
        //     'campaign_name' => 'required',
        //     'recipient' => 'required',
        //     'recording' => 'required',
        //     'ci_forward_number' => 'required |min:14|max:14',
        //     'vm_forward_number' => 'required |min:14|max:14',
        //     // 'caller_id' => 'required',
        //     'campaign_type' => 'required',
        //     'caller_id_button'=> $request->caller_id_random != null ? 'required|in:random' : ''
        //     // 'caller_id_button'=> $request->caller_id_random != null ? 'required|in:client_numbers,callzy_numbers,individual,random' : 'required|in:client_numbers,callzy_numbers,individual'
        // ]);

        $queue_name =  Str::random(10);

        $campaign = new Campaign;

        $campaign->name = $request->campaign_name;
        $campaign->caller_id = '';
        $campaign->contact_list_id = json_encode($request->recipient);
        $campaign->recording_id = $request->recording;
        $campaign->drops_per_hour = $request->drops_per_hour;
        $campaign->user_id = $user_id;
        $campaign->company_id = $company_id;
        // $campaign->jobs = json_encode([$queue_name]);
        $campaign->jobs = $queue_name;
        $campaign->campaign_type = $request->campaign_type;
        $campaign->bot_id = (isset($request->bot_type) ? $request->bot_type : null);

        $campaign->alpha_number = '';
        $campaign->ci_forward_number = $request->ci_forward_number;
        $campaign->raw_ci_forward_number = formatNumber($request->ci_forward_number) ? formatNumber($request->ci_forward_number) : preg_replace('/[^0-9]/', '', $request->ci_forward_number);
        $campaign->vm_forward_number = $request->vm_forward_number;
        $campaign->raw_vm_forward_number = formatNumber($request->vm_forward_number) ? formatNumber($request->vm_forward_number) : preg_replace('/[^0-9]/', '', $request->vm_forward_number);

        if($request->caller_id_random != null){
            $campaign->random = $request->caller_id_random;
            $campaign->is_random = true;
        }

        if ($request->campaign_type == "press-1") {
            $campaign->transfer_to_number = $request->transfer_to_number;
            $campaign->raw_transfer_to_number = formatNumber($request->transfer_to_number) ? formatNumber($request->transfer_to_number) : preg_replace('/[^0-9]/', '', $request->transfer_to_number);
            $campaign->opt_in_number = $request->opt_in_number;
            $campaign->opt_out_number = $request->opt_out_number;
            $campaign->recording_output_id = $request->optout_recording;
            $campaign->recording_optin_id = $request->optin_recording;
        }

        if ($request->campaign_time) {
            $date = Carbon::parse($request->campaign_time);
            $campaign->start_date = $date->format('Y-m-d');
            $campaign->status = "pending";
        }
        else {
            $campaign->start_date = Carbon::now()->toDateString();
            $campaign->status = "preprocessing";
        }

        $campaign->caller_filename = '';
        $campaign->alpha_filename = '';
        $campaign->save();

        $campaign_id = $campaign->id;
        // $recipient = json_decode($campaign->contact_list_id);
        // $caller_id_button = $request->caller_id_button;
        // $caller_id = $request->caller_id;
        // $caller_id_individual = $request->caller_id_individual;

        // CampaignJob::dispatchAfterResponse($campaign_id,$caller_id_button,$caller_id,$caller_id_individual);
        CampaignJob::dispatchAfterResponse($campaign_id);
//                                 ->onQueue($queue_name);

        // exec('php artisan create:campaign');

        if( $request->is('api/*')){
            return response()->json([ 'message' => 'Campaign Started Successfully', 'campaign' => $campaign]);
        }else{
            return redirect()->route('user.campaign')->with('success','Campaign Started Successfully.');
        }
    }

    public function change_status($status, $id)
    {
        // dd($status);
        $campaign = Campaign::Where('id', $id)->first();
        if ($status == "resume") {

            $campaign->status = "played";

            // $queue_name =  Str::random(10);

            // ResumeCampaign::dispatch($id)->onQueue($queue_name);

        }elseif ($status == "pause") {

            $campaign->status = "paused";

            // $queue_name =  Str::random(10);

            // PauseCampaign::dispatch($id)->onQueue($queue_name);

        }elseif ($status == "inactive") {

            $campaign->status = "inactive";

        }elseif ($status == "reset") {

            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            CampaignReset::dispatchAfterResponse($id);
            // $campaign_contacts = CampaignContact::Where('campaign_id', $id)->get();

            // foreach ($campaign_contacts as $contact) {
            //     $contact->status = "pending";
            //     $contact->save();
            // }

        }

        $campaign->save();

        return redirect()->back()->with('success','Campaign '.$status.' Successfully.');
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



    // waleed work
    public function showContactList(Request $request,$campaign_id){

        // $campaign_id = $campaign_id;
        $campaign = Campaign::find($campaign_id);
        $contactList = [];
        // dd($campaign);
        if($campaign != null &&  $campaign->contact_list_id !== null){
            $campaign->contact_list_ids = json_decode($campaign->contact_list_id);
        }else{
            $campaign->contact_list_ids = null;
        }
        if($campaign->contact_list_ids != null){

            foreach($campaign->contact_list_ids as $contact_list_id){
                $contactList[] = $contact_list_id;

            }
        }
        $contact_lists =[];
        if(count($contactList) > 0 ){
            foreach($contactList as $list){
                $contact_lists[] = ContactList::Where('id', $list)->first();
            }
        }
        // dd($contact_lists);
        return view('user.campaigns.view_contact_list', compact('contact_lists', 'campaign'));
    }
    public function showContactListStatus(Request $request){
        $contact_list_id = $request->contact_list_id;
        $campaign_id = $request->campaign_id;
        $campaign_contact = CampaignContact::where('campaign_id',$campaign_id)->where('contact_list_id',$contact_list_id)->paginate(10);

        $contactDncArray = CampaignContact::where('campaign_id',$campaign_id)
            ->where('contact_list_id',$contact_list_id)->whereIn('number', function($query) {
                $query->select('raw_number')->from('dnc');
            })->get()->pluck('id')->toArray();

        return view('user.campaigns.view_contact_list_status', compact('campaign_contact','contactDncArray'));

    }

    // waleed work end

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recordings = Recording::select('id','name')
                                ->Where('user_id', auth()->user()->id)
                                ->where('company_id',auth()->user()->company_id)
                                ->get();
        $contact_lists = ContactList::select('id','name')
                                    ->Where('user_id', auth()->user()->id)
                                    ->where('company_id',auth()->user()->company_id)
                                    ->where('status','!=','deleted')
                                    ->get();
        $campaign = Campaign::find($id);

        // $campaignCallerId = CampaignCallerId::Where('user_id', auth()->user()->id)
        //                                     ->whereIn('type', ['caller','alpha'])
        //                                     ->where('campaign_id', $id)
        //                                     ->get();

        // $individual = [];
        // $myNumbers = [];
        // $callzyNumbers = [];
        // if($campaign->campaignCallerId->isNotEmpty()){
        //     foreach($campaign->campaignCallerId as $caller){
        //          // --------------- caller type -------------

        //         if($caller->type =="caller" && $caller->caller_number_type == "client_numbers"){
        //             if($caller->my_numbers != null){
        //                 $data['id'] = $caller->my_numbers->id;
        //                 $data['number'] = $caller->my_numbers->number;
        //                 array_push($myNumbers,$data);
        //             }
        //         }

        //         if($caller->type =="caller" && $caller->caller_number_type == "individual"){
        //             if($caller->my_numbers != null){
        //                 $data1['id'] = $caller->my_numbers->id;
        //                 $data1['number'] = $caller->my_numbers->number;
        //                 array_push($individual,$data1);
        //             }
        //         }
        //         if($caller->type =="caller" && $caller->caller_number_type == "callzy_numbers"){
        //             if($caller->my_numbers != null){
        //                 $data2['id'] = $caller->my_numbers->id;
        //                 $data2['number'] = $caller->my_numbers->number;
        //                 array_push($callzyNumbers,$data2);
        //             }
        //         }

        //     }//foreach loop end
        // }//campaign caller id end

        if($campaign->contact_list_id !== null){
            $campaign->contact_list_ids = json_decode($campaign->contact_list_id);
        }else{
            $campaign->contact_list_ids = null;
        }

        $bots = Bot::select('id','bot_name')->get();

        // $count_individual = count($individual);
        // $count_myNumbers = count($myNumbers);
        // $count_callzyNumbers = count($callzyNumbers);
        return view('user.campaigns.update_wizard',
        compact(
            // 'count_individual',
            // 'count_myNumbers',
            // 'count_callzyNumbers',
            'recordings',
            'contact_lists',
            'campaign',
            // 'individual',
            // 'myNumbers',
            // 'callzyNumbers',
            'bots'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();
        //  $request->validate([
        //     'campaign_name' => 'required',
        //     'recipient' => 'required',
        //     'recording' => 'required',
        //     'campaign_type' => 'required',
        //     'ci_forward_number' => 'required |min:14|max:14',
        //     'vm_forward_number' => 'required |min:14|max:14',
        //     // 'caller_id_button'=> $request->caller_id_random != null ? 'required|in:client_numbers,callzy_numbers,individual,random' : 'required|in:client_numbers,callzy_numbers,individual'
        //     'caller_id_button'=> $request->caller_id_random != null ? 'required|in:random' : ''
        //     // 'caller_id' => 'required'
        // ]);

        $id = $request->id;
        $queue_name =  Str::random(10);

        $campaign = Campaign::findorFail($id);
        $campaign->name = $request->campaign_name;
        $campaign->jobs = $queue_name;
        $campaign->caller_id = '';
        $campaign->contact_list_id = json_encode($request->recipient);
        $campaign->recording_id = $request->recording;
        $campaign->drops_per_hour = $request->drops_per_hour;

        $campaign->campaign_type = $request->campaign_type;
        $campaign->bot_id = (isset($request->bot_type) ? $request->bot_type : null);


        $campaign->alpha_number = '';
        if($request->caller_id_random != null){
            $campaign->random = $request->caller_id_random;
            $campaign->is_random = true;
        }else{
            $campaign->random = null;
            $campaign->is_random = false;
        }
        if ($request->campaign_type == "press-1") {
            $campaign->transfer_to_number = $request->transfer_to_number;
            $campaign->raw_transfer_to_number = formatNumber($request->transfer_to_number) ? formatNumber($request->transfer_to_number) : preg_replace('/[^0-9]/', '', $request->transfer_to_number);
            $campaign->opt_in_number = $request->opt_in_number;
            $campaign->opt_out_number = $request->opt_out_number;
            $campaign->recording_output_id = $request->optout_recording;
            $campaign->recording_optin_id = $request->optin_recording;
        }

        if($request->ci_forward_number != null){
            $campaign->ci_forward_number = $request->ci_forward_number;
            $campaign->raw_ci_forward_number = formatNumber($request->ci_forward_number) ? formatNumber($request->ci_forward_number) : preg_replace('/[^0-9]/', '', $request->ci_forward_number);
        }
        if($request->vm_forward_number != null){
            $campaign->vm_forward_number = $request->vm_forward_number;
            $campaign->raw_vm_forward_number = formatNumber($request->vm_forward_number) ? formatNumber($request->vm_forward_number) : preg_replace('/[^0-9]/', '', $request->vm_forward_number);
        }

        $campaign->status = "preprocessing";
        $campaign->save();

        // $caller_id_button = $request->caller_id_button;
        // $caller_id = $request->caller_id;
        // $caller_id_individual = $request->caller_id_individual;

        // delete data related to this campaign from campaign caller ids table.
        // $deleteData = CampaignCallerId::where('campaign_id',$id)->forceDelete();

        // dispatch campaign update job

        // CampaignUpdateJob::dispatchAfterResponse($campaign,$caller_id,$caller_id_individual);
        CampaignUpdateJob::dispatchAfterResponse($campaign);
                                // ->onQueue($queue_name);



        return redirect()->route('user.campaign')->with('success','Campaign Updated Successfully.');
    }
    public function getSendSpeed(Request $request){
        $id = $request->id;
        $campaign = Campaign::findorFail($id);
        return response()->json($campaign);
    }
    public function updateSendSpeed(Request $request)
    {
        $id = $request->id;
        $campaign = Campaign::findorFail($id);
        $campaign->drops_per_hour = $request->drops_per_hour;
        // dd($request->all());
        $campaign->save();
        if(auth()->user()->role =="admin"){

            return redirect()->route('admin.dashboard')->with('success','Campaign Send Speed Updated Successfully.');
        }else{
            return redirect()->route('user.campaign')->with('success','Campaign Send Speed Updated Successfully.');
        }

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

    public function test(Request $request)
    {
        // if( $request->is('api/*')){
        //     return auth()->user()->id;
        // }else{

        //     return "we are on web";
        // }

        // $dnc_contacts_admin = DNC::Where('user_type', 'admin')->get();
        // $dnc_contacts_user = DNC::Where('user_id', 2)->get();
        // $dnc_contacts = [];

        // foreach ($dnc_contacts_admin as $admin) {
        //     $dnc_contacts[] = $admin->number;
        // }

        // foreach ($dnc_contacts_user as $user) {
        //     $dnc_contacts[] = $user->number;
        // }

        // $contacts = CampaignContact::Where('campaign_id', 52)
        //             ->Where('status', 'pending')->WhereNotIn('number' ,$dnc_contacts)->skip(0)->take(1054/60);

        // $user = Auth::user();
        // $user_id = $user->id;
        // $company_id = $user->company_id;
        // $days = Carbon::getDays();
        // $dnc_time = DNCTime::Where('user_id', $user_id)->get();
        // $dnc_array = [];
        // foreach ($dnc_time as $value) {
        //     $dnc_array[] = $value->day.'-'.$value->from_time.'-'.$value->to_time;
        // }

        $numbers = MyNumber::with('user')->Where('user_id', auth()->user()->id)->where('status', 'active')->get();


        // dd($dnc_array);
        // dd($days[0]);

        return view('user.test2', compact('numbers'));



    }

    public function test2()
    {
        $numbers = MyNumber::with('user')->Where('user_id', auth()->user()->id)->where('status', 'active')->get();
        return response()->json($numbers);
    }

    public function test3(Request $request)
    {
        dd($request->all());
    }

    public function exportCampaigns($id)
    {
        if($id != null){
            return Excel::download(new CampaignExport($id) ,'Campaign.csv');;
        }
    }

    public function testCallApi(Request $request){

        $slug         = $request->slug;
        $number_from  = $request->number_from;
        $number_to    = $request->number_to;
        $alpha_from   = $request->alpha_from;
        $recording_id = $request->recording_id;

        $api_setting = ApiSetting::Where('slug', $slug)->first();
        $recording = Recording::find($recording_id);

        // $aws = new  Aws();

        // $client = $aws->connect();

        // $cmd = $client->getCommand('GetObject', [
        //     'Bucket' => 'RVM',
        //     'Key'    => $recording->filename,
        //     'Content-Type'=> 'audio/mpeg'
        // ]);

        // $expiry = '+5 minutes';

        // try {
        //     $request = $client->createPresignedRequest($cmd, $expiry);
        //     $presignedUrl = (string) $request->getUri();
        // } catch(\Exception $e) {
        //     throw new Exception($e->getMessage());
        // }
        $alpha_from = preg_replace('/[^0-9]/', '', $alpha_from);
        $number_to = preg_replace('/[^0-9]/', '', $number_to);
        $number_from = preg_replace('/[^0-9]/', '', $number_from);
        $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $recording->filename;
        $params['alpha_from'] = '+' . str_pad($alpha_from, 11, "1", STR_PAD_LEFT);
        $params['number_from'] = '+' . str_pad($number_from, 11, "1", STR_PAD_LEFT);
        $params['number_to'] = $api_setting->prefix.'#' . str_pad($number_to, 11, "1", STR_PAD_LEFT);
        // $params['wavefile_url'] = "https://file-examples-com.github.io/uploads/2017/11/file_example_WAV_1MG.wav";
        $params['wavefile_url'] = $presignedUrl;
        $params['transaction_id'] = rand();
        $params['carrier_addr'] = $api_setting->carrier_address;
        // dd($params,$api_setting->end_point);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        //   CURLOPT_URL => 'http://135.148.102.82:7009/rvmdial',
          CURLOPT_URL => $api_setting->end_point,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($params),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        // dd($params);

        return response()->json($response,200,[],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    public function testCallApiPress1(Request $request){
        $slug         = $request->slug;
        $number_from  = $request->number_from;
        $number_to    = $request->number_to;
        $alpha_from   = $request->alpha_from;
        $wavurl_annouce = $request->recording_id;
        $wavurl_optout = $request->optout_recording;
        $wavurl_continue = $request->optin_recording;
        $digit_continue = $request->opt_in_number;
        $digit_optout = $request->opt_out_number;
        $transfer_dest = preg_replace('/[^0-9]/', '', $request->transfer_to_number);

        $api_setting = ApiSetting::Where('slug', $slug)->first();
        $recording = Recording::find($wavurl_annouce);

        // $aws = new  Aws();

        // $client = $aws->connect();

        // // WAVURL ANNOUCE RECORDING
        // $cmd = $client->getCommand('GetObject', [
        //     'Bucket' => 'RVM',
        //     'Key'    => $recording->filename,
        //     'Content-Type'=> 'audio/mpeg'
        // ]);

        // $expiry = '+5 minutes';

        // try {
        //     $request = $client->createPresignedRequest($cmd, $expiry);
        //     $presignedUrl = (string) $request->getUri();
        // } catch(\Exception $e) {
        //     throw new Exception($e->getMessage());
        // }
        $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $recording->filename;
        // wavurl_optout RECORDING
        $optout_recording = Recording::find($wavurl_optout);
        $presignedUrlOptout = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $optout_recording->filename;
        // $optoutcmd = $client->getCommand('GetObject', [
        //     'Bucket' => 'RVM',
        //     'Key'    => $optout_recording->filename,
        //     'Content-Type'=> 'audio/mpeg'
        // ]);

        // try {
        //     $request = $client->createPresignedRequest($optoutcmd, $expiry);
        //     $presignedUrlOptout = (string) $request->getUri();
        // } catch(\Exception $e) {
        //     throw new Exception($e->getMessage());
        // }

        // wavurl_optin RECORDING
        $optin_recording = Recording::find($wavurl_continue);
        $presignedUrlOptin = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $optin_recording->filename;
        // $optincmd = $client->getCommand('GetObject', [
        //     'Bucket' => 'RVM',
        //     'Key'    => $optin_recording->filename,
        //     'Content-Type'=> 'audio/mpeg'
        // ]);

        // try {
        //     $request = $client->createPresignedRequest($optincmd, $expiry);
        //     $presignedUrlOptin = (string) $request->getUri();
        // } catch(\Exception $e) {
        //     throw new Exception($e->getMessage());
        // }
        $alpha_from = preg_replace('/[^0-9]/', '', $alpha_from);
        $number_to = preg_replace('/[^0-9]/', '', $number_to);
        $number_from = preg_replace('/[^0-9]/', '', $number_from);
        $params['alpha_from'] = '+' . str_pad($alpha_from, 11, "1", STR_PAD_LEFT);
        $params['number_from'] = '+' . str_pad($number_from, 11, "1", STR_PAD_LEFT);
        $params['number_to'] = $api_setting->prefix.'#' . str_pad($number_to, 11, "1", STR_PAD_LEFT);
        $params['wavurl_annouce'] = $presignedUrl;
        $params['wavurl_optout'] = $presignedUrlOptout;
        $params['wavurl_continue'] = $presignedUrlOptin;
        $params['digit_continue'] = $digit_continue;
        $params['digit_optout'] = $digit_optout;
        $params['transfer_dest'] = $transfer_dest;
        $params['transaction_id'] = rand();
        $params['carrier_addr'] = $api_setting->carrier_address;
        // dd($params,$api_setting->end_point);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        //   CURLOPT_URL => 'http://135.148.102.82:7009/rvmdial',
          CURLOPT_URL => $api_setting->end_point,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($params),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        // dd($params);

        return response()->json($response,200,[],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    public function fsSimulation(Request $request){
        Log::info($request);
        $transaction_id = $request->get('transaction_id');
        $status = 'initiated';
        $call = Call::updateOrCreate(
            ['transaction_id' => $transaction_id, 'status' => $status],
        );
        Log::info($call);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $transaction_id,
                'status' => $status,
            ],
        ]);
    }


    public function pressOneAction(Request $request): \Illuminate\Http\JsonResponse
    {
        $transaction_id = $request->get('transaction_id');
        $number = $request->get('number');
        $raw_number = str_pad(preg_replace('/[^0-9]/', '', $number), 11, "1", STR_PAD_LEFT);
        $keypress = $request->get('keypress');
        $is_opt_in = $request->get('is_opt_in');
        $success = false;
        $messages = [];
        $pressOneLog = PressOneLog::updateOrCreate(
            ['campaign_contact_id' => $transaction_id, 'number' => $number],
            [
                'raw_number' => $raw_number, 'keypress' => $keypress,
                'is_opt_in' => $is_opt_in, 'request_data' => json_encode($request->all())
            ]
        );
        $messages[] = "Added PressOneLog";

        $campaignContact = CampaignContact::with('campaign')->where('id', $transaction_id)->first();
        if ($campaignContact && $campaignContact->campaign) {
            $messages[] ="Found campaign";
            $campaign = $campaignContact->campaign;
            if ($keypress == $campaign->opt_in_number){
                $messages[] ="Matched with opt in number";
                // handle opt in
            } else if ($keypress == $campaign->opt_out_number) {
                $messages[] ="Matched with opt out number";
                $success = true;
                DNC::updateOrCreate(
                    ['number' => $number, 'raw_number' => $raw_number],
                    ['user_type' => 'admin', 'user_id' => 1,]
                );
                $messages[] ="Added to DNC";
            } else {
                $messages[] ="Did not  matched with opt in or opt out number";
                // not opt in or out
            }
        } else {
            $messages[] ="Campaign not found";
        }

        return response()->json([
            'success' => $success,
            'data' => $pressOneLog->toArray(),
            'messages' => $messages,
        ]);
    }



}
