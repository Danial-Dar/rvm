<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Bus\Queueable;
use App\Models\AreaCodeLocation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UploadCirNumbersFromlistInput implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $list_id;
    protected $queue_name;
    protected $number_lists;
    protected $length;
    protected $user_id;
    protected $company_id;
    protected $chunkSize;
    protected $list;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id, $number_lists, $chunkSize = 500)
    { 
        $this->list_id = $list_id;
        $this->number_lists = $number_lists;
        $this->length = count($number_lists);
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('---------- CIR Contact List Job Start _ ----------------');
        $this->list = ContactList::find($this->list_id);
        $this->user_id = $this->list->user_id;
        $this->company_id = $this->list->company_id;
        $this->queue_name = $this->list->name;

        $data = [];
        if ($this->length) {
            $lists = array_filter($this->number_lists, function ($k) {
                if ($k === 'number') {
                    --$this->length;

                    return false;
                } else {
                    return true;
                }
            });
            foreach (array_unique($lists, SORT_REGULAR) as $num) {
                //filtring
                $raw_number = preg_replace('/[^0-9]/', '', $num);

                if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
                    $formatNumber = formatNumber($num);
                    if ($formatNumber) {
                        $area = AreaCodeLocation::select('location_code')->firstWhere('area_code', getStateCodeNumber($formatNumber));
                        $data[] = [
                            'number' => maskUsNumber($formatNumber),
                            // 'number' => preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
                            'contact_list_id' => $this->list_id,
                            'user_id' => $this->user_id,
                            'company_id' => $this->company_id,
                            'company_name' => $this->list->company->name,
                            'raw_number' => $formatNumber,
                            'type' => 'cir',
                            'cir_state' => isset($area->location_code) ? $area->location_code : null,
                            'status' => 'active',
                            // 'created_at' => now()->toDateTimeString(),
                            // 'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }
            }
            $filteredLength = count($data);

            if ($filteredLength) {
                $chunks = array_chunk($data, $this->chunkSize);
                foreach ($chunks as $chunk) {
                    $insert = Contact::insert($chunk);
                }
            }
            unset($data);
        } else {
            Log::error('UploadCirNumbersFromListInput:Doesnot have Phone Numbers');
        }

        $successEntry = Contact::where('contact_list_id', $this->list_id)->count();
        $this->list->success = $successEntry;
        $this->list->failed = $this->length - $filteredLength;
        $this->list->total_contacts = $successEntry;
        $this->list->selected_phone_column = '';
        $this->list->status = 'active';
        $this->list->job_status = 'success';
        $this->list->save();
    }
}
