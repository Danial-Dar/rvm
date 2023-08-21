<?php

namespace App\Http\Controllers\Cir;

use Illuminate\Http\Request;
use App\Models\ReputationHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CirReportController extends Controller
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
        $role=$user->role;
        $company_id = $user->company_id;

        // $lists = Contact::where('reputation_checked', true)->where('type','cir')->with(['company']);
        $TotalCollection = ReputationHistory::select(['company_id','reputation_score'])->where(['company_id'=>$company_id])
        ->when(Auth::user()->role!='admin' && Auth::user()->company_id!=null, function($q){
            return $q->where('company_id', Auth::user()->company_id);
        })->get();
        $monitored_count = $TotalCollection->count();
        $good_count      = $TotalCollection->where('reputation_score',100)->count();
        $fair_count      = $TotalCollection->where('reputation_score',75)->count();
        $bad_count       = $TotalCollection->where('reputation_score',50)->count();
        $terrible_count  = $TotalCollection->where('reputation_score',25)->count();

        return view('callerid.report.index', compact('monitored_count','good_count','fair_count','bad_count','terrible_count' ));
    }

    public function count_per_state()
    {
        $number_per_state=ReputationHistory::groupBy('id_')
        ->selectRaw(
            "CONCAT('US-',cir_state) as id_,
             COUNT(*) as value"
        )->when(Auth::user()->role!='admin' && Auth::user()->company_id!=null, function($q){
            return $q->where('reputation_histories.company_id', Auth::user()->company_id);
        })->get()->toArray();
        return response()->json($number_per_state);
    }
    public function count_per_day()
    {
        $number_eachday=ReputationHistory::
        groupBy('day')
        ->select(
            DB::raw('DATE(created_at) AS day'),
            DB::raw('COUNT(*) as count')
        )->when(Auth::user()->role!='admin' && Auth::user()->company_id!=null, function($q){
            return $q->where('reputation_histories.company_id', Auth::user()->company_id);
        })->orderBy('day')->get()->toArray();
        return response()->json($number_eachday);

    }
    public function count_day_company()
    {
        $number_eachday=ReputationHistory::
        join('companies AS c', 'c.id', '=', 'reputation_histories.company_id')
        ->groupBy(['day','company_name'])
        ->select(
            DB::raw('c.name as company_name'),
            DB::raw('DATE(reputation_histories.created_at) AS day'),
            // DB::raw('COUNT(*) OVER(PARTITION BY reputation_histories.created_at , c.name ) AS count'),
            DB::raw('COUNT(*) AS count'),
        )->when(Auth::user()->role!='admin' && Auth::user()->company_id!=null  ,function($q){
            return $q->where('reputation_histories.company_id', Auth::user()->company_id);
        })->get()->toArray();
        return response()->json($number_eachday);

    }
}

