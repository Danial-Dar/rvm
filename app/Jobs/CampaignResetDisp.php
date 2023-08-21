<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignStats;
use App\Models\Contact;
use App\Models\IvrIncomingCallLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CampaignResetDisp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $campaign_id;
    protected $disposition;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id, $disposition)
    {
        $this->campaign_id = $campaign_id;
        $this->disposition = $disposition;
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

            $disp = $this->disposition;

            ini_set('max_execution_time', 0);
            ini_set('memory_limit','256M');

            DB::statement("UPDATE campaign_contacts set status = 'deleted' WHERE campaign_id = ".$campaign_id);
            DB::statement("UPDATE  campaign_stats SET initiated_count = 0, contact_count = 0, dnc_count = 0 WHERE campaign_id = ".$campaign_id);

            DB::statement("DELETE from redis_keys where process_identifier='' and campaign_id = ".$campaign_id);


            DB::statement("INSERT INTO campaign_contacts (number, campaign_id, contact_list_id, status, user_id, company_id, created_at, updated_at) SELECT DISTINCT(campaign_contacts.number), ".$campaign_id.", campaign_contacts.contact_list_id, 'pending', ".$campaign->user_id.", ".$campaign->company_id.", now(), now() FROM ivr_incoming_call_logs left join campaign_contacts on campaign_contacts.id = ivr_incoming_call_logs.campaign_contact_id
            where campaign_contacts.campaign_id = ".$campaign_id."
            and ivr_incoming_call_logs.disposition = '".$disp."' ;");


            $campaign->status = "preprocessing";
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

        // $campaign_id = $this->campaign_id;
        // $campaign = Campaign::find($campaign_id);

        // $campaign_contacts = CampaignContact::Where('campaign_id', $campaign_id)->get();

        // foreach ($campaign_contacts as $contact) {
        //     $ivr_log = IvrIncomingCallLog::Where('campaign_contact_id', $contact->id)->Where('disposition', $this->disposition)->first();

        //     if ($ivr_log) {
        //         $new_camp_cont = new CampaignContact();
        //         $new_camp_cont->number = $contact->number;
        //         $new_camp_cont->campaign_id = $contact->campaign_id;
        //         $new_camp_cont->contact_list_id = $contact->contact_list_id;
        //         $new_camp_cont->status = 'pending';
        //         $new_camp_cont->user_id = $contact->user_id;
        //         $new_camp_cont->company_id = $contact->company_id;
        //         $new_camp_cont->price = $contact->price;
        //         $new_camp_cont->caller_id_number = $contact->caller_id_number;
        //         $new_camp_cont->alpha_number = $contact->alpha_number;
        //         $new_camp_cont->ci_forward_number = $contact->ci_forward_number;
        //         $new_camp_cont->random_number = $contact->random_number;
        //         $new_camp_cont->vm_forward_number = $contact->vm_forward_number;
        //         $new_camp_cont->save();
        //     }
        // }
    }
}
