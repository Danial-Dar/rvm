<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Category extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('category',$value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
        'CAP = FIXED'=>'CAP = FIXED',
        'CLEC = FIXED'=>'CLEC = FIXED',
        'GENERAL = FIXED'=>'GENERAL = FIXED',
        'IC = FIXED'=>'IC = FIXED',
        'ILEC = FIXED'=>'ILEC = FIXED',
        'INTL = International'=>'INTL = International',
        'IPES = VOIP'=> 'IPES = VOIP',
        'L RESELLER'=>'L RESELLER',
        'PCS = FIXED'=>'PCS = FIXED',
        'RBOC = FIXED'=>'RBOC = FIXED',
        'ULEC = FIXED'=>'ULEC = FIXED',
        'W RESELLER = Mobile'=>'W RESELLER = Mobile',
        'WIRELESS = Mobile'=>'WIRELESS = Mobile'
    ];
    }
}
