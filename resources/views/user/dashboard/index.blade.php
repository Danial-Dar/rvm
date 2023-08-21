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
     /*background-color: rgba(19, 24, 44, .03);*/
     background-color: rgba(0, 0, 0, 0.03) !important;
     /*border-bottom: 1px solid rgba(19, 24, 44, .125)*/
     border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
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
 .loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 10;
}
.loader
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
        </div>
        
         <div class="loader">
             <div class="text-center">
                 <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
             </div>
          </div>
        <div class="row">
          <div class="col-lg-6 mb-20">
              <input type="text" name="datetimes" class="form-control" />
           </div>
        </div>
         <div class="row ">
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="count_campaigns">{{count($campaigns)}}</h1>
                        <p>Total Campaigns</p>
                     </div>
                  </div>

               </div>
               
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="count_contact_lists">{{$contact_lists}}</h1>
                        <p>Total Contact Lists</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="total_sent">
                           @if($users != null)
                              @if($users->total_sent_count != null)
                                 {{$users->total_sent_count}}
                              @else
                                 0
                              @endif
                           @else
                              0
                           @endif
                        </h1>
                        <p>Total Sent</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="total_pending">
                           @if($users != null)
                              @if($users->total_contact_count != null || $users->total_contact_count != 0)
                                 {{$users->total_contact_count != 0 ? $users->total_contact_count - $users->total_sent_count - $users->total_dnc_count : 0}}
                              @else
                                 0
                              @endif
                           @else
                              0
                           @endif
                        </h1>
                        <p>Total Pending</p>
                     </div>
                  </div>
               </div>
            </div>
             <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="total_dnc">
                           {{-- @if($users != null)
                              @if($users->total_dnc_count != null)
                                 {{$users->total_dnc_count}}
                              @else
                                 0
                              @endif
                           @else
                              0
                           @endif --}}
                           {{$totalDNC}}
                        </h1>
                        <p>Total DNC Numbers</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xxl-3 col-sm-3  col-ssm-6 mb-30">
               
               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="total_reccording">{{$totalRecording}}</h1>
                        <p>Total Recording's</p>
                     </div>
                  </div>
               </div>
            </div>
        </div>
         <div class="row">
            <div class="col-lg-4 mb-20">
               <select name="camapign-select" id="camapign-select" class="form-control" onchange="showHideGraphs()">
                  <option value=""Selected> Choose campaigns</option>
                  @foreach($campaigns as $campaign)
                     <option value="{{$campaign->id}}">{{$campaign->name}}</option>
                  @endforeach   
               </select>
            </div>
          </div>
            <div class="row">
               <div class="col-xl-6 col-md-6 col-lg-6 mb-30" id="content_first" style="display: none;">
                 <div class="card broder-0 cashflowChart2">
                    <div class="card-header">
                       <h6>
                          Campaign & Api Status
                       </h6>
                       <div class="card-extra">
                          <ul class="card-tab-links mr-3 nav-tabs nav" role="tablist">
                             <li>
                                <a class="active" onclick="(function(){ $('#api_status_pie').removeClass('active show');$('#t_revenue-week').addClass('active show');})();return false;" href="#t_revenue-week" data-toggle="tab" id="t_revenue-week-tab" role="tab" aria-selected="true">Campaign</a>
                                
                             </li>
                             <li><a class="" onclick="(function(){ $('#api_status_pie').addClass('active show');$('#t_revenue-week').removeClass('active show');})();return false;" href="#api_status_pie" data-toggle="tab" id="api_status_pie-tab" role="tab" aria-selected="true">Api Status</a></li>
                             
                          </ul>
                       </div>
                    </div>
                    <div class="card-body">
                       <div class="tab-content">
                          <div class="tab-pane fade active show" id="t_revenue-week" role="tabpanel" aria-labelledby="t_revenue-week-tab">
                             
                             <div class="cashflow-chart">
                                <div class="parentContainer">
                                   <div>
                                     <div class="page-content page-container" id="page-content">
                                           <div class="row">
                                                 <div class="container-fluid d-flex justify-content-center">
                                                    
                                                    <div class="col-sm-12 col-md-12" id="canvasPieSecond">
                                                       <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                          <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                          </div>
                                                          <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                          </div>
                                                       </div>
                                                       <canvas id="chart-line-pie-second" class="chartjs-render-monitor" style="display: block;"></canvas>
                                                    </div>
                                                 </div>
                                           </div>
                                     </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                       <div class="tab-content">
                         <div class="tab-pane fade" id="api_status_pie" role="tabpanel" aria-labelledby="api_status_pie-tab">
                              <div class="cashflow-chart">
                                <div class="parentContainer">
                                   <div>
                                   <div class="page-content page-container" id="page-content">
                                         <div class="row">
                                               <div class="container-fluid d-flex justify-content-center">
                                                  
                                                  <div class="col-sm-12 col-md-12"  id="canvasApiStatus">
                                                     <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                              <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                              <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                        </div>
                                                     </div>
                                                     <canvas id="chart-line-pie-api" class="chartjs-render-monitor" style="display: block;"></canvas>
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
                 </div>
              </div>
               <div class="col-xl-6 col-md-6 col-lg-6 mb-30" id="content_third" style="display: none;">
                 <div class="card broder-0 cashflowChart2">
                    <div class="card-header">
                       <h6>
                          Contact List
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
                             
                             <div class="cashflow-chart">
                                <div class="parentContainer">
                                   <div>
                                   <div class="page-content page-container" id="page-content">
                                         <div class="row">
                                               <div class="container-fluid d-flex justify-content-center">
                                                  
                                                  <div class="col-sm-12 col-md-12" id="canvasThird">
                                                     <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                              <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                              <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                        </div>
                                                     </div>
                                                     <canvas id="chart-line-pie-third" class="chartjs-render-monitor" style="display: block;"></canvas>
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
                 </div>
              </div>
            </div>
           
            
            <div class="row">
              <div class="col-xl-12 col-md-12 mb-30" id="content_second" style="display: none;">
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
                                                  <div class="col-sm-8 col-md-12" id="canvasSecond">
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
                       </div>
                    </div>
                 </div>
              </div>
            </div>
             <div class="row">
              <div class="col-xl-12 col-md-12 mb-30" id="content_fourth" style="display: none;">
                 <div class="card broder-0 cashflowChart2">
                    <div class="card-header">
                       <h6>
                          Campaign Initiated
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
                                                  <div class="col-sm-8 col-md-12" id="canvasFourth">
                                                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                           <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                 <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                           </div>
                                                           <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                 <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                           </div>
                                                        </div> <canvas id="chart-line-bar-fourth" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                                    
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
                 </div>
              </div>
            </div>
            {{-- Campaign Initiated end --}}
            {{-- drops per hour daily --}}
            <div class="row" id="dropsPerHourDailyDatePicker" style="display: none;margin-bottom:5px;">
              <div class="col-lg-4">
               <input type="text" name="drops_per_hour_daily" id="dropsPerHourDaily" class="form-control" onchange="campaignInitiatedPerHour(this.value)">
              </div>
            </div>
            <div class="row">
              <div class="col-xl-12 col-md-12 mb-30" id="content_fifth" style="display: none;">
                 <div class="card broder-0 cashflowChart2">
                    <div class="card-header">
                       <h6>
                          Campaign Initiated Per Hour
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
                                                  <div class="col-sm-8 col-md-12" id="canvasFifth">
                                                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                           <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                 <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                           </div>
                                                           <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                 <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                           </div>
                                                        </div> <canvas id="chart-line-bar-fifth" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                                    
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
                 </div>
              </div>
            </div>
      </div>
   </div>
  
