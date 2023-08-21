<?php

namespace Rvm\CampaignHours\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DNC;
use App\Models\DNCTime;
use App\Models\User;
class CampaignHourController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $days = Carbon::getDays();
        
        $user_id = $request->user()->id;
        $company_id  = $request->user()->company_id;

        $dnc_time = DNCTime::Where('user_id', $user_id)->get();
        
        $fromTime = [];
        $toTime = [];
        $checkedDays =  [];
        if($dnc_time->isNotEmpty()){
            foreach ($dnc_time as $value) {
                $checkedDays[] = $value->day;
                $fromTime[$value->day] = Carbon::parse($value->from_time)->format('H:i');
                $toTime[$value->day] = Carbon::parse($value->to_time)->format('H:i');
            }
        }

        $timeArray = [
            "00:00"=>"12:00 AM","00:30"=>"12:30 AM","01:00"=>"01:00 AM","01:30"=>"01:30 AM","02:00"=>"02:00 AM",
            "02:30"=>"02:30 AM","03:00"=>"03:00 AM","03:30"=>"03:30 AM","04:00"=>"04:00 AM","04:30"=>"04:30 AM",
            "05:00"=>"05:00 AM","05:30"=>"05:30 AM","06:00"=>"06:00 AM","06:30"=>"06:30 AM","07:00"=>"07:00 AM",
            "07:30"=>"07:30 AM","08:00"=>"08:00 AM","08:30"=>"08:30 AM","09:00"=>"09:00 AM","09:30"=>"09:30 AM",
            "10:00"=>"10:00 AM","10:30"=>"10:30 AM","11:00"=>"11:00 AM","11:30"=>"11:30 AM","12:00"=>"12:00 PM",
            "12:30"=>"12:30 PM","13:00"=>"01:00 PM","13:30"=>"01:30 PM","14:00"=>"02:00 PM","14:30"=>"02:30 PM",
            "15:00"=>"03:00 PM","15:30"=>"03:30 PM","16:00"=>"04:00 PM","16:30"=>"04:30 PM","17:00"=>"05:00 PM",
            "17:30"=>"05:30 PM","18:00"=>"06:00 PM","18:30"=>"06:30 PM","19:00"=>"07:00 PM","19:30"=>"07:30 PM",
            "20:00"=>"08:00 PM","20:30"=>"08:30 PM","21:00"=>"09:00 PM","21:30"=>"09:30 PM","22:00"=>"10:00 PM",
            "22:30"=>"10:30 PM","23:00"=>"11:00 PM","23:30"=>"11:30 PM","23:59"=>"11:59 PM"];

        return response()->json([
            'dncTime' => $dnc_time,
            'timeArray' => $timeArray,
            'fromTime'=> $fromTime,
            'toTime'=> $toTime,
            'checkedDays'=> $checkedDays
        ],200);
        
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user_id = $request->user()->id;
        $company_id = $request->user()->company_id;
        $role = $request->user()->role;
        $dnc_times = DNCTime::Where('user_id', $user_id)->delete();
        if(count($data) > 0){
            foreach($data as $dt){
                $day       = $dt['day'];
                $fromTime  = $dt['fromTime'];
                $toTime    = $dt['toTime'];
                
                $dnc = new DNCTime;
                $dnc->user_id = $user_id;
                $dnc->company_id = $company_id;
                $dnc->user_type = $role;
                $dnc->day = $day;
                $dnc->from_time = Carbon::parse($fromTime)->format('H:i:s');
                $dnc->to_time = Carbon::parse($toTime)->format('H:i:s');
                $dnc->save();
            }
            return response()->json([
                'success'=>true,
                'message' => "Campaign Hour Updated Successfully",
                'data'=> $data
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>"Data not inserted",
                'data'=> null
            ],200);
        }

    }

    // public function delete(Request $request)
    // {
    //    	$dnc_id = $request->id;

    //     $dnc = DNC::find($dnc_id);
    //     $dnc->delete();

    //     return redirect()->back()->with('success','DNC Number deleted Successfully.');

    // }
}
