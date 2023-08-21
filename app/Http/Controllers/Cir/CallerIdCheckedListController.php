<?php

namespace App\Http\Controllers\Cir;

use App\Exports\CalleridContactListExport;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CallerIdCheckedListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $lists = Contact::where('reputation_checked', true)->Where('status', 'active')->with(['company']);
        if(Auth()->user()->role != 'admin'){
            $company_id = $user->company_id;
            $lists=$lists->Where('company_id', $company_id);
        }
        $lists=$lists->orderBy('id', 'desc')->paginate(20);

        return view('callerid.list.show', compact('lists'));
    }

    public function exportContacts()
    {
        $role=Auth()->user()->role;
        $company_Id=0;
        if (in_array($role,['user','company']) ) {
            $company_Id = Auth()->user()->company_id;
        }

            return Excel::download(new CalleridContactListExport($company_Id), 'callerid_contact_list.csv');

    }
}
