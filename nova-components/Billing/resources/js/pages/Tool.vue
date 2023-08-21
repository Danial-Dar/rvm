<template>
    <div>

        <Head title="Billing" />

        <Heading class="mb-6">Billing</Heading>
        <a v-if="currentUser && currentUser.role == 'admin'" href="javascript:void(0)" style=""
            @click="(show = true), (loading = false)"
            class="flex-shrink-0 mb-2 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">Add
            Payment</a>
        <Modal :show="show" data-testid="payment-modal" role="alertdialog">
            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px">
                <ModalHeader v-text="__('Payment')" />
                <ModalContent>
                    <div class="flex relative w-full mt-3 mb-2">
                        <input class="w-full form-control form-input form-input-bordered" id="amount" type="text"
                            placeholder="Enter Amount" v-model="amount" required name="amount" />
                    </div>

                    <div class="flex relative w-full mt-3 mb-2">
                        <select name="user_id" id="user_id" v-model="user_id" @change="getRateCenter"
                            class="w-full block form-control form-select form-select-bordered" required>
                            <option value="null">Select User</option>
                            <option v-for="(user) in users" :value="user.id" :key="'user-option'+user.id">
                                {{ user.first_name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex relative w-full mt-3 mb-2">
                        <textarea class="w-full form-control form-input form-input-bordered" id="textarea" rows="5"
                            placeholder="Enter Payment Decription" v-model="payment_description" required
                            name="payment_description">
                        </textarea>
                    </div>
                </ModalContent>
                <ModalFooter>
                    <div class="ml-auto">
                        <LinkButton dusk="cancel-upload-delete-button" type="button" @click.prevent="show = false"
                            class="mr-3">
                            {{ __("Cancel") }}
                        </LinkButton>
                        <LoadingButton type="submit"
                            class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                            :loading="loading" @click="loading = false">
                            Add Billing
                        </LoadingButton>
                    </div>
                </ModalFooter>
            </form>
        </Modal>
        <Card>
            <div class="flex justify-between mb-6">
                <div v-if="companies.length !== 1"
                    class="flex-1 field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    index="2">
                    <div class="px-8 mt-2 md:mt-0 md:w-1/5 md:py-5">
                        <label for="company-update-user-api-user-belongs-to-field"
                            class="inline-block pt-2 leading-tight">Company
                            <span class="text-red-500 text-sm">*</span></label>
                    </div>
                    <div class="mt-1 md:mt-0 pb-5 px-8 w-full flex-1 md:py-5">
                        <div class="flex items-center">
                            <div class="flex relative w-full">
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
                                <svg class="flex-shrink-0 pointer-events-none form-select-arrow"
                                    xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                                    <path class="fill-current"
                                        d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    index="2">
                    <div class="px-8 mt-2 md:mt-0 md:w-1/4 md:py-5">
                        <label for="company-update-user-api-user-belongs-to-field"
                            class="inline-block pt-2 leading-tight">Select date range
                            <span class="text-red-500 text-sm">*</span></label>
                    </div>
                    <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:py-5">
                        <div class="flex items-center">
                            <div class="relative w-full">
                                <Datepicker :enableTimePicker="false" @update:modelValue="load" range v-model="date">
                                </Datepicker>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Card>

        <Card>
            <ul
                class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <li class="mr-2" @click="tab = 'total'">
                    <a href="#" aria-current="page"
                        class="inline-block p-4 rounded-t-lg dark:bg-gray-800 dark:text-blue-500"
                        :class="{ 'bg-gray-100 text-blue-600': tab == 'total' }">Totals</a>
                </li>
                <li class="mr-2" @click="tab = 'category'">
                    <a href="#"
                        class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                        :class="{
                            'bg-gray-100 text-blue-600': tab == 'category',
                        }">Categories</a>
                </li>
                <li class="mr-2" @click="tab = 'detail'">
                    <a href="#"
                        class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                        :class="{
                            'bg-gray-100 text-blue-600': tab == 'detail',
                        }">Detailed</a>
                </li>
                <li class="mr-2" @click="tab = 'payments'">
                    <a href="#"
                        class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                        :class="{
                            'bg-gray-100 text-blue-600': tab == 'payments',
                        }">Payments</a>
                </li>
                <!--payments group by date
                usage group by date -->
                <li class="mr-2" @click="tab = 'charts'">
                    <a href="#"
                        class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                        :class="{
                            'bg-gray-100 text-blue-600': tab == 'charts',
                        }">History</a>
                </li>
            </ul>

            <div class="mt-3">
                <div v-if="tab == 'total'" class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <table class="w-full table-default" cellpadding="0" cellspacing="0" data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Type</span>
                                </th>
                                <!-- <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Quantity</span></th> -->
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Total</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in valuesByTypes" :key="'types'+item.type" :dusk="'types'+item.type" class="group">
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{ item.type }}
                                    </div>
                                </td>
                                <!-- <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{item.quantity}}</p>
                                    </div>
                                </td> -->
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.amount }}</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="tab == 'category'" class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <table class="w-full table-default" cellpadding="0" cellspacing="0" data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Main Type</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Quantity</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Total</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in valuesByMainTypes" :key="'main_types'+item.type" :dusk="'main_types'+item.type" class="group">
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{ item.main_type }}
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.quantity }}</p>
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.amount }}</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="tab == 'detail'" class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="w-full table-default" cellpadding="0" cellspacing="0" data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Campaign Name</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Type</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Price</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Date</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in campaignBalances" :key="'company_balances'+item.id" :dusk="'company_balances'+item.id" class="group"
                                addition-actions="[object Object]">
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{ item.campaign_name }}
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.campaign_type }}</p>
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.amount }}</p>
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{item.date}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <ResourcePagination :allMatchingResourceCount="
                            paginationData.allMatchingResourceCount
                        " :currentPage="paginationData.currentPage" :currentResourceCount="
                            paginationData.currentResourceCount
                        " :hasNextPage="paginationData.hasNextPage" :hasPreviousPage="paginationData.hasPreviousPage"
                        :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="25"
                        :resourceCountLabel="paginationData.resourceCountLabel" :shouldShowPagination="true"
                        :totalPages="paginationData.totalPages" :selectPage="selectPage" />
                </div>

                <div v-if="tab == 'payments'" class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="w-full table-default" cellpadding="0" cellspacing="0" data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Payment Date</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Payment Amount</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Description</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>User</span>
                                </th>
                                <th
                                    class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Company</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in payments" :key="'payments'+item.id" :dusk="'payments'+item.id" class="group"
                                addition-actions="[object Object]">
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{ item.created_at }}
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.amount }}</p>
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.description }}</p>
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.user.first_name }}</p>
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900" v-if="item.company">
                                    <div class="text-left" resource="[object Object]">
                                        <p>{{ item.company.name }}</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </Card>

        <div v-show="tab == 'charts'">
            <Card class="mt-2">
                <canvas id="paymentChart"></canvas>
            </Card>
            <Card class="mt-2">
                <canvas id="usageChart"></canvas>
            </Card>
        </div>
    </div>
