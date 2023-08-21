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

#chartdiv {
  width: 100%;
  height: 500px
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
       {{-- loader start --}}
       <div class="loader" id="reportLoader" style="display: none;">
            <div class="text-center">
                <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            </div>
        </div>
        {{-- loader end --}}
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
                </div>
            </div>
        </div>
        {{-- filter card end --}}
        {{-- heatmap card start --}}
        <div class="card">
            <div class="card-header">
                <h1>Heat Map </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-lg-12 mb-20">
                        <div id="chartdiv"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- heatmap card end --}}
  

    </div>{{-- crm div end --}}
</div>{{-- content div end --}}

@if(auth()->user()->role =="user")
    <input type="hidden" id="getReportCallbackHeatMapDataURL" value="{{route('user.reports.get_callback_heat_map')}}"/>
@elseif(auth()->user()->role =="admin")
    <input type="hidden" id="getReportCallbackHeatMapDataURL" value="{{route('admin.reports.get_callback_heat_map')}}"/>
@elseif(auth()->user()->role =="company")
    <input type="hidden" id="getReportCallbackHeatMapDataURL" value="{{route('company.reports.get_callback_heat_map')}}"/>
@endif

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>

    $(function(){
        $('input[name="datetimes"]').daterangepicker({
            // timePicker: true,
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            alwaysShowCalendars:true,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
        // date range picker end
    });//main dom fun end

    am4core.useTheme(am4themes_animated);
    // Create map instance
    var chart = am4core.create("chartdiv", am4maps.MapChart);
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

    async function fetchReportData(){
        let baseUrl = $('#getReportCallbackHeatMapDataURL').val();
        let dateRange = $('#dateRange').val();
        dateRange = dateRange.split(' - ');
        let startDate = dateRange[0];
        let endDate = dateRange[1];
        let campaignId = $('#camapign_select').val();
        

        $('.loader').show();

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

            $('.loader').hide();

        });
    }

    // Set heatmap values for each state
    // polygonSeries.data = polyData
    // polygonSeries.data = [
    //     {
    //         id: "US-AL",
    //         value: 444710
    //     },
    //     {
    //         id: "US-AK",
    //         value: 626932
    //     },
    //     {
    //         id: "US-AZ",
    //         value: 5130632
    //     },
    //     {
    //         id: "US-AR",
    //         value: 2673400
    //     },
    //     {
    //         id: "US-CA",
    //         value: 33871648
    //     },
    //     {
    //         id: "US-CO",
    //         value: 4301261
    //     },
    //     {
    //         id: "US-CT",
    //         value: 3405565
    //     },
    //     {
    //         id: "US-DE",
    //         value: 783600
    //     },
    //     {
    //         id: "US-FL",
    //         value: 15982378
    //     },
    //     {
    //         id: "US-GA",
    //         value: 8186453
    //     },
    //     {
    //         id: "US-HI",
    //         value: 1211537
    //     },
    //     {
    //         id: "US-ID",
    //         value: 1293953
    //     },
    //     {
    //         id: "US-IL",
    //         value: 12419293
    //     },
    //     {
    //         id: "US-IN",
    //         value: 6080485
    //     },
    //     {
    //         id: "US-IA",
    //         value: 2926324
    //     },
    //     {
    //         id: "US-KS",
    //         value: 2688418
    //     },
    //     {
    //         id: "US-KY",
    //         value: 4041769
    //     },
    //     {
    //         id: "US-LA",
    //         value: 4468976
    //     },
    //     {
    //         id: "US-ME",
    //         value: 1274923
    //     },
    //     {
    //         id: "US-MD",
    //         value: 5296486
    //     },
    //     {
    //         id: "US-MA",
    //         value: 6349097
    //     },
    //     {
    //         id: "US-MI",
    //         value: 9938444
    //     },
    //     {
    //         id: "US-MN",
    //         value: 4919479
    //     },
    //     {
    //         id: "US-MS",
    //         value: 2844658
    //     },
    //     {
    //         id: "US-MO",
    //         value: 5595211
    //     },
    //     {
    //         id: "US-MT",
    //         value: 902195
    //     },
    //     {
    //         id: "US-NE",
    //         value: 1711263
    //     },
    //     {
    //         id: "US-NV",
    //         value: 1998257
    //     },
    //     {
    //         id: "US-NH",
    //         value: 1235786
    //     },
    //     {
    //         id: "US-NJ",
    //         value: 8414350
    //     },
    //     {
    //         id: "US-NM",
    //         value: 1819046
    //     },
    //     {
    //         id: "US-NY",
    //         value: 18976457
    //     },
    //     {
    //         id: "US-NC",
    //         value: 8049313
    //     },
    //     {
    //         id: "US-ND",
    //         value: 642200
    //     },
    //     {
    //         id: "US-OH",
    //         value: 11353140
    //     },
    //     {
    //         id: "US-OK",
    //         value: 3450654
    //     },
    //     {
    //         id: "US-OR",
    //         value: 3421399
    //     },
    //     {
    //         id: "US-PA",
    //         value: 12281054
    //     },
    //     {
    //         id: "US-RI",
    //         value: 1048319
    //     },
    //     {
    //         id: "US-SC",
    //         value: 4012012
    //     },
    //     {
    //         id: "US-SD",
    //         value: 754844
    //     },
    //     {
    //         id: "US-TN",
    //         value: 5689283
    //     },
    //     {
    //         id: "US-TX",
    //         value: 20851820
    //     },
    //     {
    //         id: "US-UT",
    //         value: 2233169
    //     },
    //     {
    //         id: "US-VT",
    //         value: 608827
    //     },
    //     {
    //         id: "US-VA",
    //         value: 7078515
    //     },
    //     {
    //         id: "US-WA",
    //         value: 5894121
    //     },
    //     {
    //         id: "US-WV",
    //         value: 1808344
    //     },
    //     {
    //         id: "US-WI",
    //         value: 5363675
    //     },
    //     {
    //         id: "US-WY",
    //         value: 493782
    //     }
    // ];
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
</script>


@endsection