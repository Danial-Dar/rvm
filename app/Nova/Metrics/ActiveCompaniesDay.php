<?php

namespace App\Nova\Metrics;

use App\Models\Campaign;
use App\Models\CampaignStats;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class ActiveCompaniesDay extends Value
{

    public function name()
    {
        return 'Active Companies Today ';
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

        $campaign = CampaignStats::query();
        if ($request->user()->role == 'user') {
            $campaign = $campaign->where('user_id', $request->user()->id);
        }
        $campaign = $campaign->Where('updated_at', '>=', $time)->pluck('company_id')->toArray();

        // dd($query);
        $query = Company::WhereIn('id', $campaign);

        return $this->result($query->count());
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
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'active-companies-today';
    }
}
