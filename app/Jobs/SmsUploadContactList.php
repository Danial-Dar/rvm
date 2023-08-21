<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SmsContactList;
use App\Models\SmsContact;

class SmsUploadContactList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $list_id;
    protected $fileName;
    protected $fileRows;
    protected $queue_name;
    protected $user_id;
    protected $company_id;
    // protected $csv_header_index;
    // protected $csv_header_value;
    protected $csv_first_name_value;
    protected $csv_first_name_key;
    protected $csv_last_name_value;
    protected $csv_last_name_key;
    protected $csv_phone_value;
    protected $csv_phone_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id, $fileName,$user_id,$company_id, $queue_name,$fileRows,$csv_first_name_value,$csv_first_name_key,$csv_last_name_value,$csv_last_name_key,$csv_phone_value,$csv_phone_key)
    {
        $this->list_id = $list_id;
        $this->fileName = $fileName;
        $this->fileRows = $fileRows;
        $this->queue_name = $queue_name;
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        // $this->csv_header_index = $csv_header_index;
        // $this->csv_header_value = $csv_header_value;
        $this->csv_first_name_value = $csv_first_name_value;
        $this->csv_first_name_key = $csv_first_name_key;
        $this->csv_last_name_value = $csv_last_name_value;
        $this->csv_last_name_key =  $csv_last_name_key;
        $this->csv_phone_value = $csv_phone_value;
        $this->csv_phone_key = $csv_phone_key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('---------- SMS Contact List Job Start ----------------');
        
        $upload = storage_path().'/app/sms/contact-lists/'.$this->fileName;

        $csv = array();
        $file1 = fopen($upload, 'r');

        while (($result = fgetcsv($file1)) !== false)
        {
            $csv[] = $result;
        }
        $number_arrays=[];
        $updatedFileRows = 0;
        if(count($csv) > 0){
            $data = [];
            $x=0;
            for ($i=1; $i < $this->fileRows ; $i++) {
                // \Log::info('---------- PHONE KEYS ----------------',[$csv[$i][$this->csv_phone_key]]);
                $raw_number = preg_replace('/[^0-9]/', '', $csv[$i][$this->csv_phone_key]);
                // \Log::info('---------- RAW NUMBER ----------------',[$raw_number]);
                if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
                    // array_push($number_arrays,$csv[$i][$this->csv_header_index]);
                    // \Log::info('---------- number ----------------',[$csv[$i][$this->csv_phone_key]]);
                    $number_arrays[$x]['number']=$csv[$i][$this->csv_phone_key];
                    $number_arrays[$x]['first_name']=$csv[$i][$this->csv_first_name_key];
                    $number_arrays[$x]['last_name']=$csv[$i][$this->csv_last_name_key];
                    $x++;
                }
                
            }
            // \Log::info('---------- NUMBER ARRAYS ----------------',[$number_arrays]);
            $unique_number_array = array_unique($number_arrays,SORT_REGULAR);
            $updatedFileRows = count($unique_number_array);
            if($unique_number_array !== null && $updatedFileRows > 0){
                foreach($unique_number_array as $num){
                    $formatNumber = formatNumber($num['number']);
                    if($formatNumber){
                        $data[] = [
                            // 'number'=> $csv[$i],
                            'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num['number']),
                            'sms_contact_list_id' => $this->list_id,
                            'user_id' => $this->user_id,
                            'company_id' => $this->company_id,
                            'first_name' => $num['first_name'],
                            'last_name' => $num['last_name'],
                            'status' => "active",
                            'raw_number' => $formatNumber,
                            // 'raw_number' => preg_replace('/[^0-9]/', '', $num),
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                    
                }
            }
            
            $chunk_count = 500;
            if(count($data) > 0){
                $chunks = array_chunk($data, $chunk_count);
                foreach ($chunks as $chunk) {
                    $insert = SmsContact::insert($chunk);
                }
            }
            unset($data);
            unset($unique_number_array);
        }
        fclose($file1);
        unset($csv);
        unset($number_arrays);

        $successEntry = SmsContact::where('sms_contact_list_id',$this->list_id)->count();
        $failedEntry = $this->fileRows - $successEntry;
        // $failedEntry = $updatedFileRows - $successEntry;
        $updateContactList = SmsContactList::find($this->list_id);
        $updateContactList->success = $successEntry;
        $updateContactList->failed = $failedEntry;
        $updateContactList->total_contacts = $this->fileRows;
        // $updateContactList->selected_phone_column = $this->csv_header_value;
        $updateContactList->status = 'active';
        $updateContactList->job_status = 'success';
        $updateContactList->save();
    }
}
