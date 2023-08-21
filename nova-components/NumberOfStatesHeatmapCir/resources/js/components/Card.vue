<template>
    <Card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light">
                Numbers Heatmap
            </h1>
        </div>
        <div class="chart" ref="chartdiv"></div>
    </Card>
</template>

<script>

export default {
    data(){
        return {
            polygonSeries:null,
        };
    },
    props: [
        "card",
    ],
    mounted() {
        this.buildChart();
        // this.polygonSeries.data=this.getData();
        this.fillData();

    },
    methods: {
        async fillData(){
            let baseUrl = '/nova-vendor/number-of-states-heatmap-cir/getData';
            Nova.request().get(baseUrl)
            .then((response) => {
                if(response.status == 200){
                    if(response.data){
                        this.polygonSeries.data = response.data.map(v => {return {id:v.id_,value:v.value}});
                    }else{
                        this.polygonSeries.data = [{}];
                    }
                }
                // $('.numberToStateHeatMapLoader').hide();
            });

            // const query = this.card.query;
            // console.log('this.card.query:',this.card.query);
            // let dataHeatmap = query.heatmap;
            // return dataHeatmap.map(v => {return {id:v.id_,value:v.value}})??[{}];

        },
        buildChart(){
            window.am4core.useTheme(window.am4themes_animated);
            // Create map instance
            var chart = window.am4core.create(this.$refs.chartdiv, window.am4maps.MapChart);

            // Set map definition
            chart.geodata = window.am4geodata_usaLow;

            // Set projection
            chart.projection = new window.am4maps.projections.AlbersUsa();

            chart.chartContainer.wheelable = false;
            chart.seriesContainer.draggable = false;
            chart.seriesContainer.resizable = false;

            // Create map polygon series
            this.polygonSeries = chart.series.push(new window.am4maps.MapPolygonSeries());

            //Set min/max fill color for each area
            this.polygonSeries.heatRules.push({
                property: "fill",
                target: this.polygonSeries.mapPolygons.template,
                "min": am4core.color(window.Nova.config('brandColors')['500-hex']),
                "max": am4core.color(window.Nova.config('brandColors')['600-hex'])
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            this.polygonSeries.useGeodata = true;

            // this.polygonSeries.data = this.getData();
            //  = dataHeatmap.length > 0 ? dataHeatmap : [{}];

            // Set up heat legend
            let heatLegend = chart.createChild(am4maps.HeatLegend);
            heatLegend.series = this.polygonSeries;
            heatLegend.align = "right";
            heatLegend.valign = "bottom";
            heatLegend.height = window.am4core.percent(80);
            heatLegend.orientation = "vertical";
            heatLegend.valign = "middle";
            heatLegend.marginRight = window.am4core.percent(4);
            heatLegend.valueAxis.renderer.opposite = true;
            heatLegend.valueAxis.renderer.dx = -25;
            heatLegend.valueAxis.strictMinMax = false;
            heatLegend.valueAxis.fontSize = 9;
            heatLegend.valueAxis.logarithmic = true;

            // Configure series tooltip
            var polygonTemplate = this.polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = window.am4core.color(window.Nova.config('brandColors')['500-hex']);

            // heat legend behavior
            this.polygonSeries.mapPolygons.template.events.on("over", function (event) {
                handleHover(event.target);
            });

            this.polygonSeries.mapPolygons.template.events.on("hit", function (event) {
                handleHover(event.target);
            });

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                } else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            this.polygonSeries.mapPolygons.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });
            // Enable export
            chart.exporting.menu = new window.am4core.ExportMenu();
            chart.exporting.menu.align = "left";
            chart.exporting.menu.verticalAlign = "top";
        },
        beforeDestroy() {
            if (this.chart) {
                this.chart.dispose();
            }
        },
    },
};
</script>

<style scoped>
.chart {
    width: 100%;
    height: 500px;
}
</style>
