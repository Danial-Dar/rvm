<?php

namespace Rvm\Recordingspecificstats;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Recordingspecificstats extends Card
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
        $data = Cache::remember('recordingSpecificStat.'.$user->id, 60000, function () use ($user) {
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

        $dateWhere = "WHERE c.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT r.name,
                   SUM(cs.sent_count) as sent_count,
                   MAX(t.calls_back_count)   AS calls_back_count,
                   MAX(t.avg_calls_duration) AS avg_calls_duration
                FROM recordings r
                         LEFT JOIN campaigns c on r.id = c.recording_id
                         LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
                         LEFT JOIN (
                    SELECT c.recording_id, count(*) AS calls_back_count, AVG(icl.duration) AS avg_calls_duration
                    FROM incoming_call_logs icl
                             LEFT JOIN campaigns c on icl.campaign_id = c.id
                            $dateWhere
                            $campCondition
                            $userCondition
                            $compCondition
                    GROUP BY c.recording_id
                ) t ON t.recording_id = r.id
                $dateWhere
                $campCondition
                $userCondition
                $compCondition
                GROUP BY r.name";
        $recordingStats = collect(DB::select(DB::raw($sql)))->toArray();

        return $recordingStats;
        });

        return $this->withMeta(['query' => [
            'recordingStats' => $data,
            // 'testsql'=>$avgCallDurationPerCampaignPieChartSql
            ],
        ]);
    }

    public function component()
    {
        return 'recordingspecificstats';
    }
}
