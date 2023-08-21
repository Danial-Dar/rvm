<?php

namespace App\Nova;

use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Unroutable extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\IncomingCallLog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
    
        $status = $this->CallStatus;
        return [
            ID::make()->sortable(),
            Text::make('Company', 'company_id',function(){
                return $this->company ? $this->company->name : 'N/A';
            })->sortable(),
            BelongsTo::make('Campaign')->sortable(),
            Text::make('Type', 'type',function(){
                return $this->campaign ? $this->campaign->campaign_type : 'N/A';
            })->sortable(),
            // Text::make('Call Status', 'duration',function(){
            //     return $-->CallStatus=='queued'?
            //     'In Call'
            //     :  'N/A';
            // })->asHtml()->sortable(),
            Badge::make('Call Status', function() {
                if ($this->duration !== null && $this->duration > 0) {
                    $value = 'Completed';
                }else {
                    $value = 'In Call';
                }
                return $value;
            })->map([
                 'Completed' => 'success',
                 'In Call' => 'danger',
            ])->onlyOnIndex(),
            Text::make('Duration', function() {
                  return gmdate("H:i:s", ($this->duration !== null) ? $this->duration : 0);
            })->asHtml()->sortable(),
            Text::make('From Number','From')->sortable()->filterable(),
            Text::make('Forwarded To Number','To')->sortable()->filterable(),
            // PhoneNumber::make('Forward to number', 'forward_to'),
            Text::make('Call Start', function () {
                try{
                    $inc = IncomingCallLog::find($this->id);
                return Carbon::createFromFormat('Y-m-d H:i:s', date($inc->created_at))->format('m/d/Y H:i:s a');
                }
                catch(Exception $e){
                    return 'n/a';
                }
            }),
            Date::make('Created At')->hideFromIndex()
            // Text::make('To','To')->sortable(),
            // Text::make('User', 'user_id',function(){
            //     return $this->user ? $this->user->first_name.' '. $this->user->last_name: 'N/A';
            // })->sortable(),
            
            
            
        ];
    
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new Filters\Date,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('company_id', null);
    }
}
