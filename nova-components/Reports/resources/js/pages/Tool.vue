<template>
    <div>
        <div class="flex justify-content-between justify-between">
            <div>
                <h1 class="text-90 font-normal text-xl md:text-2xl mb-3">Reports</h1>
            </div>
            <div class="flex justiy-between">
                <div class="mr-2">
                    <select @change="load" v-model="company_id" data-testid="companies-select" style="height: 38px;"
                        dusk="company" class="w-full block form-control form-select form-select-bordered "
                        @closeMenu="load">
                        <option :value="null">All</option>
                        <template v-if="companies.length > 1">
                            <option :value="company.id" v-for="company in companies" :key="'company-option'+company.id">
                                {{ company.name }}
                            </option>
                        </template>
                    </select>
                </div>
                <div>
                    <select @change="load" v-model="company_id" data-testid="companies-select"
                        dusk="company" class="w-full block form-control form-select form-select-bordered"
                        @closeMenu="load">
                        <option :value="null">All</option>
                        <template v-if="companies.length > 1">
                            <option :value="company.id" v-for="company in companies" :key="'company-option'+company.id">
                                {{ company.name }}
                            </option>
                        </template>
                    </select>
                </div>
                <div>
                    <Datepicker :enableTimePicker="false" @update:modelValue="load" range v-model="date">
                    </Datepicker>
                </div>

            </div>
        </div>

        <Card class="mb-4">
            <h2 class="p-2">Spendings</h2>
            <div id="chartdiv1"></div>
        </Card>

        <Card class="mb-4">
            <h2 class="p-2">Payments</h2>
            <div id="chartdiv2"></div>
        </Card>

        <Card class="mb-4">
            <h2 class="p-2 mb-2">Sending by Category</h2>
            <table class="w-full table-tight" cellpadding="0" cellspacing="0" data-testid="resource-table">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th
                            class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                            <span>Category</span></th>
                        <th
                            class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                            <span>Total</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr :dusk="index+'-category'" :key="'category'+index" class="group"
                        addition-actions="[object Object]" v-for="(category, index) in spendingByCategory">
                        <td
                            class="px-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                            <div class="text-left" resource="[object Object]"><span
                                    class="text-90 whitespace-nowrap">{{category.type}}</span></div>
                        </td>
                        <td
                            class="px-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                            <div class="text-left" resource="[object Object]"><span
                                    class="text-90 whitespace-nowrap">{{category.total}}</span></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </Card>
        <div class="flex justify-between">
            <div class="flex-1 pr-1">
                <Card>
                    <h2 class="p-2 mb-2">Spendings by Company</h2>
                    <table class="w-full table-tight" cellpadding="0" cellspacing="0" data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Company</span></th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Total</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :dusk="index+'-spendings'" :key="'category'+index" class="group"
                                addition-actions="[object Object]" v-for="(spending, index) in spendingByCompany">
                                <td
                                    class="px-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]"><span
                                            class="text-90 whitespace-nowrap">{{spending.name}}</span></div>
                                </td>
                                <td
                                    class="px-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]"><span
                                            class="text-90 whitespace-nowrap">{{spending.total}}</span></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </Card>
            </div>
            <div class="flex-1 pl-1">
                <Card>
                    <h2 class="p-2 mb-2">Payments by Company</h2>
                    <table class="w-full table-tight" cellpadding="0" cellspacing="0" data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Company</span></th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Total</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :dusk="index+'-payments'" :key="'category'+index" class="group"
                                addition-actions="[object Object]" v-for="(payments, index) in paymentsByCompany">
                                <td
                                    class="px-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]"><span
                                            class="text-90 whitespace-nowrap">{{payments.name}}</span></div>
                                </td>
                                <td
                                    class="px-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]"><span
                                            class="text-90 whitespace-nowrap">{{payments.total}}</span></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </Card>
            </div>
        </div>

    </div>
</template>

