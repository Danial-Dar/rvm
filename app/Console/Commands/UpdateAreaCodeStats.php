<?php

namespace App\Console\Commands;

use App\Models\AreaCodeLocation;
use App\Models\StateSpecifcStats;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateAreaCodeStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:area_code_stats';

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
        $currentDate = Carbon::now();
        $date = $currentDate->subDays('14')->format('Y-m-d H:i:s');


        $area_code_locations = AreaCodeLocation::all();
        foreach ($area_code_locations as $acl) {
            $campaign_contacts_count_total = DB::table('campaign_contacts')
                                        ->whereRaw(DB::raw('TRIM(SUBSTRING(campaign_contacts."number", 3, 3)) = \''.$acl->area_code.'\''))
                                        ->where('campaign_contacts.created_at', '>=', $date)
                                        ->count();

            $incoming_call_logs_count_total = DB::table('incoming_call_logs')
                                        ->whereRaw(DB::raw('TRIM(SUBSTRING(incoming_call_logs."From", 3, 3)) = \''.$acl->area_code.'\''))
                                        ->where('incoming_call_logs.created_at', '>=', $date)
                                        ->count();

            $ivr_call_logs_count_total = DB::table('ivr_incoming_call_logs')
                                    ->whereRaw(DB::raw('TRIM(SUBSTRING(ivr_incoming_call_logs."from_number", 3, 3)) = \''.$acl->area_code.'\''))
                                    ->where('ivr_incoming_call_logs.created_at', '>=', $date)
                                    ->count();                            
            $dnc_count_total = DB::table('dnc')
                            ->whereRaw(DB::raw('TRIM(SUBSTRING(dnc."number", 3, 3)) = \''.$acl->area_code.'\''))
                            ->count();     
            $user_stat = StateSpecifcStats::where('user_id', null)->where('area_code', $acl->area_code)->first();
            
            if(!$user_stat) {
                $user_stat = new StateSpecifcStats();
            }
            
            $user_stat->area_code = $acl->area_code;
            $user_stat->location_code = $acl->location_code;
            $user_stat->incoming_call_log_count = $incoming_call_logs_count_total;
            $user_stat->ivr_call_log_count = $ivr_call_logs_count_total;
            $user_stat->campaign_contact_count = $campaign_contacts_count_total;
            $user_stat->dnc_count = $dnc_count_total;

            $user_stat->save();                   
            
            $users = User::Where('role', 'user')->get();

            foreach ($users as $user) {
                $user_campaign_contacts_count = DB::table('campaign_contacts')
                                                ->whereRaw(DB::raw('TRIM(SUBSTRING(campaign_contacts."number", 3, 3)) = \''.$acl->area_code.'\''))
                                                ->where('campaign_contacts.created_at', '>=', $date)
                                                ->where('campaign_contacts.user_id', $user->id)
                                                ->count();

                $user_incoming_call_logs_count = DB::table('incoming_call_logs')
                                                ->whereRaw(DB::raw('TRIM(SUBSTRING(incoming_call_logs."From", 3, 3)) = \''.$acl->area_code.'\''))
                                                ->where('incoming_call_logs.created_at', '>=', $date)
                                                ->where('incoming_call_logs.user_id', $user->id)
                                                ->count();
        
                $user_ivr_call_logs_count = DB::table('ivr_incoming_call_logs')
                                            ->join('campaign_contacts', 'campaign_contacts.id', '=', 'ivr_incoming_call_logs.campaign_contact_id')
                                            ->where('campaign_contacts.user_id', '=', $user->id)
                                            ->whereRaw(DB::raw('TRIM(SUBSTRING(ivr_incoming_call_logs."from_number", 3, 3)) = \''.$acl->area_code.'\''))
                                            ->where('ivr_incoming_call_logs.created_at', '>=', $date)
                                            ->count();                            
                $user_dnc_count = DB::table('dnc')
                                    ->whereRaw(DB::raw('TRIM(SUBSTRING(dnc."number", 3, 3)) = \''.$acl->area_code.'\''))
                                    ->where('dnc.user_id', $user->id)
                                    ->count();  

                $user_stat = StateSpecifcStats::where('user_id', $user->id)->where('area_code', $acl->area_code)->first();

                if(!$user_stat) {
                    $user_stat = new StateSpecifcStats();
                }
                $user_stat->user_id = $user->id;
                $user_stat->company_id = $user->company_id;
                $user_stat->area_code = $acl->area_code;
                $user_stat->location_code = $acl->location_code;
                $user_stat->incoming_call_log_count = $user_incoming_call_logs_count;
                $user_stat->ivr_call_log_count = $user_ivr_call_logs_count;
                $user_stat->campaign_contact_count = $user_campaign_contacts_count;
                $user_stat->dnc_count = $user_dnc_count;
                $user_stat->save();
            }

            
        }
        
        
    }
}
