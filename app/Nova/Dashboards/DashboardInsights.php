<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ActiveCompaniesDay;
use App\Nova\Metrics\AvgCallDurationDay;
use App\Nova\Metrics\TotalCallBacks;
use App\Nova\Metrics\TotalCalls;
use App\Nova\Metrics\TotalCallSentOut;
use App\Nova\Metrics\TotalCallzyNumbers;
use App\Nova\Metrics\TotalCampaigns;
use App\Nova\Metrics\TotalContacts;
use App\Nova\Metrics\TotalCustomerNumbers;
use App\Nova\Metrics\TotalMoney;
use App\Nova\Metrics\TotalMoneySpentToDay;
use App\Nova\Metrics\TotalPaymentsOfToDay;
use App\Nova\Metrics\TotalRecordings;
use App\Nova\Metrics\TotalUsers;
use Heatchart\AverageCallbackDuration\AverageCallbackDuration;
use Heatmap\AverageCallback\AverageCallback;
use Heatmap\ChartOne\ChartOne;
use Heatmap\GetCallback\GetCallback;
use Laravel\Nova\Dashboard;
use Piechart\AverageCallsPerCampaign\AverageCallsPerCampaign;
use Piechart\CallsPerCampaign\CallsPerCampaign;
use Rvm\CallSentHeatmap\CallSentHeatmap;
use Rvm\CampaignRatio\CampaignRatio;
use Rvm\Campaignstats\Campaignstats;
use Rvm\Inboundcallovertime\Inboundcallovertime;
use Rvm\Ivroutboundstats\Ivroutboundstats;
use Rvm\Listspecificstats\Listspecificstats;
use Rvm\Outboundoptinheatmap\Outboundoptinheatmap;
use Rvm\Recordingspecificstats\Recordingspecificstats;
use Rvm\Statespecificstats\Statespecificstats;
use Rvm\Campaignsendrates\Campaignsendrates;
use Rvm\Companycampaigns\Companycampaigns;
use Rvm\DashboardCallBackHeatMap\DashboardCallBackHeatMap;
use Rvm\Dashboardcalloutheatmap\Dashboardcalloutheatmap;
use Rvm\Ivrdncheatmap\Ivrdncheatmap;
use Rvm\Dncheatmap\Dncheatmap;

class DashboardInsights extends Dashboard
{
    public function label(){
        return "Voice Dashboard";
    }
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        if (!request()->is('/nova-api/dashboards/main')) {
            return [
                new TotalCampaigns(),
                (new TotalUsers())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                (new TotalContacts())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                (new TotalMoney())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                /*(new TotalCalls())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),*/
                new TotalRecordings(),
                new TotalCallBacks(),
                (new TotalCallzyNumbers())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                new TotalCustomerNumbers(),
                new AvgCallDurationDay(),
                (new ActiveCompaniesDay())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                new TotalPaymentsOfToDay(),
                new TotalMoneySpentToDay(),
                new TotalCallSentOut(),

                /*(new CallsPerCampaign())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),

                (new AverageCallsPerCampaign())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),*/
                new Campaignstats(),
                new Statespecificstats(),
                new Listspecificstats(),
                new Recordingspecificstats(),
                (new Companycampaigns())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                // (new Ivrdncheatmap())->canSee(function ($request) {
                //     return $request->user()->role== "admin";
                // }),
                new Dncheatmap(),
                (new CampaignRatio())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                (new Campaignsendrates())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),
                new DashboardCallBackHeatMap(),
                (new Dashboardcalloutheatmap())->canSee(function ($request) {
                    return $request->user()->role== "admin";
                }),

            ];
        }
        return [];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'main';
    }

    public function tabs() {
        return [];
    }
}
