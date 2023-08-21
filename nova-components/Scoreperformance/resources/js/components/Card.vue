<template>
  <Card class="flex flex-col items-center justify-center">
    <div class="px-3 py-3">
      <h1 class="text-center text-3xl text-gray-500 font-light">Score Performance</h1>
    </div>
    <div class="chart" ref="chartdiv" style="margin-top: 2rem"></div>
  </Card>
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
            selectedRange: "",
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
            let baseUrl = "/nova-api/custom/get-campaign-send-rates";
            return await Nova.request()
                .post(baseUrl, params)
                .then((response) => {
                    let campaignSendRates =
                        response.data.query.campaignSendRates;
                    let dateRange = response.data.query.dateRange;
                    dateRange.forEach((element) => {
                        let date = new Date(element.date);
                        this.data.push({
                            date: date.getTime(),
                            value: element.value,
                        });
                    });

                    console.log("12.campaignSendRates ---->", response.data.query);
                });
        },
        getDataByDateRange(date) {
            if (date !== null) {
                let startDate = moment(date[0]).format("YYYY-MM-DD");
                let endDate = moment(date[1]).format("YYYY-MM-DD");
                this.getData(startDate, endDate).then(() => {
                    this.buildChart();
                });
            }
        },
        buildChart() {
            window.am4core.useTheme(window.am4themes_animated);
            let chart = window.am4core.create(this.$refs.chartdiv, window.am4charts.XYChart);

            chart.paddingRight = 20;

            chart.data = this.data;

            let dateAxis = chart.xAxes.push(new window.am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;

            let valueAxis = chart.yAxes.push(new window.am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new window.am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";

            series.tooltipText = "{valueY.value}";
            chart.cursor = new window.am4charts.XYCursor();

            let scrollbarX = new window.am4charts.XYChartScrollbar();
            scrollbarX.series.push(series);
            chart.scrollbarX = scrollbarX;

            this.chart = chart;
        },
    },
    beforeDestroy() {
        if (this.chart) {
            this.chart.dispose();
        }
    },
};
</script>
<style scoped>
.chart {
    width: 100%;
    height: 500px;
}
</style>
