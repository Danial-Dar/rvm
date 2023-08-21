<template>
    <Modal data-testid="preview-resource-modal" :show="show" @close-via-escape="$emit('close')" role="alertdialog"
        maxWidth="2xl">
        <LoadingCard :loading="false" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <slot>
                <ModalHeader class="flex items-center">
                    Campaign Stats
                </ModalHeader>
                <ModalContent class="px-8">
                    <div>
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <div v-if="data.compaign">
                                    Sent:
                                    {{data.compaign}}
                                </div>
                                <div v-else>
                                    Sent: 0 (0 %)
                                </div>
                            </div>
                            <!-- <div class="flex-1" v-if="pending !== 0">
                                Pending:
                                {{pending +' '+  '('+( pending / data.compaign.contact_count * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)' }}
                            </div>
                            <div v-else class="flex-1">
                                Pending: 0 (0 %)
                            </div> -->
                        </div>
                        <!-- <div class="flex justify-between">
                            <div class="flex-1">
                                <div v-if="data.compaign.success_count">
                                    Transfer:
                                    {{ data.compaign.success_count +' '+ '('+ (parseFloat(data.compaign.success_count) / parseFloat(data.compaign.contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)'}}
                                </div>
                                <div v-else>
                                    Transfer: 0 (0 %)
                                </div>
                            </div>
                            <div class="flex-1">
                                <div v-if="data.compaign.success_count">
                                    DNC Calls:
                                    {{ data.compaign.dnc_count +' '+  '('+(parseFloat(data.compaign.dnc_count) / parseFloat(data.compaign.contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)'}}
                                </div>
                                <div v-else>
                                    DNC Calls: 0 (0 %)
                                </div>
                            </div>
                        </div>
                        <div>
                            Status: <span
                                class="inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold bg-green-100 text-green-600 dark:bg-green-500 dark:text-green-900">{{data.compaign.status}}</span>
                        </div> -->
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
        props: {
            data: {
                type: Object
            },
        },

        methods: {
            handleClose() {
                this.$emit('close')
            },
        },
        computed: {
            pending() {
                if(this.data.compaign.contact_count && this.data.compaign.sent_count && this.data.compaign.dnc_count)
                    return parseFloat(this.data.compaign.contact_count) - parseFloat(this.data.compaign.sent_count) -
                    parseFloat(this.data.compaign.dnc_count);
                return 0;
            }
        }
    }

</script>
