<!-- <template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="show = true"
        class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
      >
        Upload Contact List
      </button>
    </div>

    <Modal
      :show="show"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 460px"
      >
        <ModalHeader v-text="__('Upload Contact List')" />
        <ModalContent>

          <input
            v-if="type == 'csv'"
            type="file"
            @change="change"
            class="bg-white border focus:outline-none p-3 w-full"
            placeholder="Contact List Name"
          />

        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="closeModel"
              class="mr-3"
            >
              {{ __('Cancel') }}
            </LinkButton>

            <div
              class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
              @click.prevent="saveContactList"
            >
              Create
            </div>
          </div>
        </ModalFooter>
      </div>
    </Modal>
  </div>
</template> -->

<!-- <script>
// import {
//   VueCsvToggleHeaders,
//   VueCsvSubmit,
//   VueCsvMap,
//   VueCsvInput,
//   VueCsvErrors,
//   VueCsvImport,
// } from 'vue-csv-import'
// import { maska } from 'maska'

// import axios from 'axios'

export default {
  components: {
    VueCsvImport,
    VueCsvErrors,
    VueCsvInput,
    VueCsvMap,
    VueCsvSubmit,
    VueCsvToggleHeaders,
  },
  directives: {
    maska,
  },
  data() {
    return {
      show: false,
      csv: null,
      contact_list_name: '',
      file: null,
      type: 'csv',
      number: '',
    }
  },
  methods: {
    change(event) {
      this.file = event.target.files[0]
    },
    showFields() {
      console.log('csv', this.csv)
    },
    closeModel() {
      this.show = false
      this.csv = null
      this.contact_list_name = ''
    },
    async saveContactList() {


        if (this.file === null) {
          console.log('Please Attach File')
          Nova.error('Please Attach File')
          return
        }

        let formData = new FormData()
        formData.append('file', this.file)
        formData.append('type', this.type)

        await Nova.request()
          .post('/nova-api/caller-id-contact-lists/upload/new', formData)
          .then(async res => {
            if(res.data.success){
              console.log('success')
              Nova.success('Contact List Added Successfully')
              Nova.visit('/resources/caller-id-contact-lists', { remote: false })
            }else{
              console.log('fail')
              Nova.error(res.data.message)
            }
          })


      return

    },
  },
}
 </script>

<style scoped>
.csv-input {
  padding: 0.6rem;
}
.csv-map {
  padding: 0.6rem;
  background: rgb(232, 231, 231);
}
</style> -->

<template>
    <div>

        <div class="flex-shrink-0 ml-auto pr-2">
            <button @click="show=true"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">
                Upload Contact List
            </button>
        </div>
        <Modal :show="show" data-testid="payment-modal" role="alertdialog">
            <form
                @submit.prevent="submit"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >

                <ModalHeader v-text="__('Enter Contact List Name')" />
                <ModalContent>
                    <div class="flex relative w-full mt-3 mb-2">
                        <input
                        class="w-full form-control form-input form-input-bordered"
                        id="contactListName"
                        type="text"
                        maxlength="20"
                        minlength="3"
                        placeholder="Enter List Name"
                        v-model="contactListName"
                        required
                        name="contactListName"
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
        licenseKey: 'blPagDO5kM9qBqRfUMRtliLCcLZUar',
        user: {
          user_id: 'default123',
          id: null,
          list_id: null,
        },
        show:false,
        showcsv:false,
        file: null,
        options: {},
        contactListName: null,
        contactListId: null,
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
            //custom code
            this.show = false;
            Nova.visit('/resources/caller-id-contact-lists', { remote: false })
        }else{
            console.log("fail");
            //custom code
        }
        },
        async submit() {
            await Nova.request().get('/nova-api/custom/cir-contact-list-create/'+this.contactListName)
            .then(response => {
                if(response.data){
                    this.contactListId = response.data.id;
                    // console.log('ab apun yaha pe hai is '+this.contactListId+' k sath');
                    this.user = {
                        user_id: 'default123',
                        id: this.currentUser.id,
                        list_id: this.contactListId,
                    };
                    this.showcsv = true;
                    setTimeout(() => {
                        document.getElementById('csvButtton').click();
                    }, 5000);
                }


            })
        }
    },

}
</script>
