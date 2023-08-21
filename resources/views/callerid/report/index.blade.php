@extends('layouts.app')
@section('content')
<style>
.linegraphchartdiv {
    width: 100%;
    height: 500px;
    max-width: 100%
}
.heat_map{
    height: 500px;
}
.bargraphchartdiv{
    width: 100%;
    height: 500px;
}
</style>
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
                  <h4 class="text-capitalize breadcrumb-title">Caller Id Reports</h4>
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
        {{-- <div class="row">
          <div class="col-lg-6 mb-20">
              <input type="text" name="datetimes" class="form-control" />
           </div>
        </div> --}}
         <div class="row ">
            <div class="col-xxl-3 col-sm-4  col-ssm-6 mb-30">

               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="count_campaigns">{{$monitored_count}}</h1>
                        <p>Total Numbers Monitored</p>
                     </div>
                  </div>

               </div>

            </div>
            <div class="col-xxl-3 col-sm-4  col-ssm-6 mb-30">

               <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                  <div>
                     <div class="overview-content">
                        <h1 id="count_contact_lists">{{ number_format($good_count/($monitored_count?$monitored_count:1) * 100, 2)}}</h1>
                        <p> Good Status (%)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xxl-3 col-sm-4  col-ssm-6 mb-30">
                <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                   <div>
                      <div class="overview-content">
                         <h1 id="count_contact_lists">{{number_format($fair_count/($monitored_count?$monitored_count:1) * 100, 2)}}</h1>
                         <p> Fair Status (%)</p>
                      </div>
                   </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-4  col-ssm-6 mb-30">
                <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                   <div>
                      <div class="overview-content">
                         <h1 id="count_contact_lists">{{number_format($bad_count/($monitored_count?$monitored_count:1) * 100, 2)}}</h1>
                         <p>  Bad Status (%)</p>
                      </div>
                   </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-4  col-ssm-6 mb-30">
                <div class="ap-po-details ap-po-details--2 p-25 radius-xl bg-white d-flex justify-content-between">
                   <div>
                      <div class="overview-content">
                         <h1 id="count_contact_lists">{{number_format($terrible_count/($monitored_count?$monitored_count:1) * 100, 2)}}</h1>
                         <p> Terrible status (%)</p>
                      </div>
                   </div>
                </div>
            </div>
        </div>

        {{-- numberToStateHeatMap heatmap start --}}
        <div class="card">
            <div class="card-header">
                <h1>Numbers Heatmap</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="numberToStateHeatMapLoader" id="" style="display:none;position:relative;top:10rem;z-index: 1;">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            </div>
                        </div>
                        <div class="heat_map" id="numberToStateHeatMap"></div>

                    </div>
                </div>
            </div>
        </div>

         {{-- NumbersCountToDayLineGraph start --}}
         <div class="card">
            <div class="card-header">
                <h1>Numbers Monitored as time</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="NumberMonitoredLoader" id="" style="display:none;position:relative;top:10rem;z-index: 1;">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            </div>
                        </div>
                        <div class="linegraphchartdiv" id="countToDayLineGraph"></div>

                    </div>
                </div>
            </div>
        </div>

        {{-- NumberscountdaycompanyBarGraph start --}}
        <div class="card">
            <div class="card-header">
                <h1>Numbers By Company</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="NumberscountdaycompanyBarGraphLoader" id="" style="display:none;position:relative;top:10rem;z-index: 1;">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            </div>
                        </div>
                        <div class="bargraphchartdiv" id="NumberscountdaycompanyBarGraph"></div>

                    </div>
                </div>
            </div>
        </div>



      </div>
   </div>

</div>

{{-- @if(auth()->user()->role =="user") --}}

<input type="hidden" id="getReportByDayDataURL" value="{{route('callerid.report.count_per_day')}}"/>
<input type="hidden" id="getReportByStatsDataURL" value="{{route('callerid.report.count_per_state')}}"/>
<input type="hidden" id="getReportcountdaycompany" value="{{route('callerid.report.count_day_company')}}"/>

{{-- @endif --}}

