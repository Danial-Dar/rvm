<?php

namespace App\Console\Commands;

use SignalWire\Rest\Client;
use App\Models\SwNumber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddSwNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:sw_numbers';

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
     */
    public function handle()
    {
        $sw_token_id = config('app.sw_admin_token_id');
        $sw_project_id = config('app.sw_admin_project_id');
        $sw_space_url = config('app.sw_admin_space_url');

        Log::info('AddSwNumbers: Start');

        $client = new Client($sw_project_id, $sw_token_id, array("signalwireSpaceUrl" => $sw_space_url));
        $incomingPhoneNumbers = $client->incomingPhoneNumbers
            ->read();
//        $sw_numbers  = [];

        $cc = 0;
        foreach ($incomingPhoneNumbers as $record) {
            DB::table('sw_numbers')
                ->updateOrInsert(
                    ['phone_number' => $record->phoneNumber],
                    [
                        'friendly_name' => $record->friendlyName ?: $record->phoneNumber,
                        'area_code' => substr($record->phoneNumber, 2, 3),
                        'resource_id' => $record->sid,
                        'capabilities' => json_encode($record->capabilities),
                        'status' => 'active',
                    ]
                );
            $cc++;
        }
//        if (count($sw_numbers) > 0) {
//            DB::table('sw_numbers')->truncate();
//        }
//        DB::table('sw_numbers')->updateOrInsert($sw_numbers_attributes, $sw_numbers);
        Log::info("AddSwNumbers: End: " . $cc . " numbers inserted in db");
    }
}
