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
</style>
<div class="contents">
   <div class="crm">
      <div class="container-fluid">
         <div class="row ">
            <div class="col-lg-12 mb-20">
               <div class="breadcrumb-main">
                  <h4 class="text-capitalize breadcrumb-title">RVM</h4>
               </div>
               <select name="" id="" class="form-control" style="width:25%">
                     <option value=""Selected> Choose campaigns</option>
                  </select>
            </div>
            <!-- <div class="col-lg-12">
               <div class="form-group col-md-4 px-0">
                  <label for="daterange">Date Range</label>
                  <input type="text" name="daterange" id="daterange" class="form-control">
               </div>
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1>$<?php echo number_format(123132, 0, '', ',')?></h1>
                        <p>Total Refund Amount</p>
                     </div>
                  </div>

               </div>
               
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1>4654787</h1>
                        <p>Customers</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                     <h1>$<?php echo number_format(12345, 2, '.', ',')?></h1>
                        <p>Total Amount</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                     <h1>23324</h1>
                        <p>Total orders</p>
                     </div>
                  </div>
               </div>
            </div>
             -->
             <div class="col-xl-12 col-md-12 mb-30">
               <div class="card broder-0 cashflowChart2">
                  <div class="card-header">
                     <h6>
                        Campaigns Information
                     </h6>
                     <div class="card-extra">
                        <ul class="card-tab-links mr-3 nav-tabs nav" role="tablist">
                           <li>
                              <a class="active" href="#t_revenue-week" data-toggle="tab" id="t_revenue-week-tab" role="tab" aria-selected="true">All</a>
                           </li>
                           
                        </ul>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="tab-content">
                        <div class="tab-pane fade active show" id="t_revenue-week" role="tabpanel" aria-labelledby="t_revenue-week-tab">
                           <div class="cashflow-display d-flex">
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Total Campaigns</span>
                                 <h2 class="cashflow-display__amount">16<span class="color-danger fs-14 fw-600 mr-10"></span></h2>
                              </div>
                           </div>
                           <div class="cashflow-chart">
                              <div class="parentContainer">
                                 <div>
                                 <div class="page-content page-container" id="page-content">
                                       <div class="row">
                                             <div class="container-fluid d-flex justify-content-center">
                                                <div class="col-sm-8 col-md-4">
                                                   <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                      <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                      </div>
                                                      <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                      </div>
                                                   </div> <canvas id="chart-line-pie-first" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                                </div>
                                                <div class="col-sm-8 col-md-4">
                                                   <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                      <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                      </div>
                                                      <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                      </div>
                                                   </div> <canvas id="chart-line-pie-second" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                                </div>
                                             </div>
                                       </div>
                                 </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="t_revenue-month" role="tabpanel" aria-labelledby="t_revenue-month-tab">
                           <div class="cashflow-display d-flex">
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Total Campaigns</span>
                                 <h2 class="cashflow-display__amount">16</h2>
                              </div>
                           </div>
                           <div class="cashflow-chart">
                              <div class="parentContainer">
                                 <div>
                                    <canvas id="barChartCashflow_Mextra"></canvas>
                                 </div>
                              </div>
                              <ul class="legend-static ml-2">
                                 <li class="custom-label">
                                    <span class="bg-success"></span>Total Campaigns
                                 </li>
                                 <li class="custom-label">
                                    <span class="bg-primary"></span>Amount
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="t_revenue-year" role="tabpanel" aria-labelledby="t_revenue-year-tab">
                           <div class="cashflow-display d-flex">
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Won</span>
                                 <h2 class="cashflow-display__amount">50.8</h2>
                              </div>
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Amount</span>
                                 <h2 class="cashflow-display__amount">$28k</h2>
                              </div>
                           </div>
                           <div class="cashflow-chart">
                              <div class="parentContainer">
                                 <div>
                                    <canvas id="barChartCashflowExtra"></canvas>
                                 </div>
                              </div>
                              <ul class="legend-static ml-2">
                                 <li class="custom-label">
                                    <span class="bg-success"></span>Won
                                 </li>
                                 <li class="custom-label">
                                    <span class="bg-primary"></span>Amount
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-12 col-md-12 mb-30">
               <div class="card broder-0 cashflowChart2">
                  <div class="card-header">
                     <h6>
                        Contacts Information
                     </h6>
                     <div class="card-extra">
                        <ul class="card-tab-links mr-3 nav-tabs nav" role="tablist">
                           <li>
                              <a class="active" href="#t_revenue-week" data-toggle="tab" id="t_revenue-week-tab" role="tab" aria-selected="true">All</a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="tab-content">
                        <div class="tab-pane fade active show" id="t_revenue-week" role="tabpanel" aria-labelledby="t_revenue-week-tab">
                           <div class="cashflow-display d-flex">

                           </div>
                           <div class="cashflow-chart">
                              <div class="parentContainer">
                                 <div>
                                    <div class="page-content page-container" id="page-content">
                                       <div class="row">
                                             <div class="container-fluid d-flex justify-content-center">
                                                <div class="col-sm-8 col-md-12">
                                                      <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                         <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                               <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                         </div>
                                                         <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                               <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                         </div>
                                                      </div> <canvas id="chart-line-bar" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                                  
                                                </div>
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="t_revenue-month" role="tabpanel" aria-labelledby="t_revenue-month-tab">
                           <div class="cashflow-display d-flex">
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Total Forms</span>
                                 <h2 class="cashflow-display__amount">123</h2>
                              </div>
                           </div>
                           <div class="cashflow-chart">
                              <div class="parentContainer">
                                 <div>
                                    <canvas id="barChartCashflow_Mextra"></canvas>
                                 </div>
                              </div>
                              <ul class="legend-static ml-2">
                                 <li class="custom-label">
                                    <span class="bg-success"></span>Total Forms
                                 </li>
                                 <li class="custom-label">
                                    <span class="bg-primary"></span>Amount
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="t_revenue-year" role="tabpanel" aria-labelledby="t_revenue-year-tab">
                           <div class="cashflow-display d-flex">
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Won</span>
                                 <h2 class="cashflow-display__amount">50.8</h2>
                              </div>
                              <div class="cashflow-display__single">
                                 <span class="cashflow-display__title">Amount</span>
                                 <h2 class="cashflow-display__amount">$28k</h2>
                              </div>
                           </div>
                           <div class="cashflow-chart">
                              <div class="parentContainer">
                                 <div>
                                    <canvas id="barChartCashflowExtra"></canvas>
                                 </div>
                              </div>
                              <ul class="legend-static ml-2">
                                 <li class="custom-label">
                                    <span class="bg-success"></span>Won
                                 </li>
                                 <li class="custom-label">
                                    <span class="bg-primary"></span>Amount
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
            

         </div>

         
      </div>
   </div>
