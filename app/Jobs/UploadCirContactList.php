<?php

namespace App\Jobs;

use App\Models\AreaCodeLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactList;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class UploadCirContactList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $list_id;
    protected $fileName;
    protected $fileRows;
    protected $queue_name;
    protected $user_id;
    protected $company_id;
    protected $csv_header_index;
    protected $csv_header_value;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value)
    {
        $this->list_id = $list_id;
        $this->fileName = $fileName;
        $this->fileRows = $fileRows;
        $this->queue_name = $queue_name;
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->csv_header_index = $csv_header_index;
        $this->csv_header_value = $csv_header_value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('CirContactList: Start');

        $upload = storage_path() . '/app/contact-lists/' . $this->fileName;
        // $upload = $request->file('file');
        // $filepath = $upload->getRealPath();

        $csv = array();
        $file1 = fopen($upload, 'r');

        while (($result = fgetcsv($file1)) !== false) {
            // $csv[] = $result[0];
            $csv[] = $result;
        }
        $number_arrays = [];
        $updatedFileRows = 0;
        if (count($csv) > 0) {
            $data = [];
            foreach ($csv as $row ) {


                $raw_number = preg_replace('/[^0-9]/', '', $row[0]);
                if (strlen($raw_number) == 10  || strlen($raw_number) == 11) {
                    array_push($number_arrays, $row[0]);
                    // $data[] = [
                    //     // 'number'=> $csv[$i],
                    //     'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i][$this->csv_header_index]),
                    //     'contact_list_id' => $this->list_id,
                    //     'user_id' => $this->user_id,
                    //     'company_id' => $this->company_id,
                    //     'status' => "active",
                    //     // 'raw_number' => preg_replace('/[^0-9]/', '', $csv[$i]),
                    //     'raw_number' => preg_replace('/[^0-9]/', '', $csv[$i][$this->csv_header_index]),
                    //     'created_at' => now()->toDateTimeString(),
                    //     'updated_at' => now()->toDateTimeString(),
                    // ];
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
                            'number' => preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
                            'contact_list_id' => $this->list_id,
                            'user_id' => $this->user_id,
                            'company_id' => $this->company_id,
                            // 'company_name' => $this->list->company->name,
                            'raw_number' => $formatNumber,
                            'type' => 'cir',
                            'cir_state' => isset($area->location_code) ? $area->location_code : null,
                            'status' => "active",
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }
            }

            $chunk_count = 500;
            if (count($data) > 0) {
                $chunks = array_chunk($data, $chunk_count);
                foreach ($chunks as $chunk) {
                    $insert = Contact::insert($chunk);
                    Log::info('CirContactList: chuck');
                }
            }
            unset($data);
            unset($unique_number_array);
        }
        fclose($file1);
        $count = count($csv);
        unset($csv);
        unset($number_arrays);

        // dd($data);
        // // $chunk_count = $fileRows / 500;

        $successEntry = Contact::where('contact_list_id', $this->list_id)->count();
        $failedEntry = $count - $successEntry;
        // $failedEntry = $updatedFileRows - $successEntry;
        $updateContactList = ContactList::find($this->list_id);
        $updateContactList->success = $successEntry;
        $updateContactList->failed = $failedEntry;
        $updateContactList->total_contacts = $count;
        $updateContactList->selected_phone_column = $this->csv_header_value;
        $updateContactList->status = 'active';
        $updateContactList->job_status = 'success';
        $updateContactList->save();

        Log::info('CirContactList: done');

        ReputationCheckContactList::dispatchAfterResponse($this->list_id);
        

    }
}
