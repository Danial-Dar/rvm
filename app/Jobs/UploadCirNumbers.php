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

class UploadCirNumbers implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $list_id;
    protected $fileName;
    protected $fileRows;
    protected $queue_name;
    protected $user_id;
    protected $company_id;
    protected $csv_header_index;
    protected $csv_header_value;
    protected $chunkSize;
    protected $list;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id, $fileName, $fileRows, $csv_header_index, $csv_header_value, $chunkSize = 500)
    {
        $this->list_id = $list_id;
        $this->fileName = $fileName;
        $this->fileRows = $fileRows;
        $this->csv_header_index = $csv_header_index;
        $this->csv_header_value = $csv_header_value;
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->list = ContactList::with('company')->find($this->list_id);
        $this->user_id = $this->list->user_id;
        $this->company_id = $this->list->company_id;
        $this->queue_name = $this->list->name;

        $upload = storage_path().'/app/cir-lists/'.$this->fileName;
        $csv = [];
        $file1 = fopen($upload, 'r');

        while (($result = fgetcsv($file1)) !== false) {
            $csv[] = $result;
        }
        $number_arrays = [];
        $updatedFileRows = 0;
        if (count($csv) > 0) {
            $data = [];

            for ($i = 1; $i < $this->fileRows; ++$i) {
                $raw_number = preg_replace('/[^0-9]/', '', $csv[$i][$this->csv_header_index]);
                if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
                    array_push($number_arrays, $csv[$i][$this->csv_header_index]);
                }
            }

            $unique_number_array = array_unique($number_arrays);
            $updatedFileRows = count($unique_number_array);
            if ($unique_number_array !== null && $updatedFileRows > 0) {
                foreach ($unique_number_array as $num) {
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
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }
            }

            if (count($data) > 0) {
                $chunks = array_chunk($data, $this->chunkSize);
                foreach ($chunks as $chunk) {
                    $insert = Contact::insert($chunk);
                }
            }
            unset($data);
            unset($unique_number_array);
        } else {
            Log::error('UploadCirNumbers:Selected Column Doesnot have Phone Numbers');
        }
        fclose($file1);
        unset($csv);
        unset($number_arrays);

        $successEntry = Contact::where('contact_list_id', $this->list_id)->count();
        $failedEntry = $this->fileRows - $successEntry;
        $failedEntry = $updatedFileRows - $successEntry;
        $this->list->success = $successEntry;
        $this->list->failed = $failedEntry;
        $this->list->total_contacts = $successEntry;
        $this->list->selected_phone_column = $this->csv_header_value;
        $this->list->status = 'active';
        $this->list->job_status = 'success';
        $this->list->save();
    }
}
