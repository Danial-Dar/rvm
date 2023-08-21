<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyNumber;
use App\Models\MyGroup;
use App\Models\SwNumber;
use App\Models\Recording;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class DidController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $client = MyNumber::query();
        $callzy = SwNumber::query();

        if ($request->client_search != null) {

            $clientSearch = $request->client_search;
            $client->where(function($query) use($clientSearch){
                $query->where('number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('raw_number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('forward_to_number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('raw_forward_to_number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('created_at', 'LIKE', "%{$clientSearch}%");
            });
        }
        if($role == "company"){
            $clientNumbers =  $client->with('user')->Where('company_id',$company_id)->where('status', 'active')->where('type','ClientNumber')->orderBy('id','desc')->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'client'
            );
        }else if($role == "user"){
            $clientNumbers =  $client->with('user')->Where('user_id', $user_id)->where('status', 'active')->where('type','ClientNumber')->orderBy('id','desc')->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'client'
            );
        }else{
            $clientNumbers =  $client->with('user')->where('status', 'active')->where('type','ClientNumber')->orderBy('id','desc')->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'client'
            );
        }
        

        if ($request->callzy_search != null) {

            $callzySearch = $request->callzy_search;
            $callzy->where(function($query) use($callzySearch){
                $query->where('friendly_name', 'LIKE', "%{$callzySearch}%")
                    ->orWhere('phone_number', 'LIKE', "%{$callzySearch}%")
                    ->orWhere('created_at', 'LIKE', "%{$callzySearch}%");
            });
        }
       
        // if($role == "user"){
        //     $callzyNumbers =  $callzy->where('status', 'active')->orderBy('id','desc')->paginate(
        //         $perPage = 10, $columns = ['*'], $pageName = 'callzy'
        //     );
        // }
        // else{
        //     $callzyNumbers = collect();
        // }
        $callzyNumbers =  $callzy->where('status', 'active')->orderBy('id','desc')->paginate(
            $perPage = 10, $columns = ['*'], $pageName = 'callzy'
        );

        $call48States = json_decode($this->getStates(),true);

        $recordings = Recording::where('user_id', $user_id)->get();
        
        return view('user.my_numbers.index', compact('callzyNumbers','clientNumbers','call48States','recordings'));
    }
    public function search_newnumber(Request $request){
        
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            return redirect()->back()->with('error',$authenticate['error']);
        }else{
            $token  = 'Authorization: '.$authenticate['data']['token'];
            
            $type = 'local';
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
    
            // dd($results);
            return view('user.my_numbers.results', compact('results'));
        }
        
    }

    public function purchase_newnumber(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());   
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            return redirect()->back()->with('error',$authenticate['error']);
        }else{
            $token  = 'Authorization: '.$authenticate['data']['token'];

            $numbers = $request->secret;
            $array = json_decode($numbers);
            // dd($array);

            foreach ($array as $number) {
                
                $value = '{
                    "type": "local",
                    "numbers": [
                      {
                        "npa": "'.$number->npa.'",
                        "nxx": "'.$number->nxx.'",
                        "xxxx": "'.$number->xxxx.'",
                        "type": "local",
                        "state": "'.$number->state.'",
                        "ratecenter": "'.$number->ratecenter.'",
                        "fwd_preconfigured": true
                      }
                    ]
                  }';

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
                    if(auth()->user()->role =="user"){
                        $tag = 'CallzyClient-'.$user->first_name;
                    }else if(auth()->user()->role =="admin"){
                        $tag = 'Admin';
                    }
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/update_tags?number='.$number->number.'&tags='.$tag,
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
                }

                // dd($json_response);
                
                if(auth()->user()->role =="user"){
                    $my_number = new MyNumber;
                    $my_number->user_id = auth()->user()->id;
                    $my_number->number = formatNumber($number->number);
                    $my_number->status = "active";
                    $my_number->type = auth()->user()->role =="user" ? "ClientNumber" : "CallzyOwned";
                    $my_number->tags = "ClientNumber".$user->first_name;
                    $my_number->company_id = auth()->user()->company_id;
                    $formatNumber = formatNumber($number->number);
                    $my_number->raw_number = $formatNumber;
                    if ($request->forward_number) {
                        $my_number->forward_to_number = $request->forward_number;
                        $formatForwardNumber = formatNumber($request->forward_number);
                        $my_number->raw_forward_to_number = $formatForwardNumber;
                    }
                    $my_number->purchase_response = json_encode($response);
                    $my_number->purchase_response_id = "";

                    $my_number->save();

                }else{
                   
                        $sw_number = new SwNumber;
                        $sw_number->friendly_name = formatNumber($number->number);
                        $sw_number->phone_number = formatNumber($number->number);
                        $sw_number->purchase_response = json_encode($response);
                        $sw_number->purchase_response_id = "";
                        $sw_number->status = "active";
                        $sw_number->save();
                }
            }

            if(auth()->user()->role =="user"){
                $route = 'user.my_numbers';
            }else if(auth()->user()->role =="admin"){
                $route = 'admin.numbers';
            }
            return redirect()->route($route)->with('success', 'Number Purchased Successfully');
        }
        
        // return redirect()->route('user/my-numbers');
        
    }

    public function updateMyNumber(Request $request,$id)
    {
		// $request->validate([
        //     'my_number' => 'min:14|max:14',
        //     // 'forward_to_number' => 'min:14|max:14',
        // ]);
		if($request->forward_to_number != null){
			$request->validate([
				'forward_to_number' => 'min:14|max:14',
			]);
		}
        // dd($request->all());
    	$number = MyNumber::find($id);
        if($request->my_number !== null){
            $number->number = $request->my_number;
        }
        if($request->forward_to_number !== null){
            $number->forward_to_number = $request->forward_to_number;
        }
        if($request->ivr_enabled == "Yes"){
            $number->ivr_enabled = true;
        }else{
            $number->ivr_enabled = false;
        }
        $number->recording_id = $request->recording;
        $number->continue_digit = $request->continue_digit;
        $number->optout_digit = $request->optout_digit;
        
        $number->save();

		if(auth()->user()->role == "user"){
			$myNumberURL = 'user.my_numbers';
		}else if(auth()->user()->role == "admin"){
			$myNumberURL = 'admin.numbers';
		}

		if($request->exists('search')){
			return redirect()->route($myNumberURL,'search')->with('success','Number Updated Successfully.');
		}elseif($request->exists('callzy_search')){
			return redirect()->route($myNumberURL,'callzy_search')->with('success','Number Updated Successfully.');
		}elseif($request->exists('client_search')){
			return redirect()->route($myNumberURL,'client_search')->with('success','Number Updated Successfully.');
		}
		else{
			return redirect()->back()->with('success','Number Updated Successfully.');
		}
        
    }
    public function getStates(){
        $authenticate  = json_decode(call48Login(),true);
        if(!is_null($authenticate['error']))
        {
            // return response()->json(['success'=>false,'error'=>$authenticate['error'],'data'=>null],400);
            return redirect()->route('user.my_numbers')->with('error',$authenticate['error']);
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
}
