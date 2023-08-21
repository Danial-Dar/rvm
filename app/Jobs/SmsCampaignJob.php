<?php

namespace App\Jobs;

use App\Models\MyNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SmsContact;
use App\Models\SmsCampaignContact;
use App\Models\SmsCampaign;
use App\Models\SmsContactList;
use App\Models\SmsCampaignStats;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmsCampaignJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
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

        if(!is_array($campaign->sms_contact_list_id)) {
            $recipient_list = json_decode($campaign->sms_contact_list_id);
        } else {
            $recipient_list = $campaign->sms_contact_list_id;
        }

        $from_numbers = MyNumber::Where('user_id', $campaign->user_id)->Where('platform', 'sw')->pluck('raw_number')->toArray();

        foreach($recipient_list as $recipient) {
            $rand = array_rand($from_numbers);

            $list_count = SmsContact::where('sms_contact_list_id', $recipient)->count();
            if ($list_count > 700000) {
                $count = $list_count / 700000 ;
                $count = ceil($count);
                for ($i=0; $i < $count; $i++) {
                    DB::statement("INSERT INTO sms_campaign_contacts (number, sms_campaign_id, sms_contact_list_id, status, user_id, company_id, created_at, updated_at, from_number)
                    SELECT sms_contacts.raw_number, ".$campaign_id.", ".$recipient.", 'pending', ".$campaign->user_id.", ".$campaign->company_id.", now(), now(), '".$from_numbers[$rand]."'
                    FROM sms_contacts where sms_contact_list_id = ".$recipient." and sms_contacts.raw_number is not null Order by id desc limit 700000 offset ".($i * 700000).";");
                }
            }else {
                Log::info($from_numbers[$rand]);
                DB::statement("INSERT INTO sms_campaign_contacts (number, sms_campaign_id, sms_contact_list_id, status, user_id, company_id, created_at, updated_at, from_number)
                SELECT sms_contacts.raw_number, ".$campaign_id.", ".$recipient.", 'pending', ".$campaign->user_id.", ".$campaign->company_id.", now(), now(), '".$from_numbers[$rand]."'
                FROM sms_contacts where sms_contact_list_id = ".$recipient." and sms_contacts.raw_number is not null;");
            }
        }
        $campaign->save();

        // $sql = sprintf("UPDATE sms_campaign_contacts cc SET status = 'dnc' FROM dnc WHERE cc.number = dnc.raw_number and campaign_id =$campaign->id");
        // $results = DB::select($sql);
        $campaignContactCount = SmsCampaignContact::where('sms_campaign_id', $campaign->id)->count();
        $campaignStats = SmsCampaignStats::updateOrCreate(
            ['sms_campaign_id' => $campaign->id],
            ['contact_count' => $campaignContactCount, 'user_id'=> $campaign->user_id,'company_id' => $campaign->company_id]
        );

        SmsCampaignJobStart::dispatchAfterResponse($campaign_id);


        //----------------------------------Old Code Starts--------------------------------

        //     $user_id = $campaign->user_id;
        //     $company_id = $campaign->company_id;

        //     $from_numbers = MyNumber::Where('user_id', $campaign->user_id)->Where('platform', 'sw')->pluck('raw_number')->toArray();

        //     $recipient_list = json_decode($campaign->sms_contact_list_id);
        //     $phonePattern = '/(phone|cell|number|mobile|contact)/i';
        //     $firstNamePattern = '/(first_name|firstname|first name)/i';
        //     $lastNamePattern = '/(last_name|last name|lastname)/i';
        //     foreach ($recipient_list as $recipient) {
        //         $contactList = SmsContactList::find($recipient);

        //         $rand = array_rand($from_numbers);
        //         if ($contactList != null && $contactList->job_status == 'pending') {
        //             $contactListCsvUpload = storage_path().'/app/sms/contact-lists/'.$contactList->filename;
        //             if (file_exists($contactListCsvUpload)) {
        //                 $contactListCsv = [];
        //                 $contatListFile = fopen($contactListCsvUpload, 'r');
        //                 while (($result = fgetcsv($contatListFile)) !== false) {
        //                     $contactListCsv[] = $result;
        //                 }
        //                 $data = [];
        //                 $contactData = [];
        //                 $number_arrays = [];
        //                 $updatedFileRows = 0;
        //                 $phoneIndex = '';
        //                 $firstNameIndex = '';
        //                 $lastNameIndex = '';
        //                 foreach ($contactListCsv[0] as $key => $value) {
        //                     if (preg_match($phonePattern, strtolower($value)) !== 0) {
        //                         $phoneIndex = $key;
        //                     }

        //                     if (preg_match($firstNamePattern, strtolower($value)) !== 0) {
        //                         $firstNameIndex = $key;
        //                     }

        //                     if (preg_match($lastNamePattern, strtolower($value)) !== 0) {
        //                         $lastNameIndex = $key;
        //                     }
        //                 }
        //                 if (count($contactListCsv) > 0) {
        //                     $x = 0;
        //                     for ($i = 1; $i <= $contactList->total_contacts; ++$i) {
        //                         if(isset($contactListCsv[$i]) && isset($contactListCsv[$i][$phoneIndex] )){
        //                             $raw_number = preg_replace('/[^0-9]/', '', $contactListCsv[$i][$phoneIndex]);
        //                             if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
        //                                 $number_arrays[$x]['number'] = $contactListCsv[$i][$phoneIndex];
        //                                 $number_arrays[$x]['first_name'] = $contactListCsv[$i][$firstNameIndex];
        //                                 $number_arrays[$x]['last_name'] = $contactListCsv[$i][$lastNameIndex];
        //                                 ++$x;
        //                             }
        //                         }
        //                     }

        //                     $unique_number_array = array_unique($number_arrays, SORT_REGULAR);
        //                     $updatedFileRows = count($unique_number_array);
        //                     if ($unique_number_array !== null && $updatedFileRows > 0) {
        //                         foreach ($unique_number_array as $num) {
        //                             $formatNumber = formatNumber($num['number']);
        //                             if ($formatNumber) {
        //                                 $data[] = [
        //                                     'number' => preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num['number']),
        //                                     'sms_contact_list_id' => $recipient,
        //                                     'user_id' => $user_id,
        //                                     'company_id' => $company_id,
        //                                     'first_name' => $num['first_name'],
        //                                     'last_name' => $num['last_name'],
        //                                     'status' => 'active',
        //                                     'raw_number' => $formatNumber,
        //                                     'created_at' => now()->toDateTimeString(),
        //                                     'updated_at' => now()->toDateTimeString(),
        //                                 ];

        //                                 $contactData[] = [
        //                                     'number' => $formatNumber,
        //                                     'sms_campaign_id' => $campaign->id,
        //                                     'sms_contact_list_id' => $recipient,
        //                                     'first_name' => $num['first_name'],
        //                                     'last_name' => $num['last_name'],
        //                                     'status' => 'pending',
        //                                     'user_id' => $user_id,
        //                                     'company_id' => $company_id,
        //                                     'created_at' => now()->toDateTimeString(),
        //                                     'updated_at' => now()->toDateTimeString(),
        //                                     'from_number' => $from_numbers[$rand],
        //                                 ];
        //                             }
        //                         }
        //                     }

        //                     $chunk_count = 500;
        //                     if (count($data) > 0) {
        //                         $chunks = array_chunk($data, $chunk_count);
        //                         foreach ($chunks as $chunk) {
        //                             $insert = SmsContact::insert($chunk);
        //                         }
        //                     }
        //                     if (count($contactData) > 0) {
        //                         $contactChunks = array_chunk($contactData, $chunk_count);
        //                         foreach ($contactChunks as $insertchunk) {
        //                             $insertContact = SmsCampaignContact::insert($insertchunk);
        //                         }
        //                     }

        //                     unset($unique_number_array);
        //                 }

        //                 unset($contactListCsv);
        //                 unset($data);
        //                 unset($contactData);
        //                 unset($number_arrays);
        //                 fclose($contatListFile);

        //                 $successEntry = SmsContact::where('sms_contact_list_id', $recipient)->count();
        //                 $failedEntry = $contactList->total_contacts - $successEntry;
        //                 $contactList->job_status = 'success';
        //                 $contactList->success = $successEntry;
        //                 $contactList->failed = $failedEntry;

        //                 $contactList->save();
        //             }
        //         } elseif ($contactList != null && $contactList->job_status == 'success') {
        //             $existingContactListdata = [];
        //             $existingContacts = SmsContact::where('sms_contact_list_id', $recipient)->get();
        //             if ($existingContacts->isNotEmpty()) {
        //                 foreach ($existingContacts as $contact) {
        //                     $existingContactListdata[] = [
        //                         'number' => $contact->raw_number,
        //                         'sms_campaign_id' => $campaign->id,
        //                         'sms_contact_list_id' => $recipient,
        //                         'status' => 'pending',
        //                         'user_id' => $user_id,
        //                         'company_id' => $company_id,
        //                         'first_name' => $contact->first_name,
        //                         'last_name' => $contact->last_name,
        //                         'created_at' => now()->toDateTimeString(),
        //                         'updated_at' => now()->toDateTimeString(),
        //                         'from_number' => $from_numbers[$rand],
        //                     ];
        //                 }

        //                 $chunk_count = 500;
        //                 if (count($existingContactListdata) > 0) {
        //                     $chunks = array_chunk($existingContactListdata, $chunk_count);

        //                     foreach ($chunks as $chunk) {
        //                         SmsCampaignContact::insert($chunk);
        //                     }
        //                 }
        //             }

        //             $contactList->job_status = 'success';
        //             $contactList->save();

        //             unset($existingContactListdata);
        //         }
        //     }

        //     $sql = sprintf("UPDATE sms_campaign_contacts cc SET status = 'dnc' FROM dnc WHERE cc.number = dnc.raw_number and sms_campaign_id::int =$campaign->id");
        //     $results = \DB::select($sql);

        //     $campaignContactCount = SmsCampaignContact::where('sms_campaign_id', $campaign->id)->count();

        //     $campaignStats = SmsCampaignStats::updateOrCreate(
        //         ['sms_campaign_id' => $campaign->id],
        //         ['contact_count' => $campaignContactCount, 'user_id' => $campaign->user_id, 'company_id' => $campaign->company_id]
        //     );

        //     if ($campaign->status == 'preprocessing') {
        //         $campaign->status = 'played';
        //         $campaign->save();
        //     }

        //----------------------------------Old Code Ends--------------------------------
    }
}
