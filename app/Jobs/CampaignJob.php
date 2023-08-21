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
use App\Models\MyGroup;
use App\Models\MyGroupNumber;
use App\Models\CampaignCallerId;
use App\Models\MyNumber;
use App\Models\CampaignStats;
use Illuminate\Support\Facades\Log;
class CampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign_id;
    // protected $caller_id_button;
    // protected $caller_id;
    // protected $caller_id_individual;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    // $caller_id_button,$caller_id,$caller_id_individual
    public function __construct($campaign_id)
    {
       $this->campaign_id = $campaign_id;
    //    $this->caller_id_button = $caller_id_button;
    //    $this->caller_id = $caller_id;
    //    $this->caller_id_individual = $caller_id_individual;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign_id = $this->campaign_id;
        // $caller_id_button = $this->caller_id_button;
        // $caller_id =  $this->caller_id;
        // $caller_id_individual =  $this->caller_id_individual;

        $campaign = Campaign::find($campaign_id);
        $user_id = $campaign->user_id;
        $company_id = $campaign->company_id;


        // -------------- add caller ids -------------------
        // $caller_ids = [];
        // if($caller_id_button == "client_numbers" && $caller_id !== null){
        //     $caller_ids  = array_filter($caller_id, fn($value) => !is_null($value) && $value !== '');
        // }elseif($caller_id_button == "callzy_numbers" && $caller_id !== null){
        //     $caller_ids  = array_filter($caller_id, fn($value) => !is_null($value) && $value !== '');
        // }elseif($caller_id_button == "individual" && $caller_id_individual !== null){
        //     $number = new MyNumber;
        //     $number->user_id = $user_id;
        //     $number->number = $caller_id_individual;
        //     $number->raw_number = preg_replace('/[^0-9]/', '', $caller_id_individual);
        //     $number->status = 'active';
        //     $number->type = 'individual';
        //     $number->company_id = $company_id;
        //     $number->save();
        //     array_push($caller_ids,$number->id);
        // }

        // if(count($caller_ids) > 0){
        //     foreach ($caller_ids as $id) {
        //         $campaignCallerId = new CampaignCallerId;
        //         $campaignCallerId->user_id = $user_id;
        //         $campaignCallerId->campaign_id = $campaign->id;
        //         $campaignCallerId->my_number_id = $id;
        //         $campaignCallerId->company_id = $company_id;
        //         $campaignCallerId->type = 'caller';
        //         $campaignCallerId->is_group = 0;
        //         $campaignCallerId->group_id = null;
        //         $campaignCallerId->caller_number_type= $caller_id_button;
        //         $campaignCallerId->alpha_number_type= null;
        //         $campaignCallerId->save();
        //     }
        // }//count caller id end
        // unset($caller_ids);

        // ------------------ add recipient -------------------

        $recipient_list = $campaign->contact_list_id;
        foreach($recipient_list as $recipient) {

            $campaign_list = new CampaignList;
            $campaign_list->campaign_id = $campaign->id;
            $campaign_list->contact_list_id = $recipient;
            $campaign_list->user_id = $user_id;
            $campaign_list->company_id = $company_id;
            $campaign_list->save();

            $contactList = ContactList::find($recipient);
            if($contactList != null && $contactList->job_status == "pending")
            {
                $contactListCsvUpload = storage_path().'/app/contact-lists/'.$contactList->filename;
                if(file_exists($contactListCsvUpload)){

                    $contactListCsv = array();
                    $contatListFile = fopen($contactListCsvUpload, 'r');

                    while (($result = fgetcsv($contatListFile)) !== false)
                    {
                        $contactListCsv[] = $result[0];
                    }
                    $data = [];
                    $contactData = [];
                    $number_arrays=[];
                    $updatedFileRows = 0;
                    if(count($contactListCsv) > 0){

                        for ($i=1; $i <= $contactList->total_contacts ; $i++) {
                            $raw_number = preg_replace('/[^0-9]/', '', $contactListCsv[$i]);
                            if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
                                array_push($number_arrays,$contactListCsv[$i]);

                            }

                        }//for loop end

                        $unique_number_array = array_unique($number_arrays);
                        $updatedFileRows = count($unique_number_array);
                        if($unique_number_array !== null && $updatedFileRows > 0){
                            foreach($unique_number_array as $num){
                                $formatNumber = formatNumber($num);
                                if($formatNumber){
                                    $data[] = [
                                        'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
                                        'contact_list_id' => $recipient,
                                        'user_id' => $user_id,
                                        'company_id' => $company_id,
                                        'status' => "active",
                                        // 'raw_number' => preg_replace('/[^0-9]/', '', $num),
                                        'raw_number' => $formatNumber,
                                        'created_at' => now()->toDateTimeString(),
                                        'updated_at' => now()->toDateTimeString(),
                                    ];
                                    $contactData[] = [
                                        'number'                   => $formatNumber,
                                        'campaign_id'              => $campaign->id,
                                        'contact_list_id'          => $recipient,
                                        'status'                   => 'pending',
                                        'user_id'                  => $user_id,
                                        'company_id'               => $company_id,
                                        'created_at'               => now()->toDateTimeString(),
                                        'updated_at'               => now()->toDateTimeString(),
                                    ];
                                }

                            }//foreach loop end
                        }//check unique_number_array if end

                        $chunk_count = 500;
                        if(count($data) > 0){
                            $chunks = array_chunk($data, $chunk_count);
                            foreach ($chunks as $chunk) {
                                $insert = Contact::insert($chunk);
                            }
                        }
                        if(count($contactData) > 0){
                            $contactChunks = array_chunk($contactData, $chunk_count);
                            foreach ($contactChunks as $insertchunk) {
                                $insertContact = CampaignContact::insert($insertchunk);
                            }
                        }

                        unset($unique_number_array);

                    }//count csv if end

                    unset($contactListCsv);
                    unset($data);
                    unset($contactData);
                    unset($number_arrays);
                    fclose($contatListFile);

                    $successEntry = Contact::where('contact_list_id',$recipient)->count();
                    $failedEntry = $contactList->total_contacts - $successEntry;
                    $contactList->job_status = 'success';
                    $contactList->success = $successEntry;
                    $contactList->failed = $failedEntry;
                    // $contactList->total_contacts = $updatedFileRows;
                    // $contactList->total_contacts = $contactList->total_contacts;
                    $contactList->save();

                    // $updateCampaign = Campaign::find($campaign->id);
                    // $updateCampaign->status = 'played';
                    // $updateCampaign->save();

                }//file exists if end

            }elseif($contactList != null && $contactList->job_status == "success"){

                $existingContactListdata = [];
                $existingContacts = Contact::where('contact_list_id', $recipient)->get();
                if($existingContacts->isNotEmpty()){
                    foreach( $existingContacts as $contact ){
                        if($contact->raw_number && $contact->raw_number != '') {
                            $existingContactListdata[] = [
                                'number'                   => $contact->raw_number,
                                'campaign_id'              => $campaign->id,
                                'contact_list_id'          =>  $recipient,
                                'status'                   => 'pending',
                                'user_id'                  => $user_id,
                                'company_id'               => $company_id,
                                'created_at'               => now()->toDateTimeString(),
                                'updated_at'               => now()->toDateTimeString(),
                            ];
                        }
                    }

                    $chunk_count = 500;
                    if(count($existingContactListdata) > 0){
                        $chunks = array_chunk($existingContactListdata, $chunk_count);

                        foreach ($chunks as $chunk) {
                            CampaignContact::insert($chunk);
                        }
                    }//count existingContactListdata if end

                }//if existing contact list is not empty check end

                $contactList->job_status = 'success';
                $contactList->save();

                // $updateCampaign = Campaign::find($this->campaign_id);
                // $updateCampaign->status = 'played';
                // $updateCampaign->save();

                unset($existingContactListdata);

            }//exisiting or new contact list if end


        }//foreach recipient end

        $sql = sprintf("UPDATE campaign_contacts cc SET status = 'dnc' FROM dnc WHERE cc.number = dnc.raw_number and campaign_id =$campaign->id");
        $results = \DB::select($sql);
        $campaignContactCount = CampaignContact::where('campaign_id', $campaign->id)->count();
        $campaignStats = CampaignStats::updateOrCreate(
            ['campaign_id' => $campaign->id],
            ['contact_count' => $campaignContactCount, 'user_id'=> $campaign->user_id,'company_id' => $campaign->company_id]
        );

        $campaign->status = 'played';
        $campaign->save();

        $curl = curl_init();

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

    }//handle function end
}
