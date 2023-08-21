<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SmsCampaign;
use App\Models\SmsCampaignContact;
use App\Models\SmsContact;
use App\Models\SmsCampaignStats;

class SmsCampaignResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $campaign_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign_id = $this->campaign_id;
        $campaign = SmsCampaign::find($campaign_id);

        $recipient_list = json_decode($campaign->sms_contact_list_id);
        foreach($recipient_list as $recipient) {
            $existingContactListdata = [];
            $existingContacts = SmsContact::where('sms_contact_list_id', $recipient)->get();
            if($existingContacts->isNotEmpty()){
                foreach($existingContacts as $contact ){
                    $existingContactListdata[] = [
                        'number'                   => $contact->raw_number,
                        'sms_campaign_id'          => $campaign_id,
                        'sms_contact_list_id'      => $recipient,
                        'status'                   => 'pending',
                        'user_id'                  => $campaign->user_id,
                        'company_id'               => $campaign->company_id,
                        'created_at'               => now()->toDateTimeString(),
                        'updated_at'               => now()->toDateTimeString(),
                    ];
                }
                $chunk_count = 500;
                if(count($existingContactListdata) > 0){
                    $chunks = array_chunk($existingContactListdata, $chunk_count);

                    foreach ($chunks as $chunk) {
                        SmsCampaignContact::insert($chunk);
                    }
                }//count existingContactListdata if end
            }
        }
        
        $campaign->status = "played";
        $campaign->save();

        $sql = sprintf("UPDATE sms_campaign_contacts cc SET status = 'dnc' FROM dnc WHERE cc.number = dnc.raw_number and sms_campaign_id::int =$campaign->id");
        $results = \DB::select($sql);
        $campaignContactCount = SmsCampaignContact::where('sms_campaign_id', $campaign->id)->count();
        $campaignStats = SmsCampaignStats::updateOrCreate(
            ['sms_campaign_id' => $campaign->id],
            ['contact_count' => $campaignContactCount, 'user_id'=> $campaign->user_id,'company_id' => $campaign->company_id]
        );
    }
}
