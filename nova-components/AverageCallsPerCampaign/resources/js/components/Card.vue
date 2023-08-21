<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <h1 class="pt-3 pb-3">Average Calls Per Campaign</h1>
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
            loading: true,
            selectedRange: "",
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
            let baseUrl = "/nova-api/custom/get-average-calls-per-campaign";
            return await Nova.request()
                .post(baseUrl, params)
                .then((response) => {
                    if (response.data.query.length > 0) {
                        response.data.query.map((value, key) => {
                            this.data.push({
                                mm: moment
                                    .utc(value["avg_duration"] * 1000)
                                    .format("mm:ss")
                                    .split(":")[0],
                                ss: moment
                                    .utc(value["avg_duration"] * 1000)
                                    .format("mm:ss")
                                    .split(":")[1],
                                value: moment
                                    .utc(value["avg_duration"] * 1000)
                                    .format("mm:ss"),
                                name: value["name"],
                            });
                        });
                    }
                    this.loading = false;
                    console.log("6.callspercampaign------>", response.data.query);
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
            window.am4core.useTheme(window.am4themes_animated);
            // Create chart instance
            var chart = window.am4core.create(this.$refs.chartdiv, window.am4charts.PieChart);

            // Add data
            chart.data = this.data;

            // Add and configure Series
            var pieSeries = chart.series.push(new window.am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.slices.template.tooltipText = "{name}: ({mm}:{ss})";
            pieSeries.dataFields.category = "name";
            pieSeries.labels.template.disabled = true;
            chart.radius = window.am4core.percent(95);
            this.chart = chart;
        },
    },
    beforeDestroy() {
        if (this.chart) {
            this.chart.dispose();
        }
    },
    // mounted() {
    //     //
    //     const query = this.card.query;
    //     console.log(
    //         "avgCallDurationPerCampaign",
    //         query.avgCallDurationPerCampaign
    //     );

    //     // let chart = am4core.create("chartdiv", am4charts.PieChart);
    //     let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart);
    //     chart.data = query.avgCallDurationPerCampaign;
    //     // Add and configure Series
    //     let pieSeries = chart.series.push(new am4charts.PieSeries());
    //     pieSeries.dataFields.value = "avg_duration";
    //     pieSeries.dataFields.category = "name";
    //     pieSeries.labels.template.disabled = true;

    //     this.chart = chart;
    // },
};
</script>
<style scoped>
.chart {
    width: 100%;
    height: 500px;
}
</style>
