<?php

namespace App\Nova\Metrics;

use App\Models\Contact;
use App\Models\ContactList;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
// use Laravel\Nova\Metrics\Trend;

class ContactsTotal extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $query = Contact::query();

        if($request->user()->role == 'user') {
            $query->where('user_id', $request->user()->id);
        }
        return $this->count($request, $query);

        ///****************************************** */

        // if($request->user()->role == 'user') {
        //     return $this->sum($request, ContactList::where('user_id', $request->user()->id)->Where('type',null), 'total_contacts');
        // }
        // else {
        //     return $this->sum($request, ContactList::Where('type',null), 'total_contacts');
        // }
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
             'TODAY' => __('Today'),
             30 => __('30 Days'),
             60 => __('60 Days'),
            // 365 => __('365 Days'),

             //'MTD' => __('Month To Date'),
            // 30 => __('30 Days'),
            // 60 => __('60 Days'),
             90 => __('90 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addDays(1);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'contacts-total';
    }
}
