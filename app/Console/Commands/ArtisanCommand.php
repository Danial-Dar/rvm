<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ArtisanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exec:command {camp_id}';

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
        $camp_id = $this->argument('camp_id');
        $campaign = Campaign::find($camp_id);
        $jobs = json_decode($campaign->jobs);
        $start_comand_str = 'php artisan ';

        $final_cmd = '';

        foreach ($jobs as $job) {
            //php artisan queue:work --queue=myJobQueue &
            $cmd = $start_comand_str . 'queue:work --queue='.$job;

            $final_cmd = $final_cmd. $cmd.' & ';
        }

        // dd($final_cmd);


        // for ($i = 1; $i<=10; $i++){
        //     $cmd = $start_comand_str . 'migrate:rollback --step='.$i;

        //     $final_cmd = $final_cmd. $cmd.' & ';
        // }
        exec($final_cmd);
        // dd($camp_id);
        // Artisan::call('queue:work --queue='.$this->queue_name);
    }
}
