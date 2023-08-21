<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\CompanySetting;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Console\Command;

class PauseUnpaidUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unpaid:user';

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
        $users = User::Where('role', 'user')->get();
        foreach ($users as $user) {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
            $credit_limit = CompanySetting::Where('company_id', $this->company_id)->Where('key','credit_limit')->first();
            if ($credit_limit->value > ($balance * -1))
            {
                $campaigns = Campaign::where('user_id', $user->id)->get();
                foreach ($campaigns as $campaign) {
                    $campaign->status = 'paused';
                    $campaign->save();
                }

                $user->removeRole('user');
                $user->assignRole('unpaid-user');
            }
        }
    }
}