</div>
<script>
function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }
$( document ).ready(function() {
   let start_date = new Date();
    let end_date = new Date();
    <?php if(isset($params['start_date'])): ?>
        start_date = `<?php echo $params['start_date'] ?>`;
    <?php endif; ?>
    <?php if(isset($params['end_date'])): ?>
        end_date = `<?php echo $params['end_date'] ?>`;
    <?php endif; ?>
    if(start_date !== null) {
      start_date = moment(start_date, "YYYY-MM-DD").toDate();
    }
    if(end_date !== null) {
      end_date =  moment(end_date, "YYYY-MM-DD").toDate();
    }
   $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        startDate: start_date,
        endDate: end_date
    }, function(start, end, label) {
        let location = updateQueryStringParameter(window.location.href,'start_date', start.format('YYYY-MM-DD'));
        location = updateQueryStringParameter(location, 'end_date', end.format('YYYY-MM-DD'));
        window.location = location;
    });

});
</script>
<script>
   //pie chart
    $(document).ready(function() {
        var ctx = $("#chart-line-pie-first");
        var myLineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Active", "Inactive", "Pending"],
                datasets: [{
                    data: [1200, 1700, 800],
                    backgroundColor: ["#F7464A", "#FDB45C", "#e2e200"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Total Campaign'
                }
            }
        });
      //pie chart second
      var ctx = $("#chart-line-pie-second");
        var myLineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Active", "Inactive"],
                datasets: [{
                    data: [1850, 1850],
                    backgroundColor: ["#F7464A", "#FDB45C"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Campaign'
                }
            }
        });

   //Horizontal bargraph
   var ctx = $("#chart-line-bar");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
                datasets: [{
                    data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478],
                    label: "User",
                    borderColor: "#458af7",
                    backgroundColor: '#458af7',
                    fill: false
                }, {
                    data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
                    label: "Contacts",
                    borderColor: "#8e5ea2",
                    fill: true,
                    backgroundColor: '#8e5ea2'
                },]
            },
            options: {
                title: {
                    display: true,
                    text: 'Contacts Information'
                }
            }
        });
    });
</script>

@endsection
{{-- Scripts Section --}}

@section('scripts')
<script src="{{ asset('vendor_assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/charts.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
@endsection