<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\CompanySetting;
use App\Models\IncomingCallLog;
use App\Models\NovaSetting;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignStats;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:balance';

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
        ini_set('memory_limit', '-1');
        $start_date = Carbon::now()->subMinutes(5)->toDateTimeString();
        $end_date = Carbon::now()->toDateTimeString();

        $ivr_users = IncomingCallLog::where('is_billed', false)->where('campaign_id', 0)->get()->unique('user_id')->pluck('user_id');

        if(count($ivr_users) > 0) {
            foreach ($ivr_users as $user_id) {
                $user = User::find($user_id);
                    if($user){
                    if($user->company_id !== null)
                    {
            
                        
                        $rvm = IncomingCallLog::where('user_id', $user_id)->where('campaign_id', 0)->where('is_billed', false);
        
                        $rvm_duration = clone $rvm;
                        $rvm_call_price = clone $rvm;
                        $rvm_call_price = $rvm_call_price->sum('call_price');
                        $rvm_duration = $rvm_duration->sum('duration');

                        if ($rvm_call_price > 0) {

                            $balance = new Balance;
                            $balance->user_id = $user_id;
                            $balance->company_id = $user->company_id;
                            $minutes = $rvm_duration / 60;
                            $balance->minutes = number_format((float)$minutes, 2, '.', '');
                            $balance->description = 'Incoming;start date: ' . $start_date . '; end date: ' . $end_date . '; rate:'.(float)$rvm_call_price;
                            $amount = $rvm_call_price * -1;
                            $balance->amount =  number_format((float)$amount, 2, '.', '');
                            $balance->type = 'INCOMING';
                            // $balance->start_id = $start_id;
                            // $balance->end_id = $end_id;
                            $balance->save();


                            $rvm->update([
                                'is_billed' => true
                            ]);

                            $balance = Balance::where('company_id', $user->company_id)->sum('amount');
                            $credit_limit = CompanySetting::Where('company_id', $user->company_id)->Where('key','credit_limit')->first();

                            if($credit_limit) {
                                if ($credit_limit->value < ($balance * -1))
                                {
                                    $user->removeRole('unpaid-user');
                                    $user->assignRole('user');
                                }
                            }
                        }//rvm duration end

                    }
                }
            }
        }
        $campaigns = IncomingCallLog::where('is_billed', false)->where('campaign_id','!=' ,null)->get()->unique('campaign_id')->pluck('campaign_id');
        //$field = NovaSetting::first() !== null ?? json_decode(NovaSetting::first()->fields, 1);
        // \Log::info('----------BALANCE CRON -> GET INCOMING CALL LOG IS BILLED FALSE ------------',[$campaigns]);

        
        if (count($campaigns) > 0) {
            foreach ($campaigns as $campaign_id) {
                $campaign = Campaign::find($campaign_id);
                if($campaign){
                    $user_id = $campaign->user_id;
                    $user = User::find($user_id);
                    if($user) {
                    if($user->company_id !== null)
                    {
            
                        
                        $rvm = IncomingCallLog::where('campaign_id', $campaign->id)->where('user_id', $user_id)->where('is_billed', false)->whereNull('type');
        
                        $rvm_duration = clone $rvm;
                        $rvm_call_price = clone $rvm;
                        $rvm_call_price = $rvm_call_price->sum('call_price');
                        $rvm_duration = $rvm_duration->sum('duration');

                        if ($rvm_call_price > 0) {

                            $balance = new Balance;
                            $balance->user_id = $user_id;
                            $balance->company_id = $user->company_id;
                            $minutes = $rvm_duration / 60;
                            $balance->minutes = number_format((float)$minutes, 2, '.', '');
                            $balance->description = 'Incoming;start date: ' . $start_date . '; end date: ' . $end_date . '; rate:'.(float)$rvm_call_price;
                            $amount = $rvm_call_price * -1;
                            $balance->amount =  number_format((float)$amount, 2, '.', '');
                            $balance->type = 'INCOMING';
                            $balance->campaign_id = $campaign->id;
                            // $balance->start_id = $start_id;
                            // $balance->end_id = $end_id;
                            $balance->save();

    
                            $rvm->update([
                                'is_billed' => true
                            ]);

                            $balance = Balance::where('company_id', $user->company_id)->sum('amount');
                            $credit_limit = CompanySetting::Where('company_id', $user->company_id)->Where('key','credit_limit')->first();

                            if($credit_limit) {
                                if ($credit_limit->value < ($balance * -1))
                                {
                                    $user->removeRole('unpaid-user');
                                    $user->assignRole('user');
                                }
                            }
                        }//rvm duration end

                    }//if company exists end
                    }
                }//campaign exits end
                
                
            }//foreach end
        }



        $campaign_stats = CampaignStats::whereRaw('campaign_stats.prev_price_sum <> campaign_stats.price_sum')->get();

        foreach ($campaign_stats as $campaign_stat) {
            if(trim($campaign_stat->price_sum) !== '' && $campaign_stat->price_sum !== null) {
                $user = User::find($campaign_stat->user_id);
                $balance = new Balance;
                $balance->user_id = $user->id;
                $balance->company_id = $user->company_id;
                $campaign = Campaign::find($campaign_stat->campaign_id);
                // $minutes = $rvm_duration / 60;
                // $balance->minutes = number_format((float)$minutes, 2, '.', '');
                if($campaign) {
                    $amount = -1 * ((float)( $campaign_stat->price_sum - $campaign_stat->prev_price_sum));
                    $balance->description = 'Campaign stats price:'.$amount.';CampaignId:'.$campaign->id;
                    $balance->amount =  number_format((float)$amount, 2, '.', '');
                    $balance->type = $campaign->campaign_type == 'press-1'? 'PRESS-1': 'RVM';
                    $balance->campaign_id = $campaign->id;
                    // $balance->start_id = $start_id;
                    // $balance->end_id = $end_id;
                    $balance->save();

                    $campaign_stat->prev_price_sum =(float) $campaign_stat->price_sum;
                    $campaign_stat->save();
                }
            }
        }
    }
}
