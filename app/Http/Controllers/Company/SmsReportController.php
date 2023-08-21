<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\SmsCampaign;
use App\Models\SmsContactList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id){
            //TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }
        $campaig_q  = SmsCampaign::query();
        $contact_q= SmsContactList::query();
        if (auth()->user()->role == "company") {
            $campaig_q->where('company_id',$company_id);
            $contact_q->where('company_id',$company_id);
        }
        $sms_campaign = $campaig_q->get();

        $sms_contact_lists = $contact_q->get();

        return view('sms.reports.index',compact('sms_campaign','sms_contact_lists'));
    }
}