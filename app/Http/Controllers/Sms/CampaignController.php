<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ApiSetting;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SmsCampaign;
use App\Models\SmsCampaignContact;
use App\Models\SmsContact;
use App\Models\SmsContactList;
use App\Models\SmsBannedWord;
use App\Jobs\SmsCampaignJob;
use App\Jobs\SmsCampaignUpdateJob;
use App\Jobs\SmsCampaignResetJob;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SmsCampaignExport;
use App\Models\Conversation;
use App\Models\Message;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        if (!$company_id && $role == " user"){
        //    TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }

        $search = $request->search;
        $q = SmsCampaign::query();
        $q = $q->with('user','company','campaignStats');
        if ($search != null) {
            $q->whereHas('user', function ($query) use($search) {
                $query->where('first_name', 'ilike', '%'.$search.'%');
            })->orwhereHas('user', function ($query) use($search) {
                $query->where('last_name', 'ilike', '%'.$search.'%');
            })->orWhere('created_at', 'like','%'.$search.'%')
            ->orWhere('campaign_name', 'ilike','%'.$search.'%');;
        }
        if($role == "user"){
            $q->Where('user_id', $user_id)->Where('company_id', $company_id);
        }

        $campaigns = $q
            ->orderBy('id', 'desc')
            ->paginate(10);
        // dd($role);
        return view('sms.campaigns.index',compact('campaigns'));
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

        $sms_banned_words = SmsBannedWord::all();

        return view('sms.campaigns.create',compact('sms_banned_words'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $queue_name =  Str::random(10);

        // $message = $request->message;
        // if($request->domain !== null){
        //     $message = str_replace('[DOMAIN]', $request->domain, $message);
        // }
        // if($request->first_name !== null){
        //     $message = str_replace('[FNAME]', $request->first_name, $message);
        // }
        // if($request->last_name !== null){
        //     $message = str_replace('[LNAME]', $request->last_name, $message);
        // }
        // $recipient_list = $request->recipient;
        // $phonePattern = '/(phone|cell|number|mobile|contact)/i';
        // $firstNamePattern = '/(first_name|firstname|first name)/i';
        // $lastNamePattern = '/(last_name|last name|lastname)/i';
        // foreach($recipient_list as $recipient) {
        //     $contactList = SmsContactList::find($recipient);
        //     $contactListCsvUpload = storage_path().'/app/sms/contact-lists/'.$contactList->filename;
        //     $contactListCsv = array();
        //     $contatListFile = fopen($contactListCsvUpload, 'r');
        //     while (($result = fgetcsv($contatListFile)) !== false)
        //     {
        //         $contactListCsv[] = $result;
        //     }
        //     $data = [];
        //     $contactData = [];
        //     $number_arrays=[];
        //     $updatedFileRows = 0;

        //     $phoneIndex = '';
        //     $firstNameIndex = '';
        //     $lastNameIndex = '';
        //     foreach($contactListCsv[0] as $key=>$value){
        //         if(preg_match($phonePattern, strtolower($value)) !== 0){
        //             $phoneIndex = $key;
        //         }

        //         if(preg_match($firstNamePattern, strtolower($value)) !== 0){
        //             $firstNameIndex = $key;
        //         }

        //         if(preg_match($lastNamePattern, strtolower($value)) !== 0){
        //             $lastNameIndex = $key;
        //         }
        //     }

        //     if(count($contactListCsv) > 0){
        //         $x=0;
        //         for ($i=1; $i <= $contactList->total_contacts ; $i++) {
        //             $raw_number = preg_replace('/[^0-9]/', '', $contactListCsv[$i][$phoneIndex]);

        //             if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
        //                 // array_push($number_arrays,$contactListCsv[$i]);
        //                 $number_arrays[$x]['number']=$contactListCsv[$i][$phoneIndex];
        //                 $number_arrays[$x]['first_name']=$contactListCsv[$i][$firstNameIndex];
        //                 $number_arrays[$x]['last_name']=$contactListCsv[$i][$lastNameIndex];

        //                 $x++;
        //             }

        //         }//for loop end

        //         $unique_number_array = array_unique($number_arrays,SORT_REGULAR);
        //         $updatedFileRows = count($unique_number_array);

        //         if($unique_number_array !== null && $updatedFileRows > 0){

        //             foreach($unique_number_array as $num){
        //                 $formatNumber = formatNumber($num['number']);
        //                 if($formatNumber){
        //                     $data[] = [
        //                         'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num['number']),
        //                         'sms_contact_list_id' => $recipient,
        //                         'user_id' => $user_id,
        //                         'company_id' => $company_id,
        //                         'first_name' => $num['first_name'],
        //                         'last_name' => $num['last_name'],
        //                         'status' => "active",
        //                         'raw_number' => $formatNumber,
        //                         'created_at' => now()->toDateTimeString(),
        //                         'updated_at' => now()->toDateTimeString(),
        //                     ];
        //                     $contactData[] = [
        //                         'number'                   => $formatNumber,
        //                         // 'sms_campaign_id'          => $campaign->id,
        //                         'sms_contact_list_id'      => $recipient,
        //                         'first_name'               => $num['first_name'],
        //                         'last_name'                => $num['last_name'],
        //                         'status'                   => 'pending',
        //                         'user_id'                  => $user_id,
        //                         'company_id'               => $company_id,
        //                         'created_at'               => now()->toDateTimeString(),
        //                         'updated_at'               => now()->toDateTimeString(),
        //                     ];
        //                 }

        //             }//foreach loop end

        //             dd($data,$contactData);

        //         }//check unique number array if end


        //     }//count csv if end
        // }

        // dd($data,$contactData);

        $campaign = new SmsCampaign;
        $campaign->campaign_name = $request->campaign_name;
        $campaign->sms_contact_list_id = json_encode($request->recipient);
        $campaign->drops_per_hour = $request->drops_per_hour;
        $campaign->user_id = $user_id;
        $campaign->company_id = $company_id;
        $campaign->jobs = $queue_name;
        $campaign->campaign_type = $request->campaign_type;
        $campaign->forward_to_sms_number = $request->forward_number;
        $campaign->raw_forward_to_sms_number = formatNumber($request->forward_number) ? formatNumber($request->forward_number) : preg_replace('/[^0-9]/', '', $request->forward_number);
        $campaign->domain_url = $request->domain_url;
        $campaign->message = $request->message;
        $campaign->allow_long_message = $request->allow_long_message;
        $campaign->character_count = strlen($request->message);
        $campaign->variations = $request->message_variations;
        $campaign->receive_response = $request->receive_response;

        if ($request->campaign_time) {
            $date = Carbon::parse($request->campaign_time);
            $campaign->start_date = $date->format('Y-m-d');
            $campaign->status = "pending";
        }
        else {
            $campaign->start_date = Carbon::now()->toDateString();
            $campaign->status = "preprocessing";
        }


        if($request->has_banned_words == '1') {
            $campaign->status = "flagged";
        }

        $campaign->save();

        $campaign_id = $campaign->id;

        if($campaign->status !== "flagged") {
            SmsCampaignJob::dispatchAfterResponse($campaign_id);
        }

        return redirect()->route('user.sms_campaigns')->with('success','SMS Campaign Started Successfully.');

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
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $contact_lists = SmsContactList::select('id','name')
                                ->Where('user_id', auth()->user()->id)
                                ->where('company_id',auth()->user()->company_id)
                                ->where('status','!=','deleted')
                                ->get();

        $campaign = SmsCampaign::find($id);

        if($campaign->sms_contact_list_id !== null){
            $campaign->sms_contact_list_id = json_decode($campaign->sms_contact_list_id);
        }else{
            $campaign->sms_contact_list_id = null;
        }

        return view('sms.campaigns.edit', compact('contact_lists','campaign'));
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
        $user_id = $user->id;
        $company_id = $user->company_id;

        $queue_name =  Str::random(10);

        $campaign = SmsCampaign::findorFail($id);
        $campaign->campaign_name = $request->campaign_name;
        $campaign->sms_contact_list_id = json_encode($request->recipient);
        $campaign->drops_per_hour = $request->drops_per_hour;
        $campaign->user_id = $user_id;
        $campaign->company_id = $company_id;
        $campaign->jobs = $queue_name;
        $campaign->campaign_type = $request->campaign_type;
        $campaign->forward_to_sms_number = $request->forward_number;
        $campaign->raw_forward_to_sms_number = formatNumber($request->forward_number) ? formatNumber($request->forward_number) : preg_replace('/[^0-9]/', '', $request->forward_number);

        $campaign->domain_url = $request->domain_url;
        $campaign->message = $request->message;
        $campaign->allow_long_message = $request->allow_long_message;
        $campaign->character_count = strlen($request->message);
        $campaign->variations = $request->message_variations;
        $campaign->receive_response = $request->receive_response;

        //dd($request->has_banned_words);
        $campaign->status = $request->has_banned_words == '1'?"flagged":"preprocessing";
        $campaign->save();

        if($campaign->status !== "flagged") {
            SmsCampaignUpdateJob::dispatchAfterResponse($campaign);
        }

        return redirect()->route('user.sms_campaigns')->with('success','SMS Campaign Updated Successfully.');
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

    public function showContactList(Request $request,$campaign_id){

        $campaign = SmsCampaign::find($campaign_id);
        $contactList = [];
        // dd($campaign);
        if($campaign != null &&  $campaign->sms_contact_list_id !== null){
            $campaign->contact_list_ids = json_decode($campaign->sms_contact_list_id);
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
                $contact_lists[] = SmsContactList::Where('id', $list)->first();
            }
        }
        // dd($contact_lists);
        return view('sms.campaigns.view_contact_lists', compact('contact_lists', 'campaign'));
    }

    public function showContactListStatus(Request $request){
        $contact_list_id = $request->contact_list_id;
        $campaign_id = $request->campaign_id;
        $campaign_contact = SmsCampaignContact::where('sms_campaign_id',$campaign_id)->where('sms_contact_list_id',$contact_list_id)->paginate(10);

        $contactDncArray = SmsCampaignContact::where('sms_campaign_id',$campaign_id)
            ->where('sms_contact_list_id',$contact_list_id)->whereIn('number', function($query) {
                $query->select('raw_number')->from('dnc');
            })->get()->pluck('id')->toArray();

        return view('sms.campaigns.view_contact_list_status', compact('campaign_contact','contactDncArray'));

    }

    public function getSendSpeed(Request $request){
        $id = $request->id;
        $campaign = SmsCampaign::findorFail($id);
        return response()->json($campaign);
    }
    public function updateSendSpeed(Request $request)
    {
        $id = $request->id;
        $campaign = SmsCampaign::findorFail($id);
        $campaign->drops_per_hour = $request->drops_per_hour;
        $campaign->save();
        if(auth()->user()->role =="admin"){

            return redirect()->route('admin.sms_campaigns')->with('success','Sms Campaign Send Speed Updated Successfully.');
        }else{
            return redirect()->route('user.sms_campaigns')->with('success','Sms Campaign Send Speed Updated Successfully.');
        }

    }

    public function getCampaignContactList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $contact_lists = SmsContactList::select('id','name')->Where('company_id', $company_id)->Where('status','!=', 'deleted')->get();

        return response()->json($contact_lists);
    }

    public function getStats(Request $request){

        $campaignId = $request->id;
        $campaign = SmsCampaign::where('id',$campaignId)->with('campaignStats')->first();

        // $sql = sprintf("select user_id from dnc_time where day = '%s' and '%s' not between from_time and to_time",Carbon::now()->format('l'), Carbon::Now()->format('H:i:s'));
        $sql = sprintf("SELECT user_id FROM dnc_time WHERE  day = TRIM(TO_CHAR(NOW(), 'Day')) AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME");
        // dd($sql);
        $dnc_time_of_users =  DB::select(DB::raw($sql));

        $dnc_time_of_users_ids = collect($dnc_time_of_users)->where('user_id',$campaign->user_id)->toArray();
        $campaign->dnc_time_exists  = (count($dnc_time_of_users_ids) > 0 ? 0 : 1);

        return response()->json($campaign);
    }

    public function exportCampaigns($id)
    {
        if($id != null){
            return Excel::download(new SmsCampaignExport($id) ,'sms_campaign.csv');;
        }
    }

    public function change_status($status, $id)
    {
        // dd($status);
        $campaign = SmsCampaign::Where('id', $id)->first();
        if ($status == "resume") {

            $campaign->status = "played";

        }elseif ($status == "pause") {

            $campaign->status = "paused";

        }elseif ($status == "inactive") {

            $campaign->status = "inactive";

        }elseif ($status == "reset") {

            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            SmsCampaignResetJob::dispatchAfterResponse($id);


        }

        $campaign->save();

        return redirect()->back()->with('success','Campaign '.$status.' Successfully.');
    }





    public function loadConversations($id)
    {
        $campaign = SmsCampaign::findorFail($id);

        $conversations = Conversation::where('sms_campaign_id', $id)->get();

        return view('user.chat.index', compact('campaign'));
    }

    public function loadSmsConversations($id)
    {
        $campaign = SmsCampaign::findorFail($id);

        $conversations = Conversation::where('sms_campaign_id', $id)->get();

        $conversations = $conversations->map(function($conversation) {
            $messages = Message::where('conversation_id', $conversation->id)->limit(10)->get()->toArray();
            return [
                'id' => $conversation->id,
                'user_id' => $conversation->user_id,
                'company_id' => $conversation->company_id,
                'sms_campaign_id' => $conversation->sms_campaign_id,
                'phone_number' => $conversation->phone_number,
                'messages' => $messages
            ];
        });

        return $conversations;
    }


    public function messages($id, $conversation_id)
    {
        $query = Message::where('sms_campaign_id', $id);

        return $query->paginate(10);
    }
}
