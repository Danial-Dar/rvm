<?php

namespace App\Http\Controllers\Cir;
 
use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\ContactList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CalleridBillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        $users = User::get();
        if (auth()->user()->role == 'admin') {
            return view('callerid.billing.index', compact('companies', 'users'));
        } elseif (auth()->user()->role == 'user') {
            return view('callerid.billing.index', compact('companies', 'users'));
        } elseif (auth()->user()->role == 'company') {
            return view('callerid.billing.index', compact('companies', 'users'));
        }
    }

    public function getBillingData(Request $request)
    {
        $from = date($request->start_date);
        $to = date($request->end_date);
        $company = $request->company;
        $contact_lists = [];

        $settingPricePerNumberCheck = Setting::where('type', 'reputation')->firstWhere('key', 'price_per_number');
        $pricePerCheck = $settingPricePerNumberCheck ? $settingPricePerNumberCheck->value : '0.5';

        if (auth()->user()->role == 'admin') {

            $contact_lists = ContactList::with(['contacts','company'])
            ->withCount('contacts')
            ->whereIn('reputation_check_status', ['inprocess', 'failed', 'complete'])
            ->whereHas('contacts',function($query) use( $from, $to, $company ){
                if($company != 'all' && $company)
                    $query->where('company_id', $company);
                if($from && $to) {
                    $query->whereBetween('reputation_date', [$from, $to]);
                }
                return $query;
            })->get();

        } elseif (auth()->user()->role == 'user') {
            $compId = auth()->user()->company_id;
            $userId = auth()->user()->id;

            $contact_lists = ContactList::with(['contacts','company'])
            ->withCount('contacts')
            ->whereIn('reputation_check_status', ['inprocess', 'failed', 'complete'])
            ->whereHas('contacts',function($query) use( $from, $to, $compId){
                $query->where('company_id', $compId);
                if($from && $to) {
                    $query->whereBetween('reputation_date', [$from, $to]);
                }
                return $query;
            })->get();



        } elseif (auth()->user()->role == 'company') {
            $compId = auth()->user()->company_id;
            $contact_lists = ContactList::with(['contacts','company'])
            ->withCount('contacts')
            ->whereIn('reputation_check_status', ['inprocess', 'failed', 'complete'])
            ->whereHas('contacts',function($query) use( $from, $to, $compId){
                $query->where('company_id', $compId);
                if($from && $to) {
                    $query->whereBetween('reputation_date', [$from, $to]);
                }
                return $query;
            })->get();

        }
        return response()->json(['list' => $contact_lists, 'rate' => $pricePerCheck ]);
    }


}
