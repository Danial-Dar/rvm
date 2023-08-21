<?php

namespace Rvm\Outboundoptinheatmap;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Outboundoptinheatmap extends Card
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
        $data = Cache::remember('outboundOptinHeatmap.'.$user->id, 60000, function () use ($user) {
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $end_date = Carbon::now();
        $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth(); // gives 2016-01-31

        $campaign = Campaign::where('user_id', $user_id)->first();
        $campaign_id = '';
        if($campaign)
            $campaign_id = $campaign->id;
        $list = ContactList::Where('user_id', $user_id)->first();
        if($list)
            $list_id = $list->id;

        $userConditionCC = '';
        $compConditionCC = '';

        if ($role == 'user') {
            $userConditionCC = "AND cc.user_id = $user_id AND cc.company_id = $company_id";
        } elseif ($role == 'company') {
            $compConditionCC = "AND cc.company_id = $company_id";
        }

        $campConditionCC = '';
        if ($campaign_id != '') {
            $campConditionCC = "AND cc.campaign_id = $campaign_id";
        }

        $dateWhere = "WHERE ps.date::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";
        $statusWhere = "AND ps.status = 'transfered'";
        $sql = "SELECT
            CONCAT('US-',acl.location_code) as id,
            COUNT(ps.*) as value
            FROM area_code_location acl
                INNER JOIN press1_status ps on TRIM(acl.area_code) = TRIM(SUBSTRING(ps.ddi, 2, 3))
                INNER JOIN campaign_contacts cc ON cc.id = ps.tid::BIGINT
                INNER JOIN campaigns c ON c.id = cc.campaign_id
            $dateWhere
            $statusWhere
            $userConditionCC
            $compConditionCC
            $campConditionCC
            GROUP BY acl.area_code, acl.location_code
        ";

        $outboundOptin = collect(DB::select(DB::raw($sql)))->toArray();
        return $outboundOptin;
        });

        return $this->withMeta(['query' => [
            'outboundOptin' => $data
            ],
        ]);
    }

    public function component()
    {
        return 'outboundoptinheatmap';
    }
}
