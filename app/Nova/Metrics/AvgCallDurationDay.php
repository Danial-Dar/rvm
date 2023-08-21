<?php

namespace App\Nova\Metrics;

use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class AvgCallDurationDay extends Value
{

    public function name()
    {
        return 'Avg Call Duration';
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

        $query = IncomingCallLog::query();

        if ($request->user()->role == 'user') {
            $query->where('user_id', $request->user()->id);
        }

        $average = $query->Where('created_at', '>=', $time)->average('duration');

        return $this->result(\number_format($average,2))->suffix('seconds');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [

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
        return 'avg-call-duration-day';
    }
}
