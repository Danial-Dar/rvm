<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <h1 class="mt-3 mb-3">Outbound Optin Heatmap</h1>
        <Datepicker
            v-model="selectedRange"
            class="inline-block h-9 pt-3"
            range
            :enableTimePicker="false"
            @update:modelValue="getDataByDateRange"
            :clearable="true"
        />
        <div class="chart" ref="chartdiv" style="margin-top: 2rem"></div>
    </loading-card>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";

export default {
    props: [
        "card",
    ],
    components: {
        Datepicker,
    },
    data() {
        return {
            data: [],
            loading: true,
        };
    },
    mounted() {
        // this.oldAlbersUsa();
        let start_date = "";
        let end_date = "";
        this.getData(start_date, end_date).then(() => {
            this.buildChart();
        });
    },
    methods: {
        async getData(start_date, end_date) {
            let params = {
                start_date,
                end_date,
            };
            let baseUrl = "/nova-api/custom/get-outbound-optin";
            return await Nova.request()
                .post(baseUrl, params)
                .then((response) => {
                    if (response.data.query.length > 0) {
                        this.data = response.data.query;
                    }
                    this.loading = false;
                    console.log("17.outboundoptinheatmap ---->", response.data.query);
                });
        },
        getDataByDateRange(date) {
            // let date = this.selectedRange;
            // console.log(date);
            if (date !== null) {
                let startDate = moment(date[0]).format("YYYY-MM-DD");
                let endDate = moment(date[1]).format("YYYY-MM-DD");
                this.getData(startDate, endDate).then(() => {
                    this.buildChart();
                });
            }
        },
        buildChart() {
            // Themes begin
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
            var polygonSeries = chart.series.push(
                new window.am4maps.MapPolygonSeries()
            );

            //Set min/max fill color for each area
            polygonSeries.heatRules.push({
                property: "fill",
                target: polygonSeries.mapPolygons.template,
                "min": am4core.color(window.Nova.config('brandColors')['500-hex']),
                "max": am4core.color(window.Nova.config('brandColors')['600-hex'])
            });

            // Make map load polygon data (state shapes and names) from GeoJSON
            polygonSeries.useGeodata = true;

            polygonSeries.data = this.data.length > 0 ? this.data : [{}];

            // Set up heat legend
            let heatLegend = chart.createChild(window.am4maps.HeatLegend);
            heatLegend.series = polygonSeries;
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
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}: {value}";
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 0.5;

            // Create hover state and set alternative fill color
            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = window.am4core.color(window.Nova.config('brandColors')['500-hex']);

            // heat legend behavior
            polygonSeries.mapPolygons.template.events.on(
                "over",
                function (event) {
                    handleHover(event.target);
                }
            );

            polygonSeries.mapPolygons.template.events.on(
                "hit",
                function (event) {
                    handleHover(event.target);
                }
            );

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                } else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            polygonSeries.mapPolygons.template.events.on(
                "out",
                function (event) {
                    heatLegend.valueAxis.hideTooltip();
                }
            );
        },
    },
    beforeDestroy() {
        if (this.chart) {
            this.chart.dispose();
        }
    }
};
</script>
<style scoped>
.chart {
    width: 100%;
    height: 500px;
}
</style>
