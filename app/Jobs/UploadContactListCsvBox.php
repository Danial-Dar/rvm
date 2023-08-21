<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadContactListCsvBox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $list_id;
    protected $user_id;
    protected $company_id;
    protected $params;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id, $user_id, $company_id, $params)
    {
        $this->list_id = $list_id;
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->params as $row) {
            $data = $row['row_data'];
            $data['user_id'] = $this->user_id;
            $data['company_id'] = $this->company_id;
            $data['contact_list_id'] = $this->list_id;
            $data['raw_number'] = formatNumber($data['number']);
            $data['number'] = preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $data['number']);
            $data['status'] = 'active';
            $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            $contacts[] = $data;
        }
        $list = ContactList::withTrashed()->Find($this->list_id)->restore();

        $cont_list = ContactList::Find($this->list_id);
        $cont_list->status = 'active';
        $cont_list->save();


        if (count($contacts) > 0) {
            Contact::insert($contacts);
        }
    }
}
