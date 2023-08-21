<?php

namespace App\Console\Commands;

use App\Http\Helpers\Aws;
use App\Mail\CampaignFinishMail;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StartCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:campaign';

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
        Log::info("Command called ");
        $sql = "
       -- SET TIMEZONE='America/Mexico_City';
        SELECT c.id,
           NULLIF(us.value, 'daily_max_limit')::INT AS daily_max_limit,
           NULLIF(c.drops_per_hour, '')::INT        AS drops_per_hour,
           c.user_id,
           c.company_id,
           (SELECT count(id)::INT
            FROM campaign_contacts ccc
            WHERE ccc.campaign_id = c.id
            AND (ccc.is_processing = true OR ccc.status = 'posted' OR ccc.status = 'initiated')
            AND date_trunc('hour', ccc.updated_at) = date_trunc('hour', now())
           )                                        AS this_hour_sent,
           (SELECT count(id)::INT
            FROM campaign_contacts ccc
            WHERE ccc.campaign_id = c.id
            AND (ccc.is_processing = true OR ccc.status = 'posted' OR ccc.status = 'initiated')
            AND date_trunc('day', ccc.updated_at) = date_trunc('day', now())
           )                                        AS this_day_sent,
           c.random,
           c.is_random
        FROM campaigns c
                 LEFT OUTER JOIN user_settings us ON c.user_id = us.user_id AND us.key = 'daily_max_limit'
        WHERE c.start_date::DATE <= NOW()
          AND c.status NOT IN ('finished', 'paused', 'inactive', 'preprocessing')
          AND c.deleted_at IS NULL
          AND c.company_id IS NOT NULL
          AND c.user_id NOT IN
              (SELECT user_id
               FROM dnc_time
               WHERE day = TO_CHAR(NOW(), 'Day')
                 AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME)
          AND c.company_id NOT IN
              (SELECT company_id
               FROM dnc_time
               WHERE day = TO_CHAR(NOW(), 'Day')
                 AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME);
        ";
        $campaigns = DB::select(DB::raw($sql));
        Log::info($sql);
        Log::info('========================================================');

        if (isset($campaigns) && !empty($campaigns)) {
            for ($c = 0; $c < count($campaigns); $c++) {
                $dailyMaxLimitCondition = "";
                if ($campaigns[$c]->daily_max_limit > 0) {
                    $dailyMaxLimitCondition = sprintf(" AND %d > %d ",   $campaigns[$c]->daily_max_limit, $campaigns[$c]->this_day_sent);
                }
                $dropsPerHourCondition = "";
                if ($campaigns[$c]->drops_per_hour > 0) {
                    $dropsPerHourCondition = sprintf(" AND %d > %d ", $campaigns[$c]->drops_per_hour, $campaigns[$c]->this_hour_sent);
                }
                $randomSelect = "";
                $randomJoin = "";
                $randomWhere = "";
                if ($campaigns[$c]->is_random) {
                    $randomSelect = "c.random, c.is_random, NULL AS caller_id, NULL AS alpha_number, ";
                    $randomJoin = " ";
                    $randomWhere = " 1=1 ";
                } else {
                    $randomSelect = "NULL AS random, false AS is_random, rand_cid.raw_number AS caller_id, rand_aid.raw_number AS alpha_number,";
                    $randomJoin = "LEFT JOIN ( SELECT cci.campaign_id, cci.type, mn.raw_number
                                        FROM campaign_caller_ids cci TABLESAMPLE SYSTEM(100)
                                                 LEFT JOIN my_numbers mn on cci.my_number_id = mn.id
                                    ) as rand_cid on cc.campaign_id = rand_cid.campaign_id AND rand_cid.type = 'caller'
                                             LEFT JOIN (
                                        SELECT cci.campaign_id, cci.type, mn.raw_number
                                        FROM campaign_caller_ids cci TABLESAMPLE SYSTEM(100)
                                                 LEFT JOIN my_numbers mn on cci.my_number_id = mn.id
                                    ) as rand_aid on cc.campaign_id = rand_aid.campaign_id AND rand_aid.type = 'alpha'";
                    $randomWhere = "rand_cid.raw_number IS NOT NULL";
                }

                $limit = $campaigns[$c]->drops_per_hour / 60;
                if ($limit > 800) {
                    $limit = 800;
                }
                $sqlStr = "
                    WITH cte AS (
                        SELECT cc.id,
                               c.campaign_type,
                               c.opt_in_number,
                               c.opt_out_number,
                               r.filename,
                               r2.filename as filename_output,
                               %s -- randomSelect
                               cc.number,
                               api.end_point,
                               api.carrier_address,
                               api.prefix,
                               TRIM(api.call_price::char(10)) AS call_price,
                               TRIM(cs.value::char(10)) AS company_call_price,
                               b.bot_id,
                               api.transfer_dest
                        FROM campaign_contacts cc
                                 %s -- randomJoin
                                 LEFT JOIN campaigns c ON cc.campaign_id = c.id
                                 LEFT JOIN recordings r ON c.recording_id = r.id
                                 LEFT JOIN recordings r2 ON c.recording_output_id = r2.id
                                 LEFT JOIN api_settings api ON c.campaign_type = api.slug
                                 LEFT JOIN user_settings cs
                                           ON cs.company_id = cc.company_id AND cs.key = (CONCAT(c.campaign_type, '_call_price'))
                                 LEFT OUTER JOIN bots b ON c.bot_id = b.id
                        WHERE %s -- randomWhere
                          AND cc.campaign_id = %d
                          AND cc.status = 'pending'
                          AND cc.is_processing = false
                          AND cc.number NOT IN (SELECT raw_number FROM dnc WHERE (dnc.company_id = %d OR dnc.user_type = 'admin'))
                          AND cc.number IS NOT NULL
                           %s -- dropsPerHourCondition
                           %s -- dailyMaxLimitCondition
                        ORDER BY cc.id
                        LIMIT %d OFFSET 0 FOR UPDATE OF cc SKIP LOCKED)
                    UPDATE campaign_contacts cc
                    SET is_processing = true
                    FROM cte
                    WHERE cc.id = cte.id
                    RETURNING
                        cte.id, cte.campaign_type, cte.opt_in_number,  cte.opt_out_number, cte.filename, cte.filename_output, cte.random, cte.is_random,
                        cte.caller_id, cte.alpha_number, cte.number, cte.end_point, cte.carrier_address, cte.prefix, cte.call_price,
                        cte.company_call_price, cte.bot_id, cte.transfer_dest;
                ";

                $rawSql = sprintf($sqlStr, $randomSelect, $randomJoin, $randomWhere, $campaigns[$c]->id, $campaigns[$c]->company_id, $dropsPerHourCondition, $dailyMaxLimitCondition, $limit);
                $contacts = DB::connection('pgsql_script')->select(DB::connection('pgsql_script')->raw($rawSql));
                Log::info($rawSql);
                Log::info('========================================================');


                if (isset($contacts) && !empty($contacts)) {
                    foreach (array_chunk($contacts, 500) as $contacts_chunk) {
                        $mh = curl_multi_init();

                        $requests = array();
                        $responses = array();
                        $cases = [];
                        $ids = [];
                        foreach ($contacts_chunk as $k => $val) {
                            Log::info("$val->id | campaign_contacts number $val->number ");

                            $aws = new  Aws();

                            $client1 = $aws->connect();

                            $cmd = $client1->getCommand('GetObject', [
                                'Bucket' => 'RVM',
                                'Key' => $val->filename,
                                'Content-Type' => 'audio/mpeg'
                            ]);

                            if ($val->campaign_type == 'press-1') {
                                $cmdOptout = $client1->getCommand('GetObject', [
                                    'Bucket' => 'RVM',
                                    'Key' => $val->filename_output,
                                    'Content-Type' => 'audio/mpeg'
                                ]);
                            }
                            $expiry = '+8640 minutes';


                            $req = $client1->createPresignedRequest($cmd, $expiry);
                            $presignedUrl = (string)$req->getUri();

                            if ($val->campaign_type == 'press-1') {
                                $reqOptout = $client1->createPresignedRequest($cmdOptout, $expiry);
                                $presignedUrlOptout = (string)$reqOptout->getUri();
                            }

                            if ($val->is_random == 'true') {
                                $number_to = preg_replace('/[^0-9]/', '', $val->number);
                                // replace last 3 characters with random number
                                $number_from = substr_replace($number_to, $val->random, -3);
                                $alpha_number = $val->alpha_number;
                                $selected_number = $number_from;

                                $number_from = preg_replace('/[^0-9]/', '', $selected_number);


                                if ($alpha_number == null || $alpha_number == "") {
                                    $selected_alpha_number = $selected_number;
                                } else {
                                    $selected_alpha_number = $alpha_number;
                                }

                                $alpha_from = preg_replace('/[^0-9]/', '', $selected_alpha_number);


                            } else {

                                $number_to = preg_replace('/[^0-9]/', '', $val->number);

                            $number_from = $val->caller_id;
                            $alpha_number = $val->alpha_number;
                            $selected_number = $number_from;

                            $number_from = preg_replace('/[^0-9]/', '', $selected_number);


                            if ($alpha_number == null || $alpha_number == "") {
                                $selected_alpha_number = $selected_number;
                            } else {
                                $selected_alpha_number = $alpha_number;
                            }

                            $alpha_from = preg_replace('/[^0-9]/', '', $selected_alpha_number);

                            }

                            $params['alpha_from'] = str_pad($alpha_from, 11, "1", STR_PAD_LEFT);
                            $params['number_from'] = str_pad($number_from, 11, "1", STR_PAD_LEFT);
                            if($val->prefix){
                                $params['number_to'] = $val->prefix."#". str_pad($number_to, 11, "1", STR_PAD_LEFT);
                            } else {
                                $params['number_to'] = str_pad($number_to, 11, "1", STR_PAD_LEFT);
                            }
                            if ($val->campaign_type == 'bot'){
                                $params['bot_id'] = $val->bot_id;
                                $params['transfer_dest'] = $val->transfer_dest;
                            }
                            if ($val->campaign_type == 'press-1'){
                                $params['wavurl_annouce'] = $presignedUrl;
                                $params['wavurl_optout'] = $presignedUrlOptout;
                                $params['digit_continue'] = $val->opt_in_number;
                                $params['digit_optout'] = $val->opt_out_number;

                            } else {
                                $params['wavefile_url'] = $presignedUrl;
                            }


                            // $params['wavefile_url'] = "https://file-examples-com.github.io/uploads/2017/11/file_example_WAV_1MG.wav";
                            $params['wavefile_url'] = $presignedUrl;
                            $params['transaction_id'] = $val->id;
                            $params['carrier_addr'] = $val->carrier_address;


                            Log::info("Command called ", $params);

                            $options = array(
                                // CURLOPT_URL => 'http://135.148.102.86:7009/rvmdial',
//                CURLOPT_URL => $api_setting->end_point,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($params),
                                CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/json'
                                ),
                            );

                            $requests[$k] = curl_init($val->end_point);

                            Log::info(" curl_init " . $val->end_point);


                            curl_setopt_array($requests[$k], $options);

                            curl_multi_add_handle($mh, $requests[$k]);

                            $price = ($val->company_call_price && !empty($val->company_call_price))?(float) trim($val->company_call_price):(float) trim($val->call_price);
                            $cases[] = "WHEN {$val->id} then {$price} ";
                            $ids[] = $val->id;

                        }

                        do {
                            curl_multi_exec($mh, $active);

                        } while ($active > 0);

                        foreach ($requests as $key => $request) {
                            $responses[$key] = curl_multi_getcontent($request);
                            curl_multi_remove_handle($mh, $request);
                            curl_close($request);
                        }



                        $log_data = [];



                        foreach ($responses as $key => $response) {
                            Log::info("response for {$key} " . json_encode($response));

                        }
                        if (!empty($ids)) {
                            $ids = implode(',', $ids);
                            $cases = implode(' ', $cases);

                            $updateSql  ="UPDATE campaign_contacts SET status = 'initiated', is_processing = false, price = CASE id {$cases} END WHERE id in ({$ids})";
                            DB::connection('pgsql_script')->update($updateSql);
                        }
                    }



                    foreach ($campaigns as $campaign) {
                        $remainingContacts = CampaignContact::Where('campaign_id', $campaign->id)
                            ->Where('status', 'pending')->count();
                        if ($remainingContacts == 0) {
                            $campaign = Campaign::Where('id', $campaign->id)->first();
                            $campaign->status = "finished";
                            $campaign->save();

                            $user = User::Where('id', $campaign->user_id)->first();

                            Mail::to($user->email)->send(new CampaignFinishMail());
                        }
                    }
                } else {
                    Log::info("No pending contacts in campaign ".$campaigns[$c]->id);
                }
            }
        } else {
            Log::info("No pending campaigns.");
        }
        Log::info('========================================================');
    }
}
