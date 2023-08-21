<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\QaAgents;
use App\Nova\Metrics\QaAverage;
use App\Nova\Metrics\QaBadCalls;
use App\Nova\Metrics\QaFailed;
use App\Nova\Metrics\QaMinutes;
use App\Nova\Metrics\QaPending;
use App\Nova\Metrics\QaReviewed;
use Laravel\Nova\Dashboard;
use Rvm\Agentranking\Agentranking;
use Rvm\Calldetails\Calldetails;
use Rvm\Campaignperformance\Campaignperformance;
use Rvm\Coachingqueue\Coachingqueue;
use Rvm\Groupperformance\Groupperformance;
use Rvm\Scoreperformance\Scoreperformance;
use Rvm\Topmissedpoints\Topmissedpoints;

class QaReports extends Dashboard
{
    public function label(){
        return "QA Dashboard";
    }
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    
    public function cards()
    {
        return [
            new QaReviewed(),
            new QaFailed(),
            new QaBadCalls(),
            new QaAgents(),
            new QaMinutes(),
            // new QaAverage(),
            new QaPending(),
            new Agentranking(),
            // new Topmissedpoints(),
            // new Coachingqueue(),
            // new Campaignperformance(),
            // new Groupperformance(),
            new Scoreperformance(),
            new Calldetails(),
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'qa-reports';
    }

    public function tabs() {
        return [];
    }
}
