<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\ContactList;
use App\Models\CampaignContact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $q = Campaign::query();
        $q = $q->with('user', 'campaignStats');
        if ($search != null) {
            $q->whereHas('user', function ($query) use($search) {
                $query->where('first_name', 'ilike', '%'.$search.'%');
            })->orwhereHas('user', function ($query) use($search) {
                $query->where('last_name', 'ilike', '%'.$search.'%');
            })->orWhere('created_at', 'like','%'.$search.'%')->orWhere('name', 'ilike','%'.$search.'%');;
        }
        if ($status != null) {
            $q->where('status',$status);
        }
        $campaigns = $q
        // ->withCount('campaignContacts')
            // ->withCount([
            //     'campaignContacts',
            //     'campaignContacts as success' => function ($query) {
            //         $query->where('status', 'success');
            //     },
            //     'campaignContacts as fail' => function ($query) {
            //         $query->where('status', 'fail');
            //     },
            //     'campaignContacts as pending' => function ($query) {
            //         $query->whereNotIn('status', ['success','fail', 'initiated']);
            //     },
            //     'campaignContacts as initiated' => function ($query) {
            //         $query->where('status', 'initiated');
            //     },
            //     ])
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        // foreach ($campaigns as $key => $camp) {
        //     $last_ran = CampaignContact::Where('campaign_id' ,$camp->id)->orderBy('updated_at','desc')->first();
        //     if ($last_ran){
        //         $last[] = Carbon::parse($last_ran->updated_at)->format('m-d-Y H:i:s A');
        //     }
        // }
        $statusArray = ['preprocessing','finished','inactive','deleted','paused'];
        $activeCampaigns = Campaign::whereNotIn('status',$statusArray)->count();
        $pausedCampaigns = Campaign::where('status','paused')->count();
        return view('admin.dashboard.index', compact('campaigns','activeCampaigns','pausedCampaigns'));
    }

    // waleed work
    public function showContactList(Request $request,$campaign_id){

        // $campaign_id = $campaign_id;
        $campaign = Campaign::find($campaign_id);
        $contactList = [];
        // dd($campaign);
        if($campaign != null &&  $campaign->contact_list_id !== null){
            $campaign->contact_list_ids = explode(',',str_replace('"','',str_replace('"]','',str_replace('["','',$campaign->contact_list_id))));
        }else{
            $$campaign->contact_list_ids = null;
        }
        if($campaign->contact_list_ids != null){

            foreach($campaign->contact_list_ids as $contact_list_id){
                $contactList[] = $contact_list_id;

            }
        }
        $contact_lists =[];
        //-----------------previous query-----------------
        // if(count($contactList) > 0 ){
        //     foreach($contactList as $list){
        //         $contact_lists[] = ContactList::Where('id', $list)->first();
        //     }
        // }

        //----------------optimized query
        if(count($contactList) > 0 ){
            $contact_lists = ContactList::WhereIn('id', $contactList)->get();
        }

        // dd($contact_lists);
        return view('admin.dashboard.view_contact_list', compact('contact_lists', 'campaign'));
    }
    public function showContactListStatus(Request $request){
        $contact_list_id = $request->contact_list_id;
        $campaign_id = $request->campaign_id;
        $campaign_contact = CampaignContact::where('campaign_id',$campaign_id)->where('contact_list_id',$contact_list_id)->paginate(10);
        // dd($campaign_contact);
        return view('admin.dashboard.view_contact_list_status', compact('campaign_contact'));

    }
    // waleed work end
}
