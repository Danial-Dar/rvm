<?php

namespace Rvm\Listspecificstats;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Listspecificstats extends Card
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
        
        $data = Cache::remember('listSpecificStat.'.$user->id, 60000, function () use ($user) {
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $end_date = Carbon::now();

        $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth();// gives 2016-01-31

        $userCondition = '';
        $compCondition = '';

        $campaign = Campaign::where('user_id', $user_id)->first();
        $campaign_id = '';
        if($campaign)
        $campaign_id = $campaign->id;
        $list = ContactList::Where('user_id', $user_id)->first();
        $list_id = '';
        if($list)
            $list_id = $list->id;

        if ($role == 'user') {
            $userCondition = "AND c.user_id = $user_id AND c.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND c.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND c.id = $campaign_id";
        }

        $listCondition = '';
        if ($list_id != '') {
            $listCondition = "AND cc.contact_list_id = $list_id";
        }

        $dateWhere = "WHERE icl.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT c.id, c.name, c.campaign_type,cl.name as list_name, MAX(cs.sent_count) as sent_count, count(*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
        FROM incoming_call_logs icl
        LEFT JOIN campaigns c ON icl.campaign_id = c.id
        LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
        LEFT JOIN campaign_contacts cc on cc.id = icl.campaign_contact_id
        LEFT JOIN contact_lists cl on cl.id = cc.contact_list_id
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            AND c.name IS NOT NULL
            GROUP BY c.id, c.name, c.campaign_type,cl.name
            ORDER BY c.id desc;
        ";
        $listStats = collect(DB::select(DB::raw($sql)))->toArray();
        return $listStats;
        });

        return $this->withMeta(['query' => [
            'listStats' => $data,
            // 'testsql'=>$avgCallDurationPerCampaignPieChartSql
            ],
        ]);
    }
    

    public function component()
    {
        return 'listspecificstats';
    }
}
