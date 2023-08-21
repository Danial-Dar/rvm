<?php

namespace App\Jobs;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Helpers\Aws;
use App\Models\CampaignContact;
use App\Models\CampaignLog;

class PauseCampaign implements ShouldQueue
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
        // $campaign = Campaign::with('recording')->Where('id', $this->id)->first();
        // $number_from = json_decode($campaign->caller_id);
        // $recipient = json_decode($campaign->contact_list_id);
        // $alpha_number = json_decode($campaign->alpha_number);

        // $aws = new  Aws();

        // $client1 = $aws->connect();

        // $cmd = $client1->getCommand('GetObject', [
        //     'Bucket' => 'RVM',
        //     'Key'    => $campaign->recording->filename,
        //     'Content-Type'=> 'audio/mpeg'
        // ]);

        // $expiry = '+10080 minutes';

        // $req = $client1->createPresignedRequest($cmd, $expiry);
        // $presignedUrl = (string) $req->getUri();

        $contacts = CampaignContact::Where('campaign_id', $this->id)->Where('status', 'pending')->get();

        foreach ($contacts as $val) {

            $campaign_contact = CampaignContact::Where('id', $val->id)->first();
            $campaign_contact->status = 'paused';
            $campaign_contact->save();
            
        }
    }
}
