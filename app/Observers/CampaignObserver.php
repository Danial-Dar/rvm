<?php

namespace App\Observers;

use App\Jobs\CampaignJob;
use App\Jobs\CampaignReset;
use App\Jobs\CampaignUpdateJob;
use App\Models\Campaign;
use Carbon\Carbon;

class CampaignObserver
{
    /**
     * Handle the Campaign "created" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function created(Campaign $campaign)
    {
        // $campaign->status = 'played';
        if(Carbon::parse($campaign->start_date)->format('m/d/Y') == Carbon::now()->format('m/d/Y')) {
            CampaignReset::dispatchAfterResponse($campaign->id);//
            // $campaign->status = 'played';
        }else{
            $campaign->status = 'pending';
            $campaign->save();
        
        }
        //
    }

    /**
     * Handle the Campaign "updated" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function updated(Campaign $campaign)
    {
        // $campaign->status = 'played';
        // $campaign->save();
        // CampaignUpdateJob::dispatchAfterResponse($campaign);//
        //
    }

    /**
     * Handle the Campaign "deleted" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function deleted(Campaign $campaign)
    {
        //
    }

    /**
     * Handle the Campaign "restored" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function restored(Campaign $campaign)
    {
        //
    }

    /**
     * Handle the Campaign "force deleted" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function forceDeleted(Campaign $campaign)
    {
        //
    }
}