</div>
  
<script>
$(function() {
  let startDate = moment().startOf('month').format('YYYY-MM-DD');
  let endDate = moment().endOf('month').format('YYYY-MM-DD');
  localStorage.setItem("start_date", startDate);
  localStorage.setItem("end_date", endDate);
  $('input[name="datetimes"]').daterangepicker({
    // timePicker: true,
    startDate: moment().startOf('month'),
    endDate: moment().endOf('month'),
    alwaysShowCalendars:true,
    locale: {
      format: 'YYYY-MM-DD'
    },
   ranges: {
      'Today': [moment(), moment()],
      'This Week': [moment().startOf('isoWeek'), moment()],
      //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      //'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last Week': [moment().startOf('week').subtract(7,'days'), moment().endOf('week').subtract(7, 'days')],
      //'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
   }
  }, 
  function(start, end, label) {
    var startDate = start.format('YYYY-MM-DD');
    var endDate = end.format('YYYY-MM-DD');
      // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
      // ajaxDashboard(startDate,endDate)
      
      localStorage.removeItem("start_date");
      localStorage.removeItem("end_date");
      localStorage.setItem("start_date", startDate);
      localStorage.setItem("end_date", endDate);
      if($('#camapign-select').val() !== ""){
        showHideGraphs(startDate,endDate)
      }
      
  });
//   ajaxDashboard(startDate,endDate);

  $('#dropsPerHourDaily').datepicker({
      dateFormat: "yy-mm-dd",
      autoclose: true,
      todayHighlight: true,
  }).datepicker("setDate","now");

});
</script>
<script type="text/javascript">
//   function ajaxDashboard(start_date,end_date)
//   {
    
