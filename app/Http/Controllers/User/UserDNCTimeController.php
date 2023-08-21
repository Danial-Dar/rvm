<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DNC;
use App\Models\DNCTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDNCTimeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        //------------previous working code---------
        // $user = Auth::user();
        // $user_id = $user->id;
        // $company_id = $user->company_id;

        // $dnc_time = DNCTime::Where('user_id', $user_id)->paginate(20);

        // $days = Carbon::getDays();

        // return view('user.dnc-time.index', compact('dnc_time', 'days'));

        //-----------new requirements code-------------
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $days = Carbon::getDays();
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
        
        // foreach ($dnc_time as $value) {
        //     $dnc_array[] = $value->day.'-'.$value->from_time.'-'.$value->to_time;
        // }
        // dd($dnc_array);
        // $defaultDNC = ['Sunday-20:00:00-21:00:00', 'Monday-20:00:00-21:00:00', 'Tuesday-20:00:00-21:00:00', 
        //             'Wednesday-20:00:00-21:00:00', 'Thursday-20:00:00-21:00:00', 'Friday-20:00:00-21:00:00', 
        //             'Saturday-20:00:00-21:00:00', 'Sunday-21:00:00-22:00:00', 'Monday-21:00:00-22:00:00', 
        //             'Tuesday-21:00:00-22:00:00', 'Wednesday-21:00:00-22:00:00', 'Thursday-21:00:00-22:00:00', 
        //             'Friday-21:00:00-22:00:00', 'Saturday-21:00:00-22:00:00', 'Sunday-22:00:00-23:00:00', 
        //             'Monday-22:00:00-23:00:00', 'Tuesday-22:00:00-23:00:00', 'Wednesday-22:00:00-23:00:00', 
        //             'Thursday-22:00:00-23:00:00', 'Friday-22:00:00-23:00:00', 'Saturday-22:00:00-23:00:00', 
        //             'Sunday-23:00:00-00:00:00', 'Monday-23:00:00-00:00:00', 'Tuesday-23:00:00-00:00:00', 
        //             'Wednesday-23:00:00-00:00:00', 'Thursday-23:00:00-00:00:00', 'Friday-23:00:00-00:00:00', 
        //             'Saturday-23:00:00-00:00:00','Sunday-00:00:00-01:00:00', 'Sunday-01:00:00-02:00:00', 'Sunday-02:00:00-03:00:00', 
        //             'Sunday-03:00:00-04:00:00', 'Sunday-04:00:00-05:00:00', 'Sunday-05:00:00-06:00:00', 'Sunday-06:00:00-07:00:00', 'Monday-00:00:00-01:00:00', 
        //             'Monday-01:00:00-02:00:00', 'Monday-02:00:00-03:00:00', 'Monday-03:00:00-04:00:00', 'Monday-04:00:00-05:00:00', 'Monday-05:00:00-06:00:00', 
        //             'Monday-06:00:00-07:00:00', 'Tuesday-00:00:00-01:00:00', 'Tuesday-01:00:00-02:00:00', 'Tuesday-02:00:00-03:00:00', 'Tuesday-03:00:00-04:00:00', 
        //             'Tuesday-04:00:00-05:00:00', 'Tuesday-05:00:00-06:00:00', 'Tuesday-06:00:00-07:00:00', 'Wednesday-00:00:00-01:00:00', 
        //             'Wednesday-01:00:00-02:00:00', 'Wednesday-03:00:00-04:00:00', 'Wednesday-02:00:00-03:00:00', 'Wednesday-04:00:00-05:00:00', 
        //             'Wednesday-05:00:00-06:00:00', 'Wednesday-06:00:00-07:00:00', 'Thursday-06:00:00-07:00:00', 'Thursday-05:00:00-06:00:00', 'Thursday-03:00:00-04:00:00', 
        //             'Thursday-04:00:00-05:00:00', 'Thursday-02:00:00-03:00:00', 'Thursday-00:00:00-01:00:00', 'Thursday-01:00:00-02:00:00', 'Friday-00:00:00-01:00:00', 
        //             'Friday-01:00:00-02:00:00', 'Friday-02:00:00-03:00:00', 'Friday-03:00:00-04:00:00', 'Friday-04:00:00-05:00:00', 'Friday-05:00:00-06:00:00',
        //             'Friday-06:00:00-07:00:00', 'Saturday-06:00:00-07:00:00', 'Saturday-05:00:00-06:00:00', 'Saturday-04:00:00-05:00:00', 'Saturday-03:00:00-04:00:00', 
        //             'Saturday-02:00:00-03:00:00', 'Saturday-01:00:00-02:00:00', 'Saturday-00:00:00-01:00:00'];
        
        // $defaultDNC = array_diff($defaultDNC, $dnc_array);
        // dd($arr,count($defaultDNC));
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

        return view('user.dnc-time.index',compact('timeArray','fromTime','toTime','checkedDays'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'days'=> 'required',
        ]);
        $days  = array_values(array_filter($request->days, fn($value) => !is_null($value) && $value !== ''));
        $fromTime  = array_values(array_filter($request->from_time, fn($value) => !is_null($value) && $value !== ''));
        $toTime  = array_values(array_filter($request->to_time, fn($value) => !is_null($value) && $value !== ''));
        
        // dd(explode(",",$request->timeslots));
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        // $timeslots = explode(",",$request->timeslots);
        // dd($days,$fromTime,$toTime);
        $dnc_times = DNCTime::Where('user_id', $user_id)->delete();
        foreach ($days as $key=>$value) {
            if(isset($fromTime[$key]) && isset($toTime[$key])){
                $dnc = new DNCTime;
                $dnc->user_id = $user_id;
                $dnc->company_id = $company_id;
                $dnc->user_type = auth()->user()->role;
                $dnc->day = $value;
                $dnc->from_time = Carbon::parse($fromTime[$key])->format('H:i:s');
                $dnc->to_time = Carbon::parse($toTime[$key])->format('H:i:s');
                $dnc->save();
            }
        }
        // dd($dnc,$fromTime,$toTime);
        // foreach ($timeslots as $value) {
        //     $mts = explode("-", $value);
            
        //     $dnc = new DNCTime;
        //     $dnc->user_id = $user_id;
        //     $dnc->company_id = $company_id;
        //     $dnc->user_type = auth()->user()->role;
        //     $dnc->day = $mts[0];
        //     $dnc->from_time = Carbon::parse($mts[1])->format('H:i:s');
        //     $dnc->to_time = Carbon::parse($mts[2])->format('H:i:s');
        //     $dnc->save();
        // }

        return redirect()->back()->with('success','DNC Time Added Successfully.');

    }

    public function delete(Request $request)
    {
       	$dnc_id = $request->id;

        $dnc = DNCTime::find($dnc_id);
        $dnc->delete();

        return redirect()->back()->with('success','DNC Time deleted Successfully.');

    }

    public function show(Request $request){

    }
}
