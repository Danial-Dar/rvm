<?php

namespace App\Nova\Metrics;

use App\Models\Balance;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalPaymentsOfToDay extends Value
{

    public function name()
    {
        return 'Total Payments Today';
    }
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $time = Carbon::now()->startOfDay();

        $balance = Balance::query();

        if ($request->user()->role == 'user') {
            $balance->where('user_id', $request->user()->id);
        }

        return $this->result($balance->Where('created_at', '>=', $time)->Where('type', 'PAYMENT')->sum('amount'))->dollars();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {

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
        return 'total-payments-of-to-day';
    }
}
