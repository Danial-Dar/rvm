<?php

namespace App\Nova\Metrics;

use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class ContactsFailedTotal extends Value
{
    public $icon = 'x';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // $query = ContactList::query();
        
        // if($request->user()->role == 'user') {
        //     $query->where('user_id', $request->user()->id);
        // }
        // $query->where('job_status','!=','success');

        // $ids = $query->pluck('id');
        // // dd($ids);
        // $contacts = Contact::WhereIn('contact_list_id', $ids);
        // return $this->count($request, $contacts);
//######---------------------------------------------------------------------
        
        if($request->user()->role == 'user') {
            return $this->sum($request, ContactList::where('user_id', $request->user()->id)->Where('type',null), 'failed');
        }
        else {
            return $this->sum($request, ContactList::Where('type',null), 'failed');
        }
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
        return 'contacts-failed-total';
    }
}
