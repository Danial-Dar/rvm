<?php

namespace Laravel\Nova\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Nova\Contracts\ImpersonatesUsers;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Laravel\Nova\Util;
use App\Http\Helpers\Aws;
use App\Models\ApiSetting;
use App\Models\Recording;
use Aws\S3\S3Client;

class TestCallController extends Controller
{
    /**
     * Impersonate a user.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
     public function store(NovaRequest $request){

        if(!isset($request->opt_out)){ //for rvm
            $user = Nova::user($request);
            $user_id = $user->id;
            $company_id = $user->company_id;
    
            $slug         = $request->slug;
            $number_from  = $request->from_number;
            $number_to    = $request->to_number;
            // $alpha_from   = '';
            $recording_id = $request->recording_id;
    
            
            $api_setting = ApiSetting::Where('slug', $slug)->first();
            $recording = Recording::find($recording_id);
    
    
            // $alpha_from = preg_replace('/[^0-9]/', '', $alpha_from);
            $number_to = preg_replace('/[^0-9]/', '', $number_to);
            $number_from = preg_replace('/[^0-9]/', '', $number_from);
            $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $recording->filename;
            // $params['alpha_from'] = '+' . str_pad($alpha_from, 11, "1", STR_PAD_LEFT);
            $params['number_from'] = 1800;
            $params['alpha_from'] =  str_replace('+','',formatNumber($number_from));
            $params['number_to'] =  str_replace('+','',formatNumber($number_to));
            // $params['wavefile_url'] = "https://file-examples-com.github.io/uploads/2017/11/file_example_WAV_1MG.wav";
            $params['wavefile_url'] = $presignedUrl;
            $params['transaction_id'] = rand();
            $params['carrier_addr'] = $api_setting->carrier_address;
            // dd($params,$api_setting->end_point);

            //dd(json_encode($params));
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://68.69.186.198/rvmdial',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "alpha_from": "'.$params['number_from'].'",
                "number_to": "'.$params['number_to'].'",
                "number_from": "'.$params['number_from'].'",
                "wavefile_url": "'.$params['wavefile_url'].'",
                "transaction_id": "'.$params['transaction_id'].'",
                "carrier_addr": "'.$params['carrier_addr'].'"
            }',
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
        else{ //for press-1
        $user = Nova::user($request);
        $user_id = $user->id;
        $company_id = $user->company_id;
        
        $slug         = $request->slug;
        $number_from  = $request->from_number;
        $number_to    = $request->to_number;

        $wavurl_annouce = $request->recording_id;
        $wavurl_optout = $request->opt_out;
        $wavurl_continue = $request->opt_in;
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
        // $alpha_from = preg_replace('/[^0-9]/', '', $alpha_from);
        $number_to = preg_replace('/[^0-9]/', '', $number_to);
        $number_from = preg_replace('/[^0-9]/', '', $number_from);
        // $params['alpha_from'] = '+' . str_pad($alpha_from, 11, "1", STR_PAD_LEFT);
        $params['number_from'] = '1800';
        $params['number_to'] = str_replace('+','',formatNumber($number_to));
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
          CURLOPT_POSTFIELDS => '{
            "number_to": "'.$params['number_to'].'",
            "number_from": "'.$params['number_from'].'",
            "wavurl_annouce": "'.$params['wavurl_annouce'].'",
            "wavurl_continue": "'.$params['wavurl_continue'].'",
            "wavurl_optout": "'.$params['wavurl_optout'].'",
            "digit_continue": "'.$params['digit_continue'].'",
            "digit_optout": "'.$params['digit_optout'].'",
            "transfer_dest": "'.$params['transfer_dest'].'",
            "transaction_id": "'.$params['transaction_id'].'",
            "carrier_addr": "'.$params['carrier_addr'].'"
        }',
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
        
     }
}
