<?php

namespace Heatchart\AverageCallbackDuration;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class AverageCallbackDuration extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public function query()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $data = Cache::remember('get_call_back_heatmap.'.$user_id,60000, function() use($user){

        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $currentDate = Carbon::now();
        
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;    
        $start_date = $start;
        $end_date = $end;
        $campaign_id = '';
        // $list_id = $request->list_id;
        $campaignIdWhere = '';

        $userConditionicl = '';
        $compConditionicl = '';
        if ($role == 'user') {
            $userConditionicl = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionicl = "AND icl.company_id = $company_id";
        }

        $campConditionicl = '';
        if ($campaign_id != '') {
            $campConditionicl = "AND icl.campaign_id = $campaign_id";
        }

        $dateWhere = sprintf("AND icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        
        $sql = "SELECT COUNT(*) AS value, REPLACE((CONCAT('US-', acl.location_code)),'\r\n','') as id from incoming_Call_logs icl
            LEFT JOIN area_code_location acl on icl.area_code = acl.area_code
            WHERE icl.area_code IS NOT NULL
            $dateWhere
            $userConditionicl
            $compConditionicl
            $campConditionicl
            GROUP BY acl.location_code";

        $callbacks = collect(DB::select(DB::raw($sql)))->toArray();
// dd($callbacks);
        return $callbacks;
    });

        return $this->withMeta(['query' => $data]);
    }
    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'average-callback-duration';
    }
}
