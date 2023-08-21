<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadContactListApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user_id;
    protected $company_id;
    protected $list_id;
    protected $numbers_array;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $company_id, $list_id, $numbers_array)
    {
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->list_id = $list_id;
        $this->numbers_array = $numbers_array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['user_id'] = $this->user_id;
        $data['company_id'] = $this->company_id;
        $data['contact_list_id'] = $this->list_id;
        $data['numbers'] = $this->numbers_array;

        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://127.0.0.1:8080/api/contact-list-api/store',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),

            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
    }
}
