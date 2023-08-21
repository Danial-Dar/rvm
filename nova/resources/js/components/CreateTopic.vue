<template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="show = true"
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
      >
        Create Topic
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
        <ModalHeader v-text="__('Create Topic')" />
        <ModalContent>
          <!-- <input type="file" name=""> -->
          <div
            class="
              field-wrapper
              flex flex-col
              border-b border-gray-100
              dark:border-gray-700
              md:flex-row
            "
            index="0"
          >
            <div class="px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label
                for="title-create-topic-text-field"
                class="inline-block pt-2 leading-tight"
                >Title
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <input
                type="text"
                placeholder="Title"
                class="w-full form-control form-input form-input-bordered"
                id="title-create-topic-text-field"
                dusk="title"
                list="title-list"
                v-model="title"
              /><!--v-if--><!--v-if--><!--v-if-->
              <p v-if="error" style="color: red">* Please enter topic title</p>
            </div>
          </div>
          <div
            class="
              field-wrapper
              flex flex-col
              border-b border-gray-100
              dark:border-gray-700
              md:flex-row
            "
            index="0"
          >
            <div class="px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label
                for="title-create-topic-text-field"
                class="inline-block pt-2 leading-tight"
                >Scorecard
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <div class="flex relative w-full">
                <select
                  id="status"
                  dusk="status"
                  class="
                    w-full
                    block
                    form-control form-select form-select-bordered
                  "
                  v-model="score"
                >
                  <option value="">Choose an option</option>
                  <option
                    v-for="scorecard in scorecards"
                    :key="scorecard.id"
                    :value="scorecard.id"
                  >
                    {{ scorecard.name }}
                  </option></select
                ><svg
                  class="flex-shrink-0 pointer-events-none form-select-arrow"
                  xmlns="http://www.w3.org/2000/svg"
                  width="10"
                  height="6"
                  viewBox="0 0 10 6"
                >
                  <path
                    class="fill-current"
                    d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
                  ></path>
                </svg>
              </div>
              <p v-if="errorScore" style="color: red">
                * Please select scorecard
              </p>
            </div>
          </div>
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
              @click.prevent="createTopic"
            >
              <!-- <vue-csv-submit url="/post/here"></vue-csv-submit> -->
              Create
            </div>
          </div>
        </ModalFooter>
      </div>
    </Modal>
    <!-- </vue-csv-import> -->
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      show: false,
      error: false,
      errorScore: false,
      title: '',
      scorecards: [],
      score: '',
    }
  },
  mounted() {
    this.getScorecards()
  },
  methods: {
    closeModel() {
      this.show = false
    },
    async createTopic() {
      if (this.title.length === 0) {
        this.error = true
        return
      }
      this.error = false

      if (this.score === '') {
        this.errorScore = true
        return
      }
      this.errorScore = false

      await Nova.request()
        .post('/nova-api/custom/topic', {
          title: this.title,
          scorecard: this.score,
        })
        .then(async res => {
          if (res.data.success) {
            Nova.success('Topic Created Successfully')
          }

          if (!res.data.success) {
            Nova.error(res.data.message)
          }

          this.title = ''
          this.show = false
        })
    },

    async getScorecards() {
      await Nova.request()
        .get('/nova-api/custom/topic/scorecard')
        .then(async res => {
          this.scorecards = res.data.scorecards
        })
    },
  },
}
</script>

<style scoped>
</style>

