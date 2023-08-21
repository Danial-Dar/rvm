<?php

namespace App\Nova\Filters;

use App\Models\Campaign;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class CampaignSearch extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    // public $component = 'select-filter';
    public $name = 'Campaign';


    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->join('campaigns', 'incoming_call_logs.campaign_id', '=', 'campaigns.id')
                     ->where('name', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {

        $campaigns = Campaign::select('name')->distinct()->get()->pluck('name')->toArray();
        return $campaigns;
    }
}
