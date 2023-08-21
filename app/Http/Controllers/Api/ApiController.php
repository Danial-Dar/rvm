<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CampaignContact;
use App\Models\Company;
use App\Models\DNC;
use App\Models\DNCTime;
use App\Models\IvrIncomingCallLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    public function dtmf(Request $request) {

        $tmp = explode('-', $request->transactionid);
        $transaction_id = end($tmp);
        $ivr_incoming_call_log = new IvrIncomingCallLog();
        $ivr_incoming_call_log->campaign_contact_id = $transaction_id;
        $ivr_incoming_call_log->from_number = $request->from;
        $ivr_incoming_call_log->to_number = $request->to;
        $ivr_incoming_call_log->disposition = $request->Disposition;
        $ivr_incoming_call_log->save();

        if($ivr_incoming_call_log->Disposition == 'OPTOUT') {
            $dnc = new DNC();
            $dnc->number = $ivr_incoming_call_log->to_number;
            $dnc->user_id = CampaignContact::find($ivr_incoming_call_log->campaign_contact_id)->user_id;
            $dnc->company_id = CampaignContact::find($ivr_incoming_call_log->campaign_contact_id)->company_id;
            $dnc->save();
        }
        return $request->all();
    }


    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $accessToken =  $user->createToken('authToken')-> accessToken;



            return response(['user' => auth()->user(), 'access_token' => $accessToken]);
        }
        else{
            return response(['error' => 'Invalid Credentials', 200]);
        }
    }

    public function signUp(Request $request)
    {
        $params = $request->all();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'company' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'ein' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'description' => 'required',
        ];

        $validation = \Illuminate\Support\Facades\Validator::make($params, $rules,[]);

        if ($validation->fails()) {
            return Response::json($validation->errors()->first(), 400);
        }

        $company = new Company;
        $company->name = $request->company;
        $company->email = $request->email;
        $company->phone_number = preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $request->phone_number);
        $company->status = 1;
        $company->address = $request->address;
        $company->city = $request->city;
        $company->state = $request->state;
        $company->zip = $request->zip;
        $company->credit_limit = 0;
        $company->first_name =  $request->first_name;
        $company->last_name = $request->last_name;
        $company->ein = $request->ein;
        $company->save();

        $user = new User;
        $user->first_name =  $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->company_id = $company->id;
        // $user->address = $request->address;
        // $user->city = $request->city;
        // $user->state = $request->state;
        // $user->zip = $request->zip;
        // $user->description_of_use_of_system = $request->description;
        $user->role = 'company';
        $user->status = 1;
        $user->save();

        $daysArray = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

        $d1 = strtotime("09:00am");
        $d2 = strtotime("05:00pm");
        $from_time = date("h:i:sa", $d1 );
        $to_time = date("h:i:sa", $d2 );
        foreach($daysArray as $key => $value){
            $dnc = new DNCTime();
            $dnc->user_id = $user->id;
            $dnc->company_id = $company->id;
            $dnc->user_type = $user->role;
            $dnc->day = $value;
            $dnc->from_time = $from_time;
            $dnc->to_time = $to_time;
            $dnc->save();
        }

        return response(['message' => 'Sign Up Successfully', 'data' => $user]);

    }

    public function test()
    {
        return 'hello';
    }

    public function callFrom(Request $request)
    {
        $i = time();
        $i %= 2;
        if ($i == 0)
        {
            $xml =  '<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial callerId="'.$request->from.'">+19495703086</Dial>
            </Response>';
        }
        else {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial callerId="'.$request->from.'">+12092990540</Dial>
            </Response>';


        }

        return $xml;

    }
}
