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
class CampaignUploadContactList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $campaign_id;
    protected $recipient;
    protected $fileName;
    protected $user_id;
    protected $company_id;
    protected $queue_name;
    protected $fileRows;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id, $recipient, $fileName, $user_id,$company_id, $queue_name, $fileRows)
    {
        $this->campaign_id = $campaign_id;
        $this->recipient = $recipient;
        $this->fileName = $fileName;
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->queue_name = $queue_name;
        $this->fileRows = $fileRows;
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
        
        $upload = storage_path().'/app/contact-lists/'.$this->fileName;
        // $upload = $request->file('file');
        // $filepath = $upload->getRealPath();

        $csv = array();
        $file1 = fopen($upload, 'r');

        while (($result = fgetcsv($file1)) !== false)
        {
            $csv[] = $result[0];
        }

        $data = [];
        $contactData = [];
        $number_arrays=[];
        $updatedFileRows = 0;
        if(count($csv) > 0){
            for ($i=0; $i < $this->fileRows ; $i++) {
                $raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
                if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
                    array_push($number_arrays,$csv[$i]);
                    // $data[] = [
                    //     'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]),
                    //     'contact_list_id' => $this->recipient,
                    //     'user_id' => $this->user_id,
                    //     'company_id' => $this->company_id,
                    //     'status' => "active",
                    //     'raw_number' => preg_replace('/[^0-9]/', '', $csv[$i]),
                    //     'created_at' => now()->toDateTimeString(),
                    //     'updated_at' => now()->toDateTimeString(),
                    // ];
        
                    $contactData[] = [
                        'number'                   => formatNumber($csv[$i]) ? formatNumber($csv[$i]) : preg_replace('/[^0-9]/', '', $csv[$i]),
                        'campaign_id'              => $this->campaign_id,
                        'contact_list_id'          => $this->recipient,
                        'status'                   => 'pending',
                        'user_id'                  => $this->user_id,
                        'company_id'               => $this->company_id,
                        'created_at'               => now()->toDateTimeString(),
                        'updated_at'               => now()->toDateTimeString(),
                    ];
                }
                
            }

            $unique_number_array = array_unique($number_arrays);
            $updatedFileRows = count($unique_number_array);
            if($unique_number_array !== null && $updatedFileRows > 0){
                foreach($unique_number_array as $num){
                    $data[] = [
                        'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
                        'contact_list_id' => $this->recipient,
                        'user_id' => $this->user_id,
                        'company_id' => $this->company_id,
                        'status' => "active",
                        'raw_number' => formatNumber($num) ? formatNumber($num) : preg_replace('/[^0-9]/', '', $num),
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }
            }

            $chunk_count = 500;
            if(count($data) > 0){
                $chunks = array_chunk($data, $chunk_count);
                foreach ($chunks as $chunk) {
                    $insert = Contact::insert($chunk);
                }
            }
            if(count($contactData) > 0){
                $contactChunks = array_chunk($contactData, $chunk_count);
                foreach ($contactChunks as $chunk) {
                    $insertContact = CampaignContact::insert($chunk);
                }
            }

            unset($unique_number_array);

        }

        unset($csv);
        unset($data);
        unset($contactData);
        unset($number_arrays);
        fclose($file1);

        $successEntry = Contact::where('contact_list_id',$this->recipient)->count();
        // $failedEntry = $updatedFileRows - $successEntry;
        $failedEntry = $this->fileRows - $successEntry;
        $updateContactList = ContactList::find($this->recipient);
        $updateContactList->job_status = 'success';
        $updateContactList->success = $successEntry;
        $updateContactList->failed = $failedEntry;
        // $updateContactList->total_contacts = $updatedFileRows;
        $updateContactList->total_contacts = $this->fileRows;
        $updateContactList->save();

        $updateCampaign = Campaign::find($this->campaign_id);
        $updateCampaign->status = 'played';
        $updateCampaign->save();
    }
}
