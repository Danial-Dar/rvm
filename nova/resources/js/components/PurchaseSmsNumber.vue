<style type="text/css">
#purchaseBtn:disabled {
  cursor: not-allowed;
  opacity: 0.8;
}
</style>
<template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="show = true"
        class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
      >
        Purchase Sms Number
      </button>
    </div>
    <Modal
      :show="show"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
      <form
        @submit.prevent="submit"
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 460px"
      >
        <div id="search_number" v-show="showSearchFields">
          <ModalHeader v-text="__('Purchase Sms Number')" />
          <ModalContent>
            <div class="flex relative w-full mb-2">
              <select
                name="filter"
                id="filter"
                @change="setFilter"
                class="w-full block form-control form-select form-select-bordered"
                v-model="data.filter"
              >
                <option value="empty" selected>Select Filter</option>
                <option value="contains">Contains</option>
                <option value="starts_with">Starts With</option>
                <option value="ends_with">Ends With</option>
              </select>
            </div>
            <div class="flex relative w-full mb-2">
              <input
                class="w-full block form-control form-input form-input-bordered"
                name="value"
                placeholder="Value"
                v-model="data.value"
                required
                v-if="filter === 'contains' || filter === 'starts_with' || filter === 'ends_with'"
              />
            </div>

          </ModalContent>
          <ModalFooter>
            <div class="ml-auto">
              <LinkButton
                dusk="cancel-upload-delete-button"
                type="button"
                @click.prevent="
                  ;(show = false),
                    (showSearchTable = false)
                "
                class="mr-3"
              >
                {{ __('Cancel') }}
              </LinkButton>
              <LoadingButton
                type="submit"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                v-show="showSearchFields"
                :loading="loading"
                @click="
                  loading = true
                "
              >
                Search
              </LoadingButton>
            </div>
          </ModalFooter>
        </div>
        <div id="search_table" v-show="showSearchTable">
          <ModalHeader v-text="__('Purchase Sms Number')" />
          <ModalContent class="max-container">
            <table
              class="w-full"
              cellpadding="2"
              cellspacing="2"
              data-testid="resource-table"
            >
              <thead>
                <tr class="userDatatable-header">
                  <th>
                    <span class="userDatatable-title">#</span>
                  </th>
                  <th>
                    <span class="userDatatable-title">Number</span>
                  </th>
                  <!--
                  <th>
                    <span class="userDatatable-title">Npa</span>
                  </th>
                  <th>
                    <span class="userDatatable-title">Nxx</span>
                  </th>
                  <th>
                    <span class="userDatatable-title">Xxxx</span>
                  </th>
                  -->
                  <!-- <th v-if="type === 'local'">
                    <span class="userDatatable-title">State</span>
                  </th>
                  <th v-if="type === 'local'">
                    <span class="userDatatable-title">Ratecenter</span>
                  </th> -->
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, key) in searchNumbers">
                  <tr class="text-center">

                    <td>
                      <input
                        type="checkbox"
                        name="check_row"
                        :value="value.e164"
                        v-model="selectedFields"
                      />
                    </td>
                    <td>
                      {{
                        maskIt(
                          value.e164
                        )
                      }}
                    </td>
                    <!--<td>{{ value.npa }}</td>
                    <td>{{ value.nxx }}</td>
                    <td>{{ value.xxxx }}</td>-->
                    <!-- <td v-if="type === 'local'">{{ value.state }}</td>
                    <td v-if="type === 'local'">{{ value.ratecenter }}</td> -->
                  </tr>
                </template>
              </tbody>
            </table>
          </ModalContent>
          <ModalFooter>
            <div class="ml-auto">
              <LinkButton
                dusk="cancel-upload-delete-button"
                type="button"
                @click.prevent="
                  ;(show = false),
                    (showSearchTable = false),
                    (showSearchFields = true)
                "
                class="mr-3"
              >
                {{ __('Cancel') }}
              </LinkButton>
              <LoadingButton
                type="button"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                v-show="showSearchTable"
                @click.stop="purchaseNumber"
                id="purchaseBtn"
                :loading="loading"
                :disabled="
                  disabled == true ||
                  (selectedFields.length === 0 ? true : false)
                "
              >
                Purchase
              </LoadingButton>
            </div>
          </ModalFooter>
        </div>
      </form>
    </Modal>
  </div>
</template>
<script>
import { mask } from 'maska'
export default {
  // directives: { mask },
  data() {
    return {
      show: false,
      loading: false,
      states: '',
      ratecenter: '',
      type: '',
      filter: '',
      showSearchFields: true,
      showSearchTable: false,
      data: {
        filter: '',
        value: '',
      },
      selectedFields: [],
      searchNumbers: '',
      disabled: false,
    }
  },
  async created() {
    this.loading = false
    // console.log('asdasd')
    //   get states
    // await Nova.request()
    //   .post('/nova-api/numbers/get-states')
    //   .then(response => {
    //     if (response.data.error === null) {
    //       let data = response.data.data
    //       this.states = data
    //     }
    //   })
  },
  methods: {
    maskIt(i) {
      return mask(i, '+1 (###) ###-####')
    },
    setFilter(e) {
      if (e.target.value !== '') this.filter = e.target.value
      console.log(this.filter)
    },
    async submit() {
      // this.showSearchFields = false
      // this.showSearchTable = true
      this.loading = true
      let params = {
        filter: this.data.filter,
        value: this.data.value,
      }

      await Nova.request()
        .post('/nova-api/numbers/get-sms-numbers', params)
        .then(response => {
          this.showSearchFields = false
          this.showSearchTable = true
          this.loading = false
          let numbers = response.data.data.data

          if (numbers.length > 0) {
            this.searchNumbers = numbers
          }

          console.log(searchNumbers)
        })
    },

    async purchaseNumber() {
      this.loading = true
      this.disabled = true
      let numbers = this.selectedFields
    //   let name = this.data.name
    //   let filter = this.data.filter
    //   let value = this.data.value
    //   let description = this.data.description
      let params = {
        numbers: numbers,
        // name: name,
        // description: description,
      }

      await Nova.request()
        .post('/nova-api/numbers/purchase-sms-numbers', params)
        .then(response => {
          this.loading = false
          this.disabled = false
          this.showSearchFields = false
          this.showSearchTable = false
          this.show = false

          if (response.data.success) {
            Nova.success('Purchase Number successfully')
          } else {
            Nova.error(response.data.error)
          }

        //   if (response.data.role === 'user') {
        //     Nova.visit('/resources/my-numbers', { remote: false })
        //   } else {
            Nova.visit('/resources/sms-numbers', { remote: false })
        //   }
        })
    },
  },
}
</script>

<style>
.max-container {
  overflow-y: auto;
  height: 500px;
}
</style>
