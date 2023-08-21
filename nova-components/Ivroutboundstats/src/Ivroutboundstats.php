<?php

namespace Rvm\Ivroutboundstats;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Ivroutboundstats extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    /**
     * Get the component name for the element.
     *
     * @return string
     */

    public function query()
    {
        $user = Auth::user();
        $data = Cache::remember('ivrOutboundStat.'.$user->id, 60000, function () use ($user) {
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $end_date = Carbon::now();
        $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth();// gives 2016-01-31

        $campaign = Campaign::where('user_id', $user_id)->first();
        $campaign_id = '';
        if($campaign)
        $campaign_id = $campaign->id;
        $list = ContactList::Where('user_id', $user_id)->first();
        if($list)
            $list_id = $list->id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhere = "WHERE ps.date::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT count(*) as total,
            SUM(CASE WHEN ps.status = 'noinput' THEN 1 ELSE 0 END) AS noinput_count,
            SUM(CASE WHEN ps.status = 'transfered' THEN  1 ELSE 0 END) AS transfered_count,
            SUM(CASE WHEN ps.status = 'optout' THEN  1 ELSE 0 END) AS optout_count,
            c.name as campaign_name
            FROM press1_status ps
            LEFT JOIN campaign_contacts cc ON cc.id = ps.tid::BIGINT
            LEFT JOIN campaigns c ON cc.campaign_id = c.id
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            AND c.name is NOT NULL
            GROUP BY c.name
        ";
        $ivrOutboundCalls = collect(DB::select(DB::raw($sql)))->toArray();
        return $ivrOutboundCalls;
        });
        return $this->withMeta(['query' => [
            'ivrOutboundCalls' => $data,
            ],
        ]);
    }

    public function component()
    {
        return 'ivroutboundstats';
    }
}
