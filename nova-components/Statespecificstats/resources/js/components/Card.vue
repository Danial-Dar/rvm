<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light pt-3 pb-3">
                State Specific Stats
            </h1>
            <!-- <Datepicker
                v-model="selectedRange"
                class="inline-block h-9 pt-3"
                range
                :enableTimePicker="false"
                @update:modelValue="getDataByDateRange"
                :clearable="true"
            /> -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 mt-6">
                <table
                    class="w-full table-default"
                    cellpadding="0"
                    cellspacing="0"
                    data-testid="resource-table"
                >
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Area Code</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Calls Received</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Total Contacts</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>DNC's</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Avg CallBack %</span>
                            </th>
                            
                            
                        </tr>
                    </thead>
                    <tbody v-if="stateStats.length>0">
                        <tr
                            v-for="item in stateStats"
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
                                    {{ item.location_code }}
                                </div>
                            </td>
                            <td
                                class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{ item.incoming_call_log_count }}
                                </div>
                            </td>
                            <td
                                class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{ item.campaign_contact_count }}
                                </div>
                            </td>
                            <td
                                class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{ item.dnc_count }}
                                </div>
                            </td>
                            <td
                                class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{ item.average_call_back_percentage }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <ResourcePagination 
                :allMatchingResourceCount="paginationData.allMatchingResourceCount" 
                :currentPage="paginationData.currentPage" 
                :currentResourceCount="paginationData.currentResourceCount" 
                :hasNextPage="paginationData.hasNextPage" 
                :hasPreviousPage="paginationData.hasPreviousPage"
                :loadMore="loadMore" 
                paginationComponent="pagination-simple" 
                :perPage="10"
                :resourceCountLabel="paginationData.resourceCountLabel" 
                :shouldShowPagination="true"
                :totalPages="paginationData.totalPages" 
                :selectPage="selectPage" />
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
    ],
    components: {
        Datepicker,
    },
    data() {
        return {
            stateStats: [],
            loading: true,
            paginationData: {},
        };
    },
    mounted() {
        // let start_date = "";
        // let end_date = "";
        // this.getData(start_date, end_date);
        this.getData();
    },
    methods: {
        async getData() {
            // let params = {
            //     start_date,
            //     end_date,
            // };
            this.loading = true;
            let baseUrl = "/nova-api/custom/get-state-stats";
            await Nova.request()
                // .post(baseUrl, params)
                .get(baseUrl)
                .then((response) => {

                    this.stateStats = response.data.query.data;

                    this.paginationData = {
                            allMatchingResourceCount: response.data.query.length,
                            currentPage: response.data.query.current_page,
                            currentResourceCount: response.data.query.total,
                            hasNextPage: (response.data.query.next_page_url !== null) ? response.data.query.next_page_url : null,
                            hasPreviousPage: (response.data.query.prev_page_url !== null) ? response.data.query.prev_page_url : null,
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
                    console.log("11.statestats------>", response.data.query);
                });
        },
        async loadMore(val) {
            this.selectPage(val)
        },
        async selectPage(val) {
            this.loading = true;
            console.log(val)
            let params = {
                page: val,
                // start_date: this.start_date,
                // end_date: this.end_date,
            };
            let baseUrl = "/nova-api/custom/get-state-stats";
            await Nova.request()
                // .post(baseUrl, params)
                .get(baseUrl, {
                    params
                })
                .then((response) => {

                    this.stateStats = response.data.query.data;

                    this.paginationData = {
                            allMatchingResourceCount: response.data.query.length,
                            currentPage: response.data.query.current_page,
                            currentResourceCount: response.data.query.total,
                            hasNextPage: (response.data.query.next_page_url !== null) ? response.data.query.next_page_url : null,
                            hasPreviousPage: (response.data.query.prev_page_url !== null) ? response.data.query.prev_page_url : null,
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
                });
        },
        getDataByDateRange(date) {
            if (date !== null) {
                let startDate = moment(date[0]).format("YYYY-MM-DD");
                let endDate = moment(date[1]).format("YYYY-MM-DD");
                this.getData(startDate, endDate);
            }
        },
        secondsToHms(d) {
            d = Number(d);

            var h = Math.floor(d / 3600);
            var m = Math.floor(d % 3600 / 60);
            var s = Math.floor(d % 3600 % 60);
            return ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
        }
    },
};
</script>
