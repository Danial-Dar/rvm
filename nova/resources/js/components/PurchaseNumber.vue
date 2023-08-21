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
        Purchase Number
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
          <ModalHeader v-text="__('Purchase Number')" />
          <ModalContent>
            <div class="flex relative w-full mb-2">
              <input
                class="w-full block form-control form-input form-input-bordered"
                name="name"
                placeholder="Name"
                v-model="data.name"
                required
              />
            </div>
            <div class="flex relative w-full mb-2">
              <textarea
                class="w-full block form-control form-input form-input-bordered"
                name="description"
                placeholder="Description"
                v-model="data.description"
                rows="20"
                required
                style="height: 50px"
              />
            </div>
            <div class="flex relative w-full mb-2">
              <select
                name="type"
                id="type"
                @change="setTypeSearch"
                class="w-full block form-control form-select form-select-bordered"
                v-model="data.type"
                required
              >
                <option value="">Select Type</option>
                <option value="local">local</option>
                <option value="toll">toll</option>
              </select>
            </div>
            <div class="flex relative w-full mb-2">
              <select
                name="state"
                id="state"
                @change="getRateCenter"
                class="w-full block form-control form-select form-select-bordered"
                v-model="data.state"
                required
                v-if="type === 'local'"
              >
                <option value="">Select State</option>
                <option
                  v-for="(state, key) in states"
                  :value="state.state_code"
                  :key="key"
                >
                  {{ state.state_name }}
                </option>
              </select>
            </div>
            <div class="flex relative w-full mb-2">
              <select
                name="ratecenter"
                id="ratecenter"
                class="w-full block form-control form-select form-select-bordered"
                v-model="data.ratecenter"
                v-if="type === 'local'"
              >
                <option value="">Select Rate Center</option>
                <option
                  v-for="(rate, key) in ratecenter"
                  :value="rate.rate_center"
                  :key="key"
                >
                  {{ rate.rate_center }}
                </option>
              </select>
            </div>
            <div class="flex relative w-full mb-2">
              <input
                type="text"
                placeholder="No of phone numbers"
                class="w-full form-control form-input form-input-bordered"
                name="limit"
                v-model="data.limit"
                required
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
                    (showSearchTable = false),
                    (showSearchFields = true)
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
                  data.name !== '' &&
                  data.description !== '' &&
                  data.type !== '' &&
                  type === 'local'
                    ? data.state !== ''
                    : '' && data.limit !== ''
                    ? (loading = true)
                    : (loading = false)
                "
              >
                Search
              </LoadingButton>
            </div>
          </ModalFooter>
        </div>
        <div id="search_table" v-show="showSearchTable">
          <ModalHeader v-text="__('Purchase Number')" />
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
                  <th v-if="type === 'local'">
                    <span class="userDatatable-title">State</span>
                  </th>
                  <th v-if="type === 'local'">
                    <span class="userDatatable-title">Ratecenter</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, key) in searchNumbers">
                  <tr class="text-center">
                    <td v-if="type === 'local'">
                      <input
                        type="checkbox"
                        name="check_row"
                        :value="
                          value.number +
                          ',' +
                          value.npa +
                          ',' +
                          value.nxx +
                          ',' +
                          value.xxxx +
                          ',' +
                          value.state +
                          ',' +
                          value.ratecenter +
                          ',' +
                          type
                        "
                        v-model="selectedFields"
                      />
                    </td>
                    <td v-else>
                      <input
                        type="checkbox"
                        name="check_row"
                        :value="
                          value.did_number +
                          ',' +
                          value.npa +
                          ',' +
                          value.nxx +
                          ',' +
                          value.xxxx +
                          ',' +
                          null +
                          ',' +
                          null +
                          ',' +
                          type
                        "
                        v-model="selectedFields"
                      />
                    </td>
                    <td>
                      {{
                        maskIt(
                          type === 'local' ? value.number : value.did_number
                        )
                      }}
                    </td>
                    <!--<td>{{ value.npa }}</td>
                    <td>{{ value.nxx }}</td>
                    <td>{{ value.xxxx }}</td>-->
                    <td v-if="type === 'local'">{{ value.state }}</td>
                    <td v-if="type === 'local'">{{ value.ratecenter }}</td>
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
      showSearchFields: true,
      showSearchTable: false,
      data: {
        name: '',
        type: '',
        description: '',
        state: '',
        ratecenter: '',
        npx: '',
        npa: '',
        limit: '',
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
    await Nova.request()
      .post('/nova-api/numbers/get-states')
      .then(response => {
        if (response.data.error === null) {
          let data = response.data.data
          this.states = data
        }
      })
  },
  methods: {
    maskIt(i) {
      return mask(i, '+1 (###) ###-####')
    },
    setTypeSearch(e) {
      if (e.target.value !== '') this.type = e.target.value
    },
    async submit() {
      // this.showSearchFields = false
      // this.showSearchTable = true
      this.loading = true
      let params = {
        state: this.data.state,
        ratecenter: this.data.ratecenter,
        type: this.data.type,
        npa: this.data.npa,
        nxx: this.data.nxx,
        limit: this.data.limit,
      }

      await Nova.request()
        .post('/nova-api/numbers/get-numbers', params)
        .then(response => {
          this.showSearchFields = false
          this.showSearchTable = true
          this.loading = false
          let numbers = response.data.data.result

          this.searchNumbers = numbers
          if (numbers.length > 0) {
            this.searchNumbers = numbers
          }
        })
    },
    async getRateCenter() {
      let state_id = event.target.value
      let params = {
        state_id: state_id,
      }
      this.loading = true
      await Nova.request()
        .post('/nova-api/numbers/get-ratecenter', params)
        .then(response => {
          this.loading = false
          if (response.data.error === null) {
            let data = response.data.data
            this.ratecenter = data
            Nova.success('Ratecenter fetch successfully')
          } else {
            Nova.error('Ratecenter not fetched.')
          }
        })
      // this.file = this.$refs.file.files[0];
    },
    async purchaseNumber() {
      this.loading = true
      this.disabled = true
      let numbers = this.selectedFields
      let name = this.data.name
      let description = this.data.description
      let params = {
        numbers: numbers,
        name: name,
        description: description,
      }

      await Nova.request()
        .post('/nova-api/numbers/purchase-numbers', params)
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

          if (response.data.role === 'user') {
            Nova.visit('/resources/my-numbers', { remote: false })
          } else {
            Nova.visit('/resources/sw-numbers', { remote: false })
          }
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
