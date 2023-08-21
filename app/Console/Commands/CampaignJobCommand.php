<?php

namespace App\Console\Commands;

use App\Jobs\CampaignJob;
use Illuminate\Console\Command;
use App\Models\Campaign;
use Carbon\Carbon;

class CampaignJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:campaign';

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
        // $jobs = Campaign::where('status','preprocessing')->get()->pluck('jobs')->toArray();
        // if(count($jobs) > 0){
        //     $start_comand_str = 'php artisan ';

        //     $final_cmd = '';
    
        //     foreach ($jobs as $job) {
        //         $cmd = $start_comand_str . 'queue:work --queue='.$job;
    
        //         $final_cmd = $final_cmd. $cmd.' & ';
        //     }
    
        //     exec($final_cmd);
        // }//count jobs if end
    
        $date = Carbon::now()->format('Y-m-d');
        // dd($date);
        $campaigns = Campaign::where('status','pending')->where('start_date', '<=',$date)->get()->toArray();
        foreach($campaigns as $campaign){
            CampaignJob::dispatchAfterResponse($campaign['id']);
        }
    }
}
