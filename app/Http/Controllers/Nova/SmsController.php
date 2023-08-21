<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\SmsCampaignContact;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function getMessages(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vultik.signalwire.com/api/laml/2010-04-01/Accounts/299e25c1-622c-4f2b-91f2-44e7ffd49c9f/Messages?From='.$request->number,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic Mjk5ZTI1YzEtNjIyYy00ZjJiLTkxZjItNDRlN2ZmZDQ5YzlmOlBUMGVhNDQxNzc2YmY3YTY4NjY3YmU1MzEzODdiMzM1YjIwOTJhNzBlZjI3N2Q0ZjRl'
        ),
        ));

        $response = curl_exec($curl);

        $json_response = json_decode($response, true);

        curl_close($curl);

        return response()->json(['messages' => $json_response['messages']]);

    }

    public function getCampaignContacts($id)
    {
        $contacts = SmsCampaignContact::Where('sms_campaign_id',$id)->get();
        return response()->json(['numbers' => $contacts]);
    }
}
