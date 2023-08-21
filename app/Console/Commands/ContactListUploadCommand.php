<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactList;

class ContactListUploadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exec:uploadcontact {contact_list_id}';

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
        // return 0;
        $contact_list_id = $this->argument('contact_list_id');
        $contact_list = ContactList::find($contact_list_id);
        $jobs = $contact_list->jobs;
        $start_comand_str = 'php artisan ';

        $final_cmd = '';

        $cmd = $start_comand_str . 'queue:work --queue='.$jobs;

        // $final_cmd = $final_cmd. $cmd.' & ';
        // foreach ($jobs as $job) {
        //     //php artisan queue:work --queue=myJobQueue &
        //     $cmd = $start_comand_str . 'queue:work --queue='.$job;

        //     $final_cmd = $final_cmd. $cmd.' & ';
        // }

        // dd($final_cmd);


        // for ($i = 1; $i<=10; $i++){
        //     $cmd = $start_comand_str . 'migrate:rollback --step='.$i;

        //     $final_cmd = $final_cmd. $cmd.' & ';
        // }
        exec($cmd);
    }
}
