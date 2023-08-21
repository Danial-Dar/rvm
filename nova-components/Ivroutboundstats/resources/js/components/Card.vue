<template>
    <loading-card :loading="loading" class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light pt-3 pb-3">
                IVR Outbound Calls
            </h1>
            <Datepicker
                v-model="selectedRange"
                class="inline-block h-9 pt-3"
                range
                :enableTimePicker="false"
                @update:modelValue="getDataByDateRange"
                :clearable="true"
            />
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
                                <span>Campaign Name</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Optin</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Optout</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Noinput</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Optin (%)</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Optout (%)</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Noinput (%)</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in ivrOutboundCalls"
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
                                    {{ item.campaign_name }}
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
                                        {{
                                            item.transfered_count !== null
                                                ? parseFloat(
                                                      item.transfered_count
                                                  ).toFixed(2)
                                                : 0
                                        }}
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
                                        {{
                                            item.optout_count !== null
                                                ? parseFloat(
                                                      item.optout_count
                                                  ).toFixed(2)
                                                : 0
                                        }}
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
                                        {{
                                            item.noinput_count !== null
                                                ? parseFloat(
                                                      item.noinput_count
                                                  ).toFixed(2)
                                                : 0
                                        }}
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
                                        {{
                                            item.total !== 0
                                                ? (
                                                      (parseFloat(
                                                          item.transfered_count
                                                      ) /
                                                          parseFloat(
                                                              item.total
                                                          )) *
                                                      100
                                                  ).toFixed(2) + " %"
                                                : "0.0 %"
                                        }}
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
                                        {{
                                            item.total !== 0
                                                ? (
                                                      (parseFloat(
                                                          item.optout_count
                                                      ) /
                                                          parseFloat(
                                                              item.total
                                                          )) *
                                                      100
                                                  ).toFixed(2) + " %"
                                                : "0.0 %"
                                        }}
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
                                        {{
                                            item.total !== 0
                                                ? (
                                                      (parseFloat(
                                                          item.noinput_count
                                                      ) /
                                                          parseFloat(
                                                              item.total
                                                          )) *
                                                      100
                                                  ).toFixed(2) + " %"
                                                : "0.0 %"
                                        }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            ivrOutboundCalls: [],
            loading: true,
            selectedRange: "",
        };
    },
    mounted() {
        // const query = this.card.query;
        // console.log("ivrOutboundCalls", query.ivrOutboundCalls);

        // this.ivrOutboundCalls = query.ivrOutboundCalls;
        let start_date = "";
        let end_date = "";
        this.getData(start_date, end_date);
    },
    methods: {
        async getData(start_date, end_date) {
            let params = {
                start_date,
                end_date,
            };
            let baseUrl = "/nova-api/custom/get-ivr-outbound-stats";
            await Nova.request()
                .post(baseUrl, params)
                .then((response) => {
                    if (response.data.query.length > 0) {
                        this.ivrOutboundCalls = response.data.query;
                    }
                    this.loading = false;
                    console.log("10.ivroutboundstats------>", response.data.query);
                });
        },
        getDataByDateRange(date) {
            // let date = this.selectedRange;
            // console.log(date);
            if (date !== null) {
                let startDate = moment(date[0]).format("YYYY-MM-DD");
                let endDate = moment(date[1]).format("YYYY-MM-DD");
                this.getData(startDate, endDate);
            }
        },
    },
};
</script>