<script>
$(function() {
    $('.numberToStateHeatMapLoader').show();

  let startDate = moment().startOf('month').format('YYYY-MM-DD');
  let endDate = moment().endOf('month').format('YYYY-MM-DD');
  localStorage.setItem("start_date", startDate);
  localStorage.setItem("end_date", endDate);
        //   $('input[name="datetimes"]').daterangepicker({
        //     // timePicker: true,
        //     startDate: moment().startOf('month'),
        //     endDate: moment().endOf('month'),
        //     alwaysShowCalendars:true,
        //     locale: {
        //       format: 'YYYY-MM-DD'
        //     },
        //    ranges: {
        //       'Today': [moment(), moment()],
        //       'This Week': [moment().startOf('isoWeek'), moment()],
        //       //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //       //'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //       'Last Week': [moment().startOf('week').subtract(7,'days'), moment().endOf('week').subtract(7, 'days')],
        //       //'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //       'This Month': [moment().startOf('month'), moment().endOf('month')],
        //       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //    }
        //   },
        //   function(start, end, label) {
        //     var startDate = start.format('YYYY-MM-DD');
        //     var endDate = end.format('YYYY-MM-DD');
        //       // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        //       // ajaxDashboard(startDate,endDate)

        //       localStorage.removeItem("start_date");
        //       localStorage.removeItem("end_date");
        //       localStorage.setItem("start_date", startDate);
        //       localStorage.setItem("end_date", endDate);
        //       if($('#camapign-select').val() !== ""){
        //         showHideGraphs(startDate,endDate)
        //       }

        //   });
        //   ajaxDashboard(startDate,endDate);

        //   $('#dropsPerHourDaily').datepicker({
        //       dateFormat: "yy-mm-dd",
        //       autoclose: true,
        //       todayHighlight: true,
        //   }).datepicker("setDate","now");

});

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
   }



</script>

@endsection
{{-- Scripts Section --}}

@section('scripts')


<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//cdn.amcharts.com/lib/5/plugins/exporting.js"></script>


<script src="{{ asset('vendor_assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/charts.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>


