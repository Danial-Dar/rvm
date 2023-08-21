<template>
  <div>
    <Head title="Scorecard" />

    <Heading class="mb-6">Scorecard</Heading>

    <div class="flex">
      <div
        class="relative h-9 w-full md:w-1/3 md:flex-shrink-0 mb-6 mb-6"
        searchable="true"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          width="20"
          height="24"
          class="inline-block absolute ml-2 text-gray-400"
          role="presentation"
          style="top: 4px"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          ></path></svg
        ><input
          data-testid="search-input"
          dusk="search"
          class="
            appearance-none
            bg-white
            dark:bg-gray-800
            shadow
            rounded-full
            h-8
            w-full
            dark:focus:bg-gray-800
            appearance-none
            rounded-full
            h-8
            pl-10
            w-full
            focus:bg-white focus:outline-none focus:ring
            ring-primary-200
            dark:ring-gray-600
            appearance-none
            bg-white
            dark:bg-gray-800
            shadow
            rounded-full
            h-8
            w-full
            dark:focus:bg-gray-800
          "
          placeholder="Search"
          type="search"
          spellcheck="false"
          aria-label="Search"
        />
      </div>
      <div class="w-full flex items-center mb-6">
        <!-- Create / Attach Button -->
        <div class="ml-auto flex items-center">
          <!--v-if-->
          <div class="flex-shrink-0 ml-auto">
            <!-- Attach Related Models --><!-- Create Related Models --><a
              size="md"
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
              dusk="create-button"
              href="resources/scorecards/new"
              ><span class="hidden md:inline-block">Create Scorecard</span></a
            >
          </div>
        </div>
      </div>
    </div>
    <Card
      class="flex flex-col items-center justify-center"
      style="padding-top: 50px"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow"
        style="width: 100%"
      >
        <div class="relative">

          <!--v-if-->
          <div v-if="scorecardCount == 0" class="flex flex-col justify-center items-center px-6 py-8" dusk="topics-empty-dialog"><svg class="inline-block text-gray-300 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="65" height="51" viewBox="0 0 65 51"><path class="fill-current" d="M56 40h2c.552285 0 1 .447715 1 1s-.447715 1-1 1h-2v2c0 .552285-.447715 1-1 1s-1-.447715-1-1v-2h-2c-.552285 0-1-.447715-1-1s.447715-1 1-1h2v-2c0-.552285.447715-1 1-1s1 .447715 1 1v2zm-5.364125-8H38v8h7.049375c.350333-3.528515 2.534789-6.517471 5.5865-8zm-5.5865 10H6c-3.313708 0-6-2.686292-6-6V6c0-3.313708 2.686292-6 6-6h44c3.313708 0 6 2.686292 6 6v25.049375C61.053323 31.5511 65 35.814652 65 41c0 5.522847-4.477153 10-10 10-5.185348 0-9.4489-3.946677-9.950625-9zM20 30h16v-8H20v8zm0 2v8h16v-8H20zm34-2v-8H38v8h16zM2 30h16v-8H2v8zm0 2v4c0 2.209139 1.790861 4 4 4h12v-8H2zm18-12h16v-8H20v8zm34 0v-8H38v8h16zM2 20h16v-8H2v8zm52-10V6c0-2.209139-1.790861-4-4-4H6C3.790861 2 2 3.790861 2 6v4h52zm1 39c4.418278 0 8-3.581722 8-8s-3.581722-8-8-8-8 3.581722-8 8 3.581722 8 8 8z"></path></svg><h3 class="text-base font-normal mt-3">No Scorecard matched the given criteria.</h3><!-- Create / Attach Button --><div class="flex-shrink-0 mt-6"><!-- Attach Related Models --><!-- Create Related Models --></div></div>
          <div v-if="scorecardCount != 0" class="overflow-hidden overflow-x-auto relative">
            <table
              class="w-full table-default"
              cellpadding="0"
              cellspacing="0"
              data-testid="resource-table"
            >
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  <!-- Select Checkbox -->
                  <th
                    class="
                      td-fit
                      uppercase
                      text-xxs text-gray-500
                      tracking-wide
                      pl-5
                      pr-2
                      py-2
                    "
                  >
                    <span class="sr-only">Selected Resources</span>
                  </th>
                  <!-- Field Names -->
                  <th
                    class="
                      text-left
                      px-2
                      whitespace-nowrap
                      uppercase
                      text-gray-500 text-xxs
                      tracking-wide
                      py-2
                    "
                  >
                    <button
                      type="button"
                      class="
                        cursor-pointer
                        inline-flex
                        items-center
                        focus:outline-none focus:ring
                        ring-primary-200
                        dark:ring-gray-600
                        rounded
                      "
                      dusk="sort-id"
                      aria-sort="none"
                    >
                      <span
                        class="
                          inline-flex
                          font-sans font-bold
                          uppercase
                          text-xxs
                          tracking-wide
                          text-gray-500
                        "
                        >ID</span
                      ><svg
                        class="ml-2 flex-shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="14"
                        viewBox="0 0 8 14"
                      >
                        <path
                          class="fill-gray-300 dark:fill-gray-500"
                          d="M1.70710678 4.70710678c-.39052429.39052429-1.02368927.39052429-1.41421356 0-.3905243-.39052429-.3905243-1.02368927 0-1.41421356l3-3c.39052429-.3905243 1.02368927-.3905243 1.41421356 0l3 3c.39052429.39052429.39052429 1.02368927 0 1.41421356-.39052429.39052429-1.02368927.39052429-1.41421356 0L4 2.41421356 1.70710678 4.70710678z"
                        ></path>
                        <path
                          class="fill-gray-300 dark:fill-gray-500"
                          d="M6.29289322 9.29289322c.39052429-.39052429 1.02368927-.39052429 1.41421356 0 .39052429.39052429.39052429 1.02368928 0 1.41421358l-3 3c-.39052429.3905243-1.02368927.3905243-1.41421356 0l-3-3c-.3905243-.3905243-.3905243-1.02368929 0-1.41421358.3905243-.39052429 1.02368927-.39052429 1.41421356 0L4 11.5857864l2.29289322-2.29289318z"
                        ></path>
                      </svg>
                    </button>
                  </th>
                  <th
                    class="
                      text-left
                      px-2
                      whitespace-nowrap
                      uppercase
                      text-gray-500 text-xxs
                      tracking-wide
                      py-2
                    "
                  >
                    <button
                      type="button"
                      class="
                        cursor-pointer
                        inline-flex
                        items-center
                        focus:outline-none focus:ring
                        ring-primary-200
                        dark:ring-gray-600
                        rounded
                      "
                      dusk="sort-name"
                      aria-sort="none"
                    >
                      <span
                        class="
                          inline-flex
                          font-sans font-bold
                          uppercase
                          text-xxs
                          tracking-wide
                          text-gray-500
                        "
                        >Name</span
                      ><svg
                        class="ml-2 flex-shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="14"
                        viewBox="0 0 8 14"
                      >
                        <path
                          class="fill-gray-300 dark:fill-gray-500"
                          d="M1.70710678 4.70710678c-.39052429.39052429-1.02368927.39052429-1.41421356 0-.3905243-.39052429-.3905243-1.02368927 0-1.41421356l3-3c.39052429-.3905243 1.02368927-.3905243 1.41421356 0l3 3c.39052429.39052429.39052429 1.02368927 0 1.41421356-.39052429.39052429-1.02368927.39052429-1.41421356 0L4 2.41421356 1.70710678 4.70710678z"
                        ></path>
                        <path
                          class="fill-gray-300 dark:fill-gray-500"
                          d="M6.29289322 9.29289322c.39052429-.39052429 1.02368927-.39052429 1.41421356 0 .39052429.39052429.39052429 1.02368928 0 1.41421358l-3 3c-.39052429.3905243-1.02368927.3905243-1.41421356 0l-3-3c-.3905243-.3905243-.3905243-1.02368929 0-1.41421358.3905243-.39052429 1.02368927-.39052429 1.41421356 0L4 11.5857864l2.29289322-2.29289318z"
                        ></path>
                      </svg>
                    </button>
                  </th>
                  <th
                    class="
                      text-left
                      px-2
                      whitespace-nowrap
                      uppercase
                      text-gray-500 text-xxs
                      tracking-wide
                      py-2
                    "
                  >
                    <span>Status</span>
                  </th>
                  <!-- View, Edit, and Delete -->
                  <th class="uppercase text-xxs tracking-wide px-2 py-2">
                    <span class="sr-only">Controls</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="scorecard in scorecards"
                  :key="scorecard.id"
                  dusk="12-row"
                  class="group"
                  addition-actions=""
                >
                  <!-- Resource Selection Checkbox -->
                  <td
                    class="
                      py-2
                      border-t border-gray-100
                      dark:border-gray-700
                      px-2
                      cursor-pointer
                      td-fit
                      pl-5
                      pr-5
                      dark:bg-gray-800
                      group-hover:bg-gray-50
                      dark:group-hover:bg-gray-900
                    "
                  >
                    <input
                      type="checkbox"
                      class="checkbox"
                      aria-label="Select Resource test scorecard"
                      data-testid="scorecards-items-0-checkbox"
                      dusk="12-checkbox"
                    />
                  </td>
                  <!-- Fields -->
                  <td
                    class="
                      px-2
                      py-2
                      border-t border-gray-100
                      dark:border-gray-700
                      whitespace-nowrap
                      cursor-pointer
                      dark:bg-gray-800
                      group-hover:bg-gray-50
                      dark:group-hover:bg-gray-900
                    "
                  >
                    <div class="text-left">
                      <a
                        class="link-default"
                        :href="'/space/resources/scorecards/'+scorecard.id"
                        >{{ scorecard.id }}</a
                      >
                    </div>
                  </td>
                  <td
                    class="
                      px-2
                      py-2
                      border-t border-gray-100
                      dark:border-gray-700
                      whitespace-nowrap
                      cursor-pointer
                      dark:bg-gray-800
                      group-hover:bg-gray-50
                      dark:group-hover:bg-gray-900
                    "
                  >
                    <div class="text-left" resource="[object Object]">
                      <span class="text-90 whitespace-nowrap">{{
                        scorecard.name
                      }}</span>
                    </div>
                  </td>
                  <td
                    class="
                      px-2
                      py-2
                      border-t border-gray-100
                      dark:border-gray-700
                      whitespace-nowrap
                      cursor-pointer
                      dark:bg-gray-800
                      group-hover:bg-gray-50
                      dark:group-hover:bg-gray-900
                    "
                  >
                    <div class="text-left" resource="[object Object]">
                      <span class="whitespace-nowrap">{{
                        scorecard.status ? "Active" : "Deactive"
                      }}</span>
                    </div>
                  </td>
                  <td
                    class="
                      py-2
                      border-t border-gray-100
                      dark:border-gray-700
                      cursor-pointer
                      px-2
                      td-fit
                      text-right
                      align-middle
                      dark:bg-gray-800
                      group-hover:bg-gray-50
                      dark:group-hover:bg-gray-900
                    "
                  >
                    <div class="flex items-center space-x-0 text-gray-400">
                      <!-- <Link
          v-for="action in additionActions"
          :key="action.component"
          v-tooltip.click="action.toolTip"
          :aria-label="__('View')"
          :data-testid="`${testId}-view-button`"
          :dusk="`${action.dusk}-view-button`"
          :href="$url(`/resources/${action.link}`)"
          class="toolbar-button hover:text-primary-500 px-2"
          @click.stop
        >
          <Icon :type="action.icon" />
        </Link> -->
                      <!-- View Resource Link --><a
                        aria-label="View"
                        data-testid="scorecards-items-0-view-button"
                        dusk="12-view-button"
                        class="
                          toolbar-button
                          hover:text-primary-500
                          px-2
                          v-popper--has-tooltip
                        "
                        href="#"
                        @click.prevent="viewScorecard(scorecard)"
                        ><svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          width="24"
                          height="24"
                          class="inline-block"
                          role="presentation"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                          ></path>
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                          ></path></svg
                      ></a>
                      <!-- Delete Resource Link -->
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <div v-if="scorecardCount != 0" class="border-t border-gray-200 dark:border-gray-700">
            <div class="bg-20 rounded-b-lg" per-page="25">
              <nav class="flex justify-between items-center">
                <!-- Previous Link --><button
                  disabled=""
                  class="
                    text-xs
                    font-bold
                    py-3
                    px-4
                    focus:outline-none
                    rounded-bl-lg
                    focus:ring focus:ring-inset
                    text-gray-300
                    dark:text-gray-600
                  "
                  rel="prev"
                  dusk="previous"
                >
                  Previous</button
                ><span class="text-xs px-4">1-{{scorecardCount}} of {{scorecardCount}}</span
                ><!-- Next Link --><button
                  disabled=""
                  class="
                    text-xs
                    font-bold
                    py-3
                    px-4
                    focus:outline-none
                    rounded-br-lg
                    focus:ring focus:ring-inset
                    text-gray-300
                    dark:text-gray-600
                  "
                  rel="next"
                  dusk="next"
                >
                  Next
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </Card>
    <Modal
      :show="showView"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
      >
        <ModalHeader v-text="__('View Scorecard')" />
        <ModalContent>
          <h1>Phrases:</h1>
          <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
            <span
              class="
                inline-flex
                items-center
                whitespace-nowrap
                h-6
                px-2
                rounded-full
                uppercase
                text-xs
                font-bold
                mt-2
                ml-2
              "
              :class="{'badge-danger' : phrase.flag_type == 0, 'badge-info' : phrase.flag_type == 1, 'badge-success' : phrase.flag_type == 2, 'badge-warning' : phrase.flag_type == 3}"
              v-for="phrase in phrases"
              :key="phrase.id"
              >{{ phrase.title }}</span
            >
          </div>

          <br />
          <h1>Add Phrase:</h1>
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
                for="title-create-phrase-text-field"
                class="inline-block pt-2 leading-tight"
                >Phrase
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <input
                type="text"
                placeholder="Phrase"
                class="w-full form-control form-input form-input-bordered"
                id="title-create-phrase-text-field"
                dusk="title"
                list="title-list"
                v-model="phrase"
              /><!--v-if--><!--v-if--><!--v-if-->
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
            index="3"
          >
            <div class="px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label
                for="flag_type-create-phrase-select-field"
                class="inline-block pt-2 leading-tight"
                >Flag Type
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <!-- Search Input --><!-- Select Input Field -->
              <div class="flex relative w-full">
                <select
                  id="flag_type"
                  dusk="flag_type"
                  class="
                    w-full
                    block
                    form-control form-select form-select-bordered
                  "
                  v-model="flagType"
                >
                  <option disabled="" value="">Choose an option</option>
                  <option value="0">Banned</option>
                  <option value="1">Required</option>
                  <option value="2">Good</option>
                  <option value="3">NSFW</option></select
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
              <!--v-if--><!--v-if-->
            </div>
          </div>
          <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
            <button
              size="lg"
              align="center"
              component="button"
              dusk="update-button"
              class="
                shadow
                relative
                bg-primary-500
                hover:bg-primary-400
                text-white
                dark:text-gray-900
                cursor-pointer
                rounded
                text-sm
                font-bold
                focus:outline-none focus:ring
                ring-primary-200
                dark:ring-gray-600
                inline-flex
                items-center
                justify-center
                h-9
                px-3
                shadow
                relative
                bg-primary-500
                hover:bg-primary-400
                text-white
                dark:text-gray-900
              "
              @click.prevent="savePhrase"
            >
              <span class="">Add Phrase</span
              ><!--v-if-->
            </button>
          </div>
        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="showView = false"
              class="mr-3"
            >
              {{ __("Cancel") }}
            </LinkButton>
          </div>
        </ModalFooter>
      </div>
    </Modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      scorecards: [],
      scorecard: null,
      scorecardCount: 0,
      showView: false,
      phrase: null,
      phrases: [],
      flagType: null,
    };
  },
  mounted() {
    //
    this.getScorecard();
  },
  methods: {
    async getPhrases() {
      await Nova.request()
        .get("/nova-api/custom/phrases/" + this.scorecard.id)
        .then(async (res) => {
          if (res.data.status) {
            this.phrases = [];
            this.phrases = res.data.phrases;
          }
        });
    },
    async savePhrase() {
      if (this.phrase) {
        await Nova.request()
          .post("/nova-api/custom/phrase/save", {
            phrase: this.phrase,
            flagType: this.flagType,
            scorecard: this.scorecard.id,
          })
          .then(async (res) => {
            if (res.data.status) {
              Nova.success("Phrase Added Successfully");
              this.getPhrases();
            } else {
              Nova.error(res.data.message);
            }
          });
      }
    },
    viewScorecard(scorecard) {
      this.scorecard = scorecard;
      this.getPhrases();
      this.showView = true;
    },

    async getScorecard() {
      await Nova.request()
        .get("/nova-api/custom/scorecards")
        .then(async (res) => {
          if (res.data.status) {
            this.scorecards = res.data.scorecards;
            this.scorecardCount = this.scorecards.length;
          }
          console.log(this.scorecardCount);
          console.log(this.scorecards);
        });
    },
  },
};
</script>

<style>
/* Scoped Styles */
</style>
