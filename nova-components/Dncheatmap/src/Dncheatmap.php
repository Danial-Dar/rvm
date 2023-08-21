<?php

namespace Rvm\Dncheatmap;

use Laravel\Nova\Card;
use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Dncheatmap extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public function query(){
        $user = Auth::user();
        $user_id = $user->id;
        $data = Cache::remember('dnc_heatmap.'.$user_id,60000, function() use($user){
            $user_id = $user->id;
            $company_id = $user->company_id;
            $role = $user->role;

            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfMonth();
    
            $userConditionCC = '';
            $compConditionCC = '';

            if ($role == 'user') {
                $userConditionCC = "AND dc.user_id = $user_id AND dc.company_id = $company_id";
            } elseif ($role == 'company') {
                $compConditionCC = "AND dc.company_id = $company_id";
            }

            // $campConditionCC = '';
            // if($campaign_id != ""){
            //     $campConditionCC = "AND cc.campaign_id = $campaign_id";
            // }

            $dateWhere = "WHERE dc.created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE";

            $sql = "SELECT
                    CONCAT('US-',acl.location_code) as id,
                    COUNT(dc.*) as value
                    FROM area_code_location acl
                            INNER JOIN dnc dc on TRIM(acl.area_code) = TRIM(SUBSTRING(dc.raw_number, 3, 3))
                    $dateWhere
                    $userConditionCC
                    $compConditionCC
                GROUP BY acl.area_code, acl.location_code
            ";

            $dncHeatmap = collect(\DB::select(\DB::raw($sql)))->toArray();

            return $dncHeatmap;
        });

        return $this->withMeta(['query' => [
            'dncHeatmap' => $data,
            ],
        ]);
    }

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'dncheatmap';
    }
}
