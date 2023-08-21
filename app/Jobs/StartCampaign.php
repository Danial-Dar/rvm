<?php

namespace App\Jobs;

use App\Models\CampaignContact;
use App\Models\CampaignLog;
use App\Models\ContactList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Helpers\Aws;
use App\Mail\CampaignFinishMail;
use App\Models\Campaign;
use App\Models\User;
use Aws\S3\S3Client;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class StartCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $number_from;
    protected $recipient;
    protected $alpha_number;
    protected $queue_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $number_from, $recipient, $alpha_number, $queue_name)
    {
        $this->details = $details;
        $this->number_from = $number_from;
        $this->recipient = $recipient;
        $this->alpha_number = $alpha_number;
        $this->queue_name = $queue_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Artisan::call('queue:work --queue='.$this->queue_name);
        // $contact_list = ContactList::Where('id', $this->recipient)->first();
        // $readFile = storage_path('app/contact-lists/'.$contact_list->filename);
        // $file_content = file($readFile);
        $campaign = Campaign::with('recording')->Where('id', $this->details['campaign_id'])->first();

        $aws = new  Aws();

        $client1 = $aws->connect();

        $cmd = $client1->getCommand('GetObject', [
            'Bucket' => 'RVM',
            'Key'    => $campaign->recording->filename,
            'Content-Type'=> 'audio/mpeg'
        ]);

        // $expiry = '+10080 minutes'; //7days throw exception
        $expiry= '+8640 minutes'; //6 days
        try {
            $request = $client1->createPresignedRequest($cmd, $expiry);
            $presignedUrl = (string) $request->getUri();
        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }

        // $req = $client1->createPresignedRequest($cmd, $expiry);
        // $presignedUrl = (string) $req->getUri();


        $contacts = CampaignContact::Where('campaign_id', $this->details['campaign_id'])->Where('status', 'pending')->get();

        foreach ($contacts as $val) {
            $number_array = array_rand($this->number_from);
            $selected_number = $this->number_from[$number_array];

            $number_from = preg_replace('/[^0-9]/', '', $selected_number);
            $number_to = preg_replace('/[^0-9]/', '', $val->number);

            if ($this->alpha_number == "") {
                $selected_alpha_number = $selected_number;
            }else {

                $alpha_number_array = array_rand($this->alpha_number);
                $selected_alpha_number = $this->alpha_number[$alpha_number_array];
            }

            $alpha_from = preg_replace('/[^0-9]/', '', $selected_alpha_number);

            $params['alpha_from'] = '+'.$alpha_from;
            $params['number_from'] = '+'.$number_from;
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
            $campaign_contact->status = 'initiated';
            $campaign_contact->save();

            // curl_close($curl);


        }

        $campaign->status = "finished";
        $campaign->save();

        $user = User::Where('id', $campaign->user_id)->first();

        Mail::to($user->email)->send(new CampaignFinishMail());

    }
}
