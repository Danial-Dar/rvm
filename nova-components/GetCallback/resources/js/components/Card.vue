<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <h1 class="pt-3 pb-3">Callback</h1>
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

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],
    components: {
        Datepicker,
    },
    data() {
        return {
            data: [],
            selectedRange: "",
            loading: true,
            weekdays: [
                { hour: "12am", weekday: "Sunday", value: 0 },
                { hour: "1am", weekday: "Sunday", value: 0 },
                { hour: "2am", weekday: "Sunday", value: 0 },
                { hour: "3am", weekday: "Sunday", value: 0 },
                { hour: "4am", weekday: "Sunday", value: 0 },
                { hour: "5am", weekday: "Sunday", value: 0 },
                { hour: "6am", weekday: "Sunday", value: 0 },
                { hour: "7am", weekday: "Sunday", value: 0 },
                { hour: "8am", weekday: "Sunday", value: 0 },
                { hour: "9am", weekday: "Sunday", value: 0 },
                { hour: "10am", weekday: "Sunday", value: 0 },
                { hour: "11am", weekday: "Sunday", value: 0 },
                { hour: "12pm", weekday: "Sunday", value: 0 },
                { hour: "1pm", weekday: "Sunday", value: 0 },
                { hour: "2pm", weekday: "Sunday", value: 0 },
                { hour: "3pm", weekday: "Sunday", value: 0 },
                { hour: "4pm", weekday: "Sunday", value: 0 },
                { hour: "5pm", weekday: "Sunday", value: 0 },
                { hour: "6pm", weekday: "Sunday", value: 0 },
                { hour: "7pm", weekday: "Sunday", value: 0 },
                { hour: "8pm", weekday: "Sunday", value: 0 },
                { hour: "9pm", weekday: "Sunday", value: 0 },
                { hour: "10pm", weekday: "Sunday", value: 0 },
                { hour: "11pm", weekday: "Sunday", value: 0 },
                { hour: "12pm", weekday: "Monday", value: 0 },
                { hour: "1am", weekday: "Monday", value: 0 },
                { hour: "2am", weekday: "Monday", value: 0 },
                { hour: "3am", weekday: "Monday", value: 0 },
                { hour: "4am", weekday: "Monday", value: 0 },
                { hour: "5am", weekday: "Monday", value: 0 },
                { hour: "6am", weekday: "Monday", value: 0 },
                { hour: "7am", weekday: "Monday", value: 0 },
                { hour: "8am", weekday: "Monday", value: 0 },
                { hour: "9am", weekday: "Monday", value: 0 },
                { hour: "10am", weekday: "Monday", value: 0 },
                { hour: "11am", weekday: "Monday", value: 0 },
                { hour: "12am", weekday: "Monday", value: 0 },
                { hour: "1pm", weekday: "Monday", value: 0 },
                { hour: "2pm", weekday: "Monday", value: 0 },
                { hour: "3pm", weekday: "Monday", value: 0 },
                { hour: "4pm", weekday: "Monday", value: 0 },
                { hour: "5pm", weekday: "Monday", value: 0 },
                { hour: "6pm", weekday: "Monday", value: 0 },
                { hour: "7pm", weekday: "Monday", value: 0 },
                { hour: "8pm", weekday: "Monday", value: 0 },
                { hour: "9pm", weekday: "Monday", value: 0 },
                { hour: "10pm", weekday: "Monday", value: 0 },
                { hour: "11pm", weekday: "Monday", value: 0 },
                { hour: "12pm", weekday: "Tuesday", value: 0 },
                { hour: "1am", weekday: "Tuesday", value: 0 },
                { hour: "2am", weekday: "Tuesday", value: 0 },
                { hour: "3am", weekday: "Tuesday", value: 0 },
                { hour: "4am", weekday: "Tuesday", value: 0 },
                { hour: "5am", weekday: "Tuesday", value: 0 },
                { hour: "6am", weekday: "Tuesday", value: 0 },
                { hour: "7am", weekday: "Tuesday", value: 0 },
                { hour: "8am", weekday: "Tuesday", value: 0 },
                { hour: "9am", weekday: "Tuesday", value: 0 },
                { hour: "10am", weekday: "Tuesday", value: 0 },
                { hour: "11am", weekday: "Tuesday", value: 0 },
                { hour: "12am", weekday: "Tuesday", value: 0 },
                { hour: "1pm", weekday: "Tuesday", value: 0 },
                { hour: "2pm", weekday: "Tuesday", value: 0 },
                { hour: "3pm", weekday: "Tuesday", value: 0 },
                { hour: "4pm", weekday: "Tuesday", value: 0 },
                { hour: "5pm", weekday: "Tuesday", value: 0 },
                { hour: "6pm", weekday: "Tuesday", value: 0 },
                { hour: "7pm", weekday: "Tuesday", value: 0 },
                { hour: "8pm", weekday: "Tuesday", value: 0 },
                { hour: "9pm", weekday: "Tuesday", value: 0 },
                { hour: "10pm", weekday: "Tuesday", value: 0 },
                { hour: "11pm", weekday: "Tuesday", value: 0 },
                { hour: "12pm", weekday: "Wednesday", value: 0 },
                { hour: "1am", weekday: "Wednesday", value: 0 },
                { hour: "2am", weekday: "Wednesday", value: 0 },
                { hour: "3am", weekday: "Wednesday", value: 0 },
                { hour: "4am", weekday: "Wednesday", value: 0 },
                { hour: "5am", weekday: "Wednesday", value: 0 },
                { hour: "6am", weekday: "Wednesday", value: 0 },
                { hour: "7am", weekday: "Wednesday", value: 0 },
                { hour: "8am", weekday: "Wednesday", value: 0 },
                { hour: "9am", weekday: "Wednesday", value: 0 },
                { hour: "10am", weekday: "Wednesday", value: 0 },
                { hour: "11am", weekday: "Wednesday", value: 0 },
                { hour: "12am", weekday: "Wednesday", value: 0 },
                { hour: "1pm", weekday: "Wednesday", value: 0 },
                { hour: "2pm", weekday: "Wednesday", value: 0 },
                { hour: "3pm", weekday: "Wednesday", value: 0 },
                { hour: "4pm", weekday: "Wednesday", value: 0 },
                { hour: "5pm", weekday: "Wednesday", value: 0 },
                { hour: "6pm", weekday: "Wednesday", value: 0 },
                { hour: "7pm", weekday: "Wednesday", value: 0 },
                { hour: "8pm", weekday: "Wednesday", value: 0 },
                { hour: "9pm", weekday: "Wednesday", value: 0 },
                { hour: "10pm", weekday: "Wednesday", value: 0 },
                { hour: "11pm", weekday: "Wednesday", value: 0 },
                { hour: "12pm", weekday: "Thursday", value: 0 },
                { hour: "1am", weekday: "Thursday", value: 0 },
                { hour: "2am", weekday: "Thursday", value: 0 },
                { hour: "3am", weekday: "Thursday", value: 0 },
                { hour: "4am", weekday: "Thursday", value: 0 },
                { hour: "5am", weekday: "Thursday", value: 0 },
                { hour: "6am", weekday: "Thursday", value: 0 },
                { hour: "7am", weekday: "Thursday", value: 0 },
                { hour: "8am", weekday: "Thursday", value: 0 },
                { hour: "9am", weekday: "Thursday", value: 0 },
                { hour: "10am", weekday: "Thursday", value: 0 },
                { hour: "11am", weekday: "Thursday", value: 0 },
                { hour: "12am", weekday: "Thursday", value: 0 },
                { hour: "1pm", weekday: "Thursday", value: 0 },
                { hour: "2pm", weekday: "Thursday", value: 0 },
                { hour: "3pm", weekday: "Thursday", value: 0 },
                { hour: "4pm", weekday: "Thursday", value: 0 },
                { hour: "5pm", weekday: "Thursday", value: 0 },
                { hour: "6pm", weekday: "Thursday", value: 0 },
                { hour: "7pm", weekday: "Thursday", value: 0 },
                { hour: "8pm", weekday: "Thursday", value: 0 },
                { hour: "9pm", weekday: "Thursday", value: 0 },
                { hour: "10pm", weekday: "Thursday", value: 0 },
                { hour: "11pm", weekday: "Thursday", value: 0 },
                { hour: "12pm", weekday: "Friday", value: 0 },
                { hour: "1am", weekday: "Friday", value: 0 },
                { hour: "2am", weekday: "Friday", value: 0 },
                { hour: "3am", weekday: "Friday", value: 0 },
                { hour: "4am", weekday: "Friday", value: 0 },
                { hour: "5am", weekday: "Friday", value: 0 },
                { hour: "6am", weekday: "Friday", value: 0 },
                { hour: "7am", weekday: "Friday", value: 0 },
                { hour: "8am", weekday: "Friday", value: 0 },
                { hour: "9am", weekday: "Friday", value: 0 },
                { hour: "10am", weekday: "Friday", value: 0 },
                { hour: "11am", weekday: "Friday", value: 0 },
                { hour: "12am", weekday: "Friday", value: 0 },
                { hour: "1pm", weekday: "Friday", value: 0 },
                { hour: "2pm", weekday: "Friday", value: 0 },
                { hour: "3pm", weekday: "Friday", value: 0 },
                { hour: "4pm", weekday: "Friday", value: 0 },
                { hour: "5pm", weekday: "Friday", value: 0 },
                { hour: "6pm", weekday: "Friday", value: 0 },
                { hour: "7pm", weekday: "Friday", value: 0 },
                { hour: "8pm", weekday: "Friday", value: 0 },
                { hour: "9pm", weekday: "Friday", value: 0 },
                { hour: "10pm", weekday: "Friday", value: 0 },
                { hour: "11pm", weekday: "Friday", value: 0 },
                { hour: "12pm", weekday: "Saturday", value: 0 },
                { hour: "1am", weekday: "Saturday", value: 0 },
                { hour: "2am", weekday: "Saturday", value: 0 },
                { hour: "3am", weekday: "Saturday", value: 0 },
                { hour: "4am", weekday: "Saturday", value: 0 },
                { hour: "5am", weekday: "Saturday", value: 0 },
                { hour: "6am", weekday: "Saturday", value: 0 },
                { hour: "7am", weekday: "Saturday", value: 0 },
                { hour: "8am", weekday: "Saturday", value: 0 },
                { hour: "9am", weekday: "Saturday", value: 0 },
                { hour: "10am", weekday: "Saturday", value: 0 },
                { hour: "11am", weekday: "Saturday", value: 0 },
                { hour: "12am", weekday: "Saturday", value: 0 },
                { hour: "1pm", weekday: "Saturday", value: 0 },
                { hour: "2pm", weekday: "Saturday", value: 0 },
                { hour: "3pm", weekday: "Saturday", value: 0 },
                { hour: "4pm", weekday: "Saturday", value: 0 },
                { hour: "5pm", weekday: "Saturday", value: 0 },
                { hour: "6pm", weekday: "Saturday", value: 0 },
                { hour: "7pm", weekday: "Saturday", value: 0 },
                { hour: "8pm", weekday: "Saturday", value: 0 },
                { hour: "9pm", weekday: "Saturday", value: 0 },
                { hour: "10pm", weekday: "Saturday", value: 0 },
                { hour: "11pm", weekday: "Saturday", value: 0 },
            ],
        };
    },
    mounted() {
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
            let baseUrl = "/nova-api/custom/get-sendrates-per-day";
            return await Nova.request()
                .post(baseUrl, params)
                .then((response) => {
                    if (response.data.query.length > 0) {
                        // this.data = response.data.query;
                        response.data.query.forEach((element) => {
                            this.weekdays.filter((e) => {
                                if (
                                    e.hour ===
                                        element["hour"].replace(/\s/g, "") &&
                                    e.weekday ===
                                        element["weekday"].replace(/\s/g, "")
                                ) {
                                    e["value"] = element["value"];
                                }
                            });
                        });
                    }
                    this.loading = false;
                    console.log("4.sendratesperday------>", response.data.query);
                });
        },

        buildChart() {
            window.am4core.useTheme(window.am4themes_animated);
            let chart = window.am4core.create(this.$refs.chartdiv, window.am4charts.XYChart);

            chart.maskBullets = false;

            let xAxis = chart.xAxes.push(new window.am4charts.CategoryAxis());
            let yAxis = chart.yAxes.push(new window.am4charts.CategoryAxis());

            xAxis.dataFields.category = "weekday";
            yAxis.dataFields.category = "hour";

            xAxis.renderer.grid.template.disabled = true;
            xAxis.renderer.minGridDistance = 40;

            yAxis.renderer.grid.template.disabled = true;
            yAxis.renderer.inversed = true;
            yAxis.renderer.minGridDistance = 30;

            let series = chart.series.push(new window.am4charts.ColumnSeries());
            series.dataFields.categoryX = "weekday";
            series.dataFields.categoryY = "hour";
            series.dataFields.value = "value";
            series.sequencedInterpolation = true;
            series.defaultState.transitionDuration = 3000;

            let bgColor = new window.am4core.InterfaceColorSet().getFor("background");

            let columnTemplate = series.columns.template;
            columnTemplate.strokeWidth = 1;
            columnTemplate.strokeOpacity = 0.2;
            columnTemplate.stroke = bgColor;
            columnTemplate.tooltipText =
                "{weekday}, {hour}: {value.workingValue.formatNumber('#.')}";
            columnTemplate.width = window.am4core.percent(100);
            columnTemplate.height = window.am4core.percent(100);

            series.heatRules.push({
                target: columnTemplate,
                property: "fill",
                // min: window.am4core.color(window.am4core.color("#ccf4fe")),
                // max: chart.colors.getIndex(0),
                "min": am4core.color(window.Nova.config('brandColors')['500-hex']),
                "max": am4core.color(window.Nova.config('brandColors')['600-hex'])
            });

            // heat legend
            let heatLegend = chart.bottomAxesContainer.createChild(
                window.am4charts.HeatLegend
            );
            heatLegend.width = window.am4core.percent(100);
            heatLegend.series = series;
            heatLegend.valueAxis.renderer.labels.template.fontSize = 9;
            heatLegend.valueAxis.renderer.minGridDistance = 30;
            heatLegend.minColor = window.Nova.config('brandColors')['500-hex'];
            heatLegend.maxColor = window.Nova.config('brandColors')['600-hex'];
            // heat legend behavior
            series.columns.template.events.on("over", function (event) {
                handleHover(event.target);
            });

            series.columns.template.events.on("hit", function (event) {
                handleHover(event.target);
            });

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                } else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            series.columns.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            });

            chart.data = this.weekdays;
            this.chart = chart;
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
