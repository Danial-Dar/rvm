<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CampaignReset;
use App\Jobs\CampaignResetDisp;
use App\Jobs\PauseCampaign;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $campaigns = Campaign::Where('user_id', $user->id)->get();
        return response(['campaigns' => $campaigns]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'caller_id' => 'required',
            'start_date' => 'required',
            'campaign_type' => 'required',
            'contact_list_id' => 'required',
        ]);

        if ($request->campaign_type == 'rvm-test') {
            $validator = Validator::make($request->all(), [
                'vm_forward_number' => 'required',
                'recording_id' => 'required'
            ]);
        }

        if ($request->campaign_type == 'ivr-test') {
            $validator = Validator::make($request->all(), [
                'opt_in_number' => 'required',
                'transfer_to_number' => 'required',
                'opt_out_number' => 'required',
                'recording_optin_id' => 'required',
                'optout_recording_id' => 'required',
                'voice_mail_enabled' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response(['Error' => $validator->messages()->first()]);
        }
        $campaign = Campaign::create($request->all());
        // $campaign = new Campaign();
        // $campaign->name = $request->name;
        // $campaign->caller_id = $request->caller_id;
        // $campaign->recording_id = $request->recording_id;
        // $campaign->contact_list_id = $request->contact_list_id;
        // $campaign->start_date = $request->start_date;
        // $campaign->drops_per_hour = $request->drops_per_hour;
        // $campaign->campaign_type = $request->campaign_type;
        // $campaign->ci_forward_number = $request->ci_forward_number;
        // if ($request->campaign_type == 'rvm-test') {
        //     $campaign->vm_forward_number = $request->vm_forward_number;
        // } else if ($request->campaign_type == 'ivr-test') {
        //     $campaign->opt_in_number = $request->opt_in_number;
        //     $campaign->transfer_to_number = $request->transfer_to_number;
        //     $campaign->opt_out_number = $request->opt_out_number;
        //     $campaign->recording_optin_id = $request->recording_optin_id;
        //     $campaign->optout_recording_id = $request->optout_recording_id;
        //     $campaign->voice_mail_enabled = $request->voice_mail_enabled;
        // }
        // $campaign->save();
        return response(['Message' => 'Campaign Created Successflly' ,'campaigns' => $campaign]);
    }

    public function show($id)
    {
        $campaign = Campaign::find($id);
        return response(['campaigns' => $campaign]);
    }

    public function destroy($id)
    {
        $campaign = Campaign::find($id);
        $campaign->delete();
        return response(['Message' => "Campaign Deleted Successfully"]);
    }

    public function actionUpdate(Request $request, $id)
    {
        $campaign = Campaign::find($id);
        $campaign->status = $request->status;

        if ($request->status == 'reset' && $request->disp == false) {
            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            CampaignReset::dispatchAfterResponse($campaign->id);
        }

        if ($request->status == 'reset' && $request->disp == true && count($request->disposition) != 0) {
            $campaign->status = "preprocessing";
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            foreach ($request->disposition as $disposition) {
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

        $campaign->save();
        return response(['Message' => "Campaign ".$request->status." Successfully"]);
    }
}
