<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CampaignUploadExistingContactList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exec:campaignuploadexistingcontact {contact_list_id}';

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
        // return Command::SUCCESS;
        $contact_list_id = $this->argument('contact_list_id');
        $contact_list = ContactList::find($contact_list_id);
        $jobs = $contact_list->jobs;
        $start_comand_str = 'php artisan ';

        $final_cmd = '';

        $cmd = $start_comand_str . 'queue:work --queue='.$jobs;
        
        exec($cmd);
    }
}
