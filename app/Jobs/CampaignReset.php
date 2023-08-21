<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignStats;
use App\Models\Contact;
use App\Models\ContactList;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CampaignReset implements ShouldQueue
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
        try {
            $campaign_id = $this->campaign_id;
            $campaign = Campaign::find($campaign_id);
            // $campaign_contacts = CampaignContact::Where('campaign_id', $campaign_id)->get();
            // foreach ($campaign_contacts as $contact) {
            //     $contact->status = "pending";
            //     $contact->save();
            // }


            ini_set('max_execution_time', 0);
            ini_set('memory_limit','256M');

            if(!is_array($campaign->contact_list_id)) {
                $recipient_list = json_decode($campaign->contact_list_id);
            } else {
                $recipient_list = $campaign->contact_list_id;
            }

            DB::statement("UPDATE campaign_contacts set status = 'deleted' WHERE campaign_id = ".$campaign_id);
            DB::statement("UPDATE  campaign_stats SET initiated_count = 0, contact_count = 0, dnc_count = 0 WHERE campaign_id = ".$campaign_id);

            DB::statement("DELETE from redis_keys where process_identifier='' and campaign_id = ".$campaign_id);

            foreach($recipient_list as $recipient) {
                $list_count = Contact::where('contact_list_id', $recipient)->count();
                if ($list_count > 700000) {
                    $count = $list_count / 700000 ;
                    $count = ceil($count);
                    for ($i=0; $i < $count; $i++) {
                        DB::statement("INSERT INTO campaign_contacts (number, campaign_id, contact_list_id, status, user_id, company_id, created_at, updated_at) SELECT contacts.raw_number, ".$campaign_id.", ".$recipient.", 'pending', ".$campaign->user_id.", ".$campaign->company_id.", now(), now() FROM contacts where contact_list_id = ".$recipient." and contacts.raw_number is not null Order by id desc limit 700000 offset ".($i * 700000).";");
                    }
                }else {
                    DB::statement("INSERT INTO campaign_contacts (number, campaign_id, contact_list_id, status, user_id, company_id, created_at, updated_at) SELECT contacts.raw_number, ".$campaign_id.", ".$recipient.", 'pending', ".$campaign->user_id.", ".$campaign->company_id.", now(), now() FROM contacts where contact_list_id = ".$recipient." and contacts.raw_number is not null;");
                }
            }
            $campaign->save();

            $sql = sprintf("UPDATE campaign_contacts cc SET status = 'dnc' FROM dnc WHERE cc.number = dnc.raw_number and campaign_id =$campaign->id");
            $results = DB::select($sql);
            $campaignContactCount = CampaignContact::where('campaign_id', $campaign->id)->count();
            $campaignStats = CampaignStats::updateOrCreate(
                ['campaign_id' => $campaign->id],
                ['contact_count' => $campaignContactCount, 'user_id'=> $campaign->user_id,'company_id' => $campaign->company_id]
            );
            $curl = curl_init();

            if(config('app.env') == 'production') {
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://go-redisapi.voslogic.com/api/cache/campaigns/'.$campaign->id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;
            }
        } catch (\Exception $e) {
            Log::error('Campaign Reset');
            Log::error($e);
        }

    }
}
