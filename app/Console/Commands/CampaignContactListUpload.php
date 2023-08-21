<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactList;
use App\Models\Contact;
use App\Models\CampaignContact;
use App\Models\CampaignList;
use App\Models\Campaign;

class CampaignContactListUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exec:campaignuploadcontact';
    // protected $signature = 'exec:campaignuploadcontact {contact_list_id}';

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
        // ----------------- old command --------------
        // $contact_list_id = $this->argument('contact_list_id');
        // $contact_list = ContactList::find($contact_list_id);
        // $jobs = $contact_list->jobs;
        // $start_comand_str = 'php artisan ';

        // $final_cmd = '';

        // $cmd = $start_comand_str . 'queue:work --queue='.$jobs;
        
        // exec($cmd);

        // --------------------- updated command ----------------
        $jobs = Campaign::where('status','preprocessing')->get()->pluck('jobs')->toArray();
        // $jobs = json_decode($campaign->jobs);
        if(count($jobs) > 0){
            $start_comand_str = 'php artisan ';

            $final_cmd = '';
    
            foreach ($jobs as $job) {
                //php artisan queue:work --queue=myJobQueue &
                $cmd = $start_comand_str . 'queue:work --queue='.$job;
    
                $final_cmd = $final_cmd. $cmd.' & ';
            }
    
            exec($final_cmd);
        }
       
    }
}
