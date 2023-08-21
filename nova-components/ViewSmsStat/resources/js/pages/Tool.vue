<template>
  <div>
    <Head title="View Stat" />

    <div class="flex justify-content-between justify-between" style="margin-left:10px">
        <div>
            <h1 class="text-90 font-normal text-xl md:text-2xl mb-3">Campaign Stats</h1>
        </div>

    </div>
    <!-- <Heading class="" style="margin: 10px;">Campaign Stats</Heading> -->
    <Card
      class="flex flex-col items-left" style="margin: 10px; padding: 10px;"
    >
        <div>
            <div class="flex justify-between">
                <div style="margin: 10px 0px 10px 10px;">
                    <section ref="numArea" class="num-area" >
                        <h1 class="text-90 font-normal text-xl md:text-2xl" style="padding: 0px 10px 10px 10px;">Contacts</h1>
                        <p v-for="number in numbers" >
                        <button v-on:click="num(number.number)" class="number">
                            {{ number.number }}
                        </button>

                        </p>
                    </section>
                </div>
                <div class="flex-1" style="margin: 10px;" v-if="showMessages == true">
                    <section ref="chatArea" class="chat-area">
                    <h1 class="text-90 font-normal text-xl md:text-2xl mb-3">Messages</h1>
                        <p v-for="message in messages" class="message" :class="{ 'message-out': message.author === 'you', 'message-in': message.author !== 'you' }">
                        {{ message.body }}
                        </p>
                    </section>
                </div>
                <div class="flex-1" style="margin: 10px;" v-if="showMessages == false">
                    <section ref="chatArea" class="chat-area">
                         <div>
                            <h1 class="text-90 font-normal text-xl md:text-2xl mb-3">Welcome To Campaign Messages</h1>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </Card>


    <!-- <div class="flex" style="padding:10px;">
        <div class=" rounded-lg w-full flex items-center">
            <div class="flex items-center">
                <section ref="chatArea" class="chat-area">
                    <p v-for="message in messages" class="message" :class="{ 'message-out': message.author === 'you', 'message-in': message.author !== 'you' }">
                    {{ message.body }}
                    </p>
                </section>
            </div>
        </div>
    </div> -->

    <!-- <Heading class="mb-6" style="margin-left: 10px;">OutBound And InBound Data</Heading> -->
    <div v-if="campaign.campaign_type == 'press-1'">
        <div class="flex">
        <div class="relative h-9 md:flex-shrink-0" searchable="true">
            <Heading class="mb-6" style="margin-left: 10px;">OutBound And InBound Data</Heading>
        </div>
        <div class="w-full flex items-center">
            <div class="ml-auto flex items-center">
            <div>
                <div class="flex-shrink-0 ml-auto pr-2">
                <a :href="'/nova-api/custom/export-ivr-logs/' + campaign.id +'/'+ ivr_page +'/'+ ivr_per_page" class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0" @click="exportLogs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span style="margin-left: 3px;">Ivr Call Logs</span>
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>

        <loading-card
        class="flex flex-col items-left" style="margin: 10px; padding: 10px;" :loading="loading"
        >
        <div class="flex justify-end">
            <div class="pt-2 pb-3" dusk="filter-per-page">
                <h3 class="px-3 text-xs uppercase font-bold tracking-wide"><span>Per Page</span></h3>
                <div class="mt-1 px-3">
                    <div class="flex relative">
                        <select dusk="per-page-select" v-model="ivr_per_page" @change="ivrChangePerPage" class="w-full block form-control form-select form-control-sm form-select-bordered">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <svg class="flex-shrink-0 pointer-events-none form-select-arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                            <path class="fill-current" d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div>

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
                        <span>Date And Time</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>To Number</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>From Number</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>Disposition</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="log in ivr_logs"
                    :key="log.id"
                    dusk="53-row"
                    class="group"
                    addition-actions="[object Object]"
                >
                <!-- <tr class="group"> -->
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.created_at}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.to_number}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.from_number}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.disposition}}
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
            :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="ivr_per_page"
            :resourceCountLabel="paginationData.resourceCountLabel" :shouldShowPagination="true"
            :totalPages="paginationData.totalPages" :selectPage="selectPage" />
        </div>
        </loading-card>

        <div class="flex">
        <div class="relative h-9 md:flex-shrink-0" searchable="true">
            <Heading class="mb-6" style="margin-left: 10px;">Call Backs</Heading>
        </div>
        <div class="w-full flex items-center">
            <div class="ml-auto flex items-center">
            <div>
                <div class="flex-shrink-0 ml-auto pr-2">
                <a :href="'/nova-api/custom/export-call-back-logs/' + campaign.id +'/'+ call_backs_page +'/'+ call_backs_per_page" class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0" @click="exportLogs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span style="margin-left: 3px;">Call Backs</span>
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>

        <loading-card
        class="flex flex-col items-left" style="margin: 10px; padding: 10px;" :loading="loadingCallBack"
        >
        <div class="flex justify-end">
            <div class="pt-2 pb-3" dusk="filter-per-page">
                <h3 class="px-3 text-xs uppercase font-bold tracking-wide"><span>Per Page</span></h3>
                <div class="mt-1 px-3">
                    <div class="flex relative">
                        <select dusk="per-page-select" v-model="call_backs_per_page" @change="callBacksChangePerPage" class="w-full block form-control form-select form-control-sm form-select-bordered">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <svg class="flex-shrink-0 pointer-events-none form-select-arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                            <path class="fill-current" d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div>

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
                        <span>Date And Time</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>From Number</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>To Number</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>Duration</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="log in call_back_logs"
                    :key="log.id"
                    dusk="53-row"
                    class="group"
                    addition-actions="[object Object]"
                >
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.my_created_at}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.From}}
                        </div>
                    </td>
                                        <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.To}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.my_duration}}
                        </div>
                    </td>
                </tr>

            </tbody>
            </table>
            <ResourcePagination :allMatchingResourceCount="
                paginationDataCallBack.allMatchingResourceCount
            " :currentPage="paginationDataCallBack.currentPage" :currentResourceCount="
                paginationDataCallBack.currentResourceCount
            " :hasNextPage="paginationDataCallBack.hasNextPage" :hasPreviousPage="paginationDataCallBack.hasPreviousPage"
            :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="call_backs_per_page"
            :resourceCountLabel="paginationDataCallBack.resourceCountLabel" :shouldShowPagination="true"
            :totalPages="paginationDataCallBack.totalPages" :selectPage="selectPageCallBack" />
        </div>
        </loading-card>
    </div>

    <div v-if="campaign.campaign_type == 'rvm'">
        <div class="flex">
        <div class="relative h-9 md:flex-shrink-0" searchable="true">
            <Heading class="mb-6" style="margin-left: 10px;">Incoming Call Logs</Heading>
        </div>
        <div class="w-full flex items-center">
            <div class="ml-auto flex items-center">
            <div>
                <div class="flex-shrink-0 ml-auto pr-2">
                <a :href="'/nova-api/custom/export-incoming-logs/' + campaign.id +'/'+ incoming_page +'/'+ incoming_per_page" class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0" @click="exportLogs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span style="margin-left: 3px;">Incoming Call Logs</span>
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>

        <loading-card :loading="loadingIncoming"
        class="flex flex-col items-left" style="margin: 10px; padding: 10px;"
        >

        <div class="flex justify-end">
            <div class="pt-2 pb-3" dusk="filter-per-page">
                <h3 class="px-3 text-xs uppercase font-bold tracking-wide"><span>Per Page</span></h3>
                <div class="mt-1 px-3">
                    <div class="flex relative">
                        <select dusk="per-page-select" v-model="incoming_per_page" @change="incomingChangePerPage" class="w-full block form-control form-select form-control-sm form-select-bordered">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <svg class="flex-shrink-0 pointer-events-none form-select-arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                            <path class="fill-current" d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div>

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
                        <span>Date And Time</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>From Number</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>Duration</span>
                    </th>
                    <th
                        class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                    >
                        <span>Caller ID / VM Call Back</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="log in incoming_logs"
                    :key="log.id"
                    dusk="53-row"
                    class="group"
                    addition-actions="[object Object]"
                >
                <!-- <tr class="group"> -->
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.created_at}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.From}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.my_duration}}
                        </div>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                    >
                        <div
                            class="text-left"
                            resource="[object Object]"
                        >
                            {{log.To = log.alpha_number ? 'VM Call Back' : 'Caller ID' }}
                        </div>
                    </td>
                </tr>

            </tbody>
            </table>
            <ResourcePagination :allMatchingResourceCount="
                paginationDataIncoming.allMatchingResourceCount
            " :currentPage="paginationDataIncoming.currentPage" :currentResourceCount="
                paginationDataIncoming.currentResourceCount
            " :hasNextPage="paginationDataIncoming.hasNextPage" :hasPreviousPage="paginationDataIncoming.hasPreviousPage"
            :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="incoming_per_page"
            :resourceCountLabel="paginationDataIncoming.resourceCountLabel" :shouldShowPagination="true"
            :totalPages="paginationDataIncoming.totalPages" :selectPage="selectPageIncoming" />
        </div>
        </loading-card>
    </div>

    <!-- <loading-card :loading="loading" class="flex flex-col items-center justify-center" style="margin: 10px;">
        <h1 class="pt-3 pb-3">Call Sent To Destination Heat Map</h1>
        <div class="" ref="chartdiv" style="margin-top: 2rem; height:300px; width: 100%;"></div>
    </loading-card> -->

    <!-- <loading-card :loading="loadingRvmCallBackHeatMap" class="flex flex-col items-center justify-center" style="margin: 10px;" v-if="campaign.campaign_type == 'rvm'">
        <h1 class="pt-3 pb-3">Call Back Heat Map</h1>
        <div class="" ref="chartdivCallBackRvm" style="margin-top: 2rem; height:300px; width: 100%;"></div>
    </loading-card> -->

    <!-- <loading-card class="flex flex-col items-center justify-center" style="margin: 10px;" :loading="loadingSendRate">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-gray-500 font-light pt-3 pb-3">
                Campaign Send Rates
            </h1>

            <Datepicker
                v-model="date"
                class="inline-block h-9 pt-3"
                :enableTimePicker="false"
                @update:modelValue="getDataByDateRange"
                :clearable="true"
            />
        </div>
        <div class="chart" ref="chartdivSendRate" style="margin-top: 2rem; height: 300px; width: 100%;"></div>
    </loading-card> -->

    <!-- <loading-card :loading="loadingCallBackHeatMap" class="flex flex-col items-center justify-center" style="margin: 10px;" v-if="campaign.campaign_type == 'press-1'">
        <h1 class="pt-3 pb-3">Callback Heat Map</h1>
        <div class="chart" ref="chartdivCallBack" style="margin-top:2rem; height:300px; width: 100%;"></div>
    </loading-card> -->
    <!-- <div v-if="campaign.campaign_type == 'press-1'">
        <loading-card :loading="loadingOptIn" class="flex flex-col items-center justify-center" style="margin: 10px;">
            <h1 class="pt-3 pb-3">Opt In Heat Map</h1>
            <div class="chart" ref="chartdivOptIn" style="margin-top:2rem; height:300px; width: 100%;"></div>
        </loading-card>

        <loading-card :loading="loadingOptOut" class="flex flex-col items-center justify-center" style="margin: 10px;">
            <h1 class="pt-3 pb-3">Opt Out Heat Map</h1>
            <div class="chart" ref="chartdivOptOut" style="margin-top:2rem; height:300px; width: 100%;"></div>
        </loading-card>
    </div> -->

  </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";
    export default {
        data() {
            return {
            campaign: {
                id: "391"
            },
            hover: false,
            showMessages : false,
            numbers: [
                {
                    body: +923075381348
                },
                {
                    body: +923078566095
                },
                {
                    body: +923078566097
                }
            ],
            messages: [
            {
                body: 'Welcome to the chat, I\'m Bob!',
                author: 'bob'
            },
            {
                body: 'Thank you Bob',
                author: 'you'
            },
            {
                body: 'You\'re most welcome',
                author: 'bob'
            },
            {
                body: 'Welcome to the chat, I\'m Bob!',
                author: 'bob'
            },
            {
                body: 'Thank you Bob',
                author: 'you'
            },
            {
                body: 'You\'re most welcome',
                author: 'bob'
            }
            ],
            loading: true,
            loadingCallSent: true,
            loadingCallBack: true,
            loadingSendRate: true,
            loadingCallBackHeatMap: true,
            loadingOptIn: true,
            loadingOptOut: true,
            loadingRvmCallBackHeatMap: true,
            loadingIncoming: true,
            call_backs: 0,
            avg_calls_duration: 0,
            call_back_percentage: 0,
            ivr_logs: [],
            incoming_logs: [],
            call_back_logs: [],
            paginationData: {},
            paginationDataIncoming: {},
            paginationDataCallBack: {},
            data: [],
            dataSendRate: [],
            dataCallBack: [],
            dataOptIn: [],
            dataOptOut: [],
            optIn_count: 0,
            optOut_count: 0,
            ivr_count: 0,
            vm_count: 0,
            selectedRange: "",
            selectedRangeSendRate: "",
            start_date: "",
            end_date: "",
            date: new Date(),
            ivr_per_page: 10,
            incoming_per_page: 10,
            call_backs_per_page: 10,
            ivr_page: 1,
            incoming_page: 1,
            call_backs_page: 1,
            rvm_call_back_data: [],
            weekdays: [
                { hour: "12am", weekday: "Sunday", value: 0 },
                { hour: "1am", weekday: "Sunday", value: 0 },
                { hour: "2am", weekday: "Sunday", value: 0 },
                { hour: "3am", weekday: "Sunday", value: 0 },
                { hour: "4am", weekday: "Sunday", value: 0 },
                { hour: "5am", weekday: "Sunday", value: 0 },
                { hour: "6am", weekday: "Sunday", value: 0 },
                { hour: "7am", weekday: "Sunday", value: 0 },
                { hour: "8am", weekday: "Sunday", value: 0 },
                { hour: "9am", weekday: "Sunday", value: 0 },
                { hour: "10am", weekday: "Sunday", value: 0 },
                { hour: "11am", weekday: "Sunday", value: 0 },
                { hour: "12pm", weekday: "Sunday", value: 0 },
                { hour: "1pm", weekday: "Sunday", value: 0 },
                { hour: "2pm", weekday: "Sunday", value: 0 },
                { hour: "3pm", weekday: "Sunday", value: 0 },
                { hour: "4pm", weekday: "Sunday", value: 0 },
                { hour: "5pm", weekday: "Sunday", value: 0 },
                { hour: "6pm", weekday: "Sunday", value: 0 },
                { hour: "7pm", weekday: "Sunday", value: 0 },
                { hour: "8pm", weekday: "Sunday", value: 0 },
                { hour: "9pm", weekday: "Sunday", value: 0 },
                { hour: "10pm", weekday: "Sunday", value: 0 },
                { hour: "11pm", weekday: "Sunday", value: 0 },
                { hour: "12pm", weekday: "Monday", value: 0 },
                { hour: "1am", weekday: "Monday", value: 0 },
                { hour: "2am", weekday: "Monday", value: 0 },
                { hour: "3am", weekday: "Monday", value: 0 },
                { hour: "4am", weekday: "Monday", value: 0 },
                { hour: "5am", weekday: "Monday", value: 0 },
                { hour: "6am", weekday: "Monday", value: 0 },
                { hour: "7am", weekday: "Monday", value: 0 },
                { hour: "8am", weekday: "Monday", value: 0 },
                { hour: "9am", weekday: "Monday", value: 0 },
                { hour: "10am", weekday: "Monday", value: 0 },
                { hour: "11am", weekday: "Monday", value: 0 },
                { hour: "12am", weekday: "Monday", value: 0 },
                { hour: "1pm", weekday: "Monday", value: 0 },
                { hour: "2pm", weekday: "Monday", value: 0 },
                { hour: "3pm", weekday: "Monday", value: 0 },
                { hour: "4pm", weekday: "Monday", value: 0 },
                { hour: "5pm", weekday: "Monday", value: 0 },
                { hour: "6pm", weekday: "Monday", value: 0 },
                { hour: "7pm", weekday: "Monday", value: 0 },
                { hour: "8pm", weekday: "Monday", value: 0 },
                { hour: "9pm", weekday: "Monday", value: 0 },
                { hour: "10pm", weekday: "Monday", value: 0 },
                { hour: "11pm", weekday: "Monday", value: 0 },
                { hour: "12pm", weekday: "Tuesday", value: 0 },
                { hour: "1am", weekday: "Tuesday", value: 0 },
                { hour: "2am", weekday: "Tuesday", value: 0 },
                { hour: "3am", weekday: "Tuesday", value: 0 },
                { hour: "4am", weekday: "Tuesday", value: 0 },
                { hour: "5am", weekday: "Tuesday", value: 0 },
                { hour: "6am", weekday: "Tuesday", value: 0 },
                { hour: "7am", weekday: "Tuesday", value: 0 },
                { hour: "8am", weekday: "Tuesday", value: 0 },
                { hour: "9am", weekday: "Tuesday", value: 0 },
                { hour: "10am", weekday: "Tuesday", value: 0 },
                { hour: "11am", weekday: "Tuesday", value: 0 },
                { hour: "12am", weekday: "Tuesday", value: 0 },
                { hour: "1pm", weekday: "Tuesday", value: 0 },
                { hour: "2pm", weekday: "Tuesday", value: 0 },
                { hour: "3pm", weekday: "Tuesday", value: 0 },
                { hour: "4pm", weekday: "Tuesday", value: 0 },
                { hour: "5pm", weekday: "Tuesday", value: 0 },
                { hour: "6pm", weekday: "Tuesday", value: 0 },
                { hour: "7pm", weekday: "Tuesday", value: 0 },
                { hour: "8pm", weekday: "Tuesday", value: 0 },
                { hour: "9pm", weekday: "Tuesday", value: 0 },
                { hour: "10pm", weekday: "Tuesday", value: 0 },
                { hour: "11pm", weekday: "Tuesday", value: 0 },
                { hour: "12pm", weekday: "Wednesday", value: 0 },
                { hour: "1am", weekday: "Wednesday", value: 0 },
                { hour: "2am", weekday: "Wednesday", value: 0 },
                { hour: "3am", weekday: "Wednesday", value: 0 },
                { hour: "4am", weekday: "Wednesday", value: 0 },
                { hour: "5am", weekday: "Wednesday", value: 0 },
                { hour: "6am", weekday: "Wednesday", value: 0 },
                { hour: "7am", weekday: "Wednesday", value: 0 },
                { hour: "8am", weekday: "Wednesday", value: 0 },
                { hour: "9am", weekday: "Wednesday", value: 0 },
                { hour: "10am", weekday: "Wednesday", value: 0 },
                { hour: "11am", weekday: "Wednesday", value: 0 },
                { hour: "12am", weekday: "Wednesday", value: 0 },
                { hour: "1pm", weekday: "Wednesday", value: 0 },
                { hour: "2pm", weekday: "Wednesday", value: 0 },
                { hour: "3pm", weekday: "Wednesday", value: 0 },
                { hour: "4pm", weekday: "Wednesday", value: 0 },
                { hour: "5pm", weekday: "Wednesday", value: 0 },
                { hour: "6pm", weekday: "Wednesday", value: 0 },
                { hour: "7pm", weekday: "Wednesday", value: 0 },
                { hour: "8pm", weekday: "Wednesday", value: 0 },
                { hour: "9pm", weekday: "Wednesday", value: 0 },
                { hour: "10pm", weekday: "Wednesday", value: 0 },
                { hour: "11pm", weekday: "Wednesday", value: 0 },
                { hour: "12pm", weekday: "Thursday", value: 0 },
                { hour: "1am", weekday: "Thursday", value: 0 },
                { hour: "2am", weekday: "Thursday", value: 0 },
                { hour: "3am", weekday: "Thursday", value: 0 },
                { hour: "4am", weekday: "Thursday", value: 0 },
                { hour: "5am", weekday: "Thursday", value: 0 },
                { hour: "6am", weekday: "Thursday", value: 0 },
                { hour: "7am", weekday: "Thursday", value: 0 },
                { hour: "8am", weekday: "Thursday", value: 0 },
                { hour: "9am", weekday: "Thursday", value: 0 },
                { hour: "10am", weekday: "Thursday", value: 0 },
                { hour: "11am", weekday: "Thursday", value: 0 },
                { hour: "12am", weekday: "Thursday", value: 0 },
                { hour: "1pm", weekday: "Thursday", value: 0 },
                { hour: "2pm", weekday: "Thursday", value: 0 },
                { hour: "3pm", weekday: "Thursday", value: 0 },
                { hour: "4pm", weekday: "Thursday", value: 0 },
                { hour: "5pm", weekday: "Thursday", value: 0 },
                { hour: "6pm", weekday: "Thursday", value: 0 },
                { hour: "7pm", weekday: "Thursday", value: 0 },
                { hour: "8pm", weekday: "Thursday", value: 0 },
                { hour: "9pm", weekday: "Thursday", value: 0 },
                { hour: "10pm", weekday: "Thursday", value: 0 },
                { hour: "11pm", weekday: "Thursday", value: 0 },
                { hour: "12pm", weekday: "Friday", value: 0 },
                { hour: "1am", weekday: "Friday", value: 0 },
                { hour: "2am", weekday: "Friday", value: 0 },
                { hour: "3am", weekday: "Friday", value: 0 },
                { hour: "4am", weekday: "Friday", value: 0 },
                { hour: "5am", weekday: "Friday", value: 0 },
                { hour: "6am", weekday: "Friday", value: 0 },
                { hour: "7am", weekday: "Friday", value: 0 },
                { hour: "8am", weekday: "Friday", value: 0 },
                { hour: "9am", weekday: "Friday", value: 0 },
                { hour: "10am", weekday: "Friday", value: 0 },
                { hour: "11am", weekday: "Friday", value: 0 },
                { hour: "12am", weekday: "Friday", value: 0 },
                { hour: "1pm", weekday: "Friday", value: 0 },
                { hour: "2pm", weekday: "Friday", value: 0 },
                { hour: "3pm", weekday: "Friday", value: 0 },
                { hour: "4pm", weekday: "Friday", value: 0 },
                { hour: "5pm", weekday: "Friday", value: 0 },
                { hour: "6pm", weekday: "Friday", value: 0 },
                { hour: "7pm", weekday: "Friday", value: 0 },
                { hour: "8pm", weekday: "Friday", value: 0 },
                { hour: "9pm", weekday: "Friday", value: 0 },
                { hour: "10pm", weekday: "Friday", value: 0 },
                { hour: "11pm", weekday: "Friday", value: 0 },
                { hour: "12pm", weekday: "Saturday", value: 0 },
                { hour: "1am", weekday: "Saturday", value: 0 },
                { hour: "2am", weekday: "Saturday", value: 0 },
                { hour: "3am", weekday: "Saturday", value: 0 },
                { hour: "4am", weekday: "Saturday", value: 0 },
                { hour: "5am", weekday: "Saturday", value: 0 },
                { hour: "6am", weekday: "Saturday", value: 0 },
                { hour: "7am", weekday: "Saturday", value: 0 },
                { hour: "8am", weekday: "Saturday", value: 0 },
                { hour: "9am", weekday: "Saturday", value: 0 },
                { hour: "10am", weekday: "Saturday", value: 0 },
                { hour: "11am", weekday: "Saturday", value: 0 },
                { hour: "12am", weekday: "Saturday", value: 0 },
                { hour: "1pm", weekday: "Saturday", value: 0 },
                { hour: "2pm", weekday: "Saturday", value: 0 },
                { hour: "3pm", weekday: "Saturday", value: 0 },
                { hour: "4pm", weekday: "Saturday", value: 0 },
                { hour: "5pm", weekday: "Saturday", value: 0 },
                { hour: "6pm", weekday: "Saturday", value: 0 },
                { hour: "7pm", weekday: "Saturday", value: 0 },
                { hour: "8pm", weekday: "Saturday", value: 0 },
                { hour: "9pm", weekday: "Saturday", value: 0 },
                { hour: "10pm", weekday: "Saturday", value: 0 },
                { hour: "11pm", weekday: "Saturday", value: 0 },
            ],
            };
        },
        components: {
          Datepicker,
        },
        props: ['id'],
        mounted() {
            this.getCardsData();
            // this.getCampaignData();
            this.getCampaignNumbers();
            console.log(this.id);
            // let start_date = "";
            // let end_date = "";
            // this.getCampaignSentData(start_date, end_date).then(() => {
            //     this.buildCampaignSentChart();
            // });
            // this.getData();
        },
        methods: {
            async getCampaignNumbers(){
                let baseUrl = "/nova-api/custom/campaign-contacts/"+this.id;
                await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        console.log("------------------------------>"+response.data.numbers);
                        this.numbers = response.data.numbers;
                    });
                console.log(this.numbers);
            },
            async num(num){
                this.hover = true;
                let params = {
                  number : num,
                  campaign_id : this.campaign.id
                };
                this.messages = [];

                let baseUrl = "/nova-api/custom/get-messages/";
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.messages = response.data.messages;
                        console.log(this.messages);
                    });
                this.showMessages = true;

                console.log(num);
            },
            async load(params){
                let p = {}
                console.log('before date')
                console.log(this.date)
                console.log('after date')
                this.$forceUpdate()
                this.getCardsData(params[0], params[1]);
                // this.start_date = this.date[0];
                // this.end_date = this.date[1];
                this.getData(params[0], params[1]);
                this.getDataIncoming(params[0], params[1]);
                this.getCallBackLogs(params[0], params[1]);
                this.$forceUpdate()
                this.getCampaignSentData(params[0], params[1]).then(() => {
                    this.buildCampaignSentChart();
                });
                this.getSendRateData(this.date).then(() => {
                    this.buildSendRateChart();
                });
                this.getCallBackData(params[0], params[1]).then(() => {
                    this.buildCallBackChart();
                });

            },
            async exportLogs() {
            //   let baseUrl = "/nova-api/custom/export-ivr-logs/"+this.campaign.id;
            //     await Nova.request()
            //         .get(baseUrl)
            //         .then((response) => {
                        Nova.success('Csv Exported Succesfully');
                    // });
            },
            handleClose() {
                this.$emit('close')
            },
            async selectPage(val) {
                console.log(val)
                this.ivr_page = val;
                let params = {
                  page : val,
                  start_date : this.start_date,
                  end_date : this.end_date,
                  per_page: this.ivr_per_page,
                };

                let baseUrl = "/nova-api/custom/ivr-call-logs/"+this.campaign.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        console.log('current_page')
                        console.log(response.data.logs.current_page)
                        console.log('per_page')
                        console.log(response.data.logs.per_page)
                        this.ivr_logs = response.data.logs.data;
                        // console.log(this.ivr_logs);

                        this.paginationData = {
                            allMatchingResourceCount: response.data.logs.length,
                            currentPage: response.data.logs.current_page,
                            currentResourceCount: response.data.logs.total,
                            hasNextPage: response.data.logs.next_page_url !== null,
                            hasPreviousPage: response.data.logs.prev_page_url !== null,
                            resourceCountLabel: response.data.logs.from +
                                "-" +
                                response.data.logs.to +
                                " of " +
                                response.data.logs.total,
                            totalPages: response.data.logs.last_page,
                        };
                        Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();
                    });
                // await Nova.request()
                //     .get("/nova-api/custom/ivr-call-logs/"+this.campaign.id, {
                //         params: {
                //             page: val,
                //             company_id: null,
                //             from_date: null,
                //             to_date: null,
                //         },
                //     })
                //     .then((response) => {
                //         this.ivr_logs = response.data.logs.data;
                //         // console.log(this.ivr_logs);

                //         this.paginationData = {
                //             allMatchingResourceCount: response.data.logs.length,
                //             currentPage: response.data.logs.current_page,
                //             currentResourceCount: response.data.logs.total,
                //             hasNextPage: response.data.logs.next_page_url !== null,
                //             hasPreviousPage: response.data.logs.prev_page_url !== null,
                //             resourceCountLabel: response.data.logs.from +
                //                 "-" +
                //                 response.data.logs.to +
                //                 " of " +
                //                 response.data.logs.total,
                //             totalPages: response.data.logs.last_page,
                //         };
                //         Nova.$emit("resources-loaded", {});
                //         this.$forceUpdate();
                //     });
            },

            async selectPageIncoming(val) {
                this.incoming_page = val;
                let params = {
                  page : val,
                  start_date : this.start_date,
                  end_date : this.end_date,
                  per_page: this.incoming_per_page,
                };

                let baseUrl = "/nova-api/custom/incoming-call-logs/"+this.campaign.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.incoming_logs = response.data.logs.data;
                        console.log(this.incoming_logs);

                        this.paginationDataIncoming = {
                            allMatchingResourceCount: response.data.logs.length,
                            currentPage: response.data.logs.current_page,
                            currentResourceCount: response.data.logs.total,
                            hasNextPage: response.data.logs.next_page_url !== null,
                            hasPreviousPage: response.data.logs.prev_page_url !== null,
                            resourceCountLabel: response.data.logs.from +
                                "-" +
                                response.data.logs.to +
                                " of " +
                                response.data.logs.total,
                            totalPages: response.data.logs.last_page,
                        };
                        Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();
                    });



                // console.log(val)
                // await Nova.request()
                //     .get("/nova-api/custom/incoming-call-logs/"+this.campaign.id, {
                //         params: {
                //             page: val,
                //             company_id: null,
                //             from_date: null,
                //             to_date: null,
                //         },
                //     })
                //     .then((response) => {
                //         this.incoming_logs = response.data.logs.data;
                //         console.log(this.incoming_logs);

                //         this.paginationDataIncoming = {
                //             allMatchingResourceCount: response.data.logs.length,
                //             currentPage: response.data.logs.current_page,
                //             currentResourceCount: response.data.logs.total,
                //             hasNextPage: response.data.logs.next_page_url !== null,
                //             hasPreviousPage: response.data.logs.prev_page_url !== null,
                //             resourceCountLabel: response.data.logs.from +
                //                 "-" +
                //                 response.data.logs.to +
                //                 " of " +
                //                 response.data.logs.total,
                //             totalPages: response.data.logs.last_page,
                //         };
                //         Nova.$emit("resources-loaded", {});
                //         this.$forceUpdate();
                //     });
            },

            async getData(start_date, end_date) {
                let params = {
                  start_date: start_date,
                  end_date: end_date,
                  per_page: this.ivr_per_page,
                };

                let baseUrl = "/nova-api/custom/ivr-call-logs/"+this.campaign.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.ivr_logs = response.data.logs.data;

                        this.paginationData = {
                            allMatchingResourceCount: response.data.logs.length,
                            currentPage: response.data.logs.current_page,
                            currentResourceCount: response.data.logs.total,
                            hasNextPage: response.data.logs.next_page_url !== null,
                            hasPreviousPage: response.data.logs.prev_page_url !== null,
                            resourceCountLabel: response.data.logs.from +
                                "-" +
                                response.data.logs.to +
                                " of " +
                                response.data.logs.total,
                            totalPages: response.data.logs.last_page,
                        };
                        this.loading = false;
                    });
            },

            async getCallBackLogs(start_date, end_date) {
                let params = {
                  start_date,
                  end_date,
                  per_page: this.call_backs_per_page,
                };

                let baseUrl = "/nova-api/custom/call-back-logs/"+this.campaign.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.call_back_logs = response.data.call_backs.data;
                        // console.log(this.ivr_logs);
                        this.paginationDataCallBack = {
                            allMatchingResourceCount: response.data.call_backs.length,
                            currentPage: response.data.call_backs.current_page,
                            currentResourceCount: response.data.call_backs.total,
                            hasNextPage: response.data.call_backs.next_page_url !== null,
                            hasPreviousPage: response.data.call_backs.prev_page_url !== null,
                            resourceCountLabel: response.data.call_backs.from +
                                "-" +
                                response.data.call_backs.to +
                                " of " +
                                response.data.call_backs.total,
                            totalPages: response.data.call_backs.last_page,
                        };
                        this.loadingCallBack = false;
                    });
            },

            async selectPageCallBack(val) {
                this.call_backs_page = val;
                let params = {
                  page : val,
                  start_date : this.start_date,
                  end_date : this.end_date,
                  per_page: this.call_backs_per_page,
                };

                let baseUrl = "/nova-api/custom/call-back-logs/"+this.campaign.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.call_back_logs = response.data.call_backs.data;
                        // console.log(this.ivr_logs);
                        this.paginationDataCallBack = {
                            allMatchingResourceCount: response.data.call_backs.length,
                            currentPage: response.data.call_backs.current_page,
                            currentResourceCount: response.data.call_backs.total,
                            hasNextPage: response.data.call_backs.next_page_url !== null,
                            hasPreviousPage: response.data.call_backs.prev_page_url !== null,
                            resourceCountLabel: response.data.call_backs.from +
                                "-" +
                                response.data.call_backs.to +
                                " of " +
                                response.data.call_backs.total,
                            totalPages: response.data.call_backs.last_page,
                        };
                        Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();
                    });

            },

            async getDataIncoming(start_date, end_date) {
                let params = {
                  start_date,
                  end_date,
                  per_page: this.incoming_per_page,
                };

                let baseUrl = "/nova-api/custom/incoming-call-logs/"+this.campaign.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.incoming_logs = response.data.logs.data;
                        console.log(this.incoming_logs);

                        this.paginationDataIncoming = {
                            allMatchingResourceCount: response.data.logs.length,
                            currentPage: response.data.logs.current_page,
                            currentResourceCount: response.data.logs.total,
                            hasNextPage: response.data.logs.next_page_url !== null,
                            hasPreviousPage: response.data.logs.prev_page_url !== null,
                            resourceCountLabel: response.data.logs.from +
                                "-" +
                                response.data.logs.to +
                                " of " +
                                response.data.logs.total,
                            totalPages: response.data.logs.last_page,
                        };
                        this.loadingIncoming = false;
                    });
            },
            async getCardsData(start_date, end_date) {
                let params = {
                  start_date,
                  end_date,
                };
                let baseUrl = "/nova-api/custom/get-campaign-stats/"+this.id;
                await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        this.call_backs = response.data.calls_back;
                        this.avg_calls_duration = response.data.avg_calls_duration;
                        this.call_back_percentage = response.data.call_back_percentage;
                        this.optIn_count = response.data.optIn_count;
                        this.optOut_count = response.data.optOut_count;
                        this.ivr_count = response.data.ivr_count;
                        this.vm_count = response.data.vm_count;
                    });
            },
            async ivrChangePerPage() {
                this.getData();
            },
            async incomingChangePerPage() {
                this.getDataIncoming();
            },
            async callBacksChangePerPage() {
                this.getCallBackLogs();
            },
            async getCampaignData() {
                let baseUrl = "/nova-api/campaigns/stats/"+this.id;
                await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        this.campaign = response.data.campaign;
                        console.log(this.campaign);
                        this.getData();
                        this.getDataIncoming();
                        this.getCallBackLogs();
                        this.getCampaignSentData(this.start_date, this.end_date).then(() => {
                            this.buildCampaignSentChart();
                        });
                        this.getRvmCallBackData(this.start_date, this.end_date).then(() => {
                            this.buildRvmCallBackChart();
                        });
                        this.getSendRateData(this.date).then(() => {
                            this.buildSendRateChart();
                        });
                        this.getCallBackData(this.start_date,this.end_date).then(() => {
                            this.buildCallBackChart();
                        });
                        this.getOptInData(this.start_date,this.end_date).then(() => {
                            this.buildOptInChart();
                        });
                        this.getOptOutData(this.start_date,this.end_date).then(() => {
                            this.buildOptOutChart();
                        });
                    });
            },

            async getCampaignSentData(start_date, end_date) {
              let params = {
                  start_date,
                  end_date,
              };
              console.log('inside function')
              console.log(params)
              let baseUrl = "/nova-api/custom/get-callsent-to-destination/"+this.campaign.id;
              return await Nova.request()
                  .post(baseUrl, params)
                  .then((response) => {
                      if (response.data.query.length > 0) {
                          this.data = response.data.query;
                      }
                      this.loadingCallSent = false;
                      console.log("3.callsenttodestination------>", response.data.query);
                  });
            },
            getCampaignSentDataByDateRange(date) {
                // let date = this.selectedRange;
                // console.log(date);
                if (date !== null) {
                    let startDate = moment(date[0]).format("YYYY-MM-DD");
                    let endDate = moment(date[1]).format("YYYY-MM-DD");
                    this.getCampaignSentData(startDate, endDate).then(() => {
                        this.buildCampaignSentChart();
                    });
                }
            },
            buildCampaignSentChart() {
                // Themes begin
                window.am4core.useTheme(window.am4themes_animated);

                // Create map instance
                var chart = window.am4core.create(this.$refs.chartdiv, window.am4maps.MapChart);

                // Set map definition
                chart.geodata = window.am4geodata_usaLow;

                // Set projection
                chart.projection = new window.am4maps.projections.AlbersUsa();

                chart.chartContainer.wheelable = false;
                chart.seriesContainer.draggable = false;
                chart.seriesContainer.resizable = false;

                // Create map polygon series
                var polygonSeries = chart.series.push(
                    new window.am4maps.MapPolygonSeries()
                );

                //Set min/max fill color for each area
                polygonSeries.heatRules.push({
                    property: "fill",
                    target: polygonSeries.mapPolygons.template,
                    "min": am4core.color("#1fc0cd"),
                    "max": am4core.color("#158b94")
                });

                // Make map load polygon data (state shapes and names) from GeoJSON
                polygonSeries.useGeodata = true;

                polygonSeries.data = this.data.length > 0 ? this.data : [{}];

                // Set up heat legend
                let heatLegend = chart.createChild(window.am4maps.HeatLegend);
                heatLegend.series = polygonSeries;
                heatLegend.align = "right";
                heatLegend.valign = "bottom";
                heatLegend.height = window.am4core.percent(80);
                heatLegend.orientation = "vertical";
                heatLegend.valign = "middle";
                heatLegend.marginRight = window.am4core.percent(4);
                heatLegend.valueAxis.renderer.opposite = true;
                heatLegend.valueAxis.renderer.dx = -25;
                heatLegend.valueAxis.strictMinMax = false;
                heatLegend.valueAxis.fontSize = 9;
                heatLegend.valueAxis.logarithmic = true;

                // Configure series tooltip
                var polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}: {value}";
                polygonTemplate.nonScalingStroke = true;
                polygonTemplate.strokeWidth = 0.5;

                // Create hover state and set alternative fill color
                var hs = polygonTemplate.states.create("hover");
                hs.properties.fill = window.am4core.color("#1fc0cd");

                // heat legend behavior
                polygonSeries.mapPolygons.template.events.on(
                    "over",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                polygonSeries.mapPolygons.template.events.on(
                    "hit",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                function handleHover(column) {
                    if (!isNaN(column.dataItem.value)) {
                        heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                    } else {
                        heatLegend.valueAxis.hideTooltip();
                    }
                }

                polygonSeries.mapPolygons.template.events.on(
                    "out",
                    function (event) {
                        heatLegend.valueAxis.hideTooltip();
                    }
                );
            },

            async getCallBackData(start_date, end_date) {
                let params = {
                    start_date,
                    end_date,
                };
                let baseUrl = "/nova-api/custom/get-callback/"+this.campaign.id;
                return await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        if (response.data.query.length > 0) {
                            this.dataCallBack = response.data.query
                        }
                        this.loadingCallBackHeatMap = false;

                        console.log("2.callback ---->", response.data.query);
                    });
            },

            getCallBackDataByDateRange(date){
            // let date = this.selectedRange;
            if (date !== null) {
                let startDate = moment(date[0]).format('YYYY-MM-DD')
                let endDate = moment(date[1]).format('YYYY-MM-DD')
                this.getCallBackData(startDate,endDate).then(() => {
                    this.buildCallBackChart();
                });
            }

            },
            buildCallBackChart() {

                // Themes begin
                window.am4core.useTheme(window.am4themes_animated);

                // Create map instance
                var chart = am4core.create(this.$refs.chartdivCallBack, window.am4maps.MapChart);

                // Set map definition
                chart.geodata = window.am4geodata_usaLow;

                // Set projection
                chart.projection = new window.am4maps.projections.AlbersUsa();

                chart.chartContainer.wheelable = false;
                chart.seriesContainer.draggable = false;
                chart.seriesContainer.resizable = false;

                // Create map polygon series
                var polygonSeries = chart.series.push(
                    new window.am4maps.MapPolygonSeries()
                );

                //Set min/max fill color for each area
                polygonSeries.heatRules.push({
                    property: "fill",
                    target: polygonSeries.mapPolygons.template,
                    "min": am4core.color("#1fc0cd"),
                    "max": am4core.color("#158b94")
                });

                // Make map load polygon data (state shapes and names) from GeoJSON
                polygonSeries.useGeodata = true;

                polygonSeries.data = this.dataCallBack.length > 0 ? this.dataCallBack : [{}];

                // Set up heat legend
                let heatLegend = chart.createChild(am4maps.HeatLegend);
                heatLegend.series = polygonSeries;
                heatLegend.align = "right";
                heatLegend.valign = "bottom";
                heatLegend.height = window.am4core.percent(80);
                heatLegend.orientation = "vertical";
                heatLegend.valign = "middle";
                heatLegend.marginRight = window.am4core.percent(4);
                heatLegend.valueAxis.renderer.opposite = true;
                heatLegend.valueAxis.renderer.dx = -25;
                heatLegend.valueAxis.strictMinMax = false;
                heatLegend.valueAxis.fontSize = 9;
                heatLegend.valueAxis.logarithmic = true;

                // Configure series tooltip
                var polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}: {value}";
                polygonTemplate.nonScalingStroke = true;
                polygonTemplate.strokeWidth = 0.5;

                // Create hover state and set alternative fill color
                var hs = polygonTemplate.states.create("hover");
                hs.properties.fill = window.am4core.color("#1fc0cd");

                // heat legend behavior
                polygonSeries.mapPolygons.template.events.on(
                    "over",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                polygonSeries.mapPolygons.template.events.on(
                    "hit",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                function handleHover(column) {
                    if (!isNaN(column.dataItem.value)) {
                        heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                    } else {
                        heatLegend.valueAxis.hideTooltip();
                    }
                }

                polygonSeries.mapPolygons.template.events.on(
                    "out",
                    function (event) {
                        heatLegend.valueAxis.hideTooltip();
                    }
                );

            },

            async getOptInData(start_date, end_date) {
                let params = {
                    start_date,
                    end_date,
                };
                let baseUrl = "/nova-api/custom/get-optin-data/"+this.campaign.id;
                return await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        if (response.data.query.length > 0) {
                            this.dataOptIn = response.data.query
                        }
                        this.loadingOptIn = false;
                        console.log("2.callback ---->", response.data.query);
                    });
            },

            getOptInDataByDateRange(date){
            // let date = this.selectedRange;
                if (date !== null) {
                    let startDate = moment(date[0]).format('YYYY-MM-DD')
                    let endDate = moment(date[1]).format('YYYY-MM-DD')
                    this.getOptInData(startDate,endDate).then(() => {
                        this.buildOptInChart();
                    });
                }

            },
            buildOptInChart() {

                // Themes begin
                window.am4core.useTheme(window.am4themes_animated);

                // Create map instance
                var chart = am4core.create(this.$refs.chartdivOptIn, window.am4maps.MapChart);

                // Set map definition
                chart.geodata = window.am4geodata_usaLow;

                // Set projection
                chart.projection = new window.am4maps.projections.AlbersUsa();

                chart.chartContainer.wheelable = false;
                chart.seriesContainer.draggable = false;
                chart.seriesContainer.resizable = false;

                // Create map polygon series
                var polygonSeries = chart.series.push(
                    new window.am4maps.MapPolygonSeries()
                );

                //Set min/max fill color for each area
                polygonSeries.heatRules.push({
                    property: "fill",
                    target: polygonSeries.mapPolygons.template,
                    "min": am4core.color("#1fc0cd"),
                    "max": am4core.color("#158b94")
                });

                // Make map load polygon data (state shapes and names) from GeoJSON
                polygonSeries.useGeodata = true;

                polygonSeries.data = this.dataOptIn.length > 0 ? this.dataOptIn : [{}];

                // Set up heat legend
                let heatLegend = chart.createChild(am4maps.HeatLegend);
                heatLegend.series = polygonSeries;
                heatLegend.align = "right";
                heatLegend.valign = "bottom";
                heatLegend.height = window.am4core.percent(80);
                heatLegend.orientation = "vertical";
                heatLegend.valign = "middle";
                heatLegend.marginRight = window.am4core.percent(4);
                heatLegend.valueAxis.renderer.opposite = true;
                heatLegend.valueAxis.renderer.dx = -25;
                heatLegend.valueAxis.strictMinMax = false;
                heatLegend.valueAxis.fontSize = 9;
                heatLegend.valueAxis.logarithmic = true;

                // Configure series tooltip
                var polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}: {value}";
                polygonTemplate.nonScalingStroke = true;
                polygonTemplate.strokeWidth = 0.5;

                // Create hover state and set alternative fill color
                var hs = polygonTemplate.states.create("hover");
                hs.properties.fill = window.am4core.color("#1fc0cd");

                // heat legend behavior
                polygonSeries.mapPolygons.template.events.on(
                    "over",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                polygonSeries.mapPolygons.template.events.on(
                    "hit",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                function handleHover(column) {
                    if (!isNaN(column.dataItem.value)) {
                        heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                    } else {
                        heatLegend.valueAxis.hideTooltip();
                    }
                }

                polygonSeries.mapPolygons.template.events.on(
                    "out",
                    function (event) {
                        heatLegend.valueAxis.hideTooltip();
                    }
                );

            },

            async getOptOutData(start_date, end_date) {
                let params = {
                    start_date,
                    end_date,
                };
                let baseUrl = "/nova-api/custom/get-optout-data/"+this.campaign.id;
                return await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        if (response.data.query.length > 0) {
                            this.dataOptOut = response.data.query
                        }
                        this.loadingOptOut = false;
                        console.log("OptOut ---->", response.data.query);
                    });
            },

            getOptOutDataByDateRange(date){
            // let date = this.selectedRange;
                if (date !== null) {
                    let startDate = moment(date[0]).format('YYYY-MM-DD')
                    let endDate = moment(date[1]).format('YYYY-MM-DD')
                    this.getOptOutData(startDate,endDate).then(() => {
                        this.buildOptOutChart();
                    });
                }

            },
            buildOptOutChart() {

                // Themes begin
                window.am4core.useTheme(window.am4themes_animated);

                // Create map instance
                var chart = am4core.create(this.$refs.chartdivOptOut, window.am4maps.MapChart);

                // Set map definition
                chart.geodata = window.am4geodata_usaLow;

                // Set projection
                chart.projection = new window.am4maps.projections.AlbersUsa();

                chart.chartContainer.wheelable = false;
                chart.seriesContainer.draggable = false;
                chart.seriesContainer.resizable = false;

                // Create map polygon series
                var polygonSeries = chart.series.push(
                    new window.am4maps.MapPolygonSeries()
                );

                //Set min/max fill color for each area
                polygonSeries.heatRules.push({
                    property: "fill",
                    target: polygonSeries.mapPolygons.template,
                    "min": am4core.color("#1fc0cd"),
                    "max": am4core.color("#158b94")
                });

                // Make map load polygon data (state shapes and names) from GeoJSON
                polygonSeries.useGeodata = true;

                polygonSeries.data = this.dataOptOut.length > 0 ? this.dataOptOut : [{}];

                // Set up heat legend
                let heatLegend = chart.createChild(am4maps.HeatLegend);
                heatLegend.series = polygonSeries;
                heatLegend.align = "right";
                heatLegend.valign = "bottom";
                heatLegend.height = window.am4core.percent(80);
                heatLegend.orientation = "vertical";
                heatLegend.valign = "middle";
                heatLegend.marginRight = window.am4core.percent(4);
                heatLegend.valueAxis.renderer.opposite = true;
                heatLegend.valueAxis.renderer.dx = -25;
                heatLegend.valueAxis.strictMinMax = false;
                heatLegend.valueAxis.fontSize = 9;
                heatLegend.valueAxis.logarithmic = true;

                // Configure series tooltip
                var polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}: {value}";
                polygonTemplate.nonScalingStroke = true;
                polygonTemplate.strokeWidth = 0.5;

                // Create hover state and set alternative fill color
                var hs = polygonTemplate.states.create("hover");
                hs.properties.fill = window.am4core.color("#1fc0cd");

                // heat legend behavior
                polygonSeries.mapPolygons.template.events.on(
                    "over",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                polygonSeries.mapPolygons.template.events.on(
                    "hit",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                function handleHover(column) {
                    if (!isNaN(column.dataItem.value)) {
                        heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                    } else {
                        heatLegend.valueAxis.hideTooltip();
                    }
                }

                polygonSeries.mapPolygons.template.events.on(
                    "out",
                    function (event) {
                        heatLegend.valueAxis.hideTooltip();
                    }
                );

            },

            async getSendRateData(date) {
              let params = {
                  new_date: date,
              };
              console.log('///////////////////////////Ruko//////////////////')
              console.log(params);
              let baseUrl = "/nova-api/custom/get-campaign-send-rates/"+this.campaign.id;
              return await Nova.request()
                  .post(baseUrl, params)
                  .then((response) => {
                      let dateRange = response.data.query.campaignSendRates;
                      this.dataSendRate = [];
                      dateRange.forEach((element) => {
                          let date = new Date(element.date);
                          this.dataSendRate.push({
                              date: date.getTime(),
                              value: element.value,
                          });
                      });
                      this.loadingSendRate = false;
                      console.log("12.campaignSendRates ---->", response.data.query);
                  });
            },
            getDataByDateRange(date) {
                if (date !== null) {
                    console.log(moment(date).format("YYYY-MM-DD"));
                    this.getSendRateData(moment(date).format("YYYY-MM-DD")).then(() => {
                        this.buildSendRateChart();
                    });
                }
            },

            buildSendRateChart() {
                window.am4core.useTheme(window.am4themes_animated);
                let chart = window.am4core.create(this.$refs.chartdivSendRate, window.am4charts.XYChart);

                chart.paddingRight = 20;

                chart.data = this.dataSendRate;

                chart.colors.list = [
                    am4core.color("#1fc0cd"),
                ]

                let dateAxis = chart.xAxes.push(new window.am4charts.DateAxis());
                dateAxis.renderer.grid.template.location = 0;

                let valueAxis = chart.yAxes.push(new window.am4charts.ValueAxis());
                valueAxis.tooltip.disabled = true;
                valueAxis.renderer.minWidth = 35;

                let series = chart.series.push(new window.am4charts.LineSeries());
                series.dataFields.dateX = "date";
                series.dataFields.valueY = "value";

                series.tooltipText = "{valueY.value}";
                chart.cursor = new window.am4charts.XYCursor();
                series.fillOpacity = 0.3;

                let scrollbarX = new window.am4charts.XYChartScrollbar();
                scrollbarX.series.push(series);
                chart.scrollbarX = scrollbarX;

                this.chart = chart;
            },

            async getRvmCallBackData(start_date, end_date) {
                let params = {
                    start_date,
                    end_date,
                };
                let baseUrl = "/nova-api/custom/get-rvm-call-back/"+this.campaign.id;
                return await Nova.request()
                    .post(baseUrl, params)
                    .then((response) => {
                        if (response.data.query.length > 0) {
                            // this.data = response.data.query;
                            response.data.query.forEach((element) => {
                                this.weekdays.filter((e) => {
                                    if (
                                        e.hour ===
                                            element["hour"].replace(/\s/g, "") &&
                                        e.weekday ===
                                            element["weekday"].replace(/\s/g, "")
                                    ) {
                                        e["value"] = element["value"];
                                    }
                                });
                            });
                        }
                        this.loadingRvmCallBackHeatMap = false;
                        console.log("Rvm Call Back Chart------>", response.data.query);
                    });
            },

            buildRvmCallBackChart() {
                window.am4core.useTheme(window.am4themes_animated);
                let chart = window.am4core.create(this.$refs.chartdivCallBackRvm, window.am4charts.XYChart);

                chart.maskBullets = false;

                let xAxis = chart.xAxes.push(new window.am4charts.CategoryAxis());
                let yAxis = chart.yAxes.push(new window.am4charts.CategoryAxis());

                xAxis.dataFields.category = "weekday";
                yAxis.dataFields.category = "hour";

                xAxis.renderer.grid.template.disabled = true;
                xAxis.renderer.minGridDistance = 40;

                yAxis.renderer.grid.template.disabled = true;
                yAxis.renderer.inversed = true;
                yAxis.renderer.minGridDistance = 30;

                let series = chart.series.push(new window.am4charts.ColumnSeries());
                series.dataFields.categoryX = "weekday";
                series.dataFields.categoryY = "hour";
                series.dataFields.value = "value";
                series.sequencedInterpolation = true;
                series.defaultState.transitionDuration = 3000;

                let bgColor = new window.am4core.InterfaceColorSet().getFor("background");

                let columnTemplate = series.columns.template;
                columnTemplate.strokeWidth = 1;
                columnTemplate.strokeOpacity = 0.2;
                columnTemplate.stroke = bgColor;
                columnTemplate.tooltipText =
                    "{weekday}, {hour}: {value.workingValue.formatNumber('#.')}";
                columnTemplate.width = window.am4core.percent(100);
                columnTemplate.height = window.am4core.percent(100);

                series.heatRules.push({
                    target: columnTemplate,
                    property: "fill",
                    // min: window.am4core.color(window.am4core.color("#ccf4fe")),
                    // max: chart.colors.getIndex(0),
                    "min": am4core.color(window.Nova.config('brandColors')['500-hex']),
                    "max": am4core.color(window.Nova.config('brandColors')['600-hex'])
                });

                // heat legend
                let heatLegend = chart.bottomAxesContainer.createChild(
                    window.am4charts.HeatLegend
                );
                heatLegend.width = window.am4core.percent(100);
                heatLegend.series = series;
                heatLegend.valueAxis.renderer.labels.template.fontSize = 9;
                heatLegend.valueAxis.renderer.minGridDistance = 30;
                heatLegend.minColor = window.Nova.config('brandColors')['500-hex'];
                heatLegend.maxColor = window.Nova.config('brandColors')['600-hex'];
                // heat legend behavior
                series.columns.template.events.on("over", function (event) {
                    handleHover(event.target);
                });

                series.columns.template.events.on("hit", function (event) {
                    handleHover(event.target);
                });

                function handleHover(column) {
                    if (!isNaN(column.dataItem.value)) {
                        heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                    } else {
                        heatLegend.valueAxis.hideTooltip();
                    }
                }

                series.columns.template.events.on("out", function (event) {
                    heatLegend.valueAxis.hideTooltip();
                });

                chart.data = this.weekdays;
                this.chart = chart;
            },
        },
        computed: {
            pending() {
                if(this.campaign.campaignstats && this.campaign.campaignstats.contact_count && this.campaign.campaignstats.sent_count && this.campaign.campaignstats.dnc_count)
                    return parseFloat(this.campaign.campaignstats.contact_count) - parseFloat(this.campaign.campaignstats.sent_count) -
                    parseFloat(this.campaign.campaignstats.dnc_count);
                return 0;
            }
        }
    }

