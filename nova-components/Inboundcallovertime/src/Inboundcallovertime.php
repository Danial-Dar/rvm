<?php

namespace Rvm\Inboundcallovertime;

use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class Inboundcallovertime extends Card
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
        $data = Cache::remember('inbounuudCallOvertime.'.$user->id, 60000, function () use ($user) {
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $end_date = Carbon::now();
        // $start_date = $end_date->subDays($end_date->dayOfWeek)->subMonth(); // gives 2016-01-31
        $start_date = Carbon::now()->startOfMonth();

        // dd($end_date);

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
            $userCondition = "AND icl.user_id = $user_id AND icl.company_id = $company_id";
        } elseif ($role == 'company') {
            $compCondition = "AND icl.company_id = $company_id";
        }

        $campCondition = '';
        if ($campaign_id != '') {
            $campCondition = "AND icl.campaign_id = $campaign_id";
        }

        // $listCondition = '';
        // if($list_id != ""){
        //     $listCondition = "AND cc.contact_list_id = $list_id";
        // }

        $dateWhere = "WHERE icl.updated_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

        $sql = "SELECT COUNT(*) as value, icl.updated_at::DATE as date from incoming_call_logs icl
            LEFT JOIN campaigns c ON icl.campaign_id = c.id
            $dateWhere
            $campCondition
            $userCondition
            $compCondition
            GROUP BY icl.updated_at::DATE
        ";
        $inboundCall = collect(DB::select(DB::raw($sql)))->toArray();

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
        

        return [$inboundCall,$range];
        });
        return $this->withMeta(['query' => [
            'inboundCall' => $data[0],
            'range' => $data[1]
            ],
        ]);
    }

    public function component()
    {
        return 'inboundcallovertime';
    }
}