<script>
    // For countToDayLineGraph straight lines
    am5.ready(async function() {
        return;
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("countToDayLineGraph");


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
        am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX:true
        }));


        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
        behavior: "none"
        }));
        cursor.lineY.set("visible", false);


        // Generate random data
        // var date = new Date();
        // date.setHours(0, 0, 0, 0);
        // var value = 100;



        // function generateData() {
        // value = Math.round((Math.random() * 10 - 5) + value);
        // am5.time.add(date, "day", 1);
        // return {
        //     date: date.getTime(),
        //     value: value
        // };
        // }

        // function generateDatas(count) {
        // var data = [];
        // for (var i = 0; i < count; ++i) {
        //     data.push(generateData());
        // }
        // return data;
        // }


        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        maxDeviation: 0.2,
        baseInterval: {
            timeUnit: "day",
            count: 1
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        valueXField: "date",
        tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
        })
        }));


        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
        orientation: "horizontal"
        }));


        // Set data
        // var data = generateDatas(1200);
        // series.data.setAll(data);

        response = await axios.get($('#getReportByDayDataURL').val());
        if(response.status==200){
            series.data.setAll(
                response.data.map(o=>({
                    date : (new Date(o.day)).getTime(),
                    value: o.count
                }))
            );
        }


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);

    });

    // For countToDayLineGraph
    am5.ready(async function(){
        // return;
        var lineChartReportBydayRoot = am5.Root.new("countToDayLineGraph");
        lineChartReportBydayRoot.setThemes([ am5themes_Animated.new(lineChartReportBydayRoot) ]);
        var numbersByDayChart = lineChartReportBydayRoot.container.children.push(am5xy.XYChart.new(lineChartReportBydayRoot, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX"
        }));
        numbersByDayChart.chartContainer.wheelable = false;
        var inboundCallCursor = numbersByDayChart.set("cursor", am5xy.XYCursor.new(lineChartReportBydayRoot, {
            behavior: "none"
        }));
        inboundCallCursor.lineY.set("visible", false);
        var bydayXAxis = numbersByDayChart.xAxes.push(am5xy.DateAxis.new(lineChartReportBydayRoot, {
            maxDeviation: 0.5,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(lineChartReportBydayRoot, {
            pan:"zoom"
        }),
            tooltip: am5.Tooltip.new(lineChartReportBydayRoot, {})
        }));
        var bydayYAxis = numbersByDayChart.yAxes.push(am5xy.ValueAxis.new(lineChartReportBydayRoot, {
                maxDeviation:1,
                renderer: am5xy.AxisRendererY.new(lineChartReportBydayRoot, {
                pan:"zoom"
            })
        }));
        var byDaySeries = numbersByDayChart.series.push(am5xy.SmoothedXLineSeries.new(lineChartReportBydayRoot, {
            name: "Series",
            xAxis: bydayXAxis,
            yAxis: bydayYAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(lineChartReportBydayRoot, {
                labelText: "{valueY}"
            })
        }));
        byDaySeries.fills.template.setAll({
            visible: true,
            fillOpacity: 0.2
        });
        byDaySeries.bullets.push(function() {
            return am5.Bullet.new(lineChartReportBydayRoot, {
                    locationY: 0,
                    sprite: am5.Circle.new(lineChartReportBydayRoot, {
                    radius: 4,
                    stroke: lineChartReportBydayRoot.interfaceColors.get("background"),
                    strokeWidth: 2,
                    fill: byDaySeries.get("fill")
                })
            });
        });
        numbersByDayChart.set("scrollbarX", am5.Scrollbar.new(lineChartReportBydayRoot, {
            orientation: "horizontal"
        }));

        response = await axios.get($('#getReportByDayDataURL').val());
        if(response.status==200){
        // console.log('response::::',response);
            byDaySeries.data.setAll(response.data.map((o)=>({
                        date : (new Date(o.day)).getTime(),
                        value: o.count
                    })));
        }
        byDaySeries.appear(1000);
        numbersByDayChart.appear(1000, 100);
        // Enable export
        var exporting = am5plugins_exporting.Exporting.new(lineChartReportBydayRoot, {
            menu: am5plugins_exporting.ExportingMenu.new(lineChartReportBydayRoot, {
                align: "left",
                valign: "top"
            })
        });

    });


    //numbers heatmap by states
    am5.ready(async function(){

        am4core.useTheme(am4themes_animated);
        // Create map instance
        var chart = am4core.create("numberToStateHeatMap", am4maps.MapChart);
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

        let baseUrl = $('#getReportByStatsDataURL').val();
        await axios.get(baseUrl)
        .then((response) => {
            if(response.data !== null){
                if(typeof response.data !== 'undefined' && response.data.length > 0){
                    polygonSeries.data = response.data.map(v => {return {id:v.id_,value:v.value}});
                    // console.log('polygonSeries.data ',polygonSeries.data );
                }else{
                    polygonSeries.data = [{}];
                }
            }
            $('.numberToStateHeatMapLoader').hide();
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

    });

    //Bar Chart for Company-date-countofStatus changes
    am5.ready(async function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("NumberscountdaycompanyBarGraph");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
        am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: root.verticalLayout
        }));

        // Add legend
        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
        var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50
        }));



        var data=[];
        var companies=[];

        let baseUrl = $('#getReportcountdaycompany').val();
        response = await axios.get(baseUrl);
        if(response.status==200){
            companies=response.data.map(c=>(c.company_name))
            .filter((v,i,s)=>(s.indexOf(v) === i))
            .map(c=>({ company:c, color:getRandomColor()}));
            data = response.data.map(o => {
                let company_nam=o.company_name
                let ob= {
                    'day': o.day,
                    [o.company_name]: o.count,
                };
                return ob;
            });
            $('.NumberscountdaycompanyBarGraphLoader').hide();

        }else{
            return;
        }
        // console.log('data ',data );
        // console.log('companies:',companies);

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
        categoryField: "day",
        renderer: am5xy.AxisRendererY.new(root, {
            inversed: true,
            cellStartLocation: 0.1,
            cellEndLocation: 0.9
        })
        }));

        yAxis.data.setAll(data);

        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererX.new(root, {}),
        min: 0
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        function createSeries(field, name) {
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: name,
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: field,
            categoryYField: "day",
            sequencedInterpolation: true,
            tooltip: am5.Tooltip.new(root, {
            pointerOrientation: "horizontal",
            labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
            })
        }));

        series.columns.template.setAll({
            height: am5.p100
        });


        series.bullets.push(function() {
            return am5.Bullet.new(root, {
            locationX: 1,
            locationY: 0.5,
            sprite: am5.Label.new(root, {
                centerY: am5.p50,
                text: "{valueX}",
                populateText: true
            })
            });
        });

        series.bullets.push(function() {
            return am5.Bullet.new(root, {
            locationX: 1,
            locationY: 0.5,
            sprite: am5.Label.new(root, {
                centerX: am5.p100,
                centerY: am5.p50,
                text: "{name}",
                fill: am5.color(0xffffff),
                populateText: true
            })
            });
        });

        series.data.setAll(data);
        series.appear();

        return series;
        }

        companies.forEach((v)=>{
            createSeries(v.company, v.company);
        })
        // createSeries("income", "Income");
        // createSeries("expenses", "Expenses");


        // Add legend
        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
        var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50
        }));

        legend.data.setAll(chart.series.values);


        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
        behavior: "zoomY"
        }));
        // cursor.lineY.set("forceHidden", true);
        // cursor.lineX.set("forceHidden", true);


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);

    });

</script>

@endsection
