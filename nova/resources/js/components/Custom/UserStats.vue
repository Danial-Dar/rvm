<template>
    <Modal data-testid="preview-resource-modal" :show="show" @close-via-escape="$emit('close')" role="alertdialog"
        maxWidth="2xl">
        <LoadingCard :loading="false" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <slot>
                <ModalHeader class="flex items-center">
                    User Stats
                </ModalHeader>
                <ModalContent class="px-8">
                    <div>
                        <div class="flex justify-between mb-3">
                            <div class="flex-1">
                                <div v-if="data.user.total_sent_count && data.user.total_contact_count">
                                    Sent:
                                    {{data.user.total_sent_count +' '+ '('+ ((data.user.total_sent_count) / parseFloat(data.user.total_contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '') }}
                                </div>
                                <div v-else>
                                    Sent: 0 (0 %)
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mb-3">
                            <div class="flex-1">
                                <div v-if="data.user.total_initiated_count && data.user.total_contact_count">
                                    Initiated:
                                    {{data.user.total_initiated_count +' '+ '('+ ((data.user.total_initiated_count) / parseFloat(data.user.total_contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '') }}
                                </div>
                                <div v-else>
                                    Initiated: 0 (0 %)
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mb-3">
                            <div class="flex-1" v-if="pending !== 0">
                                Pending:
                                {{pending +' '+  '('+( pending / data.user.total_contact_count * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)' }}
                            </div>
                            <div v-else class="flex-1">
                                Pending: 0 (0 %)
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <div v-if="data.user.total_failed_count && data.user.total_contact_count">
                                    Failed:
                                    {{data.user.total_failed_count +' '+ '('+ ((data.user.total_failed_count) / parseFloat(data.user.total_contact_count) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '') }}
                                </div>
                                <div v-else>
                                    Failed: 0 (0 %)
                                </div>
                            </div>
                        </div>
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
                if(this.data.user.total_contact_count && this.data.user.total_sent_count && this.data.user.total_dnc_count)
                    return parseFloat(this.data.user.total_contact_count) - parseFloat(this.data.user.total_sent_count) -
                    parseFloat(this.data.user.total_dnc_count);
                return 0;
            }
        }
    }

</script>