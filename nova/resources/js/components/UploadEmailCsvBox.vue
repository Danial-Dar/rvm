<template>
    <div>

        <div class="flex-shrink-0 ml-auto pr-2">
            <button @click="submit()"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                Upload Emails
            </button>
        </div>

        <template v-if="show">
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
        /*licenseKey: 'rmrfqVH1eskfB9MYq6SKMNBFev89Ya',*/
        licenseKey: '9M5dDHFeiReKKyTw3gXIwPCbZWmpXl',
        user: {
          user_id: 'default123',
          id: null,
        },
        show:false,
        file: null,
        options: {},

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
            Nova.visit('/resources/emails', { remote: false })
            //custom code
        }else{
            console.log("fail");
            //custom code
        }
        },
        submit() {
            console.log('i am inside submit');
            this.user = {
                user_id: 'default123',
                id: this.currentUser.id,
            };
            this.show = true;
            setTimeout(() => {
                document.getElementById('csvButtton').click();
            }, 4000);
        },

    },

}
</script>
