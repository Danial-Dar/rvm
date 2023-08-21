<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light pt-3 pb-3">
                Company Campaigns
            </h1>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 mt-6">

                <table
                    class="w-full table-default card-scroll"
                    cellpadding="0"
                    cellspacing="0"
                    data-testid="resource-table"
                >
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th
                            class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                        >
                            <span>Company Name</span>
                        </th>
                        <th
                            class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                        >
                            <span>Number of Campaigns</span>
                        </th>
                        <th
                            class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                        >
                            <span>Number of Calls Sent</span>
                        </th>
                        <th
                            class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                        >
                            <span>Total Callbacks</span>
                        </th>
                        <th
                            class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                        >
                            <span>Total money Spent</span>
                        </th>
                        <th
                            class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                        >
                            <span>Total Payments Made</span>
                        </th>
                    </tr>
                </thead>

                <tbody  v-if="table_data.length>0">
                    <tr
                        v-for="item in table_data"
                        :key="item.name"
                        dusk="53-row"
                        class="group"
                        addition-actions="[object Object]"
                    >
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{ item.company.name }}
                            </div>
                        </td>
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                <p>
                                    {{ item.campaign_count }}
                                </p>
                            </div>
                        </td>
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                <p>
                                    {{ item.call_sent_count }}
                                </p>
                            </div>
                        </td>
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                <p>
                                    {{ item.total_call_backs }}
                                </p>
                            </div>
                        </td>
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                <p>
                                    {{ item.total_money_spent != null ? item.total_money_spent : 0.00 }}
                                </p>
                            </div>
                        </td>
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                <p>
                                    {{ item.total_payments_made != null ? item.total_payments_made : 0.00 }}
                                </p>
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
                :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="10"
                :resourceCountLabel="paginationData.resourceCountLabel" :shouldShowPagination="true"
                :totalPages="paginationData.totalPages" :selectPage="selectPage" />
            </div>
        </div>
    </loading-card>
</template>

<script>
import moment from "moment";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
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
            table_data: [],
            loading: true,
            selectedRange: "",
            paginationData: {},
            start_date: '',
            end_date: ''
        };
    },

    mounted() {
        let start_date = "";
        let end_date = "";
        this.getData();
        // const query = this.card.query;
        // console.log("table_data", query.table_data);

        // this.table_data = query.table_data;
        //
    },
    methods: {
        async loadMore(val) {
            this.selectPage(val)
        },
        async selectPage(val) {
            this.loading = true;
            let params = {
                //start_date: this.start_date,
                page: val,
                //end_date: this.end_date,
            };
            let baseUrl = "/nova-api/custom/company-campaign-data";
            await Nova.request()
                .get(baseUrl, {
                    params
                })
                .then((response) => {
                    this.table_data = response.data.query.data;
                    this.paginationData = {
                        allMatchingResourceCount: response.data.query.length,
                        currentPage: response.data.query.current_page,
                        currentResourceCount: response.data.query.total,
                        hasNextPage: response.data.query.next_page_url !== null,
                        hasPreviousPage: response.data.query.prev_page_url !== null,
                        resourceCountLabel: response.data.query.from +
                            "-" +
                            response.data.query.to +
                            " of " +
                            response.data.query.total,
                        totalPages: response.data.query.last_page,
                    };
                    
                    this.loading = false;
                     Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();
                    // }
                    console.log("9.recordingstats------>", response.data.query);
                });
        },
        async getData() {
            this.loading = true;
            let params = {
                //start_date,
               // end_date,
            };
            let baseUrl = "/nova-api/custom/company-campaign-data";
            await Nova.request()
                .get(baseUrl, {
                    params
                })
                .then((response) => {
                    this.table_data = response.data.query.data;
                    this.paginationData = {
                        allMatchingResourceCount: response.data.query.length,
                        currentPage: response.data.query.current_page,
                        currentResourceCount: response.data.query.total,
                        hasNextPage: response.data.query.next_page_url !== null,
                        hasPreviousPage: response.data.query.prev_page_url !== null,
                        resourceCountLabel: response.data.query.from +
                            "-" +
                            response.data.query.to +
                            " of " +
                            response.data.query.total,
                        totalPages: response.data.query.last_page,
                    };
                    
                    this.loading = false;
                    // }
                    console.log("9.recordingstats------>", response.data.query);
                });
        },
        
        secondsToHms(d) {
            d = Number(d);

            var h = Math.floor(d / 3600);
            var m = Math.floor(d % 3600 / 60);
            var s = Math.floor(d % 3600 % 60);
            return ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
            // return ('0' + h).slice(-2) + ":" + ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
        }
    },
};
</script>
