<?php

namespace App\Nova\Metrics;

use App\Models\Campaign;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class CampaignSendRate extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */

    public function calculate(NovaRequest $request)
    {
        $query = Campaign::query();

        if($request->user()->role == 'user') {
            $query->where('user_id', $request->user()->id);
        }
        $query = $query->selectRaw('AVG(drops_per_hour::int) as drops_per_hour')->where('status', 'played')->first();
        // return $this->sum($request, $query);
        return (new \Laravel\Nova\Metrics\ValueResult($query->drops_per_hour));
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'ALL' => __('All Time'),
            // 30 => __('30 Days'),
            // 60 => __('60 Days'),
            // 365 => __('365 Days'),
            // 'TODAY' => __('Today'),
            // 'MTD' => __('Month To Date'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'campaign-send-rate';
    }

    

    public function name()
    {
        return 'Campaigns Send rate';
    }
}
