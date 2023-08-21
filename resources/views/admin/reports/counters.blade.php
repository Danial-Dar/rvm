@extends('layouts.app')
@section('content')
    <style>

        .flex {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }

        @media (max-width:991.98px) {
            .padding {
                padding: 1.5rem
            }
        }

        @media (max-width:767.98px) {
            .padding {
                padding: 1rem
            }
        }

        .padding {
            padding: 5rem
        }

        .card {
            background: #fff;
            border-width: 0;
            border-radius: .25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
            margin-bottom: 1.5rem
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(19, 24, 44, .125);
            border-radius: .25rem
        }

        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(19, 24, 44, .03);
            border-bottom: 1px solid rgba(19, 24, 44, .125)
        }

        .card-header:first-child {
            border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0
        }

        card-footer,
        .card-header {
            background-color: transparent;
            border-color: rgba(160, 175, 185, .15);
            background-clip: padding-box
        }
        /* .loader
        {
           display: none;
           width:200px;
           height: 200px;
           position: fixed;
           top: 60%;
           left: 50%;
           text-align:center;
           margin-left: -50px;
           margin-top: -100px;
           z-index:2;
           overflow: auto;

        } */
        .heat_map {
            width: 100%;
            height: 500px;
        }
    </style>

    <div class="contents">
        <div class="crm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mb-20">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title">Callzy Dashboard</h4>
                        </div>

                    </div>
                </div>{{-- heading end --}}
            </div>{{-- container fluid end --}}

            {{-- filter card start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Filter By </h1>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-4 mb-20">
                            <input type="text" name="datetimes" class="form-control" id="dateRange" onchange="fetchReportData()" />
                        </div>
                        <div class="col-lg-4 mb-20">
                            <select name="camapign_select" id="camapign_select" class="form-control" onchange="fetchReportData()">
                                <option value="" Selected> Choose campaigns</option>
                                @foreach($campaigns as $campaign)
                                    <option value="{{$campaign->id}}">{{$campaign->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 mb-20">
                            <select name="list_select" id="list_select" class="form-control" onchange="fetchReportData()">
                                <option value="" Selected> Choose Lists</option>
                                @foreach($contactLists as $list)
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            {{-- filter card end --}}
            {{-- counter card start --}}
            <div class="row">
                <div class="col-lg-12">
                    {{-- loader start --}}
                    <div class="loader" id="reportLoader" style="text-align:center;position:absolute;top:11rem;left:50rem;z-index:2">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    {{-- loader end --}}
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="total_pending">0</h1>
                                <p>Total Pending</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="total_sent">0</h1>
                                <p>Total Sent</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="total_recordings">0</h1>
                                <p>Total Recordings</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="total_contact_lists">0</h1>
                                <p>Total Contact Lists</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="total_contacts">0</h1>
                                <p>Total Contacts</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="inbound_calls_per_second">0</h1>
                                <p>Inbound Calls Per Second</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="outgoing_calls_per_second">0</h1>
                                <p>Outgoing Calls Per Second</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-sm-3 mb-30">
                    <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                        <div>
                            <div class="overview-content">
                                <h1 id="total_money_spent">$0</h1>
                                <p>Total Money Spent</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- counter card end --}}

            {{-- send rates per hour start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Send Rates through the day </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sendRatesPerDayLoader" id="" style="display:none;position:relative;top:12rem">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="sendRatesPerDay"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- send rates per  hour end --}}

            {{-- no of calls per campaign pie chart start --}}
            <div class="row">
                <div class="col-md-12" id="canvasOne">
                    <div class="card">
                        <div class="card-header">
                            <h1>No Of Calls Per Campaign </h1>
                        </div>
                        <div class="card-body">
                            <div class="noOfCallsPerCampaignLoader" id="" style="display:none;position:relative;top:10rem;z-index:1">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="noOfCallsPerCampaignPieChart"></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12" id="canvasTwo">
                    <div class="card">
                        <div class="card-header">
                            <h1>Average Call Duration Per Campaign </h1>
                        </div>
                        <div class="card-body">
                            <div class="averageCallDurationPerCampaignLoader" id="" style="display:none;position:relative;top:10rem;z-index:1">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="averageCallDurationPerCampaignPieChart"></div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- no of calls per campaign pie chart end --}}
            {{-- Callback duration heatmap card start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Average Callback Duration Heat Map </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <div class="callbackDurationHeatMapLoader" id="" style="display:none;position:relative;top:12rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="callbackDurationHeatMap"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Callback duration heatmap card end --}}

            {{-- callback heatmap card start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Callback Heat Map </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <div class="callbackHeatMapLoader" id="" style="display:none;position:relative;top:12rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="callbackHeatMap"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- callback heatmap card end --}}

            {{-- callback sent to destination heatmap card start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Call Sent To Destination Heat Map</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <div class="callSentToDestionationLoader" id="" style="display:none;position:relative;top:12rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="callSentToDestionation"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- callback sent to destination heatmap card end --}}
            {{-- campaign specific stats table & list specific table start --}}
            <div class="row">
                <div class="col-md-6" id="canvasOne">
                    <div class="card">
                        <div class="card-header">
                            <h1>Campaign Specific Stats </h1>
                        </div>
                        <div class="card-body">
                            <div class="campaignSpecificStatsLoader" id="" style="display:none;position:relative;top:5rem">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="campaignSpecificStatsTableDiv">
                                <table id="campaignSpecificStatsTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Campaign Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Call Duration</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Callback (%)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title"># Of Callbacks</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6" id="canvasTwo">
                    <div class="card">
                        <div class="card-header">
                            <h1>List Specific Stats</h1>
                        </div>
                        <div class="card-body">
                            <div class="listSpecificStatsLoader" id="" style="display:none;position:relative;top:5rem">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="listSpecificStatsTableDiv">
                                <table id="listSpecificStatsTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">List Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Call Duration</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Callback (%)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title"># Of Callbacks</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            {{-- campaign specific stats table & list specific table end --}}
            {{-- recording specific stats table & stat specific table start --}}
            <div class="row">
                <div class="col-md-6" id="canvasOne">
                    <div class="card">
                        <div class="card-header">
                            <h1>Recording Specific Stats </h1>
                        </div>
                        <div class="card-body">
                            <div class="recordingSpecificStatsLoader" id="" style="display:none;position:relative;top:5rem">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="recordingSpecificStatsTableDiv">
                                <table id="recordingSpecificStatsTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Recording</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Call Duration</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Callback (%)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title"># Of Callbacks</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h1>Campagin Ratio Pie Chart</h1>
                        </div>
                        <div class="card-body">
                            <div class="campaignRatioLoader" id="" style="display:none;position:relative;top:5rem">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="campaignRatioPieChart" class="chartjs-render-monitor" style="display: block;"></canvas>


                        </div>
                    </div>

                </div>
            </div>
            {{-- recording specific stats table & campaign ratio end --}}
            {{-- camapgin send rates linechart card start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Campaign Send Rates </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <div class="campaignSendRatesLineChartLoader" id="" style="display:none;position:relative;top:10rem;z-index:1">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="heat_map" id="line-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- camapgin send rates linechart card end --}}
            {{-- camapgin send rates linechart card start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Inbound Call Overtime</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <div class="inboundCallLineChartLoader" id="" style="display:none;position:relative;top:10rem;z-index:1">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="line-chart-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- camapgin send rates linechart card end --}}
            {{-- ivr outbound stats start --}}
            <div class="card">
                <div class="card-header">
                    <h1>IVR Outbound Stats</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ivrOutboundCallStatsLoader" id="" style="display:none;position:relative;top:5rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="ivrOutboundStatsTableDiv">
                                <table id="ivrOutboundStatsTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Campaign Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Optin</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Optout</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Noinput</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Optin (%)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Optout (%)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Noinput (%)</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ivr outbound stats end --}}
            {{-- outbound stats start --}}
            <div class="card">
                <div class="card-header">
                    <h1>Outbound Optin Heatmap</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="outboundOptinHeatmapLoader" id="" style="display:none;position:relative;top:10rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="outboundOptinHeatmap"></div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- ivr outbound stats end --}}
            {{-- ivr dnc heatmap start --}}
            <div class="card">
                <div class="card-header">
                    <h1>IVR DNC Heatmap</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ivrDncHeatmapLoader" id="" style="display:none;position:relative;top:10rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="ivrDncHeatmap"></div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- ivr outbound stats end --}}
            {{-- dnc heatmap start --}}
            <div class="card">
                <div class="card-header">
                    <h1>DNC Heatmap</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dncHeatmapLoader" id="" style="display:none;position:relative;top:10rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="heat_map" id="dncHeatmap"></div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- dnc heatmap end --}}
            {{-- state stats start --}}
            <div class="row">
                <div class="col-md-12" id="canvasTwo">
                    <div class="card">
                        <div class="card-header">
                            <h1>State Specific Stats</h1>
                        </div>
                        <div class="card-body">
                            <div class="stateSpecificStatsLoader" id="" style="display:none;position:relative;top:5rem;z-index: 1;">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="stateSpecificStatsTableDiv">
                                <table id="stateSpecificStatsTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Campaign Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Call Duration</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Average Callback (%)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title"># Of Callbacks</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- state state end --}}

        </div>{{-- crm div end --}}
    </div>{{-- content div end --}}

    @if(auth()->user()->role =="user")
        <input type="hidden" id="getReportCounterDataURL" value="{{route('user.reports.counters')}}"/>
        <input type="hidden" id="getReportSendRatesPerDayDataURL" value="{{route('user.reports.get_send_rates_per_day')}}"/>
        <input type="hidden" id="getReportCallbackPieChartDataURL" value="{{route('user.reports.get_callback_pie')}}"/>
        <input type="hidden" id="getReportCallbackDurationHeatMapDataURL" value="{{route('user.reports.get_call_back_duration')}}"/>
        <input type="hidden" id="getReportCallbackHeatMapDataURL" value="{{route('user.reports.get_callback_heat_map')}}"/>
        <input type="hidden" id="getReportCallSentDestinationHeatMapDataURL" value="{{route('user.reports.get_call_sent_destination')}}"/>
        <input type="hidden" id="getReportCampaignStatsDataURL" value="{{route('user.reports.campagin_stats')}}"/>
        <input type="hidden" id="getReportListStatsDataURL" value="{{route('user.reports.list_stats')}}"/>
        <input type="hidden" id="getReportRecordingStatsDataURL" value="{{route('user.reports.recording_stats')}}"/>
        <input type="hidden" id="getReportStateStatsDataURL" value="{{route('user.reports.state_stats')}}"/>
        <input type="hidden" id="getReportCampaignRatioDataURL" value="{{route('user.reports.campaign_ratio')}}"/>
        <input type="hidden" id="getCampaignSendRatesDataURL" value="{{route('user.reports.campaign_send_rates')}}"/>
        <input type="hidden" id="getInboundCallDataURL" value="{{route('user.reports.inbound_call_overtime')}}"/>
        <input type="hidden" id="getIvrOutboundCallDataURL" value="{{route('user.reports.ivr_outbound_stats')}}"/>
        <input type="hidden" id="getOutboundOptinDataURL" value="{{route('user.reports.outbound_optin_heatmap')}}"/>
        <input type="hidden" id="getIvrDncHeatmapDataURL" value="{{route('user.reports.ivr_dnc_heatmap')}}"/>

        <input type="hidden" id="getDncHeatmapDataURL" value="{{route('user.reports.dnc_heatmap')}}"/>

    @elseif(auth()->user()->role =="admin")
        <input type="hidden" id="getReportCounterDataURL" value="{{route('admin.reports.counters')}}"/>
        <input type="hidden" id="getReportSendRatesPerDayDataURL" value="{{route('admin.reports.get_send_rates_per_day')}}"/>
        <input type="hidden" id="getReportCallbackPieChartDataURL" value="{{route('admin.reports.get_callback_pie')}}"/>
        <input type="hidden" id="getReportCallbackDurationHeatMapDataURL" value="{{route('admin.reports.get_call_back_duration')}}"/>
        <input type="hidden" id="getReportCallbackHeatMapDataURL" value="{{route('admin.reports.get_callback_heat_map')}}"/>
        <input type="hidden" id="getReportCallSentDestinationHeatMapDataURL" value="{{route('admin.reports.get_call_sent_destination')}}"/>
        <input type="hidden" id="getReportCampaignStatsDataURL" value="{{route('admin.reports.campagin_stats')}}"/>
        <input type="hidden" id="getReportListStatsDataURL" value="{{route('admin.reports.list_stats')}}"/>
        <input type="hidden" id="getReportRecordingStatsDataURL" value="{{route('admin.reports.recording_stats')}}"/>
        <input type="hidden" id="getReportStateStatsDataURL" value="{{route('admin.reports.state_stats')}}"/>
        <input type="hidden" id="getReportCampaignRatioDataURL" value="{{route('admin.reports.campaign_ratio')}}"/>
        <input type="hidden" id="getCampaignSendRatesDataURL" value="{{route('admin.reports.campaign_send_rates')}}"/>
        <input type="hidden" id="getInboundCallDataURL" value="{{route('admin.reports.inbound_call_overtime')}}"/>
        <input type="hidden" id="getIvrOutboundCallDataURL" value="{{route('admin.reports.ivr_outbound_stats')}}"/>
        <input type="hidden" id="getOutboundOptinDataURL" value="{{route('admin.reports.outbound_optin_heatmap')}}"/>
        <input type="hidden" id="getIvrDncHeatmapDataURL" value="{{route('admin.reports.ivr_dnc_heatmap')}}"/>

        <input type="hidden" id="getDncHeatmapDataURL" value="{{route('admin.reports.dnc_heatmap')}}"/>

    @elseif(auth()->user()->role =="company")
        <input type="hidden" id="getReportCounterDataURL" value="{{route('company.reports.counters')}}"/>
        <input type="hidden" id="getReportSendRatesPerDayDataURL" value="{{route('company.reports.get_send_rates_per_day')}}"/>
        <input type="hidden" id="getReportCallbackPieChartDataURL" value="{{route('company.reports.get_callback_pie')}}"/>
        <input type="hidden" id="getReportCallbackDurationHeatMapDataURL" value="{{route('company.reports.get_call_back_duration')}}"/>
        <input type="hidden" id="getReportCallbackHeatMapDataURL" value="{{route('company.reports.get_callback_heat_map')}}"/>
        <input type="hidden" id="getReportCallSentDestinationHeatMapDataURL" value="{{route('company.reports.get_call_sent_destination')}}"/>
        <input type="hidden" id="getReportCampaignStatsDataURL" value="{{route('company.reports.campagin_stats')}}"/>
        <input type="hidden" id="getReportListStatsDataURL" value="{{route('company.reports.list_stats')}}"/>
        <input type="hidden" id="getReportRecordingStatsDataURL" value="{{route('company.reports.recording_stats')}}"/>
        <input type="hidden" id="getReportStateStatsDataURL" value="{{route('company.reports.state_stats')}}"/>
        <input type="hidden" id="getReportCampaignRatioDataURL" value="{{route('company.reports.campaign_ratio')}}"/>
        <input type="hidden" id="getCampaignSendRatesDataURL" value="{{route('company.reports.campaign_send_rates')}}"/>
        <input type="hidden" id="getInboundCallDataURL" value="{{route('company.reports.inbound_call_overtime')}}"/>
        <input type="hidden" id="getIvrOutboundCallDataURL" value="{{route('company.reports.ivr_outbound_stats')}}"/>
        <input type="hidden" id="getOutboundOptinDataURL" value="{{route('company.reports.outbound_optin_heatmap')}}"/>
        <input type="hidden" id="getIvrDncHeatmapDataURL" value="{{route('company.reports.ivr_dnc_heatmap')}}"/>

        <input type="hidden" id="getDncHeatmapDataURL" value="{{route('company.reports.dnc_heatmap')}}"/>


    @endif
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
    <script>
        $(function(){
            $('input[name="datetimes"]').daterangepicker({
                // timePicker: true,
                startDate: moment().startOf('week'),
                endDate: moment().endOf('week'),
                alwaysShowCalendars:true,
                locale: {
                    format: 'YYYY-MM-DD'
                },
            });
            // date range picker end

            var campaignSpecificStatsTable = $('#campaignSpecificStatsTable').DataTable({
                lengthChange: false,
                "order": [],
                // "dom": 'lBfrtip',
                // buttons: [{
                //     extend: 'csv',
                //     footer: false,
                //     exportOptions: {
                //         columns: [4,3,1,2,0,5]
                //     }
                // }]
            });
            var listSpecificStatsTable = $('#listSpecificStatsTable').DataTable({
                lengthChange: false,
                "order": [],
                // "dom": 'lBfrtip',
                // buttons: [{
                //     extend: 'csv',
                //     footer: false,
                //     exportOptions: {
                //         columns: [0,1,2]
                //     }
                // }]
            });

            var recordingSpecificStatsTable = $('#recordingSpecificStatsTable').DataTable({
                lengthChange: false,
                "order": [],
                // "dom": 'lBfrtip',
                // buttons: [{
                //     extend: 'csv',
                //     footer: false,
                //     exportOptions: {
                //         columns: [0,1,2]
                //     }
                // }]
            });
            var stateSpecificStatsTable = $('#stateSpecificStatsTable').DataTable({
                lengthChange: false,
                "order": [],
                // "dom": 'lBfrtip',
                // buttons: [{
                //     extend: 'csv',
                //     footer: false,
                //     exportOptions: {
                //         columns: [0,1,2]
                //     }
                // }]
            });

            var ivrOutboundStatsTable = $('#ivrOutboundStatsTable').DataTable({
                lengthChange: false,
                "order": [],
                // "dom": 'lBfrtip',
                // buttons: [{
                //     extend: 'csv',
                //     footer: false,
                //     exportOptions: {
                //         columns: [0,1,2]
                //     }
                // }]
            });

            $('.loader').show();
            $('.sendRatesPerDayLoader').show();
            $('.noOfCallsPerCampaignLoader').show();
            $('.averageCallDurationPerCampaignLoader').show();
            $('.callbackDurationHeatMapLoader').show();
            $('.callbackHeatMapLoader').show();
            $('.callSentToDestionationLoader').show();
            $('.campaignSpecificStatsLoader').show();
            $('.listSpecificStatsLoader').show();
            $('.recordingSpecificStatsLoader').show();
            $('.campaignRatioLoader').show();
            $('.campaignSendRatesLineChartLoader').show();
            $('.inboundCallLineChartLoader').show();
            $('.ivrOutboundCallStatsLoader').show();
            $('.outboundOptinHeatmapLoader').show();
            $('.ivrDncHeatMapLoader').show();
            $('.dncHeatMapLoader').show();
            $('.stateSpecificStatsLoader').show();

            fetchSendRatesPerDay();
            fetchPieChart();
            callbackHeatMap();
            callSentToDestionation();
            campaignSpecificStats();
            listSpecificStats();
            getReportRecordingStats();
            campaginRatioPieChart();
            campaignSendRatesLineChart();
            inboundCall();
            ivrOutboundCallStats();
            outboundOptinHeatMap();
            ivrDncHeatMap();
            dncHeatMap();
            getReportStateStats();

        });//main dom fun end

        async function fetchReportData(){

            $('.loader').show();
            $('.sendRatesPerDayLoader').show();
            $('.noOfCallsPerCampaignLoader').show();
            $('.averageCallDurationPerCampaignLoader').show();
            $('.callbackDurationHeatMapLoader').show();
            $('.callbackHeatMapLoader').show();
            $('.callSentToDestionationLoader').show();
            $('.campaignSpecificStatsLoader').show();
            $('.listSpecificStatsLoader').show();
            $('.recordingSpecificStatsLoader').show();
            $('.campaignRatioLoader').show();
            $('.campaignSendRatesLineChartLoader').show();
            $('.inboundCallLineChartLoader').show();
            $('.ivrOutboundCallStatsLoader').show();
            $('.outboundOptinHeatmapLoader').show();
            $('.ivrDncHeatMapLoader').show();
            $('.dncHeatMapLoader').show();
            $('.stateSpecificStatsLoader').show();

            let baseUrl = $('#getReportCounterDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();
            var currencyFormatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            // let colors =  [
            //   "#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
            //   "#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
            //   "#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
            //   "#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
            //   "#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
            //   "#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
            //   "#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
            //   "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
            //   "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
            //   "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
            //   "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
            //   "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
            //   "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
            //   "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
            //   "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
            //   "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
            //   "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
            //   "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
            //   "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
            //   "#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
            //   "#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
            //   "#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473", "#e7dbce",
            //   "#421f79", "#7a3d93", "#635f6d", "#93f2d7", "#9b5c2a", "#15b9ee", "#0f5997",
            //   "#409188", "#911e20", "#1350ce", "#10e5b1", "#fff4d7", "#cb2582", "#ce00be",
            //   "#32d5d6", "#17232", "#608572", "#c79bc2", "#00f87c", "#77772a", "#6995ba",
            //   "#fc6b57", "#f07815", "#8fd883", "#060e27", "#96e591", "#21d52e", "#d00043",
            //   "#b47162", "#1ec227", "#4f0f6f", "#1d1d58", "#947002", "#bde052", "#e08c56",
            //   "#28fcfd", "#bb09b", "#36486a", "#d02e29", "#1ae6db", "#3e464c", "#a84a8f",
            //   "#911e7e", "#3f16d9", "#0f525f", "#ac7c0a", "#b4c086", "#c9d730", "#30cc49",
            //   "#3d6751", "#fb4c03", "#640fc1", "#62c03e", "#d3493a", "#88aa0b", "#406df9",
            //   "#615af0", "#4be47", "#2a3434", "#4a543f", "#79bca0", "#a8b8d4", "#00efd4",
            //   "#7ad236", "#7260d8", "#1deaa7", "#06f43a", "#823c59", "#e3d94c", "#dc1c06",
            //   "#f53b2a", "#b46238", "#2dfff6", "#a82b89", "#1a8011", "#436a9f", "#1a806a",
            //   "#4cf09d", "#c188a2", "#67eb4b", "#b308d3", "#fc7e41", "#af3101", "#ff065",
            //   "#71b1f4", "#a2f8a5", "#e23dd0", "#d3486d", "#00f7f9", "#474893", "#3cec35",
            //   "#1c65cb", "#5d1d0c", "#2d7d2a", "#ff3420", "#5cdd87", "#a259a4", "#e4ac44",
            //   "#1bede6", "#8798a4", "#d7790f", "#b2c24f", "#de73c2", "#d70a9c", "#25b67",
            //   "#88e9b8", "#c2b0e2", "#86e98f", "#ae90e2", "#1a806b", "#436a9e", "#0ec0ff",
            //   "#f812b3", "#b17fc9", "#8d6c2f", "#d3277a", "#2ca1ae", "#9685eb", "#8a96c6",
            //   "#dba2e6", "#76fc1b", "#608fa4", "#20f6ba", "#07d7f6", "#dce77a", "#77ecca"];

            // $('.loader').show();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id: listId,

                }
            })
                .then((response) => {
                    // console.log(response)
                    if(response.data && response.data.campaignCounters !== null){
                        let sent = response.data.campaignCounters.sent_count !== null ? response.data.campaignCounters.sent_count : 0;
                        let dnc = response.data.campaignCounters.dnc_count !== null ? response.data.campaignCounters.dnc_count : 0;

                        let pending = response.data.campaignCounters.contact_count !== null && response.data.campaignCounters.contact_count !== 0
                            ? parseFloat(response.data.campaignCounters.contact_count) - parseFloat(sent) - parseFloat(dnc) : 0;
                        $('#total_sent').text(sent);
                        $('#total_pending').text(pending);
                    }else{
                        $('#total_sent').text(0);
                        $('#total_pending').text(0);
                    }
                    if(response.data && response.data.totalRecordings !== null){
                        let totalRecordings = response.data.totalRecordings;
                        $('#total_recordings').text(totalRecordings);
                    }else{
                        $('#total_recordings').text(0);
                    }
                    if(response.data && response.data.totalLists !== null){
                        let totalLists = response.data.totalLists;
                        $('#total_contact_lists').text(totalLists);
                    }else{
                        $('#total_contact_lists').text(0);
                    }
                    if(response.data && response.data.totalContacts !== null){
                        let totalContacts = response.data.totalContacts;
                        $('#total_contacts').text(totalContacts);
                    }else{
                        $('#total_contacts').text(0);
                    }
                    if(response.data && response.data.billingPrice !== null){
                        let billingPrice = currencyFormatter.format(parseFloat(response.data.billingPrice).toFixed(2));

                        $('#total_money_spent').text(billingPrice);
                    }else{
                        $('#total_money_spent').text('$'+0);
                    }
                    if(response.data && response.data.inboundCall !== null){
                        let totalCalls = (parseFloat(response.data.inboundCall.call_count) / parseFloat(response.data.totalDuration)).toFixed(3)
                        $('#inbound_calls_per_second').text(totalCalls);
                    }else{
                        $('#inbound_calls_per_second').text(0);
                    }
                    if(response.data && response.data.outgoingCall !== null){
                        let totalCalls = (parseFloat(response.data.outgoingCall.call_count) / parseFloat(response.data.totalDuration)).toFixed(3)
                        $('#outgoing_calls_per_second').text(totalCalls);
                    }else{
                        $('#outgoing_calls_per_second').text(0);
                    }


                    $('.sendRatesPerDayLoader').show();
                    // fetchSendRatesPerDay();

                    $('.loader').hide();
                });
        }

        /*
        * Send Rates Per Day Map
        */
        var sendRatesPerDayRoot = am5.Root.new("sendRatesPerDay");
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        sendRatesPerDayRoot.setThemes([
            am5themes_Animated.new(sendRatesPerDayRoot)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var sendRatesPerDayChart = sendRatesPerDayRoot.container.children.push(am5xy.XYChart.new(sendRatesPerDayRoot, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none",
            layout: sendRatesPerDayRoot.verticalLayout
        }));


        // Create axes and their renderers
        var sendRatesPerDayChartYRenderer = am5xy.AxisRendererY.new(sendRatesPerDayRoot, {
            visible: false,
            minGridDistance: 20,
            inversed: true
        });

        sendRatesPerDayChartYRenderer.grid.template.set("visible", false);

        var sendRatesPerDayChartYAxis = sendRatesPerDayChart.yAxes.push(am5xy.CategoryAxis.new(sendRatesPerDayRoot, {
            maxDeviation: 0,
            renderer: sendRatesPerDayChartYRenderer,
            categoryField: "weekday"
        }));

        var sendRatesPerDayChartXRenderer = am5xy.AxisRendererX.new(sendRatesPerDayRoot, {
            visible: false,
            minGridDistance: 30,
            opposite:true
        });

        sendRatesPerDayChartXRenderer.grid.template.set("visible", false);

        var sendRatesPerDayChartXAxis = sendRatesPerDayChart.xAxes.push(am5xy.CategoryAxis.new(sendRatesPerDayRoot, {
            renderer: sendRatesPerDayChartXRenderer,
            categoryField: "hour"
        }));


        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/#Adding_series
        var sendRatesPerDaySeries = sendRatesPerDayChart.series.push(am5xy.ColumnSeries.new(sendRatesPerDayRoot, {
            calculateAggregates: true,
            stroke: am5.color(0xffffff),
            clustered: false,
            xAxis: sendRatesPerDayChartXAxis,
            yAxis: sendRatesPerDayChartYAxis,
            categoryXField: "hour",
            categoryYField: "weekday",
            valueField: "value"
        }));

        sendRatesPerDaySeries.columns.template.setAll({
            tooltipText: "{value}",
            strokeOpacity: 1,
            strokeWidth: 2,
            width: am5.percent(100),
            height: am5.percent(100)
        });

        sendRatesPerDaySeries.columns.template.events.on("pointerover", function(event) {
            var di = event.target.dataItem;
            if (di) {
                sendRatesPerDayHeatLegend.showValue(di.get("value", 0));
            }
        });

        // Add heat legend
        // https://www.amcharts.com/docs/v5/concepts/legend/heat-legend/
        var sendRatesPerDayHeatLegend = sendRatesPerDayChart.bottomAxesContainer.children.push(am5.HeatLegend.new(sendRatesPerDayRoot, {
            orientation: "horizontal",
            endColor: am5.color(0xfffb77),
            startColor: am5.color(0xfe131a)
        }));

        sendRatesPerDaySeries.events.on("datavalidated", function() {
            sendRatesPerDayHeatLegend.set("startValue", sendRatesPerDaySeries.getPrivate("valueHigh"));
            sendRatesPerDayHeatLegend.set("endValue", sendRatesPerDaySeries.getPrivate("valueLow"));
        });


        // Set up heat rules
        // https://www.amcharts.com/docs/v5/concepts/settings/heat-rules/
        sendRatesPerDaySeries.set("heatRules", [{
            target: sendRatesPerDaySeries.columns.template,
            min: am5.color(0xfffb77),
            max: am5.color(0xfe131a),
            dataField: "value",
            key: "fill"
        }]);

        async function fetchSendRatesPerDay(){
            // send rates per day heat map
            // am5.ready(function() {


            // Set data
            // https://www.amcharts.com/docs/v5/charts/xy-chart/#Setting_data
            var data =[{"hour":"12pm","weekday":"Sunday","value":0},{"hour":"1am","weekday":"Sunday","value":0},{"hour":"2am","weekday":"Sunday","value":0},{"hour":"3am","weekday":"Sunday","value":0},{"hour":"4am","weekday":"Sunday","value":0},{"hour":"5am","weekday":"Sunday","value":0},{"hour":"6am","weekday":"Sunday","value":0},{"hour":"7am","weekday":"Sunday","value":0},{"hour":"8am","weekday":"Sunday","value":0},{"hour":"9am","weekday":"Sunday","value":0},{"hour":"10am","weekday":"Sunday","value":0},{"hour":"11am","weekday":"Sunday","value":0},{"hour":"12am","weekday":"Sunday","value":0},{"hour":"1pm","weekday":"Sunday","value":0},{"hour":"2pm","weekday":"Sunday","value":0},{"hour":"3pm","weekday":"Sunday","value":0},{"hour":"4pm","weekday":"Sunday","value":0},{"hour":"5pm","weekday":"Sunday","value":0},{"hour":"6pm","weekday":"Sunday","value":0},{"hour":"7pm","weekday":"Sunday","value":0},{"hour":"8pm","weekday":"Sunday","value":0},{"hour":"9pm","weekday":"Sunday","value":0},{"hour":"10pm","weekday":"Sunday","value":0},{"hour":"11pm","weekday":"Sunday","value":0},{"hour":"12pm","weekday":"Monday","value":0},{"hour":"1am","weekday":"Monday","value":0},{"hour":"2am","weekday":"Monday","value":0},{"hour":"3am","weekday":"Monday","value":0},{"hour":"4am","weekday":"Monday","value":0},{"hour":"5am","weekday":"Monday","value":0},{"hour":"6am","weekday":"Monday","value":0},{"hour":"7am","weekday":"Monday","value":0},{"hour":"8am","weekday":"Monday","value":0},{"hour":"9am","weekday":"Monday","value":0},{"hour":"10am","weekday":"Monday","value":0},{"hour":"11am","weekday":"Monday","value":0},{"hour":"12am","weekday":"Monday","value":0},{"hour":"1pm","weekday":"Monday","value":0},{"hour":"2pm","weekday":"Monday","value":0},{"hour":"3pm","weekday":"Monday","value":0},{"hour":"4pm","weekday":"Monday","value":0},{"hour":"5pm","weekday":"Monday","value":0},{"hour":"6pm","weekday":"Monday","value":0},{"hour":"7pm","weekday":"Monday","value":0},{"hour":"8pm","weekday":"Monday","value":0},{"hour":"9pm","weekday":"Monday","value":0},{"hour":"10pm","weekday":"Monday","value":0},{"hour":"11pm","weekday":"Monday","value":0},{"hour":"12pm","weekday":"Tuesday","value":0},{"hour":"1am","weekday":"Tuesday","value":0},{"hour":"2am","weekday":"Tuesday","value":0},{"hour":"3am","weekday":"Tuesday","value":0},{"hour":"4am","weekday":"Tuesday","value":0},{"hour":"5am","weekday":"Tuesday","value":0},{"hour":"6am","weekday":"Tuesday","value":0},{"hour":"7am","weekday":"Tuesday","value":0},{"hour":"8am","weekday":"Tuesday","value":0},{"hour":"9am","weekday":"Tuesday","value":0},{"hour":"10am","weekday":"Tuesday","value":0},{"hour":"11am","weekday":"Tuesday","value":0},{"hour":"12am","weekday":"Tuesday","value":0},{"hour":"1pm","weekday":"Tuesday","value":0},{"hour":"2pm","weekday":"Tuesday","value":0},{"hour":"3pm","weekday":"Tuesday","value":0},{"hour":"4pm","weekday":"Tuesday","value":0},{"hour":"5pm","weekday":"Tuesday","value":0},{"hour":"6pm","weekday":"Tuesday","value":0},{"hour":"7pm","weekday":"Tuesday","value":0},{"hour":"8pm","weekday":"Tuesday","value":0},{"hour":"9pm","weekday":"Tuesday","value":0},{"hour":"10pm","weekday":"Tuesday","value":0},{"hour":"11pm","weekday":"Tuesday","value":0},{"hour":"12pm","weekday":"Wednesday","value":0},{"hour":"1am","weekday":"Wednesday","value":0},{"hour":"2am","weekday":"Wednesday","value":0},{"hour":"3am","weekday":"Wednesday","value":0},{"hour":"4am","weekday":"Wednesday","value":0},{"hour":"5am","weekday":"Wednesday","value":0},{"hour":"6am","weekday":"Wednesday","value":0},{"hour":"7am","weekday":"Wednesday","value":0},{"hour":"8am","weekday":"Wednesday","value":0},{"hour":"9am","weekday":"Wednesday","value":0},{"hour":"10am","weekday":"Wednesday","value":0},{"hour":"11am","weekday":"Wednesday","value":0},{"hour":"12am","weekday":"Wednesday","value":0},{"hour":"1pm","weekday":"Wednesday","value":0},{"hour":"2pm","weekday":"Wednesday","value":0},{"hour":"3pm","weekday":"Wednesday","value":0},{"hour":"4pm","weekday":"Wednesday","value":0},{"hour":"5pm","weekday":"Wednesday","value":0},{"hour":"6pm","weekday":"Wednesday","value":0},{"hour":"7pm","weekday":"Wednesday","value":0},{"hour":"8pm","weekday":"Wednesday","value":0},{"hour":"9pm","weekday":"Wednesday","value":0},{"hour":"10pm","weekday":"Wednesday","value":0},{"hour":"11pm","weekday":"Wednesday","value":0},{"hour":"12pm","weekday":"Thursday","value":0},{"hour":"1am","weekday":"Thursday","value":0},{"hour":"2am","weekday":"Thursday","value":0},{"hour":"3am","weekday":"Thursday","value":0},{"hour":"4am","weekday":"Thursday","value":0},{"hour":"5am","weekday":"Thursday","value":0},{"hour":"6am","weekday":"Thursday","value":0},{"hour":"7am","weekday":"Thursday","value":0},{"hour":"8am","weekday":"Thursday","value":0},{"hour":"9am","weekday":"Thursday","value":0},{"hour":"10am","weekday":"Thursday","value":0},{"hour":"11am","weekday":"Thursday","value":0},{"hour":"12am","weekday":"Thursday","value":0},{"hour":"1pm","weekday":"Thursday","value":0},{"hour":"2pm","weekday":"Thursday","value":0},{"hour":"3pm","weekday":"Thursday","value":0},{"hour":"4pm","weekday":"Thursday","value":0},{"hour":"5pm","weekday":"Thursday","value":0},{"hour":"6pm","weekday":"Thursday","value":0},{"hour":"7pm","weekday":"Thursday","value":0},{"hour":"8pm","weekday":"Thursday","value":0},{"hour":"9pm","weekday":"Thursday","value":0},{"hour":"10pm","weekday":"Thursday","value":0},{"hour":"11pm","weekday":"Thursday","value":0},{"hour":"12pm","weekday":"Friday","value":0},{"hour":"1am","weekday":"Friday","value":0},{"hour":"2am","weekday":"Friday","value":0},{"hour":"3am","weekday":"Friday","value":0},{"hour":"4am","weekday":"Friday","value":0},{"hour":"5am","weekday":"Friday","value":0},{"hour":"6am","weekday":"Friday","value":0},{"hour":"7am","weekday":"Friday","value":0},{"hour":"8am","weekday":"Friday","value":0},{"hour":"9am","weekday":"Friday","value":0},{"hour":"10am","weekday":"Friday","value":0},{"hour":"11am","weekday":"Friday","value":0},{"hour":"12am","weekday":"Friday","value":0},{"hour":"1pm","weekday":"Friday","value":0},{"hour":"2pm","weekday":"Friday","value":0},{"hour":"3pm","weekday":"Friday","value":0},{"hour":"4pm","weekday":"Friday","value":0},{"hour":"5pm","weekday":"Friday","value":0},{"hour":"6pm","weekday":"Friday","value":0},{"hour":"7pm","weekday":"Friday","value":0},{"hour":"8pm","weekday":"Friday","value":0},{"hour":"9pm","weekday":"Friday","value":0},{"hour":"10pm","weekday":"Friday","value":0},{"hour":"11pm","weekday":"Friday","value":0},{"hour":"12pm","weekday":"Saturday","value":0},{"hour":"1am","weekday":"Saturday","value":0},{"hour":"2am","weekday":"Saturday","value":0},{"hour":"3am","weekday":"Saturday","value":0},{"hour":"4am","weekday":"Saturday","value":0},{"hour":"5am","weekday":"Saturday","value":0},{"hour":"6am","weekday":"Saturday","value":0},{"hour":"7am","weekday":"Saturday","value":0},{"hour":"8am","weekday":"Saturday","value":0},{"hour":"9am","weekday":"Saturday","value":0},{"hour":"10am","weekday":"Saturday","value":0},{"hour":"11am","weekday":"Saturday","value":0},{"hour":"12am","weekday":"Saturday","value":0},{"hour":"1pm","weekday":"Saturday","value":0},{"hour":"2pm","weekday":"Saturday","value":0},{"hour":"3pm","weekday":"Saturday","value":0},{"hour":"4pm","weekday":"Saturday","value":0},{"hour":"5pm","weekday":"Saturday","value":0},{"hour":"6pm","weekday":"Saturday","value":0},{"hour":"7pm","weekday":"Saturday","value":0},{"hour":"8pm","weekday":"Saturday","value":0},{"hour":"9pm","weekday":"Saturday","value":0},{"hour":"10pm","weekday":"Saturday","value":0},{"hour":"11pm","weekday":"Saturday","value":0}]

            let baseUrl = $('#getReportSendRatesPerDayDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId

                }
            })
                .then((response) => {

                    if(response.data && response.data.sendRatesPerDay !== null){

                        if(typeof response.data && response.data.sendRatesPerDay !== 'undefined' && response.data && response.data.sendRatesPerDay.length > 0){
                            response.data && response.data.sendRatesPerDay.forEach(element => {

                                data.filter((e)=>{
                                    if(e.hour === element['hour'].replace(/\s/g, "") && e.weekday === element['weekday'].replace(/\s/g, "")){
                                        e['value'] = element['value'];
                                    }
                                });

                            });

                            // console.log('wdwd',data)
                            sendRatesPerDaySeries.data.setAll(data);
                        }else{
                            sendRatesPerDaySeries.data.setAll(data);
                        }
                    }

                    $('.noOfCallsPerCampaignLoader').show();
                    $('.averageCallDurationPerCampaignLoader').show();
                    $('.sendRatesPerDayLoader').hide();
                    // fetchPieChart();

                })
            // $.ajax({
            //     url: baseUrl,
            //     contentType: "application/json; charset=utf-8",
            //     data:{
            //         start_date: startDate,
            //         end_date: endDate,
            //         campaign_id: campaignId,
            //     },
            //     success: function(response){
            //         // chart.series.removeIndex(0);
            //         if(response.sendRatesPerDay !== null){
            //
            //             if(typeof response.sendRatesPerDay !== 'undefined' && response.sendRatesPerDay.length > 0){
            //                 response.sendRatesPerDay.forEach(element => {
            //
            //                     data.filter((e)=>{
            //                         if(e.hour === element['hour'].replace(/\s/g, "") && e.weekday === element['weekday'].replace(/\s/g, "")){
            //                             e['value'] = element['value'];
            //                         }
            //                     });
            //
            //                 });
            //
            //                 // console.log('wdwd',data)
            //                 sendRatesPerDaySeries.data.setAll(data);
            //             }else{
            //                 sendRatesPerDaySeries.data.setAll(data);
            //             }
            //         }
            //
            //         $('.noOfCallsPerCampaignLoader').show();
            //         $('.averageCallDurationPerCampaignLoader').show();
            //
            //         // fetchPieChart();
            //
            //     },
            //     beforeSend: function(){
            //         $('.sendRatesPerDayLoader').show()
            //     },
            //     complete: function(){
            //         $('.sendRatesPerDayLoader').hide();
            //     }
            // });


            // sendRatesPerDaySeries.data.setAll(data);
            sendRatesPerDayChartYAxis.data.setAll([
                { weekday: "Sunday" },
                { weekday: "Monday" },
                { weekday: "Tuesday" },
                { weekday: "Wednesday" },
                { weekday: "Thursday" },
                { weekday: "Friday" },
                { weekday: "Saturday" }
            ]);

            sendRatesPerDayChartXAxis.data.setAll([
                { hour: "12pm" },
                { hour: "1am" },
                { hour: "2am" },
                { hour: "3am" },
                { hour: "4am" },
                { hour: "5am" },
                { hour: "6am" },
                { hour: "7am" },
                { hour: "8am" },
                { hour: "9am" },
                { hour: "10am" },
                { hour: "11am" },
                { hour: "12am" },
                { hour: "1pm" },
                { hour: "2pm" },
                { hour: "3pm" },
                { hour: "4pm" },
                { hour: "5pm" },
                { hour: "6pm" },
                { hour: "7pm" },
                { hour: "8pm" },
                { hour: "9pm" },
                { hour: "10pm" },
                { hour: "11pm" }
            ]);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/#Initial_animation
            sendRatesPerDayChart.appear(1000, 500);

            // Enable export
            var exporting = am5plugins_exporting.Exporting.new(sendRatesPerDayRoot, {
                menu: am5plugins_exporting.ExportingMenu.new(sendRatesPerDayRoot, {
                    align: "left",
                    valign: "top"
                })
            });

            // setTimeout(function() {
            //     exporting.export("png").then(function(imgData) {
            //         document.getElementById("myImage").src = imgData;
            //     });
            // }, 2000);

            // });
        }

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element

        async function fetchPieChart(){
            let baseUrl = $('#getReportCallbackPieChartDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            var currencyFormatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                }
            })
                .then((response) => {

                    if(response.data && response.data.noOfCallsPerCampaign.length !== 0){

                        let noOfCallsPerCampaign = response.data.noOfCallsPerCampaign;
                        // let campaignName = [];
                        // let campaignId = [];
                        // let campaignCallBacks = [];
                        // let totalCallBacks = 0;
                        // let callBackPercentagePerCampaign = [];
                        let data =  []
                        response.data.noOfCallsPerCampaign.map((value,key)=>{
                            // campaignId.push(value['campaign_id']);
                            // campaignName.push(value['name'])
                            // campaignCallBacks.push(value['call_backs'])
                            // totalCallBacks = totalCallBacks + value['call_backs'];

                            data.push({
                                value: value['call_backs'],
                                name : value['name']
                            })

                        });
                        am4core.useTheme(am4themes_animated);
                        // Create chart instance
                        var chart2 = am4core.create("noOfCallsPerCampaignPieChart", am4charts.PieChart);
                        // Add data
                        chart2.data = data;

                        // Add and configure Series
                        var pieSeries = chart2.series.push(new am4charts.PieSeries());
                        pieSeries.dataFields.value = "value";
                        // pieSeries.slices.template.tooltipText = "{name}: ({mm}:{ss})";
                        pieSeries.dataFields.category = "name";
                        pieSeries.labels.template.disabled = true;
                        chart2.radius = am4core.percent(95);
                        // let noOfCallsPerCampaignCanvas = $("#noOfCallsPerCampaignPieChart");
                        // var noOfCallsPerCampaignPieChart = new Chart(noOfCallsPerCampaignCanvas, {
                        //         type: 'pie',
                        //         data:{
                        //             labels: campaignName,
                        //             datasets: [{
                        //                 label: campaignName,
                        //                 data: campaignCallBacks,
                        //                 backgroundColor: colors,
                        //                 borderColor:colors,
                        //                 borderWidth: 1
                        //             }]
                        //         },
                        //         options: {
                        //         maintainAspectRatio: true,
                        //         title: {
                        //             display: true,
                        //             position: "bottom",
                        //             text: 'No Of Callbacks Per Campaign'
                        //         },
                        //         responsive:true,
                        //         legend: {
                        //             display: true,
                        //             position: "bottom",
                        //             labels: {
                        //             boxWidth: 6,
                        //             display: true,
                        //             usePointStyle: true,
                        //             },
                        //         },
                        //         animation: {
                        //             animateScale: true,
                        //             animateRotate: true,
                        //         },
                        //         tooltips: {
                        //             enabled: true,
                        //             mode: 'single',
                        //             callbacks: {
                        //                     label: function(tooltipItem, data) {
                        //                     let sum = 0;
                        //                     // let dataArr = data[0].dataset.data;
                        //                     var allData = data.datasets[tooltipItem.datasetIndex].data;

                        //                     allData.map(data => {
                        //                         sum += Number(data);
                        //                     });

                        //                     var tooltipLabel = data.labels[tooltipItem.index];
                        //                     var tooltipData = allData[tooltipItem.index];

                        //                     let percentage = (tooltipData*100 / sum).toFixed(2)+"%";
                        //                     return tooltipLabel + ": "+ tooltipData + " | " + percentage;
                        //                 }
                        //             }
                        //         }
                        //     }
                        // });
                    }else{

                    }


                    if(response.data && response.data.avgCallDurationPerCampaign.length !== 0){

                        let averageCallDurationPerCampaign = response.data.avgCallDurationPerCampaign;
                        // let campaignName = [];
                        // let campaignId = [];
                        // let campaignAvgDuration = [];
                        let data =  []
                        response.data.avgCallDurationPerCampaign.map((value,key)=>{
                            // campaignId.push(value['campaign_id']);
                            // campaignName.push(value['name'])
                            // campaignAvgDuration.push(parseFloat(value['avg_duration']).toFixed(2))
                            data.push({
                                mm: moment.utc(value['avg_duration']*1000).format('mm:ss').split(':')[0],
                                ss: moment.utc(value['avg_duration']*1000).format('mm:ss').split(':')[1],
                                value: moment.utc(value['avg_duration']*1000).format('mm:ss'),
                                name : value['name']
                            })
                        });

                        am4core.useTheme(am4themes_animated);
                        // Create chart instance
                        var chart = am4core.create("averageCallDurationPerCampaignPieChart", am4charts.PieChart);
                        // Add data
                        chart.data = data;

                        // Add and configure Series
                        var pieSeries = chart.series.push(new am4charts.PieSeries());
                        pieSeries.dataFields.value = "value";
                        pieSeries.slices.template.tooltipText = "{name}: ({mm}:{ss})";
                        pieSeries.dataFields.category = "name";
                        pieSeries.labels.template.disabled = true;
                        chart.radius = am4core.percent(95);

                    }else{

                    }
                    $('.noOfCallsPerCampaignLoader').hide();
                    $('.averageCallDurationPerCampaignLoader').hide();

                    $('.callbackDurationHeatMapLoader').show();

                    callbackDurationHeatMap();

                });
        }

        async function callbackDurationHeatMap(){


            am4core.useTheme(am4themes_animated);
            // Create map instance
            var chart = am4core.create("callbackDurationHeatMap", am4maps.MapChart);
            // Set map definition
            chart.geodata = am4geodata_usaLow;

            // Set projection
            chart.projection = new am4maps.projections.AlbersUsa();

            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());


            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                min: chart.colors.getIndex(1).brighten(1),
                max: chart.colors.getIndex(1).brighten(-0.3),
                logarithmic: true
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            let baseUrl = $('#getReportCallbackDurationHeatMapDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,

                }
            })
                .then((response) => {

                    if(response.data && response.data.callbacks !== null){
                        if(typeof response.data.callbacks !== 'undefined' && response.data.callbacks.length > 0){
                            let newData = [];
                            response.data.callbacks.forEach(element => {
                                let xV = moment.utc(element.value*1000).format('mm:ss')
                                newData.push({
                                    value : xV,
                                    mm: xV.split(':')[0],
                                    ss: xV.split(':')[1],
                                    id : element.id
                                })

                            });
                            // console.log(newData)
                            polygonSeries.data = newData
                        }else{
                            polygonSeries.data = [{}];
                        }

                    }

                    $('.callbackDurationHeatMapLoader').hide();
                    // $('.callbackHeatMapLoader').show();
                    // callbackHeatMap();


                });

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;
            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = - 25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;


            // Configure series tooltip
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: ({mm} : {ss})";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#3c5bdc");


            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);

            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {

                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });

            // Enable export
            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";
        }

        async function callbackHeatMap(){

            am4core.useTheme(am4themes_animated);
            // Create map instance
            var chart = am4core.create("callbackHeatMap", am4maps.MapChart);
            // Set map definition
            chart.geodata = am4geodata_usaLow;

            // Set projection
            chart.projection = new am4maps.projections.AlbersUsa();

            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());


            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                min: chart.colors.getIndex(1).brighten(1),
                max: chart.colors.getIndex(1).brighten(-0.3),
                logarithmic: true
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            let baseUrl = $('#getReportCallbackHeatMapDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,

                }
            })
                .then((response) => {
                    if(response.data && response.data.callbacks !== null){
                        if(typeof response.data.callbacks !== 'undefined' && response.data.callbacks.length > 0){
                            polygonSeries.data = response.data.callbacks
                        }else{
                            polygonSeries.data = [{}];
                        }

                    }

                    $('.callbackHeatMapLoader').hide();
                    $('.callSentToDestionationLoader').show();
                    // callSentToDestionation();


                });

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;
            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = - 25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;


            // Configure series tooltip
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#3c5bdc");


            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);

            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });

            // Enable export
            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";
        }

        async function callSentToDestionation(){

            am4core.useTheme(am4themes_animated);
            // Create map instance
            var chart = am4core.create("callSentToDestionation", am4maps.MapChart);
            // Set map definition
            chart.geodata = am4geodata_usaLow;

            // Set projection
            chart.projection = new am4maps.projections.AlbersUsa();

            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());


            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                min: chart.colors.getIndex(1).brighten(1),
                max: chart.colors.getIndex(1).brighten(-0.3),
                logarithmic: true
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            let baseUrl = $('#getReportCallSentDestinationHeatMapDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,

                }
            })
                .then((response) => {
                    if(response.data && response.data.callbacks !== null){
                        if(typeof response.data.callbacks !== 'undefined' && response.data.callbacks.length > 0){
                            polygonSeries.data = response.data.callbacks
                        }else{
                            polygonSeries.data = [{}];
                        }

                    }

                    $('.callSentToDestionationLoader').hide();
                    $('.campaignSpecificStatsLoader').show();

                    // campaignSpecificStats();

                });

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;
            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = - 25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;


            // Configure series tooltip
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#3c5bdc");


            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);

            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });
            // Enable export
            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";

        }

        async function campaignSpecificStats(){

            let baseUrl = $('#getReportCampaignStatsDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id:listId
                }
            })
                .then((response) => {
                    if(response.data){
                        if(response.data.campaginStats !== null && response.data.campaginStats.length > 0){
                            var table = $('#campaignSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();

                            Object.keys(response.data.campaginStats).forEach(function(key) {
                                table.row.add( [
                                    response.data.campaginStats[key].name,
                                    response.data.campaginStats[key].avg_calls_duration !== null ? moment.utc(response.data.campaginStats[key].avg_calls_duration*1000).format('mm:ss') : 0,
                                    response.data.campaginStats[key].sent_count !==  0 && response.data.campaginStats[key].sent_count !== null ? (parseFloat(response.data.campaginStats[key].calls_back_count) / parseFloat(response.data.campaginStats[key].sent_count) * 100 ).toFixed(2) +' %'  : '0.0 %',
                                    response.data.campaginStats[key].calls_back_count,

                                ]).draw( false );
                            });
                        }else{
                            var table = $('#campaignSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                        }

                    }
                    $('.campaignSpecificStatsLoader').hide();

                    $('.listSpecificStatsLoader').show();
                    // listSpecificStats();
                });

        }

        async function listSpecificStats(){
            let baseUrl = $('#getReportListStatsDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id:listId
                }
            })
                .then((response) => {
                    if(response.data){
                        if(response.data.listStats !== null && response.data.listStats.length > 0){
                            var table = $('#listSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                            // parseFloat(response.data.listStats[key].avg_calls_duration).toFixed(2)
                            Object.keys(response.data.listStats).forEach(function(key) {
                                table.row.add( [
                                    // response.data.listStats[key].name,
                                    response.data.listStats[key].list_name,
                                    response.data.listStats[key].avg_calls_duration !== null ? moment.utc(response.data.listStats[key].avg_calls_duration*1000).format('mm:ss') : 0,
                                    response.data.listStats[key].sent_count !==  0 && response.data.listStats[key].sent_count !==  null ? (parseFloat(response.data.listStats[key].calls_back_count) / parseFloat(response.data.listStats[key].sent_count) * 100 ).toFixed(2) +' %'  : '0.0 %',
                                    response.data.listStats[key].calls_back_count,

                                ]).draw( false );
                            });
                        }else{
                            var table = $('#listSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                        }

                    }

                    $('.listSpecificStatsLoader').hide();
                    $('.recordingSpecificStatsLoader').show();
                    // getReportRecordingStats();
                });


        }

        async function getReportRecordingStats(){

            let baseUrl = $('#getReportRecordingStatsDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id:listId
                }
            })
                .then((response) => {
                    if(response.data){
                        if(response.data.recordingStats !== null && response.data.recordingStats.length > 0){
                            var table = $('#recordingSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                            // parseFloat(response.data.recordingStats[key].avg_calls_duration).toFixed(2)
                            Object.keys(response.data.recordingStats).forEach(function(key) {

                                table.row.add( [
                                    response.data.recordingStats[key].name,
                                    response.data.recordingStats[key].avg_calls_duration !== null ? moment.utc(response.data.recordingStats[key].avg_calls_duration*1000).format('mm:ss') : 0,
                                    response.data.recordingStats[key].sent_count !==  0 && response.data.recordingStats[key].sent_count !==  null ? response.data.recordingStats[key].calls_back_count !== null ? (parseFloat(response.data.recordingStats[key].calls_back_count) / parseFloat(response.data.recordingStats[key].sent_count) * 100 ).toFixed(2) +' %'  : '0.0 %': '0.0 %',
                                    response.data.recordingStats[key].calls_back_count !== null ? response.data.recordingStats[key].calls_back_count : 0,

                                ]).draw( false );
                            });
                        }else{
                            var table = $('#recordingSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                        }

                    }
                    $('.recordingSpecificStatsLoader').hide();
                    $('.campaignRatioLoader').show();
                    // campaginRatioPieChart();
                });
        }

        async function campaginRatioPieChart(){

            let baseUrl = $('#getReportCampaignRatioDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();

            let colors =  [
                "#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
                "#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
                "#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
                "#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
                "#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
                "#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
                "#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
                "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
                "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
                "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
                "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
                "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
                "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
                "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
                "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
                "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
                "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
                "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
                "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
                "#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
                "#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
                "#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473", "#e7dbce",
                "#421f79", "#7a3d93", "#635f6d", "#93f2d7", "#9b5c2a", "#15b9ee", "#0f5997",
                "#409188", "#911e20", "#1350ce", "#10e5b1", "#fff4d7", "#cb2582", "#ce00be",
                "#32d5d6", "#17232", "#608572", "#c79bc2", "#00f87c", "#77772a", "#6995ba",
                "#fc6b57", "#f07815", "#8fd883", "#060e27", "#96e591", "#21d52e", "#d00043",
                "#b47162", "#1ec227", "#4f0f6f", "#1d1d58", "#947002", "#bde052", "#e08c56",
                "#28fcfd", "#bb09b", "#36486a", "#d02e29", "#1ae6db", "#3e464c", "#a84a8f",
                "#911e7e", "#3f16d9", "#0f525f", "#ac7c0a", "#b4c086", "#c9d730", "#30cc49",
                "#3d6751", "#fb4c03", "#640fc1", "#62c03e", "#d3493a", "#88aa0b", "#406df9",
                "#615af0", "#4be47", "#2a3434", "#4a543f", "#79bca0", "#a8b8d4", "#00efd4",
                "#7ad236", "#7260d8", "#1deaa7", "#06f43a", "#823c59", "#e3d94c", "#dc1c06",
                "#f53b2a", "#b46238", "#2dfff6", "#a82b89", "#1a8011", "#436a9f", "#1a806a",
                "#4cf09d", "#c188a2", "#67eb4b", "#b308d3", "#fc7e41", "#af3101", "#ff065",
                "#71b1f4", "#a2f8a5", "#e23dd0", "#d3486d", "#00f7f9", "#474893", "#3cec35",
                "#1c65cb", "#5d1d0c", "#2d7d2a", "#ff3420", "#5cdd87", "#a259a4", "#e4ac44",
                "#1bede6", "#8798a4", "#d7790f", "#b2c24f", "#de73c2", "#d70a9c", "#25b67",
                "#88e9b8", "#c2b0e2", "#86e98f", "#ae90e2", "#1a806b", "#436a9e", "#0ec0ff",
                "#f812b3", "#b17fc9", "#8d6c2f", "#d3277a", "#2ca1ae", "#9685eb", "#8a96c6",
                "#dba2e6", "#76fc1b", "#608fa4", "#20f6ba", "#07d7f6", "#dce77a", "#77ecca"];

            // $('.loader').show();

            $('#campaignRatioPieChart').replaceWith($('<canvas id="campaignRatioPieChart"></canvas>'));

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id: listId,

                }
            })
                .then((response) => {
                    // console.log(response)

                    if(response.data && response.data.campaignRatio.length !== 0){

                        let campaignRatio = response.data.campaignRatio;
                        let campaignType = [];
                        let totalType = [];

                        response.data.campaignRatio.map((value,key)=>{
                            campaignType.push(value['campaign_type']);
                            totalType.push(value['total'])
                        });

                        let campaignRatioCanvas = $("#campaignRatioPieChart");
                        var noOfCallsPerCampaignPieChart = new Chart(campaignRatioCanvas, {
                            type: 'pie',
                            data:{
                                labels: campaignType,
                                datasets: [{
                                    label: campaignType,
                                    data: totalType,
                                    backgroundColor: colors,
                                    borderColor:colors,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                maintainAspectRatio: true,
                                title: {
                                    display: true,
                                    position: "bottom",
                                    text: 'Campaign Ratio'
                                },
                                responsive:true,
                                legend: {
                                    display: true,
                                    position: "bottom",
                                    labels: {
                                        boxWidth: 6,
                                        display: true,
                                        usePointStyle: true,
                                    },
                                },
                                animation: {
                                    animateScale: true,
                                    animateRotate: true,
                                },
                                tooltips: {
                                    enabled: true,
                                    mode: 'single',
                                    callbacks: {
                                        label: function(tooltipItem, data) {
                                            let sum = 0;
                                            // let dataArr = data[0].dataset.data;
                                            var allData = data.datasets[tooltipItem.datasetIndex].data;

                                            allData.map(data => {
                                                sum += Number(data);
                                            });

                                            var tooltipLabel = data.labels[tooltipItem.index];
                                            var tooltipData = allData[tooltipItem.index];

                                            let percentage = (tooltipData*100 / sum).toFixed(2)+"%";
                                            return tooltipLabel + ": "+ tooltipData + " | " + percentage;
                                        }
                                    }
                                }
                            }
                        });
                    }else{
                        $('#campaignRatioPieChart').replaceWith($('<canvas id="campaignRatioPieChart"></canvas>'));
                    }
                    $('.campaignRatioLoader').hide();
                    $('.campaignSendRatesLineChartLoader').show();
                    // campaignSendRatesLineChart();
                });
        }

        /*
        * Campaign Send Rates Line Chart
        */
        var campaignSendRatesLineChartRoot = am5.Root.new("line-chart");
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        campaignSendRatesLineChartRoot.setThemes([
            am5themes_Animated.new(campaignSendRatesLineChartRoot)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var campaignSendRatesChart = campaignSendRatesLineChartRoot.container.children.push(am5xy.XYChart.new(campaignSendRatesLineChartRoot, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX"
        }));
        campaignSendRatesChart.chartContainer.wheelable = false;

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var campaignSendRatesCursor = campaignSendRatesChart.set("cursor", am5xy.XYCursor.new(campaignSendRatesLineChartRoot, {
            behavior: "none"
        }));
        campaignSendRatesCursor.lineY.set("visible", false);
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var campaignSendRatesXAxis = campaignSendRatesChart.xAxes.push(am5xy.DateAxis.new(campaignSendRatesLineChartRoot, {
            maxDeviation: 0.5,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(campaignSendRatesLineChartRoot, {
                pan:"zoom"
            }),
            tooltip: am5.Tooltip.new(campaignSendRatesLineChartRoot, {})
        }));

        var campaignSendRatesYAxis = campaignSendRatesChart.yAxes.push(am5xy.ValueAxis.new(campaignSendRatesLineChartRoot, {
            maxDeviation:1,
            renderer: am5xy.AxisRendererY.new(campaignSendRatesLineChartRoot, {
                pan:"zoom"
            })
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var campaignSendRatesSeries = campaignSendRatesChart.series.push(am5xy.SmoothedXLineSeries.new(campaignSendRatesLineChartRoot, {
            name: "Series",
            xAxis: campaignSendRatesXAxis,
            yAxis: campaignSendRatesYAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(campaignSendRatesLineChartRoot, {
                labelText: "{valueY}"
            })
        }));

        campaignSendRatesSeries.fills.template.setAll({
            visible: true,
            fillOpacity: 0.2
        });

        campaignSendRatesSeries.bullets.push(function() {
            return am5.Bullet.new(campaignSendRatesLineChartRoot, {
                locationY: 0,
                sprite: am5.Circle.new(campaignSendRatesLineChartRoot, {
                    radius: 4,
                    stroke: campaignSendRatesLineChartRoot.interfaceColors.get("background"),
                    strokeWidth: 2,
                    fill: campaignSendRatesSeries.get("fill")
                })
            });
        });



        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        campaignSendRatesChart.set("scrollbarX", am5.Scrollbar.new(campaignSendRatesLineChartRoot, {
            orientation: "horizontal"
        }));

        async function campaignSendRatesLineChart(){

            let baseUrl = $('#getCampaignSendRatesDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();
            var lineChartData = [];

            // am5.ready(function() {


            // // Generate random data
            // var date = new Date();
            // date.setHours(0, 0, 0, 0);
            // var value = 100;


            // console.log(campaignSendRatesData)

            // function generateData() {
            //     value = Math.round((Math.random() * 10 - 5) + value);
            //     am5.time.add(date);

            //     return {
            //         date: date.getTime(),
            //         value: value
            //     };
            // }

            // function generateDatas(count) {
            //     var data = [];
            //     for (var i = 0; i < count; ++i) {
            //         data.push(generateData());
            //     }

            //     return data;
            // }

            // var data = generateDatas(50);
            // series.data.setAll(data);
            campaignSendRatesSeries.data.setAll([{}])
            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId

                }
            })
                .then((response) => {
                    // console.log(response)
                    if(response.data && response.data.campaignSendRates !== null && response.data && response.data.campaignSendRates.length > 0){
                        response.data && response.data.campaignSendRates.forEach(el => {
                            response.data && response.data.dateRange.filter((e)=>{
                                if(e.date === el.date){
                                    e['value'] = el['value'];
                                }
                            });

                        });

                        let campaignSendRatesData = [];
                        response.data && response.data.dateRange.forEach(element => {
                            // labels.push(element.date)
                            // data.push(element.value)
                            let date = new Date(element.date)
                            // am5.time.add(date, "day", 1)
                            campaignSendRatesData.push(
                                {
                                    date : date.getTime(),
                                    value: element.value
                                }
                            )
                        });

                        campaignSendRatesSeries.data.setAll(campaignSendRatesData);


                    }else{
                        campaignSendRatesSeries.data.setAll([{}])
                    }

                    $('.inboundCallLineChartLoader').show();
                    $('.campaignSendRatesLineChartLoader').hide();
                });
            // $.ajax({
            //     url: baseUrl,
            //     contentType: "application/json; charset=utf-8",
            //     data:{
            //         start_date: startDate,
            //         end_date: endDate,
            //         campaign_id: campaignId,
            //     },
            //     success: function(response){
            //         // chart.series.removeIndex(0);
            //        if(response.campaignSendRates !== null && response.campaignSendRates.length > 0){
            //             response.campaignSendRates.forEach(el => {
            //                 response.dateRange.filter((e)=>{
            //                     if(e.date === el.date){
            //                         e['value'] = el['value'];
            //                     }
            //                 });
            //
            //             });
            //
            //             let campaignSendRatesData = [];
            //             response.dateRange.forEach(element => {
            //                 // labels.push(element.date)
            //                 // data.push(element.value)
            //                 let date = new Date(element.date)
            //                 // am5.time.add(date, "day", 1)
            //                 campaignSendRatesData.push(
            //                     {
            //                         date : date.getTime(),
            //                         value: element.value
            //                     }
            //                 )
            //             });
            //
            //             campaignSendRatesSeries.data.setAll(campaignSendRatesData);
            //
            //
            //        }else{
            //             campaignSendRatesSeries.data.setAll([{}])
            //        }
            //
            //        $('.inboundCallLineChartLoader').show();
            //        // inboundCall();
            //
            //
            //     },
            //     beforeSend: function(){
            //         $('.campaignSendRatesLineChartLoader').show()
            //     },
            //     complete: function(){
            //         $('.campaignSendRatesLineChartLoader').hide();
            //     }
            // });

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            campaignSendRatesSeries.appear(1000);
            campaignSendRatesChart.appear(1000, 100);
            // Enable export
            var exporting = am5plugins_exporting.Exporting.new(campaignSendRatesLineChartRoot, {
                menu: am5plugins_exporting.ExportingMenu.new(campaignSendRatesLineChartRoot, {
                    align: "left",
                    valign: "top"
                })
            });

            // }); // end am5.ready()

        }
        /*
        * Inbound Call Line Chart
        */
        var inboundCallLineChartRoot = am5.Root.new("line-chart-2");
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        inboundCallLineChartRoot.setThemes([
            am5themes_Animated.new(inboundCallLineChartRoot)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var inboundCallChart = inboundCallLineChartRoot.container.children.push(am5xy.XYChart.new(inboundCallLineChartRoot, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX"
        }));
        inboundCallChart.chartContainer.wheelable = false;

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var inboundCallCursor = inboundCallChart.set("cursor", am5xy.XYCursor.new(inboundCallLineChartRoot, {
            behavior: "none"
        }));
        inboundCallCursor.lineY.set("visible", false);

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var inboundCallXAxis = inboundCallChart.xAxes.push(am5xy.DateAxis.new(inboundCallLineChartRoot, {
            maxDeviation: 0.5,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(inboundCallLineChartRoot, {
                pan:"zoom"
            }),
            tooltip: am5.Tooltip.new(inboundCallLineChartRoot, {})
        }));

        var inboundCallYAxis = inboundCallChart.yAxes.push(am5xy.ValueAxis.new(inboundCallLineChartRoot, {
            maxDeviation:1,
            renderer: am5xy.AxisRendererY.new(inboundCallLineChartRoot, {
                pan:"zoom"
            })
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var inboundCallSeries = inboundCallChart.series.push(am5xy.SmoothedXLineSeries.new(inboundCallLineChartRoot, {
            name: "Series",
            xAxis: inboundCallXAxis,
            yAxis: inboundCallYAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(inboundCallLineChartRoot, {
                labelText: "{valueY}"
            })
        }));

        inboundCallSeries.fills.template.setAll({
            visible: true,
            fillOpacity: 0.2
        });

        inboundCallSeries.bullets.push(function() {
            return am5.Bullet.new(inboundCallLineChartRoot, {
                locationY: 0,
                sprite: am5.Circle.new(inboundCallLineChartRoot, {
                    radius: 4,
                    stroke: inboundCallLineChartRoot.interfaceColors.get("background"),
                    strokeWidth: 2,
                    fill: inboundCallSeries.get("fill")
                })
            });
        });


        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        inboundCallChart.set("scrollbarX", am5.Scrollbar.new(inboundCallLineChartRoot, {
            orientation: "horizontal"
        }));

        async function inboundCall(){

            let baseUrl = $('#getInboundCallDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();


            // am5.ready(function() {

            // var data = generateDatas(50);
            // inboundCallSeries.data.setAll(data);
            inboundCallSeries.data.setAll([{}]);
            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId

                }
            })
                .then((response) => {
                    // console.log(response)

                    if(response.data && response.data.inboundCall !== null && response.data && response.data.inboundCall.length > 0){
                        response.data && response.data.inboundCall.forEach(el => {
                            response.data && response.data.dateRange.filter((e)=>{
                                if(e.date === el.date){
                                    e['value'] = el['value'];
                                }
                            });

                        });

                        let inboundCallData = [];
                        response.data && response.data.dateRange.forEach(element => {
                            // labels.push(element.date)
                            // data.push(element.value)
                            let date = new Date(element.date)
                            // am5.time.add(date, "day", 1)
                            inboundCallData.push(
                                {
                                    date : date.getTime(),
                                    value: element.value
                                }
                            )
                        });

                        inboundCallSeries.data.setAll(inboundCallData);

                    }else{
                        inboundCallSeries.data.setAll([{}]);
                    }

                    $('.ivrOutboundCallStatsLoader').show();
                    $('.inboundCallLineChartLoader').hide();
                })
            // $.ajax({
            //     url: baseUrl,
            //     contentType: "application/json; charset=utf-8",
            //     data:{
            //         start_date: startDate,
            //         end_date: endDate,
            //         campaign_id: campaignId,
            //     },
            //     success: function(response){
            //         // chart.series.removeIndex(0);
            //         if(response.inboundCall !== null && response.inboundCall.length > 0){
            //             response.inboundCall.forEach(el => {
            //                 response.dateRange.filter((e)=>{
            //                     if(e.date === el.date){
            //                         e['value'] = el['value'];
            //                     }
            //                 });
            //
            //             });
            //
            //             let inboundCallData = [];
            //             response.dateRange.forEach(element => {
            //                 // labels.push(element.date)
            //                 // data.push(element.value)
            //                 let date = new Date(element.date)
            //                 // am5.time.add(date, "day", 1)
            //                 inboundCallData.push(
            //                     {
            //                         date : date.getTime(),
            //                         value: element.value
            //                     }
            //                 )
            //             });
            //
            //             inboundCallSeries.data.setAll(inboundCallData);
            //
            //         }else{
            //             inboundCallSeries.data.setAll([{}]);
            //         }
            //         $('.ivrOutboundCallStatsLoader').show();
            //         // ivrOutboundCallStats();
            //
            //     },
            //     beforeSend: function(){
            //         $('.inboundCallLineChartLoader').show()
            //     },
            //     complete: function(){
            //         $('.inboundCallLineChartLoader').hide();
            //     }
            // });

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            inboundCallSeries.appear(1000);
            inboundCallChart.appear(1000, 100);

            // Enable export
            var exporting = am5plugins_exporting.Exporting.new(inboundCallLineChartRoot, {
                menu: am5plugins_exporting.ExportingMenu.new(inboundCallLineChartRoot, {
                    align: "left",
                    valign: "top"
                })
            });


            // }); // end am5.ready()



        }

        async function ivrOutboundCallStats(){

            let baseUrl = $('#getIvrOutboundCallDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();
            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id:listId
                }
            })
                .then((response) => {

                    if(response.data){

                        if(response.data.ivrOutboundCalls !== null && response.data.ivrOutboundCalls.length > 0){

                            var table = $('#ivrOutboundStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();

                            Object.keys(response.data.ivrOutboundCalls).forEach(function(key) {
                                table.row.add( [
                                    response.data.ivrOutboundCalls[key].campaign_name,
                                    response.data.ivrOutboundCalls[key].transfered_count !== null ? parseFloat(response.data.ivrOutboundCalls[key].transfered_count).toFixed(2) : 0,
                                    response.data.ivrOutboundCalls[key].optout_count !== null ? parseFloat(response.data.ivrOutboundCalls[key].optout_count).toFixed(2) : 0,
                                    response.data.ivrOutboundCalls[key].noinput_count !== null ? parseFloat(response.data.ivrOutboundCalls[key].noinput_count).toFixed(2) : 0,
                                    response.data.ivrOutboundCalls[key].total !==  0
                                        ?
                                        (parseFloat(response.data.ivrOutboundCalls[key].transfered_count) / parseFloat(response.data.ivrOutboundCalls[key].total) * 100 ).toFixed(2) +' %'
                                        :
                                        '0.0 %',
                                    response.data.ivrOutboundCalls[key].total !==  0
                                        ?
                                        (parseFloat(response.data.ivrOutboundCalls[key].optout_count) / parseFloat(response.data.ivrOutboundCalls[key].total) * 100 ).toFixed(2) +' %'
                                        :
                                        '0.0 %',
                                    response.data.ivrOutboundCalls[key].total !==  0
                                        ?
                                        (parseFloat(response.data.ivrOutboundCalls[key].noinput_count) / parseFloat(response.data.ivrOutboundCalls[key].total) * 100 ).toFixed(2) +' %'
                                        :
                                        '0.0 %',

                                ]).draw( false );
                            });

                        }else{
                            var table = $('#ivrOutboundStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                        }

                    }
                    $('.ivrOutboundCallStatsLoader').hide();
                    $('.outboundOptinHeatmapLoader').show();
                    // outboundOptinHeatMap();
                });

        }

        async function outboundOptinHeatMap(){

            am4core.useTheme(am4themes_animated);
            // Create map instance
            var chart = am4core.create("outboundOptinHeatmap", am4maps.MapChart);
            // Set map definition
            chart.geodata = am4geodata_usaLow;

            // Set projection
            chart.projection = new am4maps.projections.AlbersUsa();

            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());


            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                min: chart.colors.getIndex(1).brighten(1),
                max: chart.colors.getIndex(1).brighten(-0.3),
                logarithmic: true
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            let baseUrl = $('#getOutboundOptinDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,

                }
            })
                .then((response) => {
                    if(response.data && response.data.outboundOptin !== null){
                        if(typeof response.data.outboundOptin !== 'undefined' && response.data.outboundOptin.length > 0){
                            polygonSeries.data = response.data.outboundOptin
                        }else{
                            polygonSeries.data = [{}];
                        }

                    }

                    $('.outboundOptinHeatmapLoader').hide();
                    $('.ivrDncHeatMapLoader').show();
                    // ivrDncHeatMap();

                });

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;
            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = - 25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;


            // Configure series tooltip
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#3c5bdc");


            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);

            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });
            // Enable export
            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";

        }

        async function ivrDncHeatMap(){

            am4core.useTheme(am4themes_animated);
            // Create map instance
            var chart = am4core.create("ivrDncHeatmap", am4maps.MapChart);
            // Set map definition
            chart.geodata = am4geodata_usaLow;

            // Set projection
            chart.projection = new am4maps.projections.AlbersUsa();

            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());


            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                min: chart.colors.getIndex(1).brighten(1),
                max: chart.colors.getIndex(1).brighten(-0.3),
                logarithmic: true
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            let baseUrl = $('#getIvrDncHeatmapDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,

                }
            })
                .then((response) => {
                    if(response.data && response.data.ivrDncOptout !== null){
                        if(typeof response.data.ivrDncOptout !== 'undefined' && response.data.ivrDncOptout.length > 0){
                            polygonSeries.data = response.data.ivrDncOptout
                        }else{
                            polygonSeries.data = [{}];
                        }

                    }

                    $('.ivrDncHeatmapLoader').hide();
                    $('.dncHeatMapLoader').show();
                    // dncHeatMap();

                });

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;
            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = - 25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;


            // Configure series tooltip
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#3c5bdc");


            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);

            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });
            // Enable export
            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";

        }

        async function dncHeatMap(){

            am4core.useTheme(am4themes_animated);
            // Create map instance
            var chart = am4core.create("dncHeatmap", am4maps.MapChart);
            // Set map definition
            chart.geodata = am4geodata_usaLow;

            // Set projection
            chart.projection = new am4maps.projections.AlbersUsa();

            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());


            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                min: chart.colors.getIndex(1).brighten(1),
                max: chart.colors.getIndex(1).brighten(-0.3),
                logarithmic: true
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            let baseUrl = $('#getDncHeatmapDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,

                }
            })
                .then((response) => {
                    if(response.data && response.data.dncHeatmap !== null){
                        if(typeof response.data.dncHeatmap !== 'undefined' && response.data.dncHeatmap.length > 0){
                            polygonSeries.data = response.data.dncHeatmap
                        }else{
                            polygonSeries.data = [{}];
                        }

                    }

                    $('.dncHeatmapLoader').hide();
                    $('.stateSpecificStatsLoader').show();
                    // getReportStateStats();

                });

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;
            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = - 25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;


            // Configure series tooltip
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#3c5bdc");


            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);

            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });
            // Enable export
            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";

        }
        async function getReportStateStats(){
            let baseUrl = $('#getReportStateStatsDataURL').val();
            let dateRange = $('#dateRange').val();
            dateRange = dateRange.split(' - ');
            let startDate = dateRange[0];
            let endDate = dateRange[1];
            let campaignId = $('#camapign_select').val();
            let listId = $('#list_select').val();

            await axios.get(baseUrl, {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    campaign_id: campaignId,
                    list_id:listId
                }
            })
                .then((response) => {
                    if(response.data){
                        if(response.data.stateStats !== null && response.data.stateStats.length > 0){
                            var table = $('#stateSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();

                            Object.keys(response.data.stateStats).forEach(function(key) {
                                table.row.add( [
                                    response.data.stateStats[key].location_code,
                                    response.data.stateStats[key].avg_calls_duration !== null ? moment.utc(response.data.stateStats[key].avg_calls_duration*1000).format('mm:ss') : 0,
                                    response.data.stateStats[key].contact_count !==  0 && response.data.stateStats[key].contact_count !== null ? (parseFloat(response.data.stateStats[key].calls_back_count) / parseFloat(response.data.stateStats[key].contact_count) * 100 ).toFixed(2) +' %'  : '0.0 %',
                                    response.data.stateStats[key].calls_back_count,

                                ]).draw( false );
                            });
                        }else{
                            var table = $('#stateSpecificStatsTable').DataTable();
                            var rows = table
                                .rows()
                                .remove()
                                .draw();
                        }

                    }
                    $('.stateSpecificStatsLoader').hide();
                });
        }

    </script>


@endsection
