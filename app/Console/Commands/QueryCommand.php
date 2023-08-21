<?php

namespace App\Console\Commands;

use App\Mail\CampaignFinishMail;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class QueryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'query:command';

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
        //Mark Campaigns Finished after 10 days
        $ten_days = Carbon::now()->subDays(10)->format('Y-m-d 00:00:00');
        $ten_campaigns = Campaign::Where('created_at', '<', $ten_days)->Where('status','played')->get();
        foreach ($ten_campaigns as $camp) {
            $redis_keys = DB::table('redis_keys')->Where('campaign_id','=', $camp->id)->Where('process_identifier', '')
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $key1 = Redis::mget(Redis::keys($redis_keys[0]));
            $key2 = Redis::mget(Redis::keys($redis_keys[1]));
            $key3 = Redis::mget(Redis::keys($redis_keys[2]));
            $key4 = Redis::mget(Redis::keys($redis_keys[3]));

            if ($key1 == null && $key2 == null && $key3 == null && $key4 == null) {
                $camp->status = 'finished';
                $camp->save();

                $user = User::Where('id', $camp->user_id)->first();

                Mail::to($user->email)->send(new CampaignFinishMail());
            }
        }

        //Query to delete campaign_contacts past 30 days
        $thirty_days = Carbon::now()->subDays(30)->format('Y-m-d 00:00:00');
        DB::statement("DELETE FROM campaign_contacts WHERE created_at < '".$thirty_days."';");

        //Query to delete campaign_contacts that are in pending status past 10 days
        DB::statement("DELETE FROM campaign_contacts WHERE created_at < '".$ten_days."' AND status = 'pending';");

        //Query to delete campaign Logs - Past 30 days
        DB::statement("DELETE FROM campaign_logs WHERE created_at < '".$thirty_days."';");

        //Query to migrate contacts to deletedContacts table once they've been flagged as deleted for greater than 3 days
        $three_days = Carbon::now()->subDays(3)->format('Y-m-d 00:00:00');

        DB::statement("INSERT INTO deleted_contacts
            SELECT campaign_contacts.*
            FROM campaign_contacts
            WHERE status = 'deleted'
            AND updated_at < '".$three_days."';");
    }
}
