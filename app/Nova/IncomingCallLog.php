<?php

namespace App\Nova;

use App\Models\IncomingCallLog as ModelsIncomingCallLog;
use App\Nova\Filters\CampaignSearch;
use App\Nova\Filters\CompanySearch;
use App\Nova\Metrics\AvgTalktime;
use App\Nova\Metrics\TotalIncomingCall;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
// use YieldStudio\NovaPhoneField\PhoneNumber;

class IncomingCallLog extends Resource
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
    public static $title = 'From';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','From','To','campaign.name'
    ];

    public static $group = 'Voice';

    public static function label() {
        return 'Incoming Call Log';
    }

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
            BelongsTo::make('Campaign')->sortable()->filterable(),
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
                    $inc = ModelsIncomingCallLog::find($this->id);
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
        return [
            new TotalIncomingCall,
            new AvgTalktime(),
        ];
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
            new Filters\CampaignType,
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
        return [
            ExportAsCsv::make()->withFormat(function ($model) {
                // $duration = $model->duration !== null ? $model->duration : 0;
                // $dt = Carbon::now()->addSecond($duration);
                // $minutes = $dt->diffInMinutes($dt_old);
                return [
                    'ID' => $model->getKey(),
                    'Company' => $model->company != null ? $model->company->name : 'N/A',
                    'Campaign' => $model->campaign != null ? $model->campaign->name : 'N/A',
                    'Type' => $model->campaign != null ? $model->campaign->campaign_type : 'N/A',
                    'Call Status' => $model->CallStatus,
                    'Duration' => $model->duration,
                    'From' => $model->From,
                    'Call Start' => Carbon::createFromFormat('Y-m-d H:i:s', date($model->created_at))->format('m/d/Y H:i:s a')
                ];
            }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == "company") {
            return $query->where('company_id', $request->user()->company_id);
        }
        if ($request->user()->role == "user") {
            return $query->where('incoming_call_logs.user_id', $request->user()->id);
        }
        return $query->where('company_id', '!=' , null);
    }
}
