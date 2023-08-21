<?php

namespace Piechart\AverageCallsPerCampaign;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class AverageCallsPerCampaign extends Card
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
        $user_id = $user->id;

        $data = Cache::remember('averageCallsPerCampaign.'.$user_id, 60000, function () use ($user) {
            $user_id = $user->id;

            $company_id = $user->company_id;
            $role = $user->role;

            $currentDate = Carbon::now();

            $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
            $end = $currentDate;    
            $start_date = $start;
            $end_date = $end;
            $campaign_id = '';

            $noOfCallsPerCampaignWhere = '';
            $noOfCallsPerCampaignIdWhere = '';
            $avgCallDurationCampaignWhere = '';
            $avgCallDurationCampaignIdWhere = '';

            if ($role == 'user') {
                $noOfCallsPerCampaignWhere = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT = '.$company_id.'';
                $avgCallDurationCampaignWhere = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT = '.$company_id.'';
            } elseif ($role == 'company') {
                $noOfCallsPerCampaignWhere = 'AND c.company_id::BIGINT= '.$company_id.'';
                $avgCallDurationCampaignWhere = 'AND c.company_id::BIGINT= '.$company_id.'';
            }
            if ($campaign_id != null) {
                $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
                $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            }

            $avgCallDurationPerCampaignPieChartSql = "SELECT  c.name,  AVG(icl.duration) AS avg_duration FROM incoming_call_logs icl
            LEFT JOIN campaign_contacts cc on icl.campaign_contact_id::BIGINT = cc.id
            LEFT JOIN campaigns c on c.id = icl.campaign_id::BIGINT
            WHERE icl.created_at::DATE BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            $avgCallDurationCampaignWhere
            $avgCallDurationCampaignIdWhere
            AND icl.campaign_id IS NOT NULL
            GROUP BY icl.campaign_id, c.name;
        ";
            $avgCallDurationPerCampaign = collect(DB::select(DB::raw($avgCallDurationPerCampaignPieChartSql)))->all();

            return $avgCallDurationPerCampaign;
        });

        return $this->withMeta(['query' => [
                    'avgCallDurationPerCampaign' => $data,
                    // 'testsql'=>$avgCallDurationPerCampaignPieChartSql
                ],
            ]);
    }

    public function component()
    {
        return 'average-calls-per-campaign';
    }
}
