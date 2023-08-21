<template>
    <div>

        <div class="flex-shrink-0 ml-auto pr-2">
            <button @click="show=true"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                Create Lead List
            </button>
        </div>
        <Modal :show="show" data-testid="payment-modal" role="alertdialog">
            <form
                @submit.prevent="submit"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >

                <ModalHeader v-text="__('Enter Lead List Name')" />
                <ModalContent>
                    <div class="flex relative w-full mt-3 mb-2">
                        <input
                        class="w-full form-control form-input form-input-bordered"
                        id="leadListName"
                        type="text"
                        maxlength="20"
                        minlength="3"
                        placeholder="Enter List Name"
                        v-model="leadListName"
                        required
                        name="leadListName"
                        />
                    </div>


                </ModalContent>
                <ModalFooter>
                    <div class="ml-auto">
                        <LinkButton
                        dusk="cancel-upload-delete-button"
                        type="button"
                        @click.prevent="show = false"
                        class="mr-3"
                        >
                        {{ __('Cancel') }}
                        </LinkButton>
                        <button type="submit" class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                            Next
                        </button>

                    </div>
                </ModalFooter>


            </form>
        </Modal>
        <template v-if="showcsv">
            <CSVBoxButton
                :licenseKey="licenseKey"
                :user="user"
                :options="options"
                :onImport="onImport">
                <button id="csvButtton" style="display:none;" class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                    Next
                </button>
            </CSVBoxButton>
        </template>
    </div>
</template>
<script>
import CSVBoxButton  from '@csvbox/vuejs3'
import { mapGetters, mapMutations } from 'vuex'
export default {

    components: {
        CSVBoxButton,
    },
    data: () => ({
        licenseKey: 'UE5HtYR1uyLRF8hUpLv9AzAAX805aM',
        user: {
          user_id: 'default123',
          id: null,
          list_id: null,
        },
        show:false,
        showcsv:false,
        file: null,
        options: {},
        leadListName: null,
        leadListId: null,
        loading: false,

    }),
    computed: {
    ...mapGetters(['currentUser']),
    },
    mounted (){
        this.options = {
            request_headers: {
                "Content-Type": "application/json",
                "Token": btoa(this.currentUser.id)
            }
        }

    },
    methods: {
        onImport: function (result, data) {
        if(result){
            console.log("success");
            console.log(data.row_success + " rows uploaded");
            this.show = false;
            Nova.visit('/resources/lead-lists', { remote: false })
            //custom code
        }else{
            console.log("fail");
            //custom code
        }
        },
        async submit() {
            await Nova.request().get('/nova-api/custom/lead-list-create/'+this.leadListName)
            .then(response => {
                if(response.data){
                    this.leadListId = response.data.id;
                    // console.log('ab apun yaha pe hai is '+this.leadListId+' k sath');
                    this.user = {
                        user_id: 'default123',
                        id: this.currentUser.id,
                        list_id: this.leadListId,
                    };
                    this.showcsv = true;
                    setTimeout(() => {
                        document.getElementById('csvButtton').click();
                    }, 4000);
                }


            })
        }
    },

}
</script>
