<?php

namespace Heatmap\GetCallback;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Card;

class GetCallback extends Card
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

    public function currentVisitors()
    {
        return $this->withMeta(['currentVisitors' => true]);
    }
    
    public function query()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $data = Cache::remember('getCallBack.'.$user_id,60000, function() use($user){

        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        $currentDate = Carbon::now();
        
        $start = $currentDate->subDays($currentDate->dayOfWeek)->subMonth();// gives 2016-01-31
        $end = $currentDate;    
        $start_date = $start;
        $end_date = $end;
        $campaign_id = '';
        // $list_id = $request->list_id;
        $campaignIdWhere = '';
        if($campaign_id != null){
            $campaignIdWhere = 'and campaign_id='.$campaign_id.'';
       }
       $userIdWhere = '';
       $companyIdWhere = '';
       if($role == "user"){
            $userIdWhere = 'AND user_id ='.$user_id.' AND company_id= '.$company_id.'';

        }else if($role == "company"){
            $companyIdWhere = 'AND company_id= '.$company_id.'';
        }

        $dateWhere = sprintf("AND created_at::Date BETWEEN '$start_date'::DATE AND '$end_date'::DATE");

        $campaignContact = "SELECT TRIM(LEADING '0' FROM to_char( updated_at::timestamp , 'HH12pm' )) as hour, to_char( updated_at::timestamp , 'Day') as weekday, count(*) as value
            FROM campaign_contacts
            where updated_at::date BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            AND status = 'initiated'
            $dateWhere
            $campaignIdWhere
            $userIdWhere
            $companyIdWhere
            GROUP BY hour,weekday
        ";
        $campaignContactPerDay = collect(DB::select(DB::raw($campaignContact)))->toArray();
        // dd($campaignContact);

        return $campaignContactPerDay;
    });


        return $this->withMeta(['query' => $data]);
    }

    public function component()
    {
        return 'get-callback';
    }
}
