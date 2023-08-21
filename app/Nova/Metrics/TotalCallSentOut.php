<?php

namespace App\Nova\Metrics;

use App\Models\CampaignContact;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalCallSentOut extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */

    public function name()
    {
        return 'Total Calls Sent';
    }

    public function calculate(NovaRequest $request)
    {
        $time = Carbon::now()->startOfDay();
        $query = CampaignContact::query();

        if($request->user()->role == 'user') {
            $query->where('user_id', $request->user()->id);
        }

        $calls_count = $query->where('status', 'initiated')->where('updated_at', '>=', $time)->count();


        return $this->result($calls_count);
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
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return null;
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return request()->user()->id.'total-call-sent-out';
    }
}
