<?php

namespace Rvm\CallSentHeatmap;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class CallSentHeatmap extends Card
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

        $data = Cache::remember('get_call_sent_duration_heatmap.'.$user_id,60000, function() use($user){

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
            $userConditionicl = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionicl = "AND cc.company_id = $company_id";
        }

        $campConditionicl = '';
        if ($campaign_id != '') {
            $campConditionicl = "AND cc.campaign_id = $campaign_id";
        }

        $dateWhere = sprintf("AND cc.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");
        
        $statusWhere = "AND cc.status IN('pending','initiated')";
        $sql = "SELECT
            COUNT(*) AS value,
            CONCAT('US-',acl.location_code) as id
            from campaign_contacts cc
            LEFT JOIN area_code_location acl on TRIM(SUBSTRING(cc.number, 3, 3)) = acl.area_code
            WHERE cc.number IS NOT NULL AND acl.location_code IS NOT NULL
            $dateWhere
            $statusWhere
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
        return 'call-sent-heatmap';
    }
}
