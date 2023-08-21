<?php

namespace App\Nova\Metrics;

use App\Models\MyNumber;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalCustomerNumbers extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */

    public function name()
    {
        return 'Total Numbers';
    }

    public function calculate(NovaRequest $request)
    {
        $query = MyNumber::query();

        if($request->user()->role == 'user') {
            $query->where('user_id', $request->user()->id);
        }

        return $this->count($request, $query);
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
        return now()->addMinutes(10);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return request()->user()->id.'total-customer-numbers';
    }
}
