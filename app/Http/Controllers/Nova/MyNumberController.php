<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\MyNumber;
use App\Models\SwNumber;
use App\Models\Balance;
use App\Models\CallFlowNumber;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Nova;

class MyNumberController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMyNumber(Request $request, $id)
    {

    	$number = MyNumber::find($id);
        // if($request->ivr_enabled == 1){

        // }else{

            // $number->continue_digit = $request->continue_digit;
            // $number->optout_digit = $request->optout_digit;
        // }

        $number->recording_id = $request->recording_id;
        $number->forward_to_number = $request->number_type == 'forward' ? $request->forward_to_number : null;

        $number->name = $request->name;
        $number->description = $request->description;
        $number->ivr_enabled = $request->number_type == 'ivr'?true:false;
        $number->opt_out_digit = $request->opt_out_digit;
        $number->opt_in_digit = $request->opt_in_digit;
        $number->dnc_on_ivr = $request->dnc_on_ivr;
        $number->opt_in_number = $request->opt_in_number;
        $number->raw_forward_to_number = formatNumber($request->forward_to_number);
        $number->number_type = $request->number_type;
        $number->sip_endpoint = $request->number_type == 'sip' ? $request->sip_endpoint : null;
        $number->save();

        return response()->json(
            [
                // 'data' => ['message' => 'Number Updated Successfully'],
                'message' => 'Number Updated Successfully',
            ],200
        );
    }

    public function getStates(){
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            return response()->json([
                'success'=>false,
                'error'=>$authenticate['error'],
                'data'=>null
            ],400);
        }else{
            $token  = 'Authorization: '.$authenticate['data']['token'];

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/states',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                $token
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
           return $response;
        }
    }

    public function getMyNumber($id){
        // $id = $request->id;
        $number = MyNumber::findorFail($id);
        return response()->json(
            [
                'message' => 'Number fetch Successfully',
                'number' => $number
            ],200
        );
    }

    public function getStateRateCenter(Request $request){
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            return response()->json(['success'=>false,'error'=>$authenticate['error'],'data'=>null],400);
        }else{

            $state_id = $request->state_id !== null ? $request->state_id : 'CA';

            $token  = 'Authorization: '.$authenticate['data']['token'];

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/ratecenter?state='.$state_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                $token
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            return $response;
        }
    }

    public function searchSmsNumbers(Request $request){
        // dd($request->all());
        $sw_auth_token = config('app.sw_auth_token');
        $sw_project_id = config('app.sw_project_id');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers/search?'.$request->filter.'='.$request->value,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            // 'Authorization: Basic Mjk5ZTI1YzEtNjIyYy00ZjJiLTkxZjItNDRlN2ZmZDQ5YzlmOlBUMGVhNDQxNzc2YmY3YTY4NjY3YmU1MzEzODdiMzM1YjIwOTJhNzBlZjI3N2Q0ZjRl'

            'Authorization: Basic '. base64_encode($sw_project_id.":".$sw_auth_token)
        ),
        ));

        $response = curl_exec($curl);

        $json_response = json_decode($response);

        // dd($json_response->data[0]->e164);
        curl_close($curl);

        return response()->json(['success'=>true,'data'=>$json_response],200);
    }

    public function searchNumbers(Request $request){
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            return response()->json(['success'=>false,'error'=>$authenticate['error'],'data'=>null],400);
        }else{
            $token  = 'Authorization: '.$authenticate['data']['token'];
            $type = $request->type;
            $state= $request->state;
            $ratecenter= $request->ratecenter;
            $npa= $request->npa;
            $nxx= $request->nxx;
            $limit= $request->limit ? $request->limit : '10';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/search?type='.$type.'&state='.$state.'&ratecenter='.$ratecenter.'&npa='.$npa.'&nxx='.$nxx.'&limit='.$limit,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                $token
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            $data  = json_decode($response,true);

            if(is_null($data['error'])){
                // $results = $data['data']['result'];
                $results = $data['data'];
            }else{
                $results = [];
            }

            return response()->json(['success'=>true,'data'=>$results],200);
        }
    }

    public function purchaseSmsNumbers(Request $request){
        $sw_auth_token = config('app.sw_auth_token');
        $sw_project_id = config('app.sw_project_id');
        $user = Auth::user();
        $numbers = $request->numbers;
        // dd(count($numbers));

        $totalPrice = count($numbers) > 0 ? count($numbers)*0.01 : null;

        $json_response = null;
        foreach ($numbers as $number) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "number": "'.$number.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',

                'Authorization: Basic '. base64_encode($sw_project_id.":".$sw_auth_token)
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $json_response = json_decode($response, true);

            // dd($json_response['id']);
            // if (property_exists($json_response, 'errors')) {
            //     $error = $json_response->errors;
            //     return response()->json(['success'=>false,'data'=>$response,'role'=>$user->role,'error'=>$error],200);
            // }

            $my_number = new MyNumber;
            $my_number->user_id = $user->id;
            $my_number->number = formatNumber($number);
            $my_number->status = "active";
            $my_number->type = $user->role =="user" ? "ClientNumber" : "CallzyOwned";
            $my_number->tags = "ClientNumber".$user->first_name;
            $my_number->company_id = $user->company_id;
            $formatNumber = formatNumber($number);
            $my_number->raw_number = $formatNumber;
            $my_number->purchase_response = json_encode($response);
            $my_number->platform = "sw";
            $my_number->sw_id = $json_response['id'];

            $my_number->save();

        }

        if (count($numbers) > 0) {
            $balance = new Balance;
            $balance->user_id = $user->id;
            $balance->company_id = $user->company_id;
            $balance->description = 'Purchase Sms Number; Date: '.now().'; Amount:'.$totalPrice.';';
            $balance->amount = $totalPrice;
            $balance->type = 'PHONE';
            $balance->save();
        }

        return response()->json(['success'=>true,'data'=>$response,'role'=>$user->role],200);
    }

    public function purchaseCallFlowNumbers(Request $request){
        $sw_auth_token = config('app.sw_auth_token');
        $sw_project_id = config('app.sw_project_id');
        $user = Auth::user();
        $company_id = $user->company_id;
        if($user->id == 1){
            $company_id = 1;
        }
        $numbers = $request->numbers;
        // dd(count($numbers));

        $totalPrice = count($numbers) > 0 ? count($numbers)*0.01 : null;

        $json_response = null;
        foreach ($numbers as $number) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "number": "'.$number.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',

                'Authorization: Basic '. base64_encode($sw_project_id.":".$sw_auth_token)
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $json_response = json_decode($response, true);

            // dd($json_response['id']);
            // if (property_exists($json_response, 'errors')) {
            //     $error = $json_response->errors;
            //     return response()->json(['success'=>false,'data'=>$response,'role'=>$user->role,'error'=>$error],200);
            // }

            // $my_number = new MyNumber;
            // $my_number->user_id = $user->id;
            // $my_number->number = formatNumber($number);
            // $my_number->status = "active";
            // $my_number->type = $user->role =="user" ? "ClientNumber" : "CallzyOwned";
            // $my_number->tags = "ClientNumber".$user->first_name;
            // $my_number->company_id = $user->company_id;
            // $formatNumber = formatNumber($number);
            // $my_number->raw_number = $formatNumber;
            // $my_number->purchase_response = json_encode($response);
            // $my_number->platform = "sw";
            // $my_number->sw_id = $json_response['id'];

            // $my_number->save();
            $formatNumber = formatNumber($number);

            $call_number = new CallFlowNumber();
            $call_number->user_id = $user->id;
            $call_number->friendly_name = $formatNumber;
            $call_number->status = "active";
            // $call_number->type = $user->role =="user" ? "ClientNumber" : "CallzyOwned";
            // $call_number->tags = "ClientNumber".$user->first_name;
            // $call_number->company_id = $user->company_id;
            $call_number->phone_number = $formatNumber;
            $call_number->purchase_response = json_encode($response);
            // $call_number->platform = "sw";
            // $call_number->sw_id = $json_response['id'];

            $call_number->save();

        }

        if (count($numbers) > 0) {
            $balance = new Balance;
            $balance->user_id = $user->id;
            $balance->company_id = $company_id;
            $balance->description = 'Purchase Call Flow Number; Date: '.now().'; Amount:'.$totalPrice.';';
            $balance->amount = $totalPrice;
            $balance->type = 'PHONE';
            $balance->save();
        }

        return response()->json(['success'=>true,'data'=>$response,'role'=>$user->role],200);
    }

    public function purchaseNumbers(Request $request){
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            return response()->json(['success'=>false,'error'=>$authenticate['error'],'data'=>null],400);
        }else{
            $user = $request->user();
            $token  = 'Authorization: '.$authenticate['data']['token'];

            $numbersArray = $request->numbers;
            $name = $request->name;
            $description = $request->description;
            $totalPrice = count($numbersArray) > 0 ? count($numbersArray)*0.01 : null;
            $error = null;
            foreach ($numbersArray as $number) {
                $data = explode(',',$number);
                $number = $data[0];
                $npa = $data[1];
                $nxx = $data[2];
                $xxxx = $data[3];
                $type = $data[6];
                if($type === 'local'){
                    $state = $data[4];
                    $ratecenter = $data[5];
                }else{
                    $state = '';
                    $ratecenter = '';
                }

                if ($type == 'local') {
                    $value = '{
                        "type": "'.$type.'",
                        "numbers": [
                          {
                            "npa": "'.$npa.'",
                            "nxx": "'.$nxx.'",
                            "xxxx": "'.$xxxx.'",
                            "type": "'.$type.'",
                            "state": "'.$state.'",
                            "ratecenter": "'.$ratecenter.'",
                            "fwd_trunk_grpid": "53449"
                          }
                        ]
                      }';
                } elseif ($type == "toll") {
                    $value = '{
                        "type": "'.$type.'",
                        "numbers": [
                          {
                            "npa": "'.$npa.'",
                            "nxx": "'.$nxx.'",
                            "xxxx": "'.$xxxx.'",
                            "type": "'.$type.'",
                            "state": "'.$state.'",
                            "ratecenter": "'.$ratecenter.'",
                            "fwd_preconfigured": true
                          }
                        ]
                      }';
                }
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/purchase',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $value,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    $token
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $json_response = json_decode($response);

                if ($json_response->error == null) {
                    if($user->role =="user"){
                        $tag = 'CallzyClient-'.$user->first_name;
                    }else if($user->role =="admin"){
                        $tag = 'Admin';
                    }

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/update_tags?number='.$number.'&tags='.$tag,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            $token
                        ),
                    ));

                    $response_tag = curl_exec($curl);

                    curl_close($curl);

                    if($user->role =="user"){
                        $my_number = new MyNumber;
                        $my_number->name = $name;
                        $my_number->description = $description;
                        $my_number->user_id = $user->id;
                        $my_number->number = formatNumber($number);
                        $my_number->status = "active";
                        $my_number->type = $user->role =="user" ? "ClientNumber" : "CallzyOwned";
                        $my_number->tags = "ClientNumber".$user->first_name;
                        $my_number->company_id = $user->company_id;
                        $formatNumber = formatNumber($number);
                        $my_number->raw_number = $formatNumber;
                        if ($request->forward_number) {
                            $my_number->forward_to_number = $request->forward_number;
                            $formatForwardNumber = formatNumber($request->forward_number);
                            $my_number->raw_forward_to_number = $formatForwardNumber;
                        }
                        $my_number->purchase_response = json_encode($response);
                        $my_number->purchase_response_id = "";

                        $my_number->save();
                        $balance = new Balance;
                        $balance->user_id = $user->id;
                        $balance->company_id = $user->company_id;
                        $balance->description = 'Purchase Number; Date: '.now().'; Amount:'.$totalPrice.';';
                        $balance->amount = $totalPrice;
                        $balance->type = 'PHONE';
                        $balance->save();
                    }else{
                        $sw_number = new SwNumber;
                        $sw_number->name = $name;
                        $sw_number->description = $description;
                        $sw_number->friendly_name = formatNumber($number);
                        $sw_number->phone_number = formatNumber($number);
                        $sw_number->purchase_response = json_encode($response);
                        $sw_number->purchase_response_id = "";
                        $sw_number->status = "active";
                        $sw_number->save();
                    }
                }else{
                    $error = $json_response->error;
                    return response()->json(['success'=>false,'data'=>$response,'role'=>$user->role,'error'=>$error],200);
                }

            }//foreach loop end

         // add balance for purchase number
         return response()->json(['success'=>true,'data'=>$response,'role'=>$user->role,'error'=>$error],200);
        }
    }

    public function uploadCallzyNumbers(Request $request)
    {
        $ext = explode('.',$request->file->getClientOriginalName());
        if (end($ext) !== 'csv') {
            return response()->json([
                'success' => false,
                'message' => 'Please Upload Csv File Only',
            ], 200);
        }


        try {
            $file = file($request->file);
            $fileRows = count($file);
            $file1 = fopen($request->file('file'), 'r');
            $csv = [];
            while (($result = fgetcsv($file1)) !== false) {
                $raw_number = preg_replace('/[^0-9]/', '', $result[0]);
                if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
                    $csv[] =
                    array(
                        'number' => preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $result[0]),
                        'area_code' => $result[1],
                        'rate_center' => $result[4],
                    );
                }
            }

            $data = [];

            foreach ($csv as $list) {
                $data[] = [
                    // 'friendly_name' => $formatNumber,
                    // 'phone_number' => $formatNumber,
                    'friendly_name' => $list['number'],
                    'phone_number' => $list['number'],
                    'area_code' => $list['area_code'],
                    'rate_center' => $list['rate_center'],
                    'status' => 'active',
                    'name' => 'Import',
                    'description' => 'This number is imported from csv',
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
            // dd($data);
            unset($csv);
            $chunk_count = 500;

            if (count($data) > 0) {
                $chunks = array_chunk($data, $chunk_count);

                foreach ($chunks as $chunk) {
                    SwNumber::insert($chunk);
                }
            }
            fclose($file1);

            return response()->json([
                'success' => true,
                'message' => 'Callzy Numbers Added Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Callzy Number Adding Failed',
                'excepton' => $e->getMessage(),
                'msg' => $e->getTrace(),
            ], 400);
        }
    }

    public function importCallzyNumber(Request $request)
    {
        $params = $request->all();
        Log::info($params);
        $user_id = $params[0]['custom_fields']['id'];
        $user = User::Find($user_id);

        $numbers = [];
        $data = [];
        Log::info($user_id);

        foreach ($params as $row) {
            $data = $row['row_data'];
            $data['friendly_name'] = $data['phone_number'];
            $data['area_code'] = substr($data['phone_number'],2,3);
            $data['status'] = 'active';
            $data['name'] = 'Import';
            $data['description'] = 'This number is imported from csv';

            $numbers[] = $data;
        }
        if (count($numbers) > 0) {
            SwNumber::insert($numbers);
        }
    }
}
