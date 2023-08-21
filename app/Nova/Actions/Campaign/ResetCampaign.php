<?php

namespace App\Nova\Actions\Campaign;

use App\Jobs\CampaignReset;
use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ResetCampaign extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $campaign = Campaign::find($model->id);
            $campaign->status = 'preprocessing';
            $campaign->reset_count = $campaign->reset_count != null ? $campaign->reset_count + 1 : 1;
            $campaign->save();
            CampaignReset::dispatchAfterResponse($campaign->id);
        }
        
        Action::message('Reset Successfully');
        
        return Action::visit('/resources/campaigns'); 
    }
    

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