</script>

<style>
/* Scoped Styles */
.justify-end{
    justify-content: flex-end;
}
.chat-area {
/*   border: 1px solid #ccc; */
  background: white;
  color: black;
  height: 50vh;
  overflow: auto;
  /* max-width: 350px;
  margin: 0 auto 2em auto; */
  box-shadow: 2px 2px 5px 2px rgba(0, 0, 0, 0.03)
}
.num-area {
/*   border: 1px solid #ccc; */
  background: white;
  color: black;
  height: 50vh;
  padding: 1em 0em 1em 0em;
  overflow: auto;
  /* max-width: 350px;
  margin: 0 auto 2em auto; */
  box-shadow: 2px 2px 5px 2px rgba(0, 0, 0, 0.03)
}
.message {
  width: 45%;
  border-radius: 10px;
  padding: .5em;
/*   margin-bottom: .5em; */
  font-size: .8em;
}
.number-hover {
  background: #407FFF;
  color: white;
  /* width: 90%; */
  border-radius: 10px;
  padding: .5em;
  margin-bottom: .5em;
  font-size: .8em;
}
.number {
  background: #f9f6f6;
  color: black;
  /* width: 90%; */
  padding: .7em;
  margin-bottom: .1em;
  /* font-size: .8em; */
}
.message-out {
  background: #407FFF;
  color: white;
  margin-left: 50%;
}
.message-in {
  background: #F1F0F0;
  color: black;
}
</style>
