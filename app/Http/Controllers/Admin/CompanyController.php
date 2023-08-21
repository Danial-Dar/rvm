<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySettings;
use App\Models\DNCTime;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('company_settings')->get();
        
        return view('admin.company.index', compact('companies'));
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
        $request->validate([
            'name' => 'required',
            'settings' => 'required',

        ]);
        // $daysArray = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

        // $d1 = strtotime("08:00pm");
        // $d2 = strtotime("11:59pm");
        // $d3 = strtotime("12:00am");
        // $d4 = strtotime("06:00am");
        // $from_time1 = date("h:i:sa", $d1 );
        // $to_time1 = date("h:i:sa", $d2 );
        // $from_time2 = date("h:i:sa", $d3 );
        // $to_time2 = date("h:i:sa", $d4 );

        $company = new Company;
        $company->name = $request->name;
        $company->status = 1;
        $company->save();

        $settings  = $request->get('settings');
        foreach($settings as $key => $setting){
            $companySetting = CompanySettings::updateOrCreate(
                ['company_id' => $company->id, 'key' => $key]
            );
            $companySetting->key = $key;
            $companySetting->key_label = $setting['label'];
            $companySetting->value = $setting['value'];
            $companySetting->company_id = $company->id;
            $companySetting->save();
        }

        $daysArray = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

        $d1 = strtotime("09:00am");
        $d2 = strtotime("05:00pm");
        $from_time = date("h:i:sa", $d1 );
        $to_time = date("h:i:sa", $d2 );
        foreach($daysArray as $key => $value){
            $dnc = new DNCTime;
            $dnc->user_id = auth()->user()->id;
            $dnc->company_id = $company->id;
            $dnc->user_type = auth()->user()->role;
            $dnc->day = $value;
            $dnc->from_time = $from_time;
            $dnc->to_time = $to_time;
            $dnc->save();
        }   

        // foreach($daysArray as $key => $value){
        //     $dnc = new DNCTime;
        //     $dnc->user_id = auth()->user()->id;
        //     $dnc->company_id = $company->id;
        //     $dnc->user_type = auth()->user()->role;
        //     $dnc->day = $value;
        //     if($key >= 7){
        //         $dnc->from_time = $from_time2;
        //         $dnc->to_time = $to_time2;
        //     }else{
        //         $dnc->from_time = $from_time1;
        //         $dnc->to_time = $to_time1;
        //     }
        //     $dnc->save();
        // }       

        return redirect()->back()->with('success','New Company created successfully.');
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
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'settings' => 'required',
        ]);
        $company = Company::where('id' ,$request->id)->first();
        $company->name = $request->name;
        $company->status = $request->status;
        $company->save();

        if($request->status == "0"){
            User::where('company_id', $request->id)->update([
                'status' => 0,
            ]);
            // $companyUsers = User::where('company_id',$request->id)->get();
            // dd($companyUsers);
            
            // if($companyUsers->isNotEmpty()){
            //     foreach($companyUsers as $user){
            //         $updateUserStatus = User::find($user->id);
            //         $updateUserStatus->status = 0;
            //         $updateUserStatus->save();
            //     }
            // }
            
        }

        $settings  = $request->get('settings');
        foreach($settings as $key => $setting){
            $companySetting = CompanySettings::updateOrCreate(
                ['company_id' => $request->id, 'key' => $key]
            );
            $companySetting->key = $key;
            $companySetting->key_label = $setting['label'];
            $companySetting->value = $setting['value'];
            $companySetting->company_id = $request->id;
            $companySetting->save();
        }
        return redirect()->back()->with('success','Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::Where('id', $id)->first();

        $company->status = 0;
        $company->save();

        return redirect()->back()->with('success','Company Deleted.');
    }
}
