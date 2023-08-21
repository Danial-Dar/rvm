<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\Company;
use App\Models\CompanyCampaign as ModelsCompanyCampaign;
use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CompanyCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:campaign';

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
        $date = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');

        $companies = CampaignContact::Where('updated_at', '>=', $date)->Where('status', 'initiated')->distinct()->pluck('company_id');

        // dd(count($companies));

        foreach ($companies as $value) {
            $campaign_count = Campaign::Where('company_id', $value)->where('updated_at', '>=', $date)->count();
            $call_sent_count = CampaignContact::Where('company_id', $value)->Where('updated_at', '>=', $date)->Where('status','initiated')->count();
            $total_call_backs = IncomingCallLog::Where('company_id', $value)->Where('updated_at', '>=', $date)->count();
            $total_money_spent = Balance::Where('company_id', $value)->Where('type', 'PAYMENT')->Where('created_at', '>=', $date)->count();
            $total_payments_made = Balance::Where('company_id', $value)->Where('type', '!=', 'PAYMENT')->Where('created_at', '>=', $date)->count();

            $entry = ModelsCompanyCampaign::Where('company_id', $value)->first();

            if ($entry) {
                $entry->delete();
            }

            $company_campaign = new ModelsCompanyCampaign();
            $company_campaign->company_id = $value;
            $company_campaign->campaign_count = $campaign_count;
            $company_campaign->call_sent_count = $call_sent_count;
            $company_campaign->total_call_backs = $total_call_backs;
            $company_campaign->total_money_spent = $total_money_spent;
            $company_campaign->total_payments_made = $total_payments_made;
            $company_campaign->save();
        }
    }
}
