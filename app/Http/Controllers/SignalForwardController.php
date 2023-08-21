<?php
//Route::get('test', [\App\Http\Controllers\TestController::class, 'index'])->name('testindex');
//Route::post('test', [\App\Http\Controllers\TestController::class, 'store'])->name('testcampaign');

namespace App\Http\Controllers;

use App\Models\CampaignContact;
use App\Models\DNC;
use App\Models\MyNumber;
use App\Models\IncomingCallLog;
use App\Models\Recording;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class SignalForwardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }


    public function clientXml(Request $request)
    {

        // 3473394,6462090177,81,111,pending,2022-01-21 09:02:55,2022-01-21 09:02:55,13,4,,false,,,,,false,


//        array (
//        'CallSid' => '01906060-a214-4edf-b6b9-d7eadef6fc94',
//        'AccountSid' => '181081c2-b378-453e-aac3-6fa84bfe9961',
//        'From' => '+14243022903',
//        'To' => '+12174345453',
//        'Called' => '+12174345453',
//        'CallStatus' => 'queued',
//        'ApiVersion' => '2010-04-01',
//        'Direction' => 'inbound',
//    )

        try {
        $data = $request->post();

        $swFrom = $request->get('From');
        $swTo = $request->get('To');
        if (str_contains($swFrom, '@')) {
            $swFrom = (explode("@",$swFrom))[0];
        }
        if (str_contains($swTo, '@')) {
            $swTo = (explode("@",$swTo))[0];
        }

        $swFrom = str_pad(preg_replace('/[^0-9]/', '', $swFrom), 11, "1", STR_PAD_LEFT);
        $swTo = str_pad(preg_replace('/[^0-9]/', '', $swTo), 11, "1", STR_PAD_LEFT);
        $swFrom = (strlen($swFrom) > 11) ? substr($swFrom,0,11) : $swFrom;
        $swTo = (strlen($swTo) > 11) ? substr($swTo,0,11) : $swTo;
        $swFrom = formatNumber($swFrom)??'+'.$swFrom;
        $swTo = formatNumber($swTo)??'+'.$swTo;

        Log::error($request->all());

        Log::error($swFrom);

        Log::error($swTo);

        //will be saving e164 formate so no need to convert
//        $swFrom = str_pad(preg_replace('/[^0-9]/', '', $swFrom), 11, "1", STR_PAD_LEFT);
//        $swTo = str_pad(preg_replace('/[^0-9]/', '', $swTo), 11, "1", STR_PAD_LEFT);
        $cc = MyNumber::where('raw_number', $swTo)->first();

        //dd(!$cc->ivr_enabled);
        
        $xml  = '';
        
        Log::error($cc);
        if(isset($cc)) {
            $data['company_id'] = $cc->company_id;
            $data['user_id'] = $cc->user_id;
        }
        if (isset($cc) && !$cc->ivr_enabled && $cc->raw_forward_to_number != '') {
            $From = $swFrom;
            $To = $cc->raw_forward_to_number;
            // $data['campaign_contact_id'] = $cc->id;
            // $data['campaign_id'] = $cc->campaign_id;
            // $data['user_id'] = $cc->user_id;
            // $data['company_id'] = $cc->company_id;

            $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial callerId="%s">%s</Dial>
            </Response>',  $From, $To);

        }else if(isset($cc) && $cc->ivr_enabled ){
            $recording =  Recording::findorFail($cc->recording_id);
            $audioFileName = '';
            $presignedUrl = '';
            $optinDigit = $cc->continue_digit;
            $optoutDigit = $cc->optout_digit;
            if($recording){
                $audioFileName = $recording->filename;
                $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $audioFileName;
            }else{
                $audioFileName = '1641986228.mp3';
                $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $audioFileName;
            }

            $callbackURL = url('').'/client-input';

            $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Gather input="dtmf" action="%s" timeout="5" numDigits="1" method="POST">
        <Play loop="1">%s</Play>
    </Gather>
    <Say>We did not receive any input. Goodbye!</Say>
</Response>', $callbackURL, $presignedUrl);
            
        }else{
            $xml  = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
              <Say>No Results are found.!</Say>
            </Response>');
        }

        $data['response'] = $xml;
       

        Log::error($xml);
        /*if (!$From || !$To) {
            $audioFileName = '1641986228.mp3';
            $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $audioFileName; 
            $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Play loop="1">%s</Play>
</Response>', $presignedUrl);
        } else {
            $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Dial callerId="%s">%s</Dial>
</Response>',  $From, $To);
        }*/

        // $data['response'] = $xml;
        // $incomingCallLog = new IncomingCallLog();
        //     foreach ($data as $key => $value) {
        //         if(in_array($key, $incomingCallLog->getTableColumns())) {
        //             $incomingCallLog->{$key} = $value;
        //         }
        //     }
        // $incomingCallLog->save();

        $incomingCallLog = new IncomingCallLog();
            foreach ($data as $key => $value) {
                if(in_array($key, $incomingCallLog->getTableColumns())) {
                    $incomingCallLog->{$key} = $value;
                }
                $incomingCallLog->From = $swFrom;
                $incomingCallLog->To = $swTo;
            }
            $incomingCallLog->type = 'CUSTOMER';

        $incomingCallLog->save();

        return response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
    } catch(\Exception $e) {
        Log::error($e);
        throw new Exception($e);
    }

    }

    public function clientInputXml(Request $request){
        Log::error('----client input -----');

        Log::error($request->all());
        try {
        $data = $request->post();

        $swFrom = $request->get('From');
        $swTo = $request->get('To');
        if (str_contains($swFrom, '@')) {
            $swFrom = (explode("@",$swFrom))[0];
        }
        if (str_contains($swTo, '@')) {
            $swTo = (explode("@",$swTo))[0];
        }

        $swFrom = str_pad(preg_replace('/[^0-9]/', '', $swFrom), 11, "1", STR_PAD_LEFT);
        $swTo = str_pad(preg_replace('/[^0-9]/', '', $swTo), 11, "1", STR_PAD_LEFT);
        $swFrom = (strlen($swFrom) > 11) ? substr($swFrom,0,11) : $swFrom;
        $swTo = (strlen($swTo) > 11) ? substr($swTo,0,11) : $swTo;
        $swFrom = formatNumber($swFrom)??'+'.$swFrom;
        $swTo = formatNumber($swTo)??'+'.$swTo;


        // dd($request->all());
        $optinDigit = $request->get('optin');
        $optoutDigit = $request->get('optout');

        $cc = MyNumber::where('raw_number', $swTo)->firstOrFail();

        $xml = '';


        if($request->get('Digits') == $cc->opt_in_digit) {
            $From = $swFrom;
            $To = $cc->opt_in_number;
            $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial callerId="%s">%s</Dial>
            </Response>',  $From, $To);
        } else if($request->get('Digits') == $cc->opt_out_digit && !$cc->dnc_on_ivr) {
            $xml  = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
              <Say>Good bye!</Say>
            </Response>');
        } else if($request->get('Digits') == $cc->opt_out_digit && $cc->dnc_on_ivr == true) {
            $xml  = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
              <Say>You\'ve been placed on our do not call list.</Say>
            </Response>');
            $dnc = new DNC();
            $dnc->number = $swFrom;
            $dnc->raw_number = $swFrom;
            $dnc->company_id = $cc->company_id;
            $dnc->user_id = $cc->user_id;
            $dnc->upload_type = 'IVR';
            $dnc->save();
        } else {
            $xml  = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
              <Say>That\'s not a valid input!</Say>
            </Response>');
        }


        return response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
        } catch (Exception $ex) {
            throw new Exception($ex);
        }

    }

    public function adminXml(Request $request)
    {

        $data = $request->post();

        $From = '';
        $To = '';
        $swFrom = $request->get('From');
        $swTo = $request->get('To');
        if (str_contains($swFrom, '@')) {
            $swFrom = (explode("@",$swFrom))[0];
        }
        if (str_contains($swTo, '@')) {
            $swTo = (explode("@",$swTo))[0];
        }
        //will be saving e164 formate so no need to convert
        if (str_contains($swFrom, '@')) {
            $swFrom = (explode("@",$swFrom))[0];
        }
        if (str_contains($swTo, '@')) {
            $swTo = (explode("@",$swTo))[0];
        }
        $swFrom = str_pad(preg_replace('/[^0-9]/', '', $swFrom), 11, "1", STR_PAD_LEFT);
        $swTo = str_pad(preg_replace('/[^0-9]/', '', $swTo), 11, "1", STR_PAD_LEFT);
        $swFrom = (strlen($swFrom) > 11) ? substr($swFrom,0,11) : $swFrom;
        $swTo = (strlen($swTo) > 11) ? substr($swTo,0,11) : $swTo;
        $swFrom = formatNumber($swFrom)??'+'.$swFrom;
        $swTo = formatNumber($swTo)??'+'.$swTo;
        
        $cc = CampaignContact::where(function($query) use($swTo) {
            $query->where('caller_id_number', $swTo)->orWhere('alpha_number', $swTo);
        })->where('number', $swFrom)->first();
        
        if (isset($cc) && $cc->ci_forward_number != '') {
            $From = $swFrom;
            $To = $cc->ci_forward_number;
            $data['campaign_contact_id'] = $cc->id;
            $data['campaign_id'] = $cc->campaign_id;
            $data['user_id'] = $cc->user_id;
            $data['company_id'] = $cc->company_id;
            $data['forward_to'] = $To;

        } else {
            $cc = CampaignContact::where('alpha_number', $swTo)->where('number', $swFrom)->first();
            
            if (isset($cc) && $cc->vm_forward_number != '') {
                $From = $swFrom;
                $To = $cc->vm_forward_number;
                $data['campaign_contact_id'] = $cc->id;
                $data['campaign_id'] = $cc->campaign_id;
                $data['user_id'] = $cc->user_id;
                $data['company_id'] = $cc->company_id;
                $data['forward_to'] = $To;
            }
            
        }
        
        if (!$From || !$To) {
            $audioFileName = '1641986228.mp3';
            $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $audioFileName; // 'https://rvm.vultik.com/storage/full.mp3';
            $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Play loop="1">%s</Play>
            </Response>', $presignedUrl);
                    } else {
                        $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial callerId="%s">%s</Dial>
            </Response>',  $From, $To);
        }

        $data['response'] = $xml;
        
        $incomingCallLog = new IncomingCallLog();
            foreach ($data as $key => $value) {
                if(in_array($key, $incomingCallLog->getTableColumns())) {
                    $incomingCallLog->{$key} = $value;
                }
                $incomingCallLog->From = $swFrom;
                $incomingCallLog->To = $swTo;
            }
        $incomingCallLog->save();

        return response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);

    }

    public function testSample(Request $request){
        $data = $request->post();

        $From = '';
        $To = '';
        $swFrom = $request->get('From');
        $swTo = $request->get('To');
        if (str_contains($swFrom, '@')) {
            $swFrom = (explode("@",$swFrom))[0];
        }
        if (str_contains($swTo, '@')) {
            $swTo = (explode("@",$swTo))[0];
        }
        //will be saving e164 formate so no need to convert
        if (str_contains($swFrom, '@')) {
            $swFrom = (explode("@",$swFrom))[0];
        }
        if (str_contains($swTo, '@')) {
            $swTo = (explode("@",$swTo))[0];
        }
        $swFrom = str_pad(preg_replace('/[^0-9]/', '', $swFrom), 11, "1", STR_PAD_LEFT);
        $swTo = str_pad(preg_replace('/[^0-9]/', '', $swTo), 11, "1", STR_PAD_LEFT);
        $swFrom = (strlen($swFrom) > 11) ? substr($swFrom,0,11) : $swFrom;
        $swTo = (strlen($swTo) > 11) ? substr($swTo,0,11) : $swTo;
        $swFrom = formatNumber($swFrom)??'+'.$swFrom;
        $swTo = formatNumber($swTo)??'+'.$swTo;


        $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial callerId="%s">%s</Dial>
            </Response>',  $swFrom, $swTo);

        return  response($xml, 200, [
                'Content-Type' => 'application/xml'
            ]);
    }
}



