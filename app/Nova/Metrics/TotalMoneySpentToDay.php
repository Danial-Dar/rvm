<?php

namespace App\Nova\Metrics;

use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalMoneySpentToDay extends Value
{

    public function name()
    {
        return 'Total Money Spent Today';
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

        $amount = $balance->Where('type', '!=', 'PAYMENT')->where('created_at', '>=', $time)->sum('amount');

        return $this->result($amount * -1)->dollars();
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
        return null;
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-money-spent-to-day';
    }
}
