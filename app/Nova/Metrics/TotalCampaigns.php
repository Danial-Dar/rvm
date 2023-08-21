<?php

namespace App\Nova\Metrics;

use App\Models\Campaign;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalCampaigns extends Value
{
    public $name = "Total Active Campaigns";
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $user_id = $request->user()->id;
        $company_id = $request->user()->company_id;
        $query = Campaign::query();
        if($request->user()->hasRole('user')){
            $query->where('user_id',$user_id);
        }else if($request->user()->hasRole('company-admin')){
            $query->where('company_id',$company_id);
        }

        $query->where('status', 'played');

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
        return now()->addMinutes(10);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        if(Auth()->check()){
            return 'total-campaigns_'.Auth()->user()->id;
        }else{
            return 'total-campaigns';
        }
    }
}
