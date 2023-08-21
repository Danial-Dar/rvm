<?php

namespace App\Nova\Metrics\Cir;

use Laravel\Nova\Metrics\Value;
use App\Models\ReputationHistory;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Http\Requests\NovaRequest;

class GoodStatusCir extends Value
{
    public $icon = 'badge-check';
    public $name = 'Good Status';

    public $helpText="Show the good number of cell-numbers monitored.";
    public $helpWidth = 250;


    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $TotalCollection = ReputationHistory::select(['company_id','reputation_score'])
        ->when(Auth::user()->role!='admin' && Auth::user()->company_id!=null, function($q){
            return $q->where('company_id', Auth::user()->company_id);
        })->get();
        $monitored_count = $TotalCollection->count();
        $good_count      = $TotalCollection->where('reputation_score',100)->count();

        return $this->result(
            ($good_count/($monitored_count?$monitored_count:1) * 100)
        )->suffix('%');

        // $fair_count      = $TotalCollection->where('reputation_score',75)->count();
        // $bad_count       = $TotalCollection->where('reputation_score',50)->count();
        // $terrible_count  = $TotalCollection->where('reputation_score',25)->count();
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
        return 'cir-good-status-cir';
    }
}
