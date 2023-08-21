<template>
    <Modal data-testid="preview-resource-modal" :show="show" @close-via-escape="$emit('close')" role="alertdialog"
        maxWidth="2xl">
        <LoadingCard :loading="false" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <slot>
                <ModalHeader class="flex items-center">
                    Sms Campaign Stats
                </ModalHeader>
                <ModalContent class="px-8">
                    <div>
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <div v-if="data.campaign.campaign_stats && data.campaign.campaign_stats.sent_count">
                                    Sent:
                                    {{data.campaign.campaign_stats.sent_count +' '+ '('+ ((data.campaign.campaign_stats.sent_count) / parseFloat(data.campaign.campaign_stats.contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '') + ')' }}
                                </div>
                                <div v-else>
                                    Sent: 0 (0 %)
                                </div>
                            </div>
                            <div class="flex-1" v-if="pending !== 0">
                                Pending:
                                {{pending +' '+  '('+( pending / data.campaign.campaign_stats.contact_count * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)' }}
                            </div>
                            <div v-else class="flex-1">
                                Pending: 0 (0 %)
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <div v-if="data.campaign.campaign_stats && data.campaign.campaign_stats.success_count">
                                    Transfer:
                                    {{ data.campaign.campaign_stats.success_count +' '+ '('+ (parseFloat(data.campaign.campaign_stats.success_count) / parseFloat(data.campaign.campaign_stats.contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)'}}
                                </div>
                                <div v-else>
                                    Transfer: 0 (0 %)
                                </div>
                            </div>
                            <div class="flex-1">
                                <div v-if="data.campaign.campaign_stats">
                                    DNC Calls:
                                    {{ data.campaign.campaign_stats.dnc_count +' '+  '('+(parseFloat(data.campaign.campaign_stats.dnc_count) / parseFloat(data.campaign.campaign_stats.contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)'}}
                                </div>
                                <div v-else>
                                    DNC Calls: 0 (0 %)
                                </div>
                            </div>
                        </div>
                        <div>
                            Status: 
                            <span v-if="data.campaign.status == 'inactive'" class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-danger">{{data.campaign.status}}</span>
                            <span v-if="data.campaign.status == 'pending'" class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-info">{{data.campaign.status}}</span>
                            <span v-if="data.campaign.status == 'paused'" class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-warning">{{data.campaign.status}}</span>
                            <span v-if="data.campaign.status == 'finished'" class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-finished">{{data.campaign.status}}</span>
                            <span v-if="data.campaign.status == 'played'" class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold bg-green-100 text-green-600 dark:bg-green-500 dark:text-green-900">{{data.campaign.status}}</span>
                            <span v-if="data.campaign.status == 'outside of hours'" class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-warning">{{data.campaign.status}}</span>
                        </div>
                    </div>
                    <div v-if="data.campaign.campaign_type == 'press-1'">
                        <h3 class="text-90 uppercase tracking-wide font-bold md:text-sm border-b border-gray-100 dark:border-gray-700 py-4 flex items-center">
                            OutBound And InBound Data
                        </h3>
                        <table
                            class="w-full table-default card-scroll"
                            cellpadding="0"
                            cellspacing="0"
                            data-testid="resource-table"
                        >
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="text-left whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
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
                                        class=" py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
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
                        :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="25"
                        :resourceCountLabel="paginationData.resourceCountLabel" :shouldShowPagination="true"
                        :totalPages="paginationData.totalPages" :selectPage="selectPage" />
                    </div>
                </ModalContent>
            </slot>

            <ModalFooter>
                <div class="ml-auto">
                    <LoadingButton @click.prevent="$emit('close')" ref="confirmButton" dusk="confirm-preview-button">
                        {{ __('Close') }}
                    </LoadingButton>
                </div>
            </ModalFooter>
        </LoadingCard>
    </Modal>
</template>

<script>
    export default {
        data() {
            return {
            ivr_logs: [],
            paginationData: {},
            };
        },
        props: {
            data: {
                type: Object
            },
        },
        mounted() {
            this.getData();
        },       
        methods: {
            handleClose() {
                this.$emit('close')
            },
            async selectPage(val) {
                console.log(val)
                await Nova.request()
                    .get("/nova-api/custom/ivr-call-logs/"+this.data.campaign.id, {
                        params: {
                            page: val,
                            company_id: null,
                            from_date: null,
                            to_date: null,
                        },
                    })
                    .then((response) => {
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
            },
            async getData() {
                let baseUrl = "/nova-api/custom/ivr-call-logs/"+this.data.campaign.id;
                await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
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
                    });
            },
        },
        computed: {
            pending() {
                if(this.data.campaign.campaign_stats && this.data.campaign.campaign_stats.contact_count && this.data.campaign.campaign_stats.sent_count && this.data.campaign.campaign_stats.dnc_count)
                    return parseFloat(this.data.campaign.campaign_stats.contact_count) - parseFloat(this.data.campaign.campaign_stats.sent_count) -
                    parseFloat(this.data.campaign.campaign_stats.dnc_count);
                return 0;
            }
        }
    }

</script>
