<?php

namespace Sms\SmsCampaignBuilder\Http\Controller;

use Carbon\Carbon;
use App\Models\SmsCampaign;
use App\Models\SmsBannedWord;
use Illuminate\Support\Str;
use App\Jobs\SmsCampaignJob;
use Illuminate\Http\Request;
use App\Models\SmsContactList;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sw_auth_token = config('app.sw_auth_token');
        $sw_project_id = config('app.sw_project_id');
        // dd($request->message_flow);
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $queue_name = Str::random(10);
////////////////////////////////////----------------------////////////////////start
        $company = Company::find($company_id);

        $curl = curl_init();

        // dd('Authorization: Basic '. base64_encode(env('SW_PROJECT_ID').":".env('SW_AUTH_TOKEN')));

        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/registry/beta/brands/3ee1aaa2-432c-4d5b-a096-3fac95386bcc/campaigns',
            CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/registry/beta/brands/'.$company->sw_brand_id.'/campaigns',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "name": "'.$request->campaign_name.'",
            "sms_use_case": "'.$request->sms_use_case.'",
            "campaign_verify_token": null,
            "description": "'.$request->description.'",
            "sample1": "'.$request->message.'",
            "sample2": "'.$request->message.'",
            "dynamic_templates": "string",
            "message_flow": "'.$request->message_flow.'",
            "opt_in_message": "'.$request->opt_in_message.'",
            "opt_out_message": "'.$request->opt_out_message.'",
            "help_message": "'.$request->help_message.'",
            "number_pooling_per_campaign": "'.$request->number_pooling_per_campaign.'",
            "direct_lending": "'.$request->direct_lending.'",
            "embedded_link": "'.$request->embedded_link.'",
            "embedded_phone": "'.$request->embedded_phone.'",
            "age_gated_content": "'.$request->age_gated_content.'",
            "lead_generation": "'.$request->lead_generation.'",
            "terms_and_conditions": "true"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                // 'Authorization: Basic Mjk5ZTI1YzEtNjIyYy00ZjJiLTkxZjItNDRlN2ZmZDQ5YzlmOlBUMGVhNDQxNzc2YmY3YTY4NjY3YmU1MzEzODdiMzM1YjIwOTJhNzBlZjI3N2Q0ZjRl'
                'Authorization: Basic '. base64_encode($sw_project_id.":".$sw_auth_token)
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $json_response = json_decode($response);

        if (property_exists($json_response, 'errors')) {
            return response()->json(['status' => 'error', 'error' => $json_response->errors]);
        }
        // dd($json_response);

        // $smsCampaign->sw_campaign_id = $json_response->id;

        // $smsCampaign->save();
///////////////////////////--------------------------//////////////////////end
        // dd($request->all());

        $campaign = new SmsCampaign();
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
            $campaign->status = 'pending';
        } else {
            $campaign->start_date = Carbon::now()->toDateString();
            $campaign->status = 'preprocessing';
        }

        if ($request->has_banned_words == '1') {
            $campaign->status = 'flagged';
        }
        $campaign->sw_campaign_id = $json_response->id;
        $campaign->sms_use_case = $request->sms_use_case;
        $campaign->description = $request->description;
        $campaign->message_two = $request->message;
        $campaign->message_flow = $request->message_flow;
        $campaign->opt_in_message = $request->opt_in_message;
        $campaign->opt_out_message = $request->opt_out_message;
        $campaign->help_message = $request->help_message;
        $campaign->number_pooling_per_campaign = $request->number_pooling_per_campaign;
        $campaign->direct_lending = $request->direct_lending == 'true' ? true : false;
        $campaign->embedded_link = $request->embedded_link == 'true' ? true : false;
        $campaign->embedded_phone = $request->embedded_phone == 'true' ? true : false;
        $campaign->age_gated_content = $request->age_gated_content == 'true' ? true : false;
        $campaign->lead_generation = $request->lead_generation == 'true' ? true : false;
        $campaign->terms_and_conditions = $request->terms_and_conditions == 'true' ? true : false;
        $campaign->save();

        $campaign_id = $campaign->id;

        if ($campaign->status !== 'flagged') {
            SmsCampaignJob::dispatchAfterResponse($campaign_id);
        }

        return response()->json(['status' => 'success', 'message' => 'SMS Campaign Started Successfully.']);
    }

    public function getCampaignContactList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $contact_lists = SmsContactList::select('id', 'name')->Where('company_id', $company_id)->Where('status', '!=', 'deleted')->get();

        return response()->json($contact_lists);
    }

    public function validateCsv(Request $request)
    {
        $upload = $request->file('file');

        $filepath = $upload->getRealPath();

        $csv = [];
        $file1 = fopen($filepath, 'r');
        $csv = array_map('str_getcsv', file($upload));
        $header = array_shift($csv);
        // Seperate the header from data

        // $col = array_search("phone_number", $header);
        $col = implode(',', $header);
        $pattern = '/(phone|cell|number|mobile|contact)/i';
        $pattern2 = '/(first_name|last_name|first name|last name|firstname|lastname)/i';

        unset($csv);
        if (preg_match($pattern, strtolower($col)) === 0) {
            return response()->json(['success' => true]);
        // return redirect()->back()->with('error','Please add a phone column to your CSV.');
        } else {
            if (preg_match($pattern2, strtolower($col)) === 0) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function getSmsBannedWord(Request $request)
    {
        $bannedWords = SmsBannedWord::get();

        return response()->json(['bannedWords' => $bannedWords]);
    }

    public function ajaxStore(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        // code after job
        $fileName = time().'.csv';

        $file = file($request->file);

        $request->file->move(storage::path('sms/contact-lists'), $fileName);

        $fileRows = count($file);

        // dd($fileRows);

        $queue_name = Str::random(10);

        $list = new SmsContactList();
        $list->name = $request->name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'sms/contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows - 1;
        $list->status = 'active';
        $list->jobs = '';
        $list->job_status = 'pending';
        $list->save();

        $lists = SmsContactList::where('user_id', $user_id)->where('company_id', $company_id)->where('status', '!=', 'deleted')->get();

        return response()->json(['contactList' => $lists, 'success' => 'Contact List Added Successfully.']);
    }
}
