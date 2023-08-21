<?php
namespace Rvm\MonitorNumberToTimeCir\Http\Controllers;

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

    public function count_per_day()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $number_eachday = Cache::remember('cirNumbersToDays_chart.' . $user_id,60000, function(){
            $number_per_state = ReputationHistory::
            groupBy('day')
            ->select(
                DB::raw('DATE(created_at) AS day'),
                DB::raw('COUNT(*) as count')
            )->when(Auth::user()->role!='admin' && Auth::user()->company_id!=null, function($q){
                return $q->where('reputation_histories.company_id', Auth::user()->company_id);
            })->orderBy('day')->get()->toArray();
            return $number_per_state??[];
        });

        return response()->json($number_eachday);

    }

}

