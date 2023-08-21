<?php

namespace Rvm\Scoreperformance;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Scoreperformance extends Card
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
        $company_id = $user->company_id;
        $role = $user->role;
        $start_date = Carbon::now()->startOfMonth();
        $end_date = Carbon::now()->endOfMonth();
        $campaign = Campaign::where('user_id', $user_id)->first();
        $campaign_id = '';
        if($campaign)
        $campaign_id = $campaign->id;
        $list_id = '';
        $list = ContactList::Where('user_id', $user_id)->first();
        if($list)
        $list_id = $list->id;

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND cc.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND cc.campaign_id = $campaign_id";
        }

        $listCondition = '';
        if ($list_id != '') {
            $listCondition = "AND cc.contact_list_id = $list_id";
        }

        $dateWhere = "AND cc.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT COUNT(*) as value, to_char(cc.updated_at::DATE,'Month') as month,cc.updated_at::DATE as date from campaign_contacts cc
            LEFT JOIN campaigns c ON cc.campaign_id = c.id
            WHERE cc.status = 'initiated'
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            GROUP BY cc.updated_at::DATE
        ";
        $campaignSendRates = collect(DB::select(DB::raw($sql)))->toArray();

        $periods = CarbonPeriod::create(Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay());
        $range = [];
        foreach ($periods as $period) {
            $date = $period->format('Y-m-d');
            $dataX = [
                'date' => $date,
                'value' => 0,
            ];
            array_push($range, $dataX);
        }
        return $this->withMeta(['query' => [
            'campaignSendRates' => $campaignSendRates,
            'dateRange' => $range,
            ],
        ]);
    }
    public function component()
    {
        return 'scoreperformance';
    }
}
