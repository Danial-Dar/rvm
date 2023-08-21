<?php

namespace App\Jobs;

use App\Http\Helpers\Aws;
use App\Mail\CampaignFinishMail;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignLog;
use App\Models\User;
use Aws\S3\S3Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ResumeCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $queue_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = Campaign::with('recording')->Where('id', $this->id)->first();

        $aws = new  Aws();

        $client1 = $aws->connect();

        $cmd = $client1->getCommand('GetObject', [
            'Bucket' => 'RVM',
            'Key'    => $campaign->recording->filename,
            'Content-Type'=> 'audio/mpeg'
        ]);

        $expiry = '+10080 minutes';

        $req = $client1->createPresignedRequest($cmd, $expiry);
        $presignedUrl = (string) $req->getUri();

        $number_from = $campaign->caller_id;

        $contacts = CampaignContact::Where('campaign_id', $this->id)->Where('status', 'paused')->get();

        foreach ($contacts as $val) {
            $number_array = array_rand($number_from);
            $selected_number = $number_from[$number_array];

            $number_from_new = preg_replace('/[^0-9]/', '', $selected_number);
            $number_to = preg_replace('/[^0-9]/', '', $val->number);

            if ($campaign->alpha_number == "") {
                $selected_alpha_number = $selected_number;
            }else {
                $alpha_number = $campaign->alpha_numner;
                $alpha_number_array = array_rand($alpha_number);
                $selected_alpha_number = $alpha_number[$alpha_number_array];
            }

            $alpha_from = preg_replace('/[^0-9]/', '', $selected_alpha_number);

            $params['alpha_from'] = '+'.$alpha_from;
            $params['number_from'] = '+'.$number_from_new;
            $params['number_to'] = '+'.$number_to;
            // $params['wavefile_url'] = "https://file-examples-com.github.io/uploads/2017/11/file_example_WAV_1MG.wav";
            $params['wavefile_url'] = $presignedUrl;
            $params['transaction_id'] = mt_rand(10000000, 99999999);
            $params['carrier_addr'] = "google.com";

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://135.148.102.86:7009/rvmdial',
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
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $logs = new CampaignLog;
            $logs->user_id = $this->details['user_id'];
            $logs->request_data = json_encode($params);
            $logs->response_data = json_encode($response);
            $logs->save();

            $campaign_contact = CampaignContact::Where('id', $val->id)->first();
            // $campaign_contact->status = $response['data.status'];
            $campaign_contact->status = 'played';
            $campaign_contact->save();

            // curl_close($curl);


        }

        $campaign->status = "finished";
        $campaign->save();

        $user = User::Where('id', $campaign->user_id)->first();

        Mail::to($user->email)->send(new CampaignFinishMail());
    }
}
