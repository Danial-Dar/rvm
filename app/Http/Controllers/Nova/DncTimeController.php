<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\DNCTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class DncTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function dncTime(Request $request)
    {
        $user = Nova::user($request);
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

        return response()->json(
            [
                'data' => ['timeArray' => $timeArray, 'fromTime' => $fromTime, 'toTime' => $toTime, 'checkedDays' => $checkedDays],
            ],200
        );
    }

    public function updateDncTime(Request $request)
    {
        $request->validate([
            'days'=> 'required',
        ]);
        $days  = array_values(array_filter($request->days, fn($value) => !is_null($value) && $value !== ''));
        $fromTime  = array_values(array_filter($request->from_time, fn($value) => !is_null($value) && $value !== ''));
        $toTime  = array_values(array_filter($request->to_time, fn($value) => !is_null($value) && $value !== ''));
        
        $user = Nova::user($request);
        $user_id = $user->id;
        $company_id = $user->company_id;

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

        return response()->json(
            [
                'data' => ['message' => 'DNC Time Added Successfully.'],
            ],200
        );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
