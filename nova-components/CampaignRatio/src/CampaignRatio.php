<?php

namespace Rvm\CampaignRatio;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class CampaignRatio extends Card
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
        $data = Cache::remember('campaignRatio.'.$user->id, 60000, function () use ($user) {
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

        $userCondition = '';
        $compCondition = '';

        if ($role == 'user') {
            $userCondition = "AND user_id = $user_id AND company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhere = "WHERE created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT COUNT(*) as total,campaign_type
            from campaigns
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            GROUP BY campaign_type
        ";
        $campaignRatio = collect(DB::select(DB::raw($sql)))->toArray();

        return $campaignRatio;
        });
        return $this->withMeta(['query' => [
            'campaignRatio' => $data,
            ],
        ]);
    }

    public function component()
    {
        return 'campaign_ratio';
    }
}
