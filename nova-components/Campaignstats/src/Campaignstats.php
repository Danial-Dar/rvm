<?php

namespace Rvm\Campaignstats;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Campaignstats extends Card
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
        
        $data = Cache::remember('campaignStats.'.$user->id, 60000, function () use ($user) {
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            $end_date = Carbon::now();

            $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth();// gives 2016-01-31
            
            $campaign = Campaign::where('user_id', $user_id)->first();
            $campaign_id = '';
            if($campaign)
                $campaign_id = $campaign->id;
            // $list = ContactList::Where('user_id', $user_id)->first();
            // $list_id = $list->id;

            // $start_date = $request->start_date;
            // $end_date = $request->end_date;
            // $campaign_id = $request->campaign_id;
            // $list_id = $request->list_id;

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

            $dateWhere = "WHERE c.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

            $sql = "SELECT c.name, c.campaign_type, cs.sent_count,
                (SELECT count(*) FROM incoming_call_logs icl WHERE icl.campaign_id = c.id) AS calls_back_count,
                (SELECT AVG(icl.duration) FROM incoming_call_logs icl WHERE icl.campaign_id = c.id) AS avg_calls_duration
                    -- calls_back_count / cs.contact_count * 100 AS call_back_percentage
                FROM campaigns c
                LEFT JOIN campaign_stats cs on c.id = cs.campaign_id
                $dateWhere
                $campCondition
                $userCondition
                $compCondition
                ORDER BY c.id desc;
            ";

            return $sql;
            
            $campaignStats = collect(DB::select(DB::raw($sql)))->toArray();
            // dd($campaignStats);
            return $campaignStats;
        });

        
        return $this->withMeta(['query' => [
            'campaignStats' => $data,
        ],
        ]);
    }

    public function component()
    {
        return 'campaignstats';
    }
}
