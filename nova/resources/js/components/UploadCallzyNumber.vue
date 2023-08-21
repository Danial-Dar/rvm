<template>
    <div>

        <div class="flex-shrink-0 ml-auto pr-2">
            <button @click="show=true"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                Import Callzy Numbers
            </button>
        </div>
        <Modal :show="show" data-testid="confirm-upload-removal-modal" role="alertdialog">
            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden" style="width: 460px">
                <ModalHeader v-text="__('Upload Callzy Numbers')" />
                <ModalContent>
                    <input type="file" @change="uploadFile" ref="file">
                </ModalContent>
                <ModalFooter>
                    <div class="ml-auto">
                        <LinkButton
            dusk="cancel-upload-delete-button"
            type="button"
            @click.prevent="show=false"
            class="mr-3"
          >
            {{ __('Cancel') }}
          </LinkButton>
                        <button type="submit"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                Upload Callzy Numbers</button>


                    </div>
                </ModalFooter>
            </form>
        </Modal>
    </div>
</template>
<script>
export default {
    data(){
        return {
            show:false,
            file: null,
        }
    },
    methods:{
        submit(){
            if(this.file == null){
                Nova.error('Please Select File')
                return
            }
            let formdata = new FormData();

            const headers = { 'Content-Type': 'multipart/form-data' };

            formdata.append('file',this.file);

            Nova.request().post('/nova-api/upload/callzy-numbers', formdata, {headers}).then(res => {
            if(res.data.success){
                console.log('success')
                Nova.success('Callzy Numbers Uploaded Successfully')
                Nova.visit('/resources/sw-numbers', { remote: false })
            }else{
                console.log('fail')
                Nova.error(res.data.message)
            }

            })
        },
        uploadFile() {
        this.file = this.$refs.file.files[0];
      },
    }
}
</script>