<script>
    import Datepicker from "@vuepic/vue-datepicker";
    import "@vuepic/vue-datepicker/dist/main.css";
    export default {
        data() {
            return {
                spendPerDay: {},
                spendingByCategory: [],
                spendingByCompany: [],
                paymentsByCompany: [],
                date: [
                    new Date(),
                    new Date()
                ],
                companies: [],
                company_id: null
            }
        },
        components: {
            Datepicker,
        },
        methods: {
            async load(params) {
                // this.$forceUpdate();
                console.log('before date')
                console.log(this.date)
                console.log('after date')
                this.$forceUpdate()
                this.$nextTick(async () => {
                    if (this.date !== null) {
                    console.log('inside if')
                    params.from_date = this.date[0];
                    params.to_date = this.date[1];
                    params.company_id = this.company_id
                    console.log(params)

                    
                    await Nova.request().get('/nova-api/custom/reports/spend-per-day', {
                        params: {
                            from_date: this.date[0],
                            to_date:this.date[1],
                            company_id: this.company_id
                        }
                    })
                    .then(res => {
                        this.spendPerDay = res.data
                    }, err => {})


                    let chart2 = window.am4core.create('chartdiv2', window.am4charts.XYChart)

                    let chart1 = window.am4core.create('chartdiv1', window.am4charts.XYChart)



                    let spendings = [];
                    let payments = [];
                    this.spendPerDay.forEach(spending => {
                        let el = null
                        let bl = null
                        el = spendings.find(a => a.date == spending.created)
                        bl = payments.find(a => a.date == spending.created)
                        if (!el) {
                            spendings.push({
                                date: spending.created
                            })
                            el = spendings.find(a => a.date == spending.created)
                        }
                        if (!bl) {
                            payments.push({
                                date: spending.created
                            })
                            bl = payments.find(a => a.date == spending.created)
                        }
                        bl[spending.name] = spending.payments
                        el[spending.name] = spending.spendings
                    });

                    let keys = [];
                    for (const key in spendings[0]) {
                        console.log(key)
                        if (key !== 'date') {
                            keys.push(key)
                        }
                    }

                    this.buildChart(chart2, payments, keys)
                    this.buildChart(chart1, spendings, keys)
                    Nova.request().get('/nova-api/custom/reports/spending-by-category', {
                        params: params
                    })
                        .then(res => {
                            this.spendingByCategory = res.data
                        })
                    Nova.request().get('/nova-api/custom/reports/spending-by-company', {
                        params: params
                    })
                        .then(res => {
                            this.spendingByCompany = res.data
                        })
                    Nova.request().get('/nova-api/custom/reports/payments-by-company', {
                        params: params
                    })
                        .then(res => {
                            this.paymentsByCompany = res.data
                        })
                    }
                })
            },
            buildChart(chart, data, keys) {
                window.am4core.useTheme(window.am4themes_animated);
                chart.colors.step = 2;

                chart.legend = new window.am4charts.Legend()
                chart.legend.position = 'top'
                chart.legend.paddingBottom = 20
                chart.legend.labels.template.maxWidth = 95

                chart.numberFormatter.numberFormat = "#a";

                let xAxis = chart.xAxes.push(new window.am4charts.CategoryAxis())
                xAxis.dataFields.category = 'date'
                xAxis.renderer.cellStartLocation = 0.1
                xAxis.renderer.cellEndLocation = 0.9
                xAxis.renderer.grid.template.location = 0;

                let yAxis = chart.yAxes.push(new window.am4charts.ValueAxis());
                yAxis.min = 0;

                function createSeries(value, name) {
                    let series = chart.series.push(new window.am4charts.ColumnSeries())
                    series.dataFields.valueY = value
                    series.dataFields.categoryX = 'date'
                    series.name = name

                    series.columns.template.width = am4core.percent(70);

                    series.events.on("hidden", arrangeColumns);
                    series.events.on("shown", arrangeColumns);

                    // let bullet = series.bullets.push(new window.am4charts.LabelBullet())
                    // bullet.interactionsEnabled = true
                    // bullet.dy = 30;
                    // bullet.label.text = '{valueY}'
                    // bullet.label.fill = window.am4core.color('#000000')

                    var circleBullet = series.bullets.push(new window.am4charts.CircleBullet());
                    circleBullet.circle.stroke = am4core.color("#fff");
                    circleBullet.circle.strokeWidth = 0;
                    circleBullet.circle.fillOpacity = 0;
                    circleBullet.tooltipText = name + " : [bold]{valueY}[/]";
                    return series;
                }

                keys.forEach(key => {
                    createSeries(key, key);
                });

                chart.data = data



                function arrangeColumns() {

                    let series = chart.series.getIndex(0);

                    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
                    if (series.dataItems.length > 1) {
                        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                        var delta = ((x1 - x0) / chart.series.length) * w;
                        if (window.am4core.isNumber(delta)) {
                            var middle = chart.series.length / 2;

                            var newIndex = 0;
                            chart.series.each(function (series) {
                                if (!series.isHidden && !series.isHiding) {
                                    series.dummyData = newIndex;
                                    newIndex++;
                                } else {
                                    series.dummyData = chart.series.indexOf(series);
                                }

                            })
                            var visibleCount = newIndex;
                            var newMiddle = visibleCount / 2;

                            chart.series.each(function (series) {
                                var trueIndex = chart.series.indexOf(series);
                                var newIndex = series.dummyData;

                                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                                series.animate({
                                    property: "dx",
                                    to: dx
                                }, series.interpolationDuration, series.interpolationEasing);
                                series.bulletsContainer.animate({
                                    property: "dx",
                                    to: dx
                                }, series.interpolationDuration, series.interpolationEasing);
                            })
                        }
                    }
                }
            }
        },
        async mounted() {
            await Nova.request()
                .get("/nova-api/custom/companies")
                .then(
                    (res) => {
                        this.companies = res.data.companies;
                        // console.log("this.companies");
                        // console.log(this.companies.length);
                    },
                    (err) => {}
                );
            await Nova.request().get('/nova-api/custom/reports/spend-per-day')
                .then(res => {
                    this.spendPerDay = res.data
                }, err => {})


            let chart2 = window.am4core.create('chartdiv2', window.am4charts.XYChart)

            let chart1 = window.am4core.create('chartdiv1', window.am4charts.XYChart)



            let spendings = [];
            let payments = [];
            this.spendPerDay.forEach(spending => {
                let el = null
                let bl = null
                el = spendings.find(a => a.date == spending.created)
                bl = payments.find(a => a.date == spending.created)
                if (!el) {
                    spendings.push({
                        date: spending.created
                    })
                    el = spendings.find(a => a.date == spending.created)
                }
                if (!bl) {
                    payments.push({
                        date: spending.created
                    })
                    bl = payments.find(a => a.date == spending.created)
                }
                bl[spending.name] = spending.payments
                el[spending.name] = spending.spendings
            });

            let keys = [];
            for (const key in spendings[0]) {
                console.log(key)
                if (key !== 'date') {
                    keys.push(key)
                }
            }

            this.buildChart(chart2, payments, keys)
            this.buildChart(chart1, spendings, keys)
            Nova.request().get('/nova-api/custom/reports/spending-by-category')
                .then(res => {
                    this.spendingByCategory = res.data
                })
            Nova.request().get('/nova-api/custom/reports/spending-by-company')
                .then(res => {
                    this.spendingByCompany = res.data
                })
            Nova.request().get('/nova-api/custom/reports/payments-by-company')
                .then(res => {
                    this.paymentsByCompany = res.data
                })
        },
    }

</script>

<style>
    /* Scoped Styles */
    #chartdiv1 {
        width: 100%;
        height: 500px;
    }

    #chartdiv2 {
        width: 100%;
        height: 500px;
    }
    .companies {
        padding: 5px 12px;
        font-size: 1rem;
        line-height: 1.5rem;
        min-height: 37px;
    }

</style>
