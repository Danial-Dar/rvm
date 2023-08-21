<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiSetting;
use App\Models\Setting;
use Exception;

class ApiSettingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $rvm_api_setting = ApiSetting::Where('slug', 'rvm')->first();
        $bot_api_setting = ApiSetting::Where('slug', 'bot')->first();
        $press_api_setting = ApiSetting::Where('slug', 'press-1')->first();
        $reputation_settings = Setting::Where('type', 'reputation')->get();



        return view('admin.settings.index', compact('rvm_api_setting', 'bot_api_setting', 'press_api_setting','reputation_settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'end_point' => 'required',
            'carrier_address' => 'required',
            // 'prefix' => 'required',
            'slug' => 'required'
        ]);

        $id = $request->id;
        if ($id == 0) {
            $api = new ApiSetting;
            $api->end_point = $request->end_point;
            $api->carrier_address = $request->carrier_address;
            $api->prefix = $request->prefix;
            $api->slug = $request->slug;
            if ($request->slug == "bot") {
                $api->transfer_dest = $request->transfer_dest;
            }
            $api->call_price = $request->call_price;
            $api->save();
        } else {
            $api = ApiSetting::find($id);
            $api->end_point = $request->end_point;
            $api->carrier_address = $request->carrier_address;
            $api->prefix = $request->prefix;
            $api->slug = $request->slug;
            if ($api->slug == "bot") {
                $api->transfer_dest = $request->transfer_dest;
            }
            $api->call_price = $request->call_price;
            $api->save();
        }

        return redirect()->back()->with('success', 'Api Setting Updated Successfully.');
    }


    public function storeReputationSettings(Request $request)
    {

        $request->validate([
            'robokiller_username' => 'required',
            'robokiller_password' => 'required',
            'ftc_api_key' => 'required',
            'price_per_number' => 'required|numeric',
            'type' => 'required'
        ]);

        Setting::updateOrCreate(
            ['key' => 'robokiller_username','type' => 'reputation'],
            ['value' => $request->robokiller_username]
        );
        Setting::updateOrCreate(
            ['key' => 'robokiller_password','type' => 'reputation'],
            ['value' => $request->robokiller_password]
        );
        Setting::updateOrCreate(
            ['key' => 'ftc_api_key','type' => 'reputation'],
            ['value' => $request->ftc_api_key]
        );
        Setting::updateOrCreate(
            ['key' => 'price_per_number','type' => 'reputation'],
            ['value' => $request->price_per_number]
        );

        return redirect()->back()->with('success', 'Caller Id Reputation Setting Updated Successfully.');
    }
}
