<?php
namespace Rvm\NumberOfStatesHeatmapCir\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ReputationHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    }

    public function count_per_state(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $data = Cache::remember('numbersToStates_heatmap.' . $user_id,60000, function(){
            $number_per_state = ReputationHistory::groupBy('id_')
            ->selectRaw(
                "CONCAT('US-',cir_state) as id_,
                 COUNT(*) as value"
            )->when(Auth::user()->role!=='admin' && Auth::user()->company_id!==null, function($q){
                return $q->where('reputation_histories.company_id', Auth::user()->company_id);
            })->get()->toArray();
            return $number_per_state??[];
        });
        return response()->json($data );
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

