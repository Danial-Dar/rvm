<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Cir\BadStatusCir;
use App\Nova\Metrics\Cir\FailStatusCir;
use App\Nova\Metrics\Cir\GoodStatusCir;
use App\Nova\Metrics\Cir\TerribleStatusCir;
use App\Nova\Metrics\Cir\TotalNumberMonitoredCir;
use Laravel\Nova\Dashboard;
use Rvm\MonitorNumberToTimeCir\MonitorNumberToTimeCir;
use Rvm\NumberOfStatesHeatmapCir\NumberOfStatesHeatmapCir;
use Rvm\NumberToCompanyCir\NumberToCompanyCir;

class CirInsights extends Dashboard
{

    public function label(){
        return "Caller Id Dashboard";
    }
    public function name(){
        return "Caller ID Reputation Dashboard";
    }
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            //values
            new TotalNumberMonitoredCir(),
            new GoodStatusCir(),
            new FailStatusCir(),
            new BadStatusCir(),
            new TerribleStatusCir(),
            // cards
           /* (new NumberOfStatesHeatmapCir()),
            (new MonitorNumberToTimeCir()),
            (new NumberToCompanyCir()),*/

        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'cir-insights';
    }

    public function tabs() {
        return [];
    }
}