</template>

<script>
    import Datepicker from "@vuepic/vue-datepicker";
    import "@vuepic/vue-datepicker/dist/main.css";
    import {
        mapGetters,
        mapMutations
    } from "vuex";
    import {
        nextTick
    } from "vue";
    import {
        Chart,
        BarController,
        CategoryScale,
        LinearScale,
        PointElement,
        BarElement,
        Title
    } from 'chart.js'

    Chart.register(BarController, BarElement, PointElement, LinearScale, CategoryScale, LinearScale, Title)
    export default {
        data() {
            return {
                show: false,
                amount: null,
                payment_description: null,
                user_id: null,
                companies: [],
                date: null,
                valuesByTypes: [],
                valuesByMainTypes: [],
                payments: [],
                company_id: null,
                paginationData: {},
                balances: [],
                campaignBalances: [],
                tab: "total",
                dataSets: {},
                useAgeChart: null,
                paymentChart: null
            };
        },
        components: {
            Datepicker,
        },
        computed: {
            ...mapGetters(["currentUser"]),
        },
        async mounted() {
            await Nova.request()
                .get("/nova-api/custom/get-usage-group-by-date")
                .then(
                    (res) => {
                        var ctx = document.getElementById("usageChart").getContext("2d");
                        let usageGroupedByDates = res.data.usage_grouped_by_date
                        const dataforUsage = {
                            labels: usageGroupedByDates.map(a => {
                                return a.date
                            }),
                            datasets: [{
                                label: 'My First Dataset',
                                data: usageGroupedByDates.map(a => {
                                    return a.total
                                }),
                                backgroundColor: [
                                    'rgba(255, 99, 132)',
                                    'rgba(255, 159, 64)',
                                    'rgba(255, 205, 86)',
                                    'rgba(75, 192, 192)',
                                    'rgba(54, 162, 235)',
                                    'rgba(153, 102, 255)',
                                    'rgba(201, 203, 207)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ],
                                borderWidth: 1
                            }]
                        };
                        this.useAgeChart = new Chart(ctx, {
                            type: 'bar',
                            data: dataforUsage,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },

                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Usage History',
                                        font: {
                                            size: 20
                                        },
                                        padding: {
                                            top: 10,
                                            bottom: 30
                                        }
                                    },
                                    tooltip: {
                                    callbacks: {
                                        labelColor: function(context) {
                                            return {
                                                borderColor: 'rgb(0, 0, 255)',
                                                backgroundColor: 'rgb(255, 0, 0)',
                                                borderWidth: 2,
                                                borderDash: [2, 2],
                                                borderRadius: 2,
                                            };
                                        },
                                        labelTextColor: function(context) {
                                            return '#543453';
                                        },
                                        label: function(context) {
                                            let label = context.dataset.label || '';

                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                },
                                }
                            },
                        });
                    }
                )
            await Nova.request()
                .get("/nova-api/custom/get-payment-group-by-date")
                .then(
                    (res) => {
                        var ctx = document.getElementById("paymentChart").getContext("2d");
                        let paymentGroupedByDates = res.data.payment_grouped_by_date
                        this.dataSets.labels = paymentGroupedByDates.map(a => {
                            return a.date
                        })
                        this.dataSets.data = paymentGroupedByDates.map(a => {
                            return a.total
                        })
                        const data = {
                            labels: this.dataSets.labels,
                            datasets: [{
                                label: 'My First Dataset',
                                data: this.dataSets.data,
                                backgroundColor: [
                                    'rgba(255, 99, 132)',
                                    'rgba(255, 159, 64)',
                                    'rgba(255, 205, 86)',
                                    'rgba(75, 192, 192)',
                                    'rgba(54, 162, 235)',
                                    'rgba(153, 102, 255)',
                                    'rgba(201, 203, 207)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ],
                                borderWidth: 1
                            }]
                        };
                        this.paymentChart = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            label: 'Payment History',
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    title: {
                                        font: {
                                            size: 20
                                        },
                                        display: true,
                                        text: 'Payment History',
                                        padding: {
                                            top: 10,
                                            bottom: 30
                                        }
                                    }
                                }
                            },
                        });
                    }
                )
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
            await Nova.request()
                .get("/nova-api/custom/users")
                .then(
                    (res) => {
                        this.users = res.data.users;
                        // console.log("this.users");
                        // console.log(this.users.length);
                    },
                    (err) => {}
                );
            await Nova.request()
                .get("/nova-api/custom/billing/get-value-by-types")
                .then(
                    (res) => {
                        this.valuesByTypes = res.data.value_by_type;
                        // console.log(res.data);
                    },
                    (err) => {}
                );
            await Nova.request()
                .get("/nova-api/custom/billing/get-value-by-main-types")
                .then((res) => {
                    this.valuesByMainTypes = res.data.value_by_main_type;
                });

            // await Nova.request().get('/nova-api/custom/balances')
            //     .then(res => {
            //         this.balances = res.data.data
            //         this.paginationData = {
            //             allMatchingResourceCount: res.data.data.length,
            //             currentPage: res.data.current_page,
            //             currentResourceCount: res.data.total,
            //             hasNextPage: res.data.next_page_url !== null,
            //             hasPreviousPage: res.data.prev_page_url !== null,
            //             resourceCountLabel: res.data.from +'-'+ res.data.to + ' of ' + res.data.total,
            //             totalPages: res.data.last_page,
            //         }
            //     })
            await Nova.request()
                .get("/nova-api/custom/billing/get-value-by-campaign-id", {
                    params: {
                        company_id: null,
                        from_date: null,
                        to_date: null,
                    },
                })
                .then((res) => {
                    this.campaignBalances = res.data.value_by_campaign_id.data;
                    // console.log('campaign balances ------>',res.data)
                    this.paginationData = {
                        allMatchingResourceCount: res.data.value_by_campaign_id.data.length,
                        currentPage: res.data.value_by_campaign_id.current_page,
                        currentResourceCount: res.data.value_by_campaign_id.total,
                        hasNextPage: res.data.value_by_campaign_id.next_page_url !== null,
                        hasPreviousPage: res.data.value_by_campaign_id.prev_page_url !== null,
                        resourceCountLabel: res.data.value_by_campaign_id.from +
                            "-" +
                            res.data.value_by_campaign_id.to +
                            " of " +
                            res.data.value_by_campaign_id.total,
                        totalPages: res.data.value_by_campaign_id.last_page,
                    };
                });
            await Nova.request()
                .get("/nova-api/custom/billing/payments")
                .then((res) => {
                    this.payments = res.data;
                });
            document.body.style.overflow = "visible";

        },
        methods: {
            async selectPage(val) {
                console.log(val)
                await Nova.request()
                    .get("/nova-api/custom/billing/get-value-by-campaign-id", {
                        params: {
                            page: val,
                            company_id: null,
                            from_date: null,
                            to_date: null,
                        },
                    })
                    .then((res) => {
                        this.campaignBalances = res.data.value_by_campaign_id.data;
                        // console.log('campaign balances ------>',res.data)
                        this.paginationData = {
                            allMatchingResourceCount: res.data.value_by_campaign_id.data.length,
                            currentPage: res.data.value_by_campaign_id.current_page,
                            currentResourceCount: res.data.value_by_campaign_id.total,
                            hasNextPage: res.data.value_by_campaign_id.next_page_url !==
                                null,
                            hasPreviousPage: res.data.value_by_campaign_id.prev_page_url !==
                                null,
                            resourceCountLabel: (res.data.value_by_campaign_id.from !== null ?
                                    res.data.value_by_campaign_id.from :
                                    0) +
                                "-" +
                                (res.data.value_by_campaign_id.to !== null ?
                                    res.data.value_by_campaign_id.to :
                                    0) +
                                " of " +
                                res.data.value_by_campaign_id.total,
                            totalPages: res.data.value_by_campaign_id.last_page,
                        };
                        Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();
                    });
            },
            async loadMore(val) {
                console.log(val);
            },
            async load() {
                await nextTick();
                let params = {
                    company_id: this.company_id,
                };
                if (this.date !== null) {
                    params.from_date = this.date[0];
                    params.to_date = this.date[1];
                }
                // let billingParams ={
                //     company_id: this.company_id,
                //     from_date : this.date[0],
                //     to_date : this.date[1]
                // }
                await Nova.request()
                    .get("/nova-api/custom/billing/get-value-by-types", {
                        params: params,
                    })
                    .then(
                        (res) => {
                            this.valuesByTypes = res.data.value_by_type;
                        },
                        (err) => {}
                    );
                await Nova.request()
                    .get("/nova-api/custom/billing/get-value-by-main-types", {
                        params: params,
                    })
                    .then((res) => {
                        this.valuesByMainTypes = res.data.value_by_main_type;
                    });
                await Nova.request()
                    .get("/nova-api/custom/billing/get-value-by-campaign-id", {
                        params: params,
                    })
                    .then((res) => {
                        this.campaignBalances = res.data.value_by_campaign_id.data;
                        // console.log('campaign balances ------>',res.data)
                        this.paginationData = {
                            allMatchingResourceCount: res.data.value_by_campaign_id.data.length,
                            currentPage: res.data.value_by_campaign_id.current_page,
                            currentResourceCount: res.data.value_by_campaign_id.total,
                            hasNextPage: res.data.value_by_campaign_id.next_page_url !==
                                null,
                            hasPreviousPage: res.data.value_by_campaign_id.prev_page_url !==
                                null,
                            resourceCountLabel: (res.data.value_by_campaign_id.from !== null ?
                                    res.data.value_by_campaign_id.from :
                                    0) +
                                "-" +
                                (res.data.value_by_campaign_id.to !== null ?
                                    res.data.value_by_campaign_id.to :
                                    0) +
                                " of " +
                                res.data.value_by_campaign_id.total,
                            totalPages: res.data.value_by_campaign_id.last_page,
                        };
                    });
                await Nova.request()
                    .get("/nova-api/custom/billing/payments", {
                        params: params,
                    })
                    .then((res) => {
                        this.payments = res.data;
                    });
                await Nova.request()
                .get("/nova-api/custom/get-usage-group-by-date", {
                    params: params,
                })
                .then(
                    (res) => {
                        this.useAgeChart.destroy()
                        var ctx = document.getElementById("usageChart").getContext("2d");
                        let usageGroupedByDates = res.data.usage_grouped_by_date
                        const dataforUsage = {
                            labels: usageGroupedByDates.map(a => {
                                return a.date
                            }),
                            datasets: [{
                                label: 'My First Dataset',
                                data: usageGroupedByDates.map(a => {
                                    return a.total
                                }),
                                backgroundColor: [
                                    'rgba(255, 99, 132)',
                                    'rgba(255, 159, 64)',
                                    'rgba(255, 205, 86)',
                                    'rgba(75, 192, 192)',
                                    'rgba(54, 162, 235)',
                                    'rgba(153, 102, 255)',
                                    'rgba(201, 203, 207)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ],
                                borderWidth: 1
                            }]
                        };
                        this.useAgeChart = new Chart(ctx, {
                            type: 'bar',
                            data: dataforUsage,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },

                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Usage History',
                                        font: {
                                            size: 20
                                        },
                                        padding: {
                                            top: 10,
                                            bottom: 30
                                        }
                                    },
                                    tooltip: {
                                    callbacks: {
                                        labelColor: function(context) {
                                            return {
                                                borderColor: 'rgb(0, 0, 255)',
                                                backgroundColor: 'rgb(255, 0, 0)',
                                                borderWidth: 2,
                                                borderDash: [2, 2],
                                                borderRadius: 2,
                                            };
                                        },
                                        labelTextColor: function(context) {
                                            return '#543453';
                                        },
                                        label: function(context) {
                                            let label = context.dataset.label || '';

                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                },
                                }
                            },
                        });
                    }
                )
                await Nova.request()
                .get("/nova-api/custom/get-payment-group-by-date", {
                    params: params,
                })
                .then(
                    (res) => {
                        this.paymentChart.destroy();
                        var ctx = document.getElementById("paymentChart").getContext("2d");
                        let paymentGroupedByDates = res.data.payment_grouped_by_date
                        this.dataSets.labels = paymentGroupedByDates.map(a => {
                            return a.date
                        })
                        this.dataSets.data = paymentGroupedByDates.map(a => {
                            return a.total
                        })
                        const data = {
                            labels: this.dataSets.labels,
                            datasets: [{
                                label: 'My First Dataset',
                                data: this.dataSets.data,
                                backgroundColor: [
                                    'rgba(255, 99, 132)',
                                    'rgba(255, 159, 64)',
                                    'rgba(255, 205, 86)',
                                    'rgba(75, 192, 192)',
                                    'rgba(54, 162, 235)',
                                    'rgba(153, 102, 255)',
                                    'rgba(201, 203, 207)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ],
                                borderWidth: 1
                            }]
                        };
                        this.paymentChart = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            label: 'Payment History',
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    title: {
                                        font: {
                                            size: 20
                                        },
                                        display: true,
                                        text: 'Payment History',
                                        padding: {
                                            top: 10,
                                            bottom: 30
                                        }
                                    }
                                }
                            },
                        });
                    }
                )
            },
            async submit() {
                this.loading = true;

                let data = {
                    user_id: this.user_id,
                    amount: this.amount,
                    payment_description: this.payment_description,
                };
                // let amount = this.result.amount;
                let params = data;

                await Nova.request()
                    .post("/nova-api/custom/payment", params)
                    .then((response) => {
                        this.loading = false;
                        this.show = false;
                        if (response.data.data.success) {
                            Nova.success("Balance added successfully.");
                        } else {
                            Nova.error("Error In Payment Process.");
                        }
                    });
            },
        },
    };

</script>

<style>
    /* Scoped Styles */

</style>
