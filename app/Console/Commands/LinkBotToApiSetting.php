<?php

namespace App\Console\Commands;

use App\Models\ApiSetting;
use App\Models\Bot;
use Illuminate\Console\Command;

class LinkBotToApiSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bots';

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
        $api_setting = ApiSetting::where('slug', 'bot')->first();

        if($api_setting != null){
            $bots = Bot::all();

            foreach ($bots as $bot) {
                $bot->api_setting_id = $api_setting->id;
                $bot->save();
            }
        }
        return 1;
    }
}
