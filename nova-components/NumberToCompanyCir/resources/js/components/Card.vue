<template>
    <Card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light">
                Numbers By Company
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
            companies:[],
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
            let baseUrl = '/nova-vendor/number-to-company-cir/getData';
            return Nova.request().get(baseUrl)
            .then(response => {
            if(response.status==200){
                //for adding company name series
                this.companies=response.data.map(c=>(c.company_name))
                .filter((v,i,s)=>(s.indexOf(v) === i))
                .map(c=>({ company:c, color:this.getRandomColor()}));
                //data reated to each company
                this.data = response.data.map(o => {
                        let company_nam=o.company_name
                        let ob= {
                            'day': o.day,
                            [o.company_name]: o.count,
                        };
                        return ob;
                    });
                }
                // console.log(this.data,this.companies);
            });
        },
        getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        buildChart(){
        let root = am5.Root.new(this.$refs.chartdiv);
        root.locale=am5locales_en_US;
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        this.chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            layout: root.verticalLayout
        }));
        var legend = this.chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50
        }));
        let yAxis = this.chart.yAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "day",
            renderer: am5xy.AxisRendererY.new(root, {
                inversed: true,
                cellStartLocation: 0.1,
                cellEndLocation: 0.9
            })
        }));
        yAxis .data.setAll(this.data);
        let xAxis = this.chart.xAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererX.new(root, {}),
            min: 0
        }));
        this.companies.forEach((v)=>{
            let field = v.company;
            let name = v.company;
            var series = this.chart.series.push(am5xy.ColumnSeries.new(root, {
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

            series.data.setAll(this.data);
            series.appear();
        });
        var legend = this.chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50
        }));
        legend.data.setAll(this.chart.series.values);
        var cursor = this.chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "zoomY"
        }));
        cursor.lineY.set("forceHidden", true);
        cursor.lineX.set("forceHidden", true);
        this.chart.appear(1000, 100);

            // Enable export
            // this.chart.exporting.menu = new am5core.ExportMenu();
            // this.chart.exporting.menu.;
            // this.chart.exporting.menu.;

            var exporting = am5plugins_exporting.Exporting.new(root, {
                menu: am5plugins_exporting.ExportingMenu.new(root, {
                    align : "left",
                    verticalAlign : "top"
                }),
                pngOptions: {
                    quality: 0.8,
                    maintainPixelRatio: true
                }
            });
        },

        beforeDestroy() {
            if (this.root) {
                this.root.dispose();
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

