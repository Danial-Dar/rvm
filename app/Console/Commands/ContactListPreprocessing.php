<?php

namespace App\Console\Commands;

use App\Jobs\UploadContactList;
use App\Models\ContactList;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ContactListPreprocessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contactlist:stuck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contact_lists = ContactList::Where('created_at', '>=', Carbon::now()->subHour()->format('Y-m-d H:m:s'))->Where('status', 'preprocessing')->get();
        foreach ($contact_lists as $list) {
            UploadContactList::dispatchAfterResponse($list->id, $list->fileName, $list->user_id, $list->company_id, $list->jobs, $list->total_contacts, 0, 'number');
            
        }
    }
}
