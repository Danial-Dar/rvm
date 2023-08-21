<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <h1 class="pt-3 pb-3">No Of Calls Per Campaign</h1>
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
            loading: true,
            data: [],
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
            let baseUrl = "/nova-api/custom/get-calls-per-campaign";
            return await Nova.request()
                .post(baseUrl,params)
                .then((response) => {
                    if (response.data.query.length > 0) {
                        response.data.query.map((value, key) => {
                            this.data.push({
                                value: value["call_backs"],
                                name: value["name"],
                            });
                        });
                    }
                    this.loading = false;
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
            // Create chart instance
            var chart = am4core.create(
                this.$refs.chartdiv,
                window.am4charts.PieChart
            );
            // Add data
            chart.data = this.data;

            // Add and configure Series
            var pieSeries = chart.series.push(new window.am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            // pieSeries.slices.template.tooltipText = "{name}: ({mm}:{ss})";
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
    }
};
</script>
<style scoped>
.chart {
    width: 100%;
    height: 500px;
}
</style>
