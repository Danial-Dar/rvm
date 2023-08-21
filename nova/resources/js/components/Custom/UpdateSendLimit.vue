<template>
    <Modal data-testid="preview-resource-modal" :show="show" @close-via-escape="$emit('close')" role="alertdialog"
        maxWidth="2xl">
        <LoadingCard :loading="false" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <slot>
                <ModalHeader class="flex items-center">
                    Update Send Limit
                </ModalHeader>
                <ModalContent class="px-8">
                    <div>
                        <div class="flex justify-between">
                            <div class="flex-1">
                            
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
            // defaultValue(){
            //     console.log(this.data)
            //     // ->confirmButtonText('Activate')
            // }
        },
        computed: {
            
            // pending() {
            //     if(this.data.compaign.contact_count && this.data.compaign.sent_count && this.data.compaign.dnc_count)
            //         return parseFloat(this.data.compaign.contact_count) - parseFloat(this.data.compaign.sent_count) -
            //         parseFloat(this.data.compaign.dnc_count);
            //     return 0;
            // }
        },
        mounted(){
            // console.log('state',this.data)
            this.defaultValue()
        }
    }

</script>