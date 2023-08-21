<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Campaign;
use Illuminate\Console\Command;

class PauseCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pause:campaign';

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
        $now = Carbon::now()->format('H:i:00');

        if($now == '20:00:00') {
            $campaigns = Campaign::where('status','played')->get();

            foreach($campaigns as $campaign) {
                $campaign->status = 'paused';
                $campaign->save();
            }
        }
    }
}
