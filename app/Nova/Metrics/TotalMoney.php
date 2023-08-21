<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use App\Models\Balance;
use Laravel\Nova\Metrics\Value;

class TotalMoney extends Value
{
    public $name = "Total Money Spent";
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {

        //$time = Carbon::now()->startOfDay();
        $balance = Balance::query();

        if ($request->user()->role == 'user') {
            $balance->where('user_id', $request->user()->id);
        }

         $balance->Where('type', '!=', 'PAYMENT')/*->sum('amount')*/;

        //return $this->result($amount * -1)->dollars();

         return $this->sum($request, $balance,'amount')->dollars();
        //return $this->countByMonths($request, User::class);
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
            30 => __('30 Days'),
            60 => __('60 Days'),
            365 => __('365 Days'),
            'TODAY' => __('Today'),
            'MTD' => __('Month To Date'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(60);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-money';
    }
}