//     $.ajax({
//         url: '{{route('user.ajaxdashboard')}}',
//         contentType: "application/json; charset=utf-8", 
//         data:{start_date: start_date,end_date:end_date},
//         success: function(result){
//           console.log(result);
//           if(result !== null){
//             $('#count_campaigns').text(result['count_campaigns']);
//             $('#count_contact_lists').text(result['count_contact_lists']);
//             $('#total_sent').text(result['totalSent']);
//             $('#total_pending').text(result['totalPending']);
//             $('#total_dnc').text(result['totalDNC']);
//             $('#total_reccording').text(result['total_recording']);
            
           
//           }
            
//         },
//         beforeSend: function(){
//              $('.loader').show()
//          },
//         complete: function(){
//              $('.loader').hide();
//         }
//     });

//   }

  function campaignInitiatedPerHour(date){
    
    let campaign_id = $('#camapign-select').val();
    let selected_date = date;
    
    $("#chart-line-bar-fifth").remove(); // this is my <canvas> element
    
    $('#canvasFifth').append('<canvas id="chart-line-bar-fifth" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"><canvas>');
     
    $.ajax({
        url: '{{route('user.dashboard.per_hour_results')}}',
        contentType: "application/json; charset=utf-8", 
        data:{drops_per_hour_date: selected_date,campaign_id:campaign_id},
        success: function(result){
          
          if(result['campaignInitiatedPerHour'].length > 0){
            // var campaignInitiatedPerHourLabel=[];
            // var campaignInitiatedPerHourCount=[];
            // if(campaignInitiatedPerHour.length > 0){
            //   for(var i=0;i<result['campaignInitiatedPerHour'].length;i++){
            //     campaignInitiatedPerHourLabel.push(result['campaignInitiatedPerHour'][i]['hour'])
            //     campaignInitiatedPerHourCount.push(result['campaignInitiatedPerHour'][i]['count'])
            //   }
            // }
            var bar_graph_fifth = $("#chart-line-bar-fifth");
            var myBarGraphFifth = new Chart(bar_graph_fifth, {
               type: 'line',
               data: {
                  
                  labels: Object.values(result['dropsPerHourArray']),
                  //  labels: list_contacts,
                  datasets: [{
                     //   data: [50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000],
                     data: Object.values(result['campaignInitiatedPerHour']),
                     label: "Campaign Initiated Per Hour",
                     borderColor: "#458af7",
                     backgroundColor: '#458af7',
                     fill: false
                  }]
               },
               options: {
                  title: {
                     display: true,
                     text: 'Campaign Initiated Per Hour'
                  }
               }
            });
          }else{
            var bar_graph_fifth = $("#chart-line-bar-fifth");
            var myBarGraphFifth = new Chart(bar_graph_fifth, {
               type: 'line',
               data: {
                  
                  labels: [],
                  datasets: [{
                     data: [],
                     label: "Campaign Initiated Per Hour",
                     borderColor: "#458af7",
                     backgroundColor: '#458af7',
                     fill: false
                  }]
               },
               options: {
                  title: {
                     display: true,
                     text: 'Campaign Initiated Per Hour'
                  }
               }
            });
          }
          
          
          
            
        },
        beforeSend: function(){
             $('.loader').show()
         },
        complete: function(){
             $('.loader').hide();
        }
    });
  }
  
