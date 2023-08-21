<template>
    <div>
        <Head title="Contact List Stat" />

        <Heading class="mb-6">Contact List Stat</Heading>

        <Card
            class="flex flex-col items-center justify-center"
            style="min-height: 300px"
        >
            <!-- <h1 class="dark:text-white text-4xl font-light mb-6"></h1>

            <p class="dark:text-white text-lg opacity-70"></p> -->

            <div class="hello" ref="chartdiv"></div>
        </Card>
    </div>
</template>

<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

am4core.useTheme(am4themes_animated);
export default {
    mounted() {
        let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart);

        chart.data = [
            { category: "Lithuania", value: 501.9 },
            { category: "Czechia", value: 301.9 },
            { category: "Ireland", value: 201.1 },
            { category: "Germany", value: 165.8 },
            { category: "Australia", value: 139.9 },
            { category: "Austria", value: 128.3 },
            { category: "UK", value: 99 },
        ];

        let series = chart.series.push(new am4charts.PieSeries());
        series.dataFields.value = "value";
        series.dataFields.category = "category";
        series.colors.list = [
            am4core.color("#0066CC"),
            am4core.color("#009900"),
            am4core.color("#CC0033"),
            am4core.color("#FF6600"),
            am4core.color("#FF9900"),
            am4core.color("#663399"),
            am4core.color("#CC0066"),
        ];
    },
};
</script>

<style scoped>
.hello {
    width: 100%;
    height: 500px;
}
</style>
