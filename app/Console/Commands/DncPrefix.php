<?php

namespace App\Console\Commands;

use App\Models\DNC;
use Illuminate\Console\Command;

class DncPrefix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dnc:prefix';

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
        $dncs = DNC::whereRaw('LENGTH(raw_number) = 18')->get();
        foreach ($dncs as $dnc) {
            $dnc->raw_number = substr_replace($dnc->raw_number,"",1,6);
            $dnc->number = substr_replace($dnc->number,"",0,6);
            $dnc->save();
        }
    }
}
