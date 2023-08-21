<?php

namespace App\Jobs;

use App\Models\SmsContact;
use Illuminate\Bus\Queueable;
use App\Models\SmsContactList;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SmsUploadContactListFromlistInput implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    protected $list_id;
    protected $list;
    protected $data;
    protected $length;
    protected $user_id;
    protected $company_id;
    protected $chunkSize;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id, $data, $chunkSize = 500)
    {
        $this->list_id = $list_id;
        $this->data = $data;
        $this->length = count($data);
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('---------- SMS Contact List Job Start _ ----------------');

        $this->list = SmsContactList::find($this->list_id);
        $this->company_id = $this->list->company_id;
        $this->user_id = $this->list->user_id;

        $data = [];
        $numbers = [];
        if ($this->length) {
            foreach ($this->data as $d) {
                // || !$d['first_name']
                if (in_array($d['phone'], $numbers)) {
                    continue;
                }
                array_push($numbers, $d['phone']);

                $raw_number = preg_replace('/[^0-9]/', '', $d['phone']);
                if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
                    $formatNumber = formatNumber($d['phone']);
                    if ($formatNumber) {
                        $data[] = [
                            // 'number' => preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $d['phone']),
                            'number' => maskUsNumber($formatNumber),
                            'sms_contact_list_id' => $this->list_id,
                            'user_id' => $this->user_id,
                            'company_id' => $this->company_id,
                            // 'first_name' => $d['first_name'] ?? '',
                            // 'last_name' => $d['last_name'] ?? '',
                            'first_name' => '',
                            'last_name' => '',
                            'status' => 'active',
                            'raw_number' => $formatNumber,
                            // 'raw_number' => preg_replace('/[^0-9]/', '', $num),
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }
            }
            $filteredLength = count($data);

            if ($filteredLength) {
                $chunks = array_chunk($data, $this->chunkSize);
                foreach ($chunks as $chunk) {
                    $insert = SmsContact::insert($chunk);
                }
            }
            unset($data);
            unset($numbers);
        } else {
            Log::error('SmsUploadContactListFromlistInput:Doesnot have Appropriate Data!');
        }

        $successEntry = SmsContact::where('sms_contact_list_id', $this->list_id)->count();
        $failedEntry = $this->length - $successEntry;
        $updateContactList = SmsContactList::find($this->list_id);
        $updateContactList->success = $successEntry;
        $updateContactList->failed = $failedEntry;
        $updateContactList->total_contacts = $this->length;
        $updateContactList->status = 'active';
        $updateContactList->job_status = 'success';
        $updateContactList->save();
    }
}
