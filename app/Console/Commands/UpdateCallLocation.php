<?php

namespace App\Console\Commands;

use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateCallLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:call_location';

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
     */
    public function handle()
    {
        $sql = "UPDATE incoming_call_logs icl
                SET location = ac.location_code, area_code = ac.area_code
                FROM area_code_location ac
                WHERE TRIM(SUBSTRING(icl.\"From\", 3, 3)) = TRIM(ac.area_code)
                AND (icl.location IS NULL or icl.\"location\" = '')
                AND (icl.area_code IS NULL or icl.area_code = '');";

        $sqlUpdateCampaign = "UPDATE campaigns c
            SET status = CASE WHEN cs.contact_count::INT = (COALESCE(cs.sent_count, 0 )::INT + COALESCE( cs.dnc_count, 0 )::INT) THEN 'finished' ELSE status END
            FROM campaign_stats cs WHERE cs.campaign_id = c.id AND c.status != 'finished'";

        $update_ivr = "UPDATE ivr_incoming_call_logs icl
        SET location = ac.location_code, area_code = ac.area_code
        FROM area_code_location ac
        WHERE TRIM(SUBSTRING(icl.from_number, 2, 3)) = TRIM(ac.area_code)
          AND (icl.location IS NULL or icl.\"location\" = '')
          AND (icl.area_code IS NULL or icl.area_code = '');";
        $updateCallsWithoutLocation = DB::select(DB::raw($sql));
        $updateCampaignStatus = DB::select(DB::raw($sqlUpdateCampaign));
        $update_ivr = DB::select(DB::raw($update_ivr));
    }
}
