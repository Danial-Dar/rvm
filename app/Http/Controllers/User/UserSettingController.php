<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $models_all = UserSetting::Where('user_id', $user_id)->get();
        $models = array();
        foreach ($models_all as $model) {
            $models[$model->key] = $model->value;
        }
        // dd($models);
        $count = count($models);

        return view('user.user_setting.index', compact('models', 'count', 'models_all'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
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
        // dd($companyUsers);
        // foreach($settings as $key => $setting){
        //     $userSetting = UserSetting::updateOrCreate(
        //         ['user_id' => $user_id, 'key' => $key]
        //     );
        //     $userSetting->key_label = $setting['label'];
        //     $userSetting->value = $setting['value'];
        //     $userSetting->company_id = $company_id;
        //     $userSetting->save();
        // }

        return redirect()->back()->with('success','User Setting added successfully.');

    }

    public function delete(Request $request)
    {
       	$id = $request->id;

        $model = UserSetting::find($id);
        $model->delete();

        return redirect()->back()->with('success','User Setting deleted Successfully.');

    }

    public function show(Request $request){

    }
}
