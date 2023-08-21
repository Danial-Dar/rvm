<template>
    <Card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light">
                Numbers Monitored As Time
            </h1>
        </div>
        <div class="chart" ref="chartdiv"></div>
    </Card>
</template>

<script>
import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";

import am5themes_Animated from "@amcharts/amcharts5/themes/animated";
import * as am5plugins_exporting from "@amcharts/amcharts5/plugins/exporting";
import am5locales_en_US from "@amcharts/amcharts5/locales/en_US";

// am5core.useTheme(am5themes_Animated);
export default {
    data(){
        return {
            data:[],
        };
    },
    props: [
        "card",
    ],
    mounted() {
        this.getData().then(()=>{
            this.buildChart();
        });
    },
    methods: {
        async getData(){
            let baseUrl = '/nova-vendor/monitor-number-to-time-cir/getData';
            return Nova.request().get(baseUrl)
            .then(response => {
                if(response.status===200){
                    this.data = response.data.map((o)=>({
                        date : (new Date(o.day)).getTime(),
                        value: o.count
                    }));
                    // console.log(this.data);
                }
            });
        },
        buildChart(){
            var root = am5.Root.new(this.$refs.chartdiv);
            root.locale = am5locales_en_US;

            root.setThemes([ am5themes_Animated.new(root) ]);
            var numbersByDayChart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX"
            }));
            numbersByDayChart.chartContainer.wheelable = false;
            var inboundCallCursor = numbersByDayChart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none"
            }));
            inboundCallCursor.lineY.set("visible", false);
            var bydayXAxis = numbersByDayChart.xAxes.push(am5xy.DateAxis.new(root, {
                maxDeviation: 0.5,
                baseInterval: {
                    timeUnit: "day",
                    count: 1
                },
                renderer: am5xy.AxisRendererX.new(root, {
                pan:"zoom"
            }),
                tooltip: am5.Tooltip.new(root, {})
            }));
            var bydayYAxis = numbersByDayChart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation:1,
                    renderer: am5xy.AxisRendererY.new(root, {
                    pan:"zoom"
                })
            }));
            var byDaySeries = numbersByDayChart.series.push(am5xy.SmoothedXLineSeries.new(root, {
                name: "Series",
                xAxis: bydayXAxis,
                yAxis: bydayYAxis,
                valueYField: "value",
                valueXField: "date",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY}"
                })
            }));
            byDaySeries.fills.template.setAll({
                visible: true,
                fillOpacity: 0.2
            });
            byDaySeries.bullets.push(function() {
                return am5.Bullet.new(root, {
                        locationY: 0,
                        sprite: am5.Circle.new(root, {
                        radius: 4,
                        stroke: root.interfaceColors.get("background"),
                        strokeWidth: 2,
                        fill: byDaySeries.get("fill")
                    })
                });
            });
            numbersByDayChart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal"
            }));

            byDaySeries.data.setAll(this.data);

            byDaySeries.appear(1000);
            numbersByDayChart.appear(1000, 100);
            // Enable export
            var exporting = am5plugins_exporting.Exporting.new(root, {
                menu: am5plugins_exporting.ExportingMenu.new(root, {
                    align: "left",
                    valign: "top"
                })
            });

        },
        beforeDestroy() {
            if (this.root) {
                this.root.dispose();
            }
        },
        getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
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