</script>
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
   // pie chart
   //  $(document).ready(function() {
      function graphs(list_names, list_contacts,successful, initiated, pending, fail,sent,totalCampaignContacts,campaignInitiatedPerHour,periods,totalCampaignInitiated,dropsPerHourArray) {

         
         var pie_second = $("#chart-line-pie-second");
         var myPieSecond = new Chart(pie_second, {
               type: 'pie',
               data: {
                  labels: ["Successfull", "Initiated", "Failed"], //, "Pending"
                  datasets: [{
                     data: [successful, initiated, fail], //, pending
                     backgroundColor: ["#0074D9", "#2ECC40", "#FF4136"], //, "yellowgreen"
                     hoverBackgroundColor: "#20C997",
                     label: label,
                  }]
               },
               options: {
                 maintainAspectRatio: true,
                  title: {
                     display: true,
                     position: "bottom",
                     text: 'Campaign'
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
               }
         });

         // api status
         var pie_second_api = $("#chart-line-pie-api");
         var myPieSecondApi = new Chart(pie_second_api, {
               type: 'pie',
               data: {
                  labels: ["Sent", "Pending"],
                  datasets: [{
                     data: [sent, pending],
                     backgroundColor: ["#FF851B", "#7FDBFF"],
                     // hoverBackgroundColor: "#20C997",
                     label: label,
                  }]
               },
               options: {
                 maintainAspectRatio: true,
                  title: {
                     display: true,
                     position: "bottom",
                     text: 'Api Status'
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
               }
         });
         
         // contact list pie chart
         let background=[];

         for (let i=0;i<list_contacts.length;i++) {
              // background.push('#'+Math.floor(Math.random()*16777215).toString(16));
              background.push('#'+(Math.random()*0xFFFFFF<<0).toString(16));
         }
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
         // console.log(totalCampaignContacts)
         var pie_third = $("#chart-line-pie-third");
         var myPieThird = new Chart(pie_third, {
               type: 'pie',
               data: {
                  labels: list_names,
                  datasets: [{
                     data: list_contacts,
                     backgroundColor: background,
                     label: label,
                  }]
               },
                options: {
                 maintainAspectRatio: true,
                  // title: {
                  //    display: true,
                  //    text: 'Contact List'
                  // },
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
                        // //  alert(allData)
                       // return tooltipLabel + ": " + tooltipData + "%";
                          return tooltipLabel + ": "+ tooltipData + " | " + percentage;
                    }
                  }
                }
              }
         });
         //Horizontal bargraph
         var bar_graph = $("#chart-line-bar");
         // console.log(list_names);
         // console.log(list_contacts);
         

         var myBarGraph = new Chart(bar_graph, {
               type: 'bar',
               data: {
                  //  labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050, 1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
                  // labels: [list_names[0], list_names[1]],
                  labels: Object.values(list_names),
                  //  labels: list_contacts,
                  datasets: [{
                     //   data: [50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000],
                     data: Object.values(list_contacts),
                     label: "No. Of Contacts",
                     borderColor: "#458af7",
                     backgroundColor: '#458af7',
                     fill: false
                  }]
               },
               options: {
                  title: {
                     display: true,
                     text: 'Contacts Information'
                  }
               }
         });
         // campaign initiated

          // var campaignInitiatedLabel=[];
          // var campaignInitiatedCount=[];

          // if(campaignInitiated.length > 0){
          //   for(var i=0;i<campaignInitiated.length;i++){
          //     campaignInitiatedLabel.push(campaignInitiated[i]['date'])
          //     campaignInitiatedCount.push(campaignInitiated[i]['count'])
          //   }
          // }

         //   console.log(campaignInitiatedLabel);
         // console.log(campaignInitiatedCount);
        
         var bar_graph_fourth = $("#chart-line-bar-fourth");
         var myBarGraphFourth = new Chart(bar_graph_fourth, {
               type: 'line',
               data: {
                  //  labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050, 1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
                  // labels: [list_names[0], list_names[1]],
                  labels: Object.values(periods),
                  //  labels: list_contacts,
                  datasets: [{
                     //   data: [50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000],
                     data: Object.values(totalCampaignInitiated),
                     label: "Campaign Initiated",
                     borderColor: "#458af7",
                     backgroundColor: '#458af7',
                     fill: false
                  }]
               },
               options: {
                  title: {
                     display: true,
                     text: 'Campaign Initiated'
                  }
               }
         });

          // var campaignInitiatedPerHourLabel=[];
          // var campaignInitiatedPerHourCount=[];

          // if(campaignInitiatedPerHour.length > 0){
          //   for(var i=0;i<campaignInitiatedPerHour.length;i++){
          //     campaignInitiatedPerHourLabel.push(campaignInitiatedPerHour[i]['hour'])
          //     campaignInitiatedPerHourCount.push(campaignInitiatedPerHour[i]['count'])
          //   }
          // }
      
         var bar_graph_fifth = $("#chart-line-bar-fifth");
         var myBarGraphFifth = new Chart(bar_graph_fifth, {
               type: 'line',
               data: {
                  //  labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050, 1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
                  // labels: [list_names[0], list_names[1]],
                  labels: Object.values(dropsPerHourArray),
                  //  labels: list_contacts,
                  datasets: [{
                     //   data: [50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000],
                     data: Object.values(campaignInitiatedPerHour),
                     label: "Campaign Initiated Per Hour",
                     borderColor: "#458af7",
                     backgroundColor: '#458af7',
                     fill: false
                  }]
               },
               options: {
                  title: {
                     display: true,
                     text: 'Campaign Initiated Per Hour'
                  }
               }
         });

          
      }
      // });

    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }  
    //to show hide div 
   async function showHideGraphs(start_date,end_date) {
      // var x = element.value;
      let startDate = localStorage.getItem('start_date');
      let endDate = localStorage.getItem('end_date');
      var element = document.getElementById('camapign-select');
      var x = element.value;
      var url = '<?php echo url('user/dashboard/results/') ?>';
      // alert(url+'/'+x);
      let dropsPerHourDailyDatePicker = $('#dropsPerHourDaily').val();

      response = await axios.get(url+'/'+x+'?start_date='+startDate+'&end_date='+endDate+'&drops_per_hour_date='+dropsPerHourDailyDatePicker);
      // response = await axios.get('/rvm-laravel/user/dashboard/results/'+element.value);
      var list_names = response.data.contact_list_names;
      var list_contacts = response.data.contact_list_contacts;
      var successful = response.data.successful;
      var initiated = response.data.initiated;
      var pending = response.data.pending;
      var sent = response.data.initiated;
      var fail = response.data.fail;
      var totalCampaignContacts = response.data.totalCampaignContacts;
      var campaignInitiated = response.data.campaignInitiated;
      var campaignInitiatedPerHour = response.data.campaignInitiatedPerHour;
      var dropsPerHourArray = response.data.dropsPerHourArray;
      var periods = response.data.periods;
      var totalCampaignInitiated = response.data.totalCampaignInitiated;
      // alert(successful);
      $("#chart-line-bar-fourth").remove(); // this is my <canvas> element
    
      $('#canvasFourth').append('<canvas id="chart-line-bar-fourth" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"><canvas>');
      
      // $("#chart-line-bar").remove(); // this is my <canvas> element
    
      // $('#canvasSecond').append('<canvas id="chart-line-bar" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"><canvas>');
       

      $("#chart-line-pie-second").remove();
      $('#canvasPieSecond').append('<canvas id="chart-line-pie-second" class="chartjs-render-monitor" style="display: block;"></canvas>');

      $("#chart-line-pie-third").remove(); // this is my <canvas> element
      $('#canvasThird').append('<canvas id="chart-line-pie-third" class="chartjs-render-monitor" style="display: block"></canvas>');

      $("#chart-line-pie-api").remove();
      $('#canvasApiStatus').append('<canvas id="chart-line-pie-api" class="chartjs-render-monitor" style="display: block;"></canvas>');
      graphs(list_names, list_contacts, successful, initiated, pending, fail,sent,totalCampaignContacts,campaignInitiatedPerHour,periods,totalCampaignInitiated,dropsPerHourArray);
      document.getElementById("content_first").style.display = element.value != "" ? 'block' : 'none';
      // document.getElementById("content_second").style.display = element.value != "" ? 'block' : 'none';
      // document.getElementById("api_content").style.display = element.value != "" ? 'block' : 'none';
      document.getElementById("content_third").style.display = element.value != "" ? 'block' : 'none';
      document.getElementById("content_fourth").style.display = element.value != "" ? 'block' : 'none';
      document.getElementById("content_fifth").style.display = element.value != "" ? 'block' : 'none';
      document.getElementById("dropsPerHourDailyDatePicker").style.display = element.value != "" ? 'block' : 'none';
      

   }
</script>

@endsection
{{-- Scripts Section --}}

@section('scripts')
<script src="{{ asset('vendor_assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/charts.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
@endsection