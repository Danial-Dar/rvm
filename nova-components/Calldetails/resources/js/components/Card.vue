<template>
  <Card class="flex flex-col items-center justify-center">
    <div class="px-3 py-3">
      <h1 class="text-center text-3xl text-gray-500 font-light">Call Details</h1>
      <div class="ml-4 bg-white dark:bg-gray-800 rounded-lg shadow mb-6 mt-6" style="overflow: auto; height: 300px; width: 95%">
                <table
                    class="w-full table-default"
                    cellpadding="0"
                    cellspacing="0"
                    data-testid="resource-table"
                >
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <!-- <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Type</span>
                            </th> -->
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Status</span>
                            </th>
                            <!-- <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Result</span>
                            </th> -->
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Reviewer</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Duration</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Phone</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Score</span>
                            </th>
                            <!-- <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Missed Items</span>
                            </th> -->
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Call Date</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Agent</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>First Name</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Last Name</span>
                            </th>
                            <th
                                class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Email</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr class="group"
                      v-for="item in calls"
                            :key="item.name"
                            dusk="53-row"
                            addition-actions="[object Object]">
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.status}}
                            </div>
                        </td>
                      
                        <!-- <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                x
                            </div>
                        </td> -->
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.reviewer}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.length}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.phone_number}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.score}}%
                            </div>
                        </td>
                      
                        <!-- <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                2
                            </div>
                        </td> -->
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.created_at}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.agent.first_name}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.user.first_name}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.user.last_name}}
                            </div>
                        </td>
                      
                        <td
                            class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                        >
                            <div
                                class="text-left"
                                resource="[object Object]"
                            >
                                {{item.user.email}}
                            </div>
                        </td>
                      </tr>
                      
                    
                    </tbody>
                </table>
            </div>
    </div>
  </Card>
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
            calls: [],
            selectedRange: "",
        };
    },

    mounted() {
        // const query = this.card.query;
        // console.log("listStats", query.listStats);

        // this.listStats = query.listStats;
        let start_date = "";
        let end_date = "";
        this.getData();
    },
    methods: {
        async getData() {
            let baseUrl = "/nova-api/custom/get-call-details";
            await Nova.request()
                .get(baseUrl)
                .then((response) => {
                    // if (response.data.query.length > 0) {
                        this.calls = response.data.calls;
                        console.log(this.calls)
                    // }
                    // console.log("8.liststats------>", response.data.query);
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
