<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignList;
use App\Models\Company;
use App\Models\ContactList;
use App\Models\Recording;
use App\Models\User;
use App\Models\DNCTime;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = Company::Where('status', 1)->orderBy('id','desc')->get();

        // $users = User::with('company')->withCount([
        //     'campaign_contacts',
        //     'campaign_contacts as success' => function ($query) {
        //         $query->where('status', 'success');
        //     },
        //     'campaign_contacts as fail' => function ($query) {
        //         $query->where('status', 'fail');
        //     },
        //     'campaign_contacts as pending' => function ($query) {
        //         $query->where('status', 'pending');
        //     },
        //     'campaign_contacts as initiated' => function ($query) {
        //         $query->where('status', 'initiated');
        //     },
        //     ])
        // ->get();

        $q = User::query();
        $q = $q->with('company')->withCount([
            // 'campaignStats',
            'campaignStats as total_contact_count' => function ($query) {
                $query->select(\DB::raw('SUM(contact_count) AS total_contact_count'));
            },
            'campaignStats as total_sent_count' => function ($query) {
                $query->select(\DB::raw('SUM(sent_count) AS total_sent_count'));
            },
            'campaignStats as total_initiated_count' => function ($query) {
                $query->select(\DB::raw('SUM(initiated_count) AS total_initiated_count'));
            },
            'campaignStats as total_success_count' => function ($query) {
                $query->select(\DB::raw('SUM(success_count) AS total_success_count'));
            },
            'campaignStats as total_failed_count' => function ($query) {
                $query->select(\DB::raw('SUM(failed_count) AS total_failed_count'));
            },
            'campaignStats as total_dnc_count' => function ($query) {
                $query->select(\DB::raw('SUM(dnc_count) AS total_dnc_count'));
            },
        ]);
        // ->where('company_id',auth()->user()->company_id)
        $users = $q->get();

        // dd($users);

        return view('admin.users.index', compact('users', 'companies'));

    }

    public function getUsers()
    {
        $users = User::Where('role', 'user')->get();
        return Response::json(['users' => $users], 200);
    }

    public function getBotUser($id)
    {
        $bot = Bot::Find($id);
        $user = User::Where('role', 'company')->Where('company_id', $bot->company_id)->first();
        return response()->json([
            'user_id' => $user->id,
            'port_number' => $bot->port_number,
        ], 200);
    }

    public function test()
    {
        $sql = DB::table('model_has_roles')->truncate();

        $users = User::Where('role', 'user')->get();

        $admins = User::Where('role', 'admin')->get();

        foreach ($users as $user) {
            $user->assignRole('user');
        }

        foreach ($admins as $admin) {
            $admin->assignRole('super-admin');
        }

        return 'Roles Assign To all Users';

    }

    public function create(Request $request)
    {
         $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role' => 'required',
        ]);

            $user = new User;
            $user->first_name =  $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            if ($request->image) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(storage_path('images'), $imageName);

                $user->user_image = $imageName;
            }
            $user->status = 1;
            if ($request->role == "user") {
                $user->company_id = $request->company;
            }
            if ($request->role == "company") {
                $user->company_id = $request->company;
            }

            $user->save();

            $daysArray = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

            $d1 = strtotime("09:00am");
            $d2 = strtotime("05:00pm");
            $from_time = date("h:i:sa", $d1 );
            $to_time = date("h:i:sa", $d2 );

            foreach($daysArray as $key => $value){
                $dnc = new DNCTime;
                $dnc->user_id = $user->id;
                $dnc->company_id = $user->company_id;
                $dnc->user_type = $user->role;
                $dnc->day = $value;
                $dnc->from_time = $from_time;
                $dnc->to_time = $to_time;
                $dnc->save();
            }

            return redirect()->back()->with('success','New '.$request->role.' created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);
        $user = User::where('id' ,$request->id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        // $user->status = $request->status;
        // $old_role = $user->role;
        // $user->role = (isset($request->role)) ? $request->role : $old_role;
        // $user->company_id = $request->company;

        $old_password = $user->password;
        $user->password = (isset($request->password)) ? Hash::make($request->password) : $old_password;

        if ($request->image) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(storage_path('images'), $imageName);

            $user->user_image = $imageName;
        }
        // dd($user);
        $user->save();
        return redirect()->back()->with('success','User updated successfully.');
    }
    public function delete($id)
    {
        $recordings = Recording::where('user_id', $id)->where('status', 1)->get();

        $recording_id =[];
        foreach ($recordings as $rec) {
            $recording_id[] = $rec->id;
        }

        $contact_lists = CampaignList::with('campaign')->whereHas('campaign', function ($query) {
            $query->whereIn('status',['played', 'pending']);
        })->Where('user_id', $id)->count();

        if ($contact_lists > 0 ) {
            return redirect()->back()->with('error','Users Lists are currently used in campaigns.');
        }

        // foreach ($contact_lists as $list) {
        //     $list_camp_id[] = $list->campaign_id;
        // }
        $campaigns = Campaign::where('user_id', $id)->whereIn('status',['played', 'pending'])
                     ->WhereIn('recording_id', $recording_id)
                     ->count();
        // dd($campaigns);

        if($campaigns > 0){

            return redirect()->back()->with('error','Users Campaigns are currently Playing / Pending.');

        }

        $user = User::Where('id', $id)->first();

        if($user != null && $user->role =="company"){
            User::where('company_id', $user->company_id)->update([
                'status' => 0,
            ]);
            // $companyUsers = User::where('company_id',$user->company_id)->get();
            // foreach($companyUsers as $user){
            //     $updateUserStatus = User::find($user->id);
            //     $updateUserStatus->status = 0;
            //     $updateUserStatus->save();
            // }
        }else{
            $user->status = 0;
            $user->save();
        }


        return redirect()->back()->with('success','User Inactive Successfully.');
    }

    public function activate($id)
    {
        $user = User::Where('id', $id)->first();

        $user->status = 1;
        $user->save();
        $activeCompany = Company::find($user->company_id);
        $activeCompany->status = 1;
        $activeCompany->save();

        return redirect()->back()->with('success','User Activated Successfully.');
    }

    public function userDetail($id){
        if (is_numeric($id)) {
            $user = User::find($id);
            $campaigns = Campaign::with('user', 'last_ran')

                ->withCount([
                    'campaignContacts',
                    'campaignContacts as success' => function ($query) {
                        $query->where('status', 'success');
                    },
                    'campaignContacts as fail' => function ($query) {
                        $query->where('status', 'fail');
                    },
                    'campaignContacts as pending' => function ($query) {
                        $query->whereNotIn('status', ['success','fail']);
                    },
                    ])
                ->where('user_id',$id)->get();
            // $last = [];
            // foreach ($campaigns as $key => $camp) {
            //     $last_ran = CampaignContact::Where('campaign_id' ,$camp->id)->orderBy('updated_at','desc')->first();
            //     if ($last_ran){
            //         $last[] = Carbon::parse($last_ran->updated_at)->format('m-d-Y H:i:s A');
            //     }
            // }

            $lists = ContactList::Where('user_id', $id)->get();
            $recordings = Recording::Where('user_id', $id)->get();
        }else{
            $user =collect();
            $campaigns = collect();
            $last = [];
            $lists = collect();
            $recordings = collect();
        }


        return view('admin.users.user_detail', compact('user','campaigns','lists','recordings'));
    }

    public function companyUser()
    {
        $companies = Company::Where('status', 1)->get();
        $q = User::query();
        $q = $q->with('company')->withCount([
            // 'campaignStats',
            'campaignStats as total_contact_count' => function ($query) {
                $query->select(\DB::raw('SUM(contact_count) AS total_contact_count'));
            },
            'campaignStats as total_sent_count' => function ($query) {
                $query->select(\DB::raw('SUM(sent_count) AS total_sent_count'));
            },
            'campaignStats as total_initiated_count' => function ($query) {
                $query->select(\DB::raw('SUM(initiated_count) AS total_initiated_count'));
            },
            'campaignStats as total_success_count' => function ($query) {
                $query->select(\DB::raw('SUM(success_count) AS total_success_count'));
            },
            'campaignStats as total_failed_count' => function ($query) {
                $query->select(\DB::raw('SUM(failed_count) AS total_failed_count'));
            },
            'campaignStats as total_dnc_count' => function ($query) {
                $query->select(\DB::raw('SUM(dnc_count) AS total_dnc_count'));
            },
        ]);
        $users = $q->where('company_id',auth()->user()->company_id)->get();
        // dd($users);
        return view('company.users.index', compact('users', 'companies'));

    }

    public function userLogin($id,Request $request){
        try{
            $user = User::findorFail($id);
            $credentials = [
                'email' => $user->email,
                // 'password' => $user->password,
            ];
            // dd(Auth::loginUsingId($user->id, TRUE));
            if(Auth::loginUsingId($user->id, TRUE)) {
                return redirect()->route('user.dashboard');
            }else{
                return redirect()->back()->with('error','invalid credentials.');
            }
        }catch(\Exception $e){
            return redirect()->route('user')->with('error',$e->getMessage());
        }


    }

    public function company_user_setting($id)
    {
        $company_id = $id;

        $user = User::Where('company_id', $company_id)->Where('role', 'company')->first();

        $value = 0;

        if ($user != "") {
            $user_id = $user->id;
            $company_id = $user->company_id;

            $setting = UserSetting::Where('user_id', $user_id)->Where('key', 'daily_max_limit')->first();

            if ($setting != "") {
                $value = $setting->value;
            }
        }

        return Response::json(array(
            'value' => $value));

    }

    public function company_user_setting_update(Request $request)
    {
        // dd($request->all());
        $company_id = $request->id_daily_limit;

        $request->validate([
            'settings' => 'required',
        ]);
        $companyUsers = User::where('company_id',$company_id)->get();

        $settings  = $request->get('settings');
        foreach($companyUsers as $user){
            foreach($settings as $key => $setting){
                $userSetting = UserSetting::updateOrCreate(
                    ['user_id' => $user->id, 'key' => $key]
                );
                $userSetting->key_label = $setting['label'];
                $userSetting->value = $setting['value'];
                $userSetting->company_id = $company_id;
                $userSetting->save();
            }
        }

        return redirect()->back()->with('success', 'Daily Limit Updated Successfully');
    }

    public function user_setting($id)
    {
        $user_id = $id;
        $setting = UserSetting::Where('user_id', $user_id)->Where('key', 'daily_max_limit')->first();

        $value = 0;

        if ($setting != "") {
            $value = $setting->value;
        }
        return Response::json(array(
            'value' => $value));

    }

    public function user_setting_update(Request $request)
    {
        // dd($request->all());
        $user = User::Where('id' ,$request->id_daily_limit)->first();

        $request->validate([
            'settings' => 'required',
        ]);
        // $companyUsers = User::where('company_id',$company_id)->get();

        $settings  = $request->get('settings');
        // foreach($companyUsers as $user){
            foreach($settings as $key => $setting){
                $userSetting = UserSetting::updateOrCreate(
                    ['user_id' => $user->id, 'key' => $key]
                );
                $userSetting->key_label = $setting['label'];
                $userSetting->value = $setting['value'];
                $userSetting->company_id = $user->company_id;
                $userSetting->save();
            }
        // }

        return redirect()->back()->with('success', 'Daily Limit Updated Successfully');
    }


}
