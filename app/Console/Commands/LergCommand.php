<?php

namespace App\Console\Commands;

use App\Jobs\LergJob;
use App\Models\Contact;
use App\Models\Lerg;
use Illuminate\Console\Command;

class LergCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:lerge';

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
        // $lerg = Lerg::take(10)->get();
        // $lerg = Lerg::get();
        // $chunks = $lerg->chunk(5);
        // dd($chunks[0]);

        Lerg::chunk(500, function ($lergs) {
            foreach ($lergs as $lerg) {
                dispatch(new LergJob($lerg));
            }

        });
    }
}
