<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsBillingSetting;
use Illuminate\Http\Request;

class SmsBillingSettingController extends Controller
{
    public function index()
    {
        $sms_billing_settings = SmsBillingSetting::paginate(10);
        return view('sms.billing.settings', compact('sms_billing_settings'));
    }

    public function update(Request $request, $id)
    {
        $sms_billing_setting = SmsBillingSetting::findOrFail($id);

        $sms_billing_setting->type = $request->type;
        $sms_billing_setting->rate = $request->rate;
        $sms_billing_setting->save();


        return redirect()->route('admin.sms.billing_settings')->with('success','Settings Updated Successfully.');
    }
}
