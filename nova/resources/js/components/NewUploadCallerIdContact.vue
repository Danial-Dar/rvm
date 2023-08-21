<template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="show = true"
        class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
      >
        Add Number
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
        <ModalHeader v-text="__('Upload Contact')" />
        <ModalContent>
          <!-- <input type="file" name=""> -->

          <div class="flex relative w-full mb-2">
            <div class="md:w-1/5">
              <label for="">Number:</label>
            </div>
            <div class="flex-1">

              <!-- <input
                type="text"
                class="bg-white border focus:outline-none p-3 w-full"
                placeholder="+1 (123) 456-7895"
                v-maska="'+1 (###) ###-####'"
                v-model="number"
                required
              /> -->


               <phone-number  :class="{
                                        'border-error':
                                            !forward_number && !isValid,
                                    }"
                                    class="bg-white border focus:outline-none p-3 w-full" :value="number"  v-model="number" id="number" placeholder="+1 (123) 456-7895" required />




               
            </div>
          </div>
          <br />
          
          <!-- <vue-csv-toggle-headers></vue-csv-toggle-headers>
            <vue-csv-errors></vue-csv-errors> -->
          <!-- <div class="csv-input"> -->
          <!-- <vue-csv-input ></vue-csv-input> -->
          <!-- </div> -->
          <!-- <div class="csv-map"> -->
          <!-- <vue-csv-map :auto-match="true"></vue-csv-map> -->
          <!-- </div> -->
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
              @click.prevent="saveContact"
            >
              <!-- <vue-csv-submit url="/post/here"></vue-csv-submit> -->
              Create
            </div>
          </div>
        </ModalFooter>
      </div>
    </Modal>
  </div>
</template>
<script>

import {
  VueCsvToggleHeaders,
  VueCsvSubmit,
  VueCsvMap,
  VueCsvInput,
  VueCsvErrors,
  VueCsvImport,
} from 'vue-csv-import'
import { maska } from 'maska'

import PhoneNumber from './PhoneNumber.vue';

import axios from 'axios'
export default {
  components: {
    VueCsvImport,
    VueCsvErrors,
    VueCsvInput,
    VueCsvMap,
    VueCsvSubmit,
    VueCsvToggleHeaders,
     PhoneNumber,
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
      type: 'individual', //csv,individual
      number: '',
    }
  },
  methods: {
    
    closeModel() {
      this.show = false
      this.csv = null
      this.contact_list_name = ''
    },

    async saveContact() {
        if (this.number === '') {
          console.log('Please Add Number')
          Nova.error('Please Add Number')
          return
        }
        this.saveContactListButtonDisable = true
        Nova.request()
          .post('/nova-api/caller-id-contact-lists/upload', {
            type: this.type,
            number: this.number,
            // company_id: this.company_id,
            file: [],
          })
          .then(res => {
            console.log('res', res.data)
            if (res.data.status == 'success') {
              this.saveContactListButtonDisable = false
              this.show = false
              Nova.info(res.data.message)

              Nova.visit('/resources/caller-id-contact-lists', {
                remote: false,
              })
            } else {
              this.saveContactListButtonDisable = false
              Nova.error(res.data.message)
            }
          })
          .catch(error => {
            Nova.error('An error came')
            console.log('error', error)
            this.saveContactListButtonDisable = false
          })
    }
  }
}
</script>