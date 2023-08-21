<?php

namespace App\Nova\Actions\Campaign;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ViewStat extends Action
{
    use InteractsWithQueue, Queueable;


    public $name = 'View Stats';
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if ($models->count() > 1) {
            return Action::danger('Please run this on only one user resource.');
        }

        $campaign = Campaign::with('campaignStats')->Where('id',$models->first()->id)->first();

        // dd($campaign);

        $sql = sprintf("SELECT user_id FROM dnc_time WHERE  day = TRIM(TO_CHAR(NOW(), 'Day')) AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME");
        
        $dnc_time_of_users =  DB::select(DB::raw($sql));

        $dnc_time_of_users_ids = collect($dnc_time_of_users)->where('user_id',$campaign->user_id)->toArray();
        $campaign->dnc_time_exists  = (count($dnc_time_of_users_ids) > 0 ? 0 : 1);

        $dailyLimitSql =  "SELECT c.id,
            NULLIF(us.value, 'daily_max_limit')::INT AS daily_max_limit,
            NULLIF(c.drops_per_hour, '')::INT        AS drops_per_hour,
            c.user_id,
            c.company_id,
            t.this_hour_sent                         AS this_hour_sent,
            t.this_day_sent                          AS this_day_sent
                FROM campaigns c
                        LEFT OUTER JOIN user_settings us ON c.user_id = us.user_id AND us.key = 'daily_max_limit'
                        LEFT JOIN (
                    SELECT ccc.campaign_id,
                        SUM(CASE
                                WHEN DATE_TRUNC('hour', ccc.updated_at) = DATE_TRUNC('hour', NOW()) THEN 1
                                ELSE 0 END)                                                                           AS this_hour_sent,
                        SUM(CASE
                                WHEN DATE_TRUNC('day', ccc.updated_at) = DATE_TRUNC('day', NOW()) THEN 1
                                ELSE 0 END)                                                                           AS this_day_sent
                    FROM campaign_contacts ccc
                    WHERE (ccc.is_processing = true OR ccc.status = 'posted' OR ccc.status = 'initiated')
                    GROUP BY ccc.campaign_id
                ) t ON t.campaign_id = c.id

                WHERE c.id = $campaign->id;
        ";
        $dailyLimit = collect(DB::select(DB::raw($dailyLimitSql)))->first();
        $dailyLimitReached = 0;
        $dropPerHourLimitReached = 0;
        if($dailyLimit != null){
            if($dailyLimit->daily_max_limit !== null && $dailyLimit->daily_max_limit !== 0){
                if($dailyLimit->this_day_sent !==  null && $dailyLimit->this_day_sent > $dailyLimit->daily_max_limit){
                    $dailyLimitReached = 1;
                }else{
                    $dailyLimitReached = 0;
                }
            }

            if($dailyLimit->drops_per_hour !== null && $dailyLimit->drops_per_hour !== 0){
                if($dailyLimit->this_hour_sent !==  null && $dailyLimit->this_hour_sent > $dailyLimit->drops_per_hour){
                    $dropPerHourLimitReached = 1;
                }else{
                    $dropPerHourLimitReached = 0;
                }
            }
        }
        $campaign->daily_limit = $dailyLimitReached;
        $campaign->drop_limit = $dropPerHourLimitReached;

        // dd($campaign);
    
        // return Action::modal('ViewStats', [
        //     'campaign' => $campaign,
        // ]);
        return Action::visit('/view-stat/'.$campaign->id);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
