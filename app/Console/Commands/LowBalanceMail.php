<?php

namespace App\Console\Commands;

use App\Mail\LowBalanceMail as MailLowBalanceMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LowBalanceMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'low:balance';

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
        $users = User::Where('low_balance_check', false)->first();

        foreach ($users as $user)
        {
            if ($user->balance << -1000) {
                Mail::to($user->email)->send(new MailLowBalanceMail());
                $user->low_balance_check = true;
                $user->save();
            }
        }
    }
}
