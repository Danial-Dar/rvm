<?php

namespace App\Nova\Metrics\Cir;

use Laravel\Nova\Metrics\Value;
use App\Models\ReputationHistory;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Http\Requests\NovaRequest;

class TotalNumberMonitoredCir extends Value
{

    public $icon = 'check';
    public $name = 'Total Number Monitored';

    public $helpText="Show the total number of cell-numbers monitored.";
    public $helpWidth = 250;


    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $query=ReputationHistory::query();
        $query->select('id')
        ->when(Auth::user()->role!=='admin' && Auth::user()->company_id!==null, function($q){
            return $q->where('company_id', Auth::user()->company_id);
        });
        return $this->result($query->count());
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            // 30 => __('30 Days'),
            // 60 => __('60 Days'),
            // 365 => __('365 Days'),
            // 'TODAY' => __('Today'),
            // 'MTD' => __('Month To Date'),
            // 'QTD' => __('Quarter To Date'),
            // 'YTD' => __('Year To Date'),
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
        return 'cir-total-number-monitored-cir';
    }
}
