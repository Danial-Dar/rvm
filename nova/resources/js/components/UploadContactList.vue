<template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="show = true"
        class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
      >
        Create Contact List
      </button>
    </div>
    <!-- <vue-csv-import
      v-model="csv"
      ref="csv"
      :fields="{ phone: { required: true, label: 'Phone' } }"
    > -->
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
          <!-- <input type="file" name=""> -->
          <input
            type="text"
            class="bg-white border focus:outline-none p-3 w-full"
            placeholder="Contact List Name"
            v-model="contact_list_name"
          />
          <br />
          <br />
          <input
            ref="file"
            type="file"
            @change="change"
            class="bg-white border focus:outline-none p-3 w-full"
            placeholder="Contact List Name"
          />
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

            <!-- <div
                class="
                  flex-shrink-0
                  shadow
                  rounded
                  focus:outline-none
                  ring-primary-200
                  dark:ring-gray-600
                  focus:ring
                  bg-primary-500
                  hover:bg-primary-400
                  active:bg-primary-600
                  text-white
                  dark:text-gray-800
                  inline-flex
                  items-center
                  font-bold
                  px-4
                  h-9
                  text-sm
                  flex-shrink-0
                "
                @click.prevent="saveContactList"

              >
                Create
              </div> -->
            <LoadingButton
              type="submit"
              class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
              :loading="loading"
              @click.prevent="saveContactList"
            >
              Create List
            </LoadingButton>
          </div>
        </ModalFooter>
      </div>
    </Modal>
    <!-- </vue-csv-import> -->
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
import axios from 'axios'

export default {
  components: {
    VueCsvImport,
    VueCsvErrors,
    VueCsvInput,
    VueCsvMap,
    VueCsvSubmit,
    VueCsvToggleHeaders,
  },
  data() {
    return {
      show: false,
      csv: null,
      contact_list_name: '',
      file: null,
      loading: false,
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
      if (this.contact_list_name.length === 0 || this.file == null) {
        console.log('Please Fill All Fields')
        Nova.error('Please Fill All Fields')
        return
      }
      this.loading = true
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('name', this.contact_list_name)
      await Nova.request()
        .post('/nova-api/contact-lists/upload', formData)
        .then(async res => {
          if (res.data.success) {
            console('==============================')
            console(res.data)
            console.log('success')
            Nova.success('Contact List Added Successfully')
            Nova.visit('/resources/contact-lists', { remote: false })
          } else {
            console.log('fail')
            Nova.error(res.data.message)
          }
          this.loading = false
        })
      return
      if (this.contact_list_name !== null && this.csv !== null) {
        console.log('name', this.contact_list_name)
        console.log('csv', this.csv)

        let formdata = new FormData()

        // const headers = { 'Content-Type': 'multipart/form-data' };

        // formdata.append('file',this.csv);
        // formdata.append('name',this.contact_list_name);

        let csvs = this.csv.length / 1000

        await Nova.request()
          .post('/nova-api/contact-lists/upload', {
            name: this.contact_list_name,
          })
          .then(async res => {
            // console.log('res', res.data)
            if (res.data.success) {
              for (let index = 0; index < csvs; index++) {
                await Nova.request().post('/nova-api/contact-lists/upload', {
                  contact_list_id: res.data.contact_list_id,
                  file: this.csv.slice(index * 1000, 1000 * (index + 1) - 1),
                })
              }
            }
          })
        Nova.success('Contact List Added Successfully')
        Nova.visit('/resources/contact-lists', { remote: false })
        // console.log('Api Request Send >>>>>>> /nova-api/contact-lists/upload')
      } else {
        Nova.error('Please fill all fields')
      }
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
</style>
