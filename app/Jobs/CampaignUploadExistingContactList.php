<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactList;
use App\Models\Contact;
use App\Models\CampaignContact;
use App\Models\CampaignList;
use App\Models\Campaign;
class CampaignUploadExistingContactList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $campaign_id;
    protected $recipient;
    protected $user_id;
    protected $company_id;
    protected $queue_name2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id, $recipient, $user_id,$company_id, $queue_name2)
    {
        $this->campaign_id = $campaign_id;
        $this->recipient = $recipient;
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->queue_name2 = $queue_name2;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign_list = new CampaignList;
        $campaign_list->campaign_id = $this->campaign_id;
        $campaign_list->contact_list_id = $this->recipient;
        $campaign_list->user_id = $this->user_id;
        $campaign_list->company_id = $this->company_id;
        $campaign_list->save();

        $data = [];
        $contacts = Contact::where('contact_list_id', $this->recipient)->get();
        if($contacts->isNotEmpty()){
            foreach( $contacts as $contact ){
                $data[] = [
                    'number'                   => $contact->raw_number,
                    'campaign_id'              => $this->campaign_id,
                    'contact_list_id'          =>  $this->recipient,
                    'status'                   => 'pending',
                    'user_id'                  => $this->user_id,
                    'company_id'               => $this->company_id,
                    'created_at'               => now()->toDateTimeString(),
                    'updated_at'               => now()->toDateTimeString(),
                ];
            }
        
            $chunk_count = 500;
    
            $chunks = array_chunk($data, $chunk_count);
    
            foreach ($chunks as $chunk) {
                CampaignContact::insert($chunk);
            }
        }

        $updateContactList = ContactList::find($this->recipient);
        $updateContactList->job_status = 'success';
        $updateContactList->save();

        $updateCampaign = Campaign::find($this->campaign_id);
        $updateCampaign->status = 'played';
        $updateCampaign->save();
        
        unset($data);

    }
}
