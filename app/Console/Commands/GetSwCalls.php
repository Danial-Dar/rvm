<?php

namespace App\Console\Commands;

use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetSwCalls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:sw_calls';

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
        $sw_token_id = config('app.sw_admin_token_id');
        $sw_project_id = config('app.sw_admin_project_id');
        $sw_space_url = config('app.sw_admin_space_url');

        Log::info('GetSwCalls: Start');

        $sql = "
    SELECT icl.id, icl.\"CallSid\", icl.\"AccountSid\", cs.value AS per_minute_call_price
FROM incoming_call_logs icl
LEFT JOIN company_settings cs on icl.company_id = cs.company_id AND cs.key = 'per_minute_call_price'
WHERE (icl.sw_call_price IS NULL or icl.sw_call_price = 0) AND icl.user_id IS NOT NULL order by id desc LIMIT 500
        ";
        $callsWithoutPrice = DB::select(DB::raw($sql));

//        $client = new Client($sw_project_id, $sw_token_id, array("signalwireSpaceUrl" => $sw_space_url));

        foreach ($callsWithoutPrice as $call) {
            $client = new \GuzzleHttp\Client();

            if($call->AccountSid && $call->CallSid) {
            $response = $client->request('GET', 'https://'.$sw_space_url.'/api/laml/2010-04-01/Accounts/'.$call->AccountSid.'/Calls/'.$call->CallSid, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUMjBkOTFlZTkxMmEyNzIzYWU2MTM2ODk2N2E4ZmQzMGUzY2RlZDQ1ZjIxNTdlZWU1',
                ],
            ]);

            $resposeJson = json_decode($response->getBody()->getContents());

//                $min = CarbonInterval::seconds($resposeJson->duration)->cascade();
//                if ($min->s > 0){
//                    $minutes = $min->i + 1;
//                } else {
//                    $minutes = $min->i;
//                }
            if (isset($resposeJson->price)) {
                $swCallPrice = (float)$resposeJson->price;
                $callPrice = ((float)$resposeJson->price * (float)$call->per_minute_call_price);
            } else {
                $swCallPrice = 0;
                $callPrice = 0;
            }
            if (isset($resposeJson->duration)) {
                $callDuration = $resposeJson->duration;
            } else {
                $callDuration = 0;
            }
//                SWPrice * multiplier in super admin.

                IncomingCallLog::where('id', $call->id)->update([
                    'sw_call_price' => $swCallPrice,
                    'duration' => $callDuration,
                    'call_price' => $callPrice,
                ]);

        }
        }



    }
}
