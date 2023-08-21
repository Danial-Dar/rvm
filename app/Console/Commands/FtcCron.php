<?php

namespace App\Console\Commands;
use App\Models\FtcDnc;
use App\Models\FtcResponceLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FtcCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     *
     * from Y-m-d formate date (optionally) to setfrom date till now.
     */
    protected $signature = 'ftc:cron {from}';

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
        $params['api_key'] = Setting::getValue('ftc_api_key');
        $endpoint = 'https://api.ftc.gov/v0/dnc-complaints'.'?api_key='.$params['api_key'];
        echo $this->argument('from');
        if($this->argument('from')){
            $params['created_date_from'] =$this->argument('from'); //Carbon::now()->yesterday()->format('Y-m-d');
            $params['created_date_to'] = Carbon::now()->format('Y-m-d');
            $endpoint = $endpoint.'&created_date_from="' . $params['created_date_from'] . '"';
            $endpoint = $endpoint.'&created_date_to="' . $params['created_date_to'] . '"';
        }else{
            $params['created_date'] = Carbon::now()->format('Y-m-d');
            $endpoint = $endpoint.'&created_date="'.$params['created_date'].'"';
        }

                $limit     =  1000;
                $remaining = $limit -1;

                $headers = [
                    "X-RateLimit-Limit:1000",
                    "X-RateLimit-Remaining:".$remaining,
                ];
        // $endpoint = $endpoint.'&items_per_page=1000';//useless max is 50
        echo  $endpoint;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            // CURLOPT_POSTFIELDS => json_encode($params),
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers)
        ]);



        $response = curl_exec($curl);
        $json_response = json_decode($response);
        // dd($json_response);
        curl_close($curl);

        $search_log = new FtcResponceLog();
        $search_log->request_data = json_encode($params);
        $search_log->response_data = $response;
        $search_log->save();
//echo "<pre>dddd";print_r($json_response);exit;
if(!isset($json_response->error)):
        foreach ($json_response->data as $data) {

            $value = (array) $data->attributes;
            if ($value['company-phone-number'] != '') {

                

                $number = FtcDnc::updateOrCreate(
                    [
                        'number' => $value['company-phone-number'],
                        'raw_number' => '+1'.$value['company-phone-number'],
                    ],
                    [
                        'robocall_status' => $value['recorded-message-or-robocall'],
                        'ftc_response' => json_encode($data->attributes),

                        'ftc_status' => 'active',
                        'search_log_id' => $search_log->id,
                    ],
                );
            }
        }
    else:
        echo "<pre>";print_r($json_response->error);
        exit;

    endif;

        $totalRecordsthisPage=$json_response->meta->{'records-this-page'};
        $totalRecords=$json_response->meta->{'record-total'};
        if($totalRecords > $totalRecordsthisPage){
            $offset=50;
            $i=0;
            while($totalRecords > $offset ){
                $i++;
                $params['offset']=$offset;
                $endpoint2 = $endpoint.'&offset='.$params['offset'];
                $offset += 50;
                $limit     =  1000;
                $remaining = $limit -$i;

                $headers = [
                    "X-RateLimit-Limit:1000",
                    "X-RateLimit-Remaining:".$remaining,
                ];
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $endpoint2,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    // CURLOPT_POSTFIELDS => json_encode($params),
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers)
                ]);
                
                
               

                $response = curl_exec($curl);
                $json_response = json_decode($response);
                // dd($json_response);

                curl_close($curl);
                $search_log = new FtcResponceLog();
                $search_log->request_data = json_encode($params);
                $search_log->response_data = $response;
                $search_log->save();
                //if(isset($json_response->data)):
                foreach ($json_response->data as $data) {
                    $value = (array) $data->attributes;
                    if ($value['company-phone-number'] != '') {
                        $number = FtcDnc::updateOrCreate(
                            [
                                'number' => $value['company-phone-number'],
                                'raw_number' => '+1'.$value['company-phone-number'],
                            ],[
                                'robocall_status' => $value['recorded-message-or-robocall'],
                                'ftc_response' => json_encode($data->attributes),

                                'ftc_status' => 'active',
                                'search_log_id' => $search_log->id,
                            ],
                        );
                    }
                }
           // endif;



                $totalRecordsthisPage=$json_response->meta->{'records-this-page'};
            }


        }



    }
}

