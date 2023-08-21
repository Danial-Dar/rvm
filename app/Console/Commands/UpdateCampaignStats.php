<?php

namespace App\Console\Commands;

use App\Mail\CampaignFinishMail;
use App\Models\Campaign;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Notifications\NovaNotification;

class UpdateCampaignStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:campaignstats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // try{
        // DB::statement('UPDATE  sw_numbers c
        // SET number_of_calls = p.cc
        //         from
        //         (
        //             SELECT  "To",
        //                     COUNT(*) AS cc
        //             FROM incoming_call_logs
        //             GROUP BY "To"
        //         ) p
        //             Where c.phone_number = p."To";');
        // } catch(Exception $e) {
        //     Log::error($e);
        // }
        $campaigns = Campaign::where('status', 'played')->get();
        foreach ($campaigns as $campaign) {
            DB::statement("UPDATE campaign_stats cs
        SET contact_count = cc.contact_count,
            sent_count = cc.sent_count,
            initiated_count = cc.initiated_count,
            success_count = cc.success_count,
            failed_count = cc.failed_count,
            dnc_count = cc.dnc_count,
            last_ran = cc.last_ran,
            price_sum = cc.price_sum,
            user_id = cc.user_id,
            company_id = cc.company_id
        FROM (SELECT campaign_id,
                     COUNT(*) AS contact_count,
                     SUM(CASE WHEN status != 'pending' AND status != 'dnc' THEN 1 ELSE 0 END) AS sent_count,
                     SUM(CASE WHEN status = 'initiated' THEN 1 ELSE 0 END) AS initiated_count,
                     SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) AS success_count,
                     SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS failed_count,
                     SUM(CASE WHEN status = 'dnc' THEN 1 ELSE 0 END) AS dnc_count,
                     SUM(price) AS price_sum,
                     MAX(updated_at) AS last_ran,
                     MAX(user_id) AS user_id,
                     MAX(company_id) AS company_id,
                     NOW(), NOW() FROM campaign_contacts WHERE campaign_id = ".$campaign->id." GROUP BY campaign_id) cc
        WHERE cs.campaign_id = cc.campaign_id;");
        DB::statement("UPDATE campaigns c SET status = CASE WHEN cs.contact_count::INT = (COALESCE(cs.sent_count, 0 )::INT + COALESCE( cs.dnc_count, 0 )::INT) THEN 'finished' ELSE status END FROM campaign_stats cs WHERE cs.campaign_id = c.id AND c.id = ".$campaign->id);


        event(new \App\Events\UpdateProgressBar($campaign->id));

        if($campaign->status == 'finished'){
            $user = User::find($campaign->user_id);
            $user->notify(
                NovaNotification::make()->message('Campaign '. $campaign->name. ' is finished.')->icon('check')->type('info')
            );

            Mail::to($user->email)->send(new CampaignFinishMail());
        }
        }

        $campaigns = Campaign::where('status', 'preprocessing')->get();

        foreach ($campaigns as $campaign) {
            event(new \App\Events\UpdateProgressBar($campaign->id));
        }

        // DB::statement("UPDATE ivr_incoming_call_logs icl
        //     SET location = ac.location_code, area_code = ac.area_code
        //     FROM area_code_location ac
        //     WHERE TRIM(SUBSTRING(icl.from_number, 3, 3)) = TRIM(ac.area_code)
        //     AND icl.location IS NULL
        //     AND icl.area_code IS NULL");

        // DB::statement("UPDATE incoming_call_logs icl
        //     SET location = ac.location_code, area_code = ac.area_code
        //     FROM area_code_location ac
        //     WHERE TRIM(SUBSTRING(icl.\"From\", 3, 3)) = TRIM(ac.area_code)
        //     AND icl.location IS NULL
        //     AND icl.area_code IS NULL");

    }
}
