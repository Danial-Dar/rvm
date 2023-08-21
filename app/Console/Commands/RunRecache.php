<?php

namespace App\Console\Commands;

use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class RunRecache extends Command
{
    protected $baseUrl;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:recache';

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
        $this->baseUrl = "https://go-redisapi.voslogic.com";
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try{
            $response = Http::get($this->baseUrl."/api/recache");

            if(!$response->successful()){
                $response->throw();
            }
            Log::error("Successfully api hit");
        }
        catch(Throwable $e){
            report($e);
        }
    }
}
