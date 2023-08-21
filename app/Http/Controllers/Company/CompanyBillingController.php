<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyBillingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function index()
    {
        // $companies = Company::get();
        $users = User::Where('role', 'user')->Where('company_id', auth()->user()->company_id)->get();
        // dd($users);
        return view('company.billing.index', compact( 'users'));
    }

    

    public function all_user()
    {
        $users = User::Where('company_id', auth()->user()->company_id)->Where('role', 'user')->get();
        foreach ($users as $user) {

            $user['sum'] = CampaignContact::Where('user_id', $user->id)->sum('price');

            $user['rvm_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'rvm');
                })->Where('user_id', $user->id)->sum('price');

            $user['bot_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'bot');
                })->Where('user_id', $user->id)->sum('price');

            $user['press_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'press-1');
                })->Where('user_id', $user->id)->sum('price');
        }

        // dd($users);

        return $users;
    }

    public function specific_user($id)
    {
        
        // $campaigns = Campaign::Where('user_id', $id)->get();

        // foreach ($campaigns as $campaign) {
        //     $campaign['sum'] = CampaignContact::Where('campaign_id', $campaign->id)->sum('price'); 
        // }

        $campaigns = Campaign::withSum('campaignContacts as sum', 'price')->WhereHas('campaignContacts', function ($query) {
            $query->where('price', '!=', null);
            })->Where('user_id', $id)->get();

        return $campaigns;
    }
}
