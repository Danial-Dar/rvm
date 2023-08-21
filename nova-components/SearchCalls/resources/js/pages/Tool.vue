<template>
  <div>
    <Head title="Search Calls" />

    <Heading class="mb-6">Filters</Heading>
    <Card style="min-height: 100px" class="mt-4">
      <!-- <Heading class="pl-2 mt-2">Filters</Heading> -->

      <div class="flex-container flex-start">
        <!-- <div class="flex-item relative">
          <select
            id=""
            class="w-full block form-control form-select form-select-bordered"
            v-model="selectedFilters.groups"
            @change="updateFilter"
          >
            <option selected value="">Select Group</option>
            <option
              v-for="group in filters.groups"
              :key="group.id"
              :value="group.id"
            >
              {{ group.name }}
            </option>
          </select>
          <svg
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
        </div> -->

        <div class="flex-item relative">
          <select
            id=""
            class="w-full block form-control form-select form-select-bordered"
            v-model="selectedFilters.agents"
            @change="updateFilter"
          >
            <option selected value="">Select Agent</option>
            <option
              v-for="agent in filters.agents"
              :key="agent.id"
              :value="agent.id"
            >
              {{ agent.first_name + " " + agent.last_name }}
            </option>
          </select>
          <svg
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

        <!-- <div class="flex-item relative">
          <select
            id=""
            class="w-full block form-control form-select form-select-bordered"
            v-model="selectedFilters.scorecards"
            @change="updateFilter"
          >
            <option selected value="">Select Scorecard</option>
            <option
              v-for="scorecard in filters.scorecards"
              :key="scorecard.id"
              :value="scorecard.id"
            >
              {{ scorecard.name }}
            </option>
          </select>
          <svg
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
        </div> -->

        <!-- <div class="flex-item relative">
          <select
            id=""
            class="w-full block form-control form-select form-select-bordered"
            v-model="selectedFilters.phrases"
            @change="updateFilter"
          >
            <option selected value="">Select Phrase</option>
            <option
              v-for="phrase in filters.phrases"
              :key="phrase.id"
              :value="phrase.id"
            >
              {{ phrase.title }}
            </option>
          </select>
          <svg
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
        </div> -->

        <div class="flex-item relative">
          <input
            type="text"
            placeholder="Phone Number"
            class="w-full form-control form-input form-input-bordered"
            id="name-create-campaign-text-field"
            dusk="name"
            list="name-list"
          />
        </div>
        <div class="flex-item relative">
          <div class="flex-shrink-0 ml-auto pr-2">
            <button
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
              @click="reset"
            >
              Reset
            </button>
          </div>
        </div>
      </div>

      <!-- <Heading class="pl-2 mt-2">Human review</Heading> -->

      <div class="flex-container flex-start">
        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="transcribed"
                type="checkbox"
                v-model="selectedFilters.transcribed"
                @change="updateFilter2('transcribed')"
              /><span class="mlbz-radio-label">Transcribed</span></label
            >
          </div>
        </div>

        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="processed"
                type="checkbox"
                v-model="selectedFilters.processed"
                @change="updateFilter2('processed')"
              /><span class="mlbz-radio-label">Processed</span></label
            >
          </div>
        </div>

        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="pending"
                v-model="selectedFilters.pending"
                @change="updateFilter2('pending')"
                type="checkbox"
              /><span class="mlbz-radio-label">Pending</span></label
            >
          </div>
        </div>

        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="flagged"
                type="checkbox"
                v-model="selectedFilters.flagged"
                @change="updateFilter2('flagged')"
              /><span class="mlbz-radio-label">Flagged</span></label
            >
          </div>
        </div>

        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="type"
                type="checkbox"
                v-model="selectedFilters.reviewed"
                @change="updateFilter"
              /><span class="mlbz-radio-label">Reviewed</span></label
            >
          </div>
        </div>

        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="type"
                type="checkbox"
                v-model="selectedFilters.valid"
                @change="updateFilter2('valid')"
              /><span class="mlbz-radio-label">Valid</span></label
            >
          </div>
        </div>

        <div class="flex-item relative">
          <div>
            <label for="type"
              ><input
                name="type"
                type="checkbox"
                v-model="selectedFilters.invalid"
                @change="updateFilter2('invalid')"
              /><span class="mlbz-radio-label">Invalid</span></label
            >
          </div>
        </div>
      </div>
    </Card>

    <div class="w-full flex items-center mb-6">
      <Heading class="mb-6 mt-6">Search Calls</Heading>

      <!-- Create / Attach Button -->
      <div class="ml-auto flex items-center">
        <div>
          <div class="flex-shrink-0 ml-auto pr-2">
            <button
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
              @click="show = true"
            >
              Add Call
            </button>
          </div>
          <!--teleport start-->
          <!--teleport end-->
        </div>
        <!--v-if-->
        <!--v-if-->
      </div>
    </div>
    <Card
      v-for="call in calls"
      :key="call.id"
      style="min-height: 100px"
      class="mt-4"
    >
    <a href="" v-on:click.prevent="changeButton(call.id)">
      <table
        id="secondTable"
        style="
          font-family: 'Open Sans', sans-serif;
          width: 100%;
          margin: 10px 10px 0 10px;
        "
      >
        <thead>
          <tr>
            <th style="padding: 8px; min-width: 30px; text-align: left">
              SESSION ID: {{ call.id }}
            </th>
            <th style="padding: 8px; min-width: 30px; text-align: left">
              CALL DATE: {{ call.created_at }}
            </th>
            <th style="padding: 8px; min-width: 30px; text-align: left">
              CALL STATUS:
              <span
                v-if="call.status === 'success'"
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
                  badge-success
                "
                >{{ call.status }}</span
              >
              <span
                v-if="call.status === 'processed'"
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
                  badge-info
                "
                >{{ call.status }}</span
              >
              <span
                v-if="call.status === 'pending'"
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
                  badge-warning
                "
                >{{ call.status }}</span
              >
              <span
                v-if="call.status === 'flagged'"
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
                  badge-danger
                "
                >{{ call.status }}</span
              >
            </th>
          </tr>
          <tr>
            <th style="padding: 8px; min-width: 30px; text-align: left">
              AGENT: {{ call.agent.first_name }} {{ call.agent.last_name }}
            </th>
            <!-- <th style="padding: 8px;min-width: 30px;text-align: left;">SCORECARD: {{ call.scorecard.name }}</th> -->
            <th style="padding: 8px; min-width: 30px; text-align: left">
              CALL DURATION:
              {{ call.length != null ? call.length : "00:00:00" }}
            </th>
          </tr>
          <tr>
            <th style="padding: 8px; min-width: 30px; text-align: left">
              PHONE: {{ call.phone_number != null ? call.phone_number : "N/A" }}
            </th>
            <th style="padding: 8px; min-width: 30px; text-align: left">
              SILENCE: {{ call.silence != null ? call.silence : "N/A" }}
            </th>
            <!-- <th style="padding: 8px;min-width: 30px;">CALL DURATION: {{ call.length != null ? call.length : '00:00:00' }} </th> -->
          </tr>
          <tr>
            <th></th>
          </tr>
        </thead>
      </table>
      </a>
      <div class="flex-container flex-center dark-bg">
        <div class="flex-item lightskyblue">
          NSFW:
          {{ call.nsfw_count != null ? call.nsfw : 0 }}
        </div>
        <div class="flex-item orangered">
          BANNED: {{ call.banned_count != null ? call.banned_count : 0 }}
        </div>

        <div class="flex-item lime">
          GOOD:
          {{ call.positive_count != null ? call.positive_count : 0 }}
        </div>
        <div class="flex-item lightcoral">
          REQUIRED:
          {{ call.req_found_count != null ? call.req_found_count : 0 }}
        </div>
        <div class="flex-item" v-if="call.status == 'flagged'">
          <svg  xmlns="http://www.w3.org/2000/svg" style="color: red; fill:red" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
          </svg>
        </div>
        <div class="flex-item">
          <audio id="recordingPlay" controls>
            <source
              :src="
                'https://rvm.nyc3.digitaloceanspaces.com/RVM/' + call.filename
              "
              type="audio/wav"
            />
          </audio>
        </div>

        <div class="flex-item">
          <a
            aria-label="View"
            data-testid="audio-items-0-view-button"
            dusk="3-view-button"
            class="hover:text-primary-500 v-popper--has-tooltip"
            v-if="call.status === 'success'"
            @click.stop="loadChat(call.id)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              width="24"
              class="inline-block v-popper--has-tooltip"
              role="presentation"
              data-v-0c784995=""
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
              ></path>
            </svg>
          </a>
        </div>
      </div>
    </Card>

    <Modal
      :show="showChatModal"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 660px"
      >
        <ModalHeader v-text="__('Call Text')" />
        <ModalContent>
            <section ref="chatArea" class="chat-area">
                <p v-for="message in messages" :key="message.speaker" class="message-chat-modal" :class="{ 'message-out': message.speaker === 'B', 'message-in': message.speaker === 'A' }">
                {{ message.text }}
                </p>
            </section>
        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="showChatModal = false"
              class="mr-3"
            >
              {{ __("Cancel") }}
            </LinkButton>
          </div>
        </ModalFooter>
    </div>
    </Modal>

    <Modal
      :show="show"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 660px"
      >
        <ModalHeader v-text="__('Add Call')" />
        <ModalContent>
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
                for="agent-create-audio-belongs-to-field"
                class="inline-block pt-2 leading-tight"
                >Agent
                <span class="text-red-500 text-sm" style="color: red"
                  >*</span
                ></label
              >
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <div class="flex items-center">
                <!--v-if-->
                <div class="flex relative w-full">
                  <select
                    data-testid="agents-select"
                    dusk="agent"
                    class="
                      w-full
                      block
                      form-control form-select form-select-bordered
                    "
                    v-model="addCall.agent_id"
                    @change="errors.agent_id = null"
                  >
                    <option disabled="" value="">—</option>
                    <option
                      v-for="agent in filters.agents"
                      :key="agent.id"
                      :value="agent.id"
                    >
                      {{ agent.first_name + " " + agent.last_name }}
                    </option>
                  </select>
                  <svg
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
                <!--v-if-->
              </div>
              <p v-if="errors.agent_id" style="color: red">
                {{ errors.agent_id }}
              </p>

              <!--teleport start-->
              <!--teleport end-->
              <!--v-if-->
              <!--v-if-->
              <!--v-if-->
            </div>
          </div>
          <!-- <div
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
                for="agent-create-audio-belongs-to-field"
                class="inline-block pt-2 leading-tight"
                >Scorecard
                <span class="text-red-500 text-sm" style="color: red"
                  >*</span
                ></label
              >
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <div class="flex items-center">
                <div class="flex relative w-full">
                  <select
                    data-testid="agents-select"
                    dusk="agent"
                    class="
                      w-full
                      block
                      form-control form-select form-select-bordered
                    "
                    v-model="addCall.scorecard_id"
                    @change="errors.scorecard_id = null"
                  >
                    <option disabled="" value="">—</option>
                    <option
                      v-for="scorecard in filters.scorecards"
                      :key="scorecard.id"
                      :value="scorecard.id"
                    >
                      {{ scorecard.name }}
                    </option>
                  </select>
                  <svg
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
              </div>
              <p v-if="errors.scorecard_id" style="color: red">
                {{ errors.scorecard_id }}
              </p>
            </div>
          </div> -->

          <div
            class="
              field-wrapper
              flex flex-col
              border-b border-gray-100
              dark:border-gray-700
              md:flex-row
            "
            index="2"
          >
            <div class="px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label
                for="file-audio-upload_audio"
                class="inline-block pt-2 leading-tight"
                >Upload Call
                <span class="text-red-500 text-sm" style="color: red"
                  >*</span
                ></label
              >
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <!--v-if-->
              <!--v-if--><span class="form-file mr-4"
                ><input
                  dusk="upload_audio"
                  class="form-file-input select-none"
                  type="file"
                  id="file-audio-upload_audio"
                  name="name"
                  @change="fileChange"
                /><label
                  for="file-audio-upload_audio"
                  class="
                    cursor-pointer
                    focus:outline-none focus:ring
                    rounded
                    border-2 border-primary-300
                    dark:border-gray-500
                    hover:border-primary-500
                    active:border-primary-400
                    dark:hover:border-gray-400 dark:active:border-gray-300
                    bg-white
                    dark:bg-transparent
                    text-primary-500
                    dark:text-gray-400
                    px-3
                    h-9
                    inline-flex
                    items-center
                    font-bold
                    flex-shrink-0
                  "
                  ><span>Choose File</span></label
                ></span
              ><span
                class="text-90 text-sm select-none"
                v-if="errors.file == null"
                >{{ currentLabel ? currentLabel : "no file selected" }}</span
              ><span class="" style="color: red" v-if="errors.file">{{
                errors.file
              }}</span>
            </div>
          </div>

          <!-- file field end -->

          <!-- status field start -->
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
                for="status-create-audio-select-field"
                class="inline-block pt-2 leading-tight"
                >Status
                <!--v-if-->
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
              <!-- Search Input -->
              <!-- Select Input Field -->
              <div class="flex relative w-full">
                <select
                  id="status"
                  dusk="status"
                  disabled=""
                  class="
                    w-full
                    block
                    form-control form-select form-select-bordered
                  "
                >
                  <option disabled="" value="">Choose an option</option>
                  <option value="pending">Pending</option>
                  <option value="success">Success</option>
                  <option value="failed">Failed</option></select
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
              <!--v-if-->
              <!--v-if-->
            </div>
          </div>
          <!-- status field end -->
        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="show = false"
              class="mr-3"
            >
              {{ __("Cancel") }}
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
              @click.prevent="submit"
            >
              Create
            </div>
          </div>
        </ModalFooter>
      </div>
    </Modal>
    <Modal
      :show="showChat"
      data-testid="conversation-modal"
      role="alertdialog"
      style="padding-right: 20rem; height:80vh; overflow:auto"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 900px"
      >
        <ModalHeader v-text="__('Conversation Report')" />
        <ModalContent>
          <div>
            <div class="container2">
              <div class="row clearfix">
                <div class="col-lg-12">
                  <div class="chat-app">
                    <div class="chat">
                      <div class="chat-history">
                        <ul class="m-b-0">
                          <!-- <li class="clearfix">
                            <div class="message-data text-right">
                              <span class="message-data-time"
                                >10:10 AM, Today</span
                              >
                            </div>
                            <div class="message other-message float-right">
                              Hi Aiden, how are you? How is the project coming
                              along?
                            </div>
                          </li> -->
                          <li class="clearfix">
                          <!-- <li class="clearfix" v-for="chat in chatData" :key="chat.time"> -->
                            <!-- <div class="message-data">
                              <span class="message-data-time"
                                >{{chat.time.split(':')[0]  + 's to '+ chat.time.split(':')[1] + 's' }}</span
                              >
                            </div>
                            <div class="message my-message">
                              {{chat.text}}
                            </div> -->
                            <section ref="chatArea" class="chat-area">
                                <div v-for="message in chatData" :key="message.speaker">
                                    <p class="message-chat-modal mb-1" :class="{ 'message-out': message.speaker !== 'A', 'message-in': message.speaker !== 'B' }">
                                        {{ message.text }}

                                        <template v-if="message.sentiment == 'NEGATIVE'">
                                            <span :class="{ 'emoji-out': message.speaker !== 'A', 'emoji-in': message.speaker !== 'B' }">
                                                🙁
                                            </span>
                                        </template>
                                        <template v-if="message.sentiment == 'POSITIVE'">
                                            <span :class="{ 'emoji-out': message.speaker !== 'A', 'emoji-in': message.speaker !== 'B' }">
                                                ❤️
                                            </span>
                                        </template>
                                    </p>
                                </div>

                            </section>
                          </li>


                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div>
            <h1>QA REPORT:</h1>
            <div class="flex-container-report">
              <div class="item1-report">
                <p>
                  Department:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{
                      audio.agent.topic
                        ? audio.agent.topic.department.name
                        : "ssa"
                    }}</span
                  >
                </p>
                <p>
                  Topic:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{ audio.agent.topic
                        ? audio.agent.topic.title
                        : "ssa" }}</span
                  >
                </p>
                <p>
                  Agent:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{ audio.agent.first_name }}
                    {{ audio.agent.last_name }}</span
                  >
                </p>
                <p>
                  Scorecard:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{ audio.scorecard ? audio.scorecard.name : "sas" }}</span
                  >
                </p>
              </div>
              <div class="item2-report">
                <p>
                  Duration:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{
                      audio.length != null ? audio.length : "00:00:00"
                    }}</span
                  >
                </p>
                <p>
                  Occurences of NSFW:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{
                      audio.nsfw_count != null ? audio.nsfw_count : "00"
                    }}</span
                  >
                </p>
                <p>
                  Occurences of Banned:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{
                      audio.positive_count != null ? audio.positive_count : "00"
                    }}</span
                  >
                </p>
                <p>
                  Occurences of Good:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{
                      audio.positive_count != null ? audio.positive_count : "00"
                    }}</span
                  >
                </p>
                <p>
                  Occurences of Required:
                  <span
                    class="
                      inline-flex
                      items-center
                      whitespace-nowrap
                      h-6
                      px-2
                      m-2
                      rounded-full
                      uppercase
                      text-xs
                      font-bold
                      badge-success
                    "
                    >{{
                      audio.req_found_count != null ? audio.req_found_count : "00"
                    }}</span
                  >
                </p>
              </div>
            </div>
          </div> -->

          <!-- <div>
            <h1 class="h pt-6">Previous Notes:</h1>

            <div class="flex-container-report chat" style="overflow:auto; height:200px;">
              <div class="item1-report">
                <div v-if="notes">
                  <div class="chat-history">
                    <ol start="1">
                      <li v-for="note in notes" :key="note.id" class="clearfix">
                        <div class="message-data">
                          <span class="message-data-time">{{ note.created_at.split('T')[0]}}, by  {{ note.user.first_name + ' ' + note.user.last_name }}</span>
                        </div>
                        <div class="message my-message">* {{ note.body }}</div>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>

            <h1 class="h mt-6">Add Notes:</h1>
            <div class="flex-container-report">
              <div class="item1-report">
                <textarea
                  name=""
                  id=""
                  cols="100"
                  rows="3"
                  style="background: #f2f2f2"
                  v-model="noteNew"
                ></textarea>
              </div>
            </div>
          </div> -->
          <!-- <div>
            <button
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
                px-6
                mb-4
                h-9
                text-sm
              "
              @click="saveNote()"
            >
              Save
            </button>
          </div> -->
          <!-- <h1 class="h">Play Audio:</h1> -->

          <!-- <div class="flex-container-report">
            <div class="item1-report" style="width: 80%">
              <audio id="recordingPlay" controls style="width: 80%">
                <source
                  :src="
                    'https://rvm.nyc3.digitaloceanspaces.com/RVM/' +
                    audio.filename
                  "
                  type="audio/wav"
                />
              </audio>
            </div>
            <div class="item1-report" v-if="audio.bad_calls == true">

            </div>
          </div> -->

          </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="showChat = false"
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
      type: "all",
      show: false,
      showChat: false,
      chatData: [],
      noteNew: "",
      callId: null,
      addNote: false,
      topics: null,
      scorecards: null,
      notes: null,
      audioPath: null,
      showCalls: false,
      calls: [],
      audio: [],
      addCall: {
        agent_id: null,
        scorecard_id: null,
        file: null,
      },
      currentLabel: null,
      filters: {
        groups: null,
        agents: null,
        topics: null,
        scorecards: null,
        phrases: null,
        phoneNumber: null,
        transcribed: false,
        flagged: false,
        pending: false,
        reviewed: false,
        valid: false,
        invalid: false,
        processed: false,
      },
      selectedFilters: {
        groups: "",
        agents: "",
        topics: "",
        scorecards: "",
        phrases: "",
        phoneNumber: null,
        transcribed: false,
        flagged: false,
        pending: false,
        reviewed: false,
        valid: false,
        invalid: false,
        processed: false,
      },
      errors: {
        agent_id: null,
        scorecard_id: null,
        file: null,
      },
      showChatModal: false,
      messages: [],
      reportMessages: []
    };
  },
  mounted() {
    this.getFilters();
    this.getCalls();
  },
  methods: {
    async changeButton(value)
    {
        console.log(value);
        await Nova.request()
        .get("/nova-api/custom/qa-call/" + value)
        .then((res) => {
          console.log(JSON.parse(res.data.call.json_data));
          this.messages = JSON.parse(res.data.call.json_data);
          this.speakerFirst = this.messages[0].speaker[0];
          console.log(this.speakerFirst);
          console.log(res.data.call.status);
          if (res.data.call.status == "success") {
            this.showChatModal = true;
          } else {
            this.showChatModal = false;
          }

          console.log(this.showChatModal);
        });
    },
    async saveNote() {
      console.log(this.noteNew);
      if (this.noteNew.length > 0) {
        await Nova.request()
          .post("/nova-api/audio/notes/store", {
            note: this.noteNew,
            call_id: this.callId,
          })
          .then((res) => {
            if (!res.data.success) {
              Nova.error(res.data.message);
            } else {
              Nova.success("Note Added Successfully");
              Nova.visit("/search-calls", { remote: false });
            }
          });
      } else {
        Nova.error("Note field is empty");
      }
    },
    fileChange(event) {
      this.addCall.file = event.target.files[0];
      this.currentLabel = this.addCall.file.name;
      this.errors.file = null;
    },
    async loadChat(id) {
      console.log(
        "?????????????????????????????????????????????????????????????????????????????"
      );
      this.callId = id;
      await Nova.request()
        .get("/nova-api/custom/audio/" + id)
        .then((res) => {
          console.log(res.data);
          this.chatData = res.data.chatData;
          this.scorecards = res.data.scorecards;
          this.notes = res.data.notes;
          this.audioPath =
            "https://rvm.nyc3.digitaloceanspaces.com/RVM/" + res.data.filename;
          this.audio = res.data.audio;
        });

      this.showChat = true;
    },
    async reset() {
      this.showCalls = false;
      await this.getCalls();
      this.selectedFilters.topics = "";
      this.selectedFilters.scorecards = "";
      this.selectedFilters.groups = "";
      this.selectedFilters.agents = "";
      this.selectedFilters.phrases = "";
      this.selectedFilters.pending = "";
      this.selectedFilters.transcribed = "";
      this.selectedFilters.flagged = "";
      this.selectedFilters.reviewed = "";
      this.selectedFilters.valid = "";
      this.selectedFilters.invalid = "";
      this.selectedFilters.processed = "";
      Nova.success("Filters Reset Successfully");
    },
    updateFilter2(e) {
      console.log(e);
      if (e == "transcribed") {
        this.selectedFilters.pending = "";
        this.selectedFilters.flagged = "";
        this.selectedFilters.processed = "";
      } else if (e == "pending") {
        this.selectedFilters.transcribed = "";
        this.selectedFilters.flagged = "";
        this.selectedFilters.processed = "";
      } else if (e == "flagged") {
        this.selectedFilters.pending = "";
        this.selectedFilters.transcribed = "";
        this.selectedFilters.processed = "";
      } else if (e == "processed") {
        this.selectedFilters.pending = "";
        this.selectedFilters.transcribed = "";
        this.selectedFilters.flagged = "";
      }

      if (e == "valid") {
        this.selectedFilters.invalid = "";
      } else if (e == "invalid") {
        this.selectedFilters.valid = "";
      }
      this.updateFilter();
    },
    async updateFilter() {
      await Nova.request()
        .post("/nova-api/audio/filters/" + this.type, this.selectedFilters)
        .then((res) => {
          if (!res.data.success) {
            Nova.error(res.data.message);
          } else {
            this.calls = null;
            Nova.success("Filter Applied");

            this.calls = res.data.calls;
            console.log(this.calls);
          }
        });
    },

    async submit() {
      console.log(this.addCall.agent_id);
      console.log(this.addCall.scorecard_id);
      console.log(this.addCall.file);
      if (this.addCall.agent_id === null)
        this.errors.agent_id = "Please Select Agent";
      if (this.addCall.scorecard_id === null)
        this.errors.scorecard_id = "Please Select Scorecard";
      if (this.addCall.file === null) this.errors.file = "Please Select File";
      if (this.addCall.file.type !== "audio/wav")
        this.errors.file = "File type must be wav";

      if (
        this.addCall.agent_id == null ||
        this.addCall.scorecard_id === null ||
        this.addCall.file === null
      ) {
        return;
      }

      if (this.addCall.file.type !== "audio/wav") {
        return;
      }

      this.errors.agent_id = null;
      this.errors.scorecard_id = null;
      this.errors.file = null;

      let formData = new FormData();
      formData.append("agent_id", this.addCall.agent_id);
      formData.append("scorecard_id", this.addCall.scorecard_id);
      formData.append("file", this.addCall.file);

      await Nova.request()
        .post("/nova-api/audio/create", formData)
        .then((res) => {
          if (!res.data.success) {
            Nova.error(res.data.message);
          } else {
            Nova.success("Call Added Successfully");
            Nova.visit("/search-calls", { remote: false });
          }
        });
    },
    async getFilters() {
      // alert('Hello')
      await Nova.request()
        .get("/nova-api/audio/filters")
        .then(async (res) => {
          if (res.data.success) {
            this.filters.groups = res.data.groups;
            this.filters.agents = res.data.agents;
            this.filters.scorecards = res.data.scorecards;
            this.filters.phrases = res.data.phrases;

            console.log("filters", this.filters);
          }
        });
    },
    async getCalls() {
      await Nova.request()
        .get("/nova-api/audio/type/" + this.type)
        .then(async (res) => {
          if (res.data.calls) {
            this.calls = res.data.calls;
            this.showCalls = true;
          }
          console.log(this.calls);
        });
    },
  },
};
</script>

<style scoped  >
/* Scoped Styles */
.flex-container {
  padding: 0;
  margin: 0;
  list-style: none;
  display: flex;
}
.chat-area {
/*   border: 1px solid #ccc; */
  background: white;
  height: 50vh;
  padding: 0px;
  overflow: auto;
  /* max-width: 350px; */
  margin: 0 auto 2em auto;
}
.message-chat-modal {
  width: 45%;
  border-radius: 10px;
  padding: .5em;
/*   margin-bottom: .5em; */
  font-size: .8em;
}
.message-out {
  background: #407FFF;
  color: white;
  margin-left: 50%;
  position: relative;
}
.div2{


margin: 10px;
opacity: 0.7;
}
.message-in {
  background: #F1F0F0;
  color: black;
  position: relative;
}
.emoji-out {
    z-index: 1;
    margin-left: 55%;
    position: absolute;
    bottom: -13px;
    right: 5px;
}
.emoji-in {
    z-index: 1;
    margin-left: 55%;
    position: absolute;
    bottom: -13px;
    right: 5px;
}
/* .emoji-in {
  background: #F1F0F0;
  color: black;
} */
.space-between {
  justify-content: space-between;
}

.flex-start {
  justify-content: flex-start;
}

.flex-center {
  justify-content: center;
}

.flex-item {
  margin: 5px;
  color: rgb(108, 107, 107);
}

span {
  font-size: 13px;
  font-weight: bold;
  color: currentColor;
  font-style: normal;
  text-decoration: none;
  line-height: 2em;
  letter-spacing: 0px;
}

.orangered {
  color: orangered;
}

.lightskyblue {
  color: lightskyblue;
}

.lime {
  color: lime;
}

.lightcoral {
  color: lightcoral;
}

.dark-bg {
  background: rgb(240, 239, 239);
}

audio {
  width: 300px;
  height: 24px;
}

/* new design */

.bg {
  background: #b4daef;
}

* {
  outline: 0;
}

.time {
  text-align: center;
  margin-bottom: 10px;
}

.time span {
  background-color: #000000;
  display: inline-block;
  border-radius: 3px;
  text-align: center;
  padding: 2px 20px;
  color: #fff;
  opacity: 0.3;
}

.message {
  margin-bottom: 10px;
}

.message .messageText {
  text-align: left;
  color: #ffffff;
}

.message.sol {
  text-align: left;
}

.message.sag {
  text-align: right;
}

.message .resim {
  background: #ff0044 none no-repeat center;
  vertical-align: text-top;
  background-size: cover;
  display: inline-block;
  position: relative;
  color: #ffffff;
  height: 40px;
  width: 40px;
}

.message .messageText {
  background-color: #0a74a3;
  vertical-align: text-top;
  display: inline-block;
  position: relative;
  line-height: 20px;
  max-width: 165px;
  color: #ffffff;
  padding: 10px;
}

.message.left .userPortrait,
.message.sag .messageText {
  border-radius: 5px 0 0 5px;
}

.message.sag .userPortrait,
.message.sol .messageText {
  border-radius: 0 5px 5px 0;
}

.message.mtLine.sol .messageText {
  border-radius: 0 5px 5px 0;
}

.message.mtLine.sag .messageText {
  border-radius: 5px 0 0 5px;
}

.message .messageText:before {
  border-color: transparent #0a74a3;
  border-style: solid;
  position: absolute;
  border-width: 0;
  display: block;
  content: "";
  z-index: 1;
}

.message.sol .messageText:before {
  border-width: 0 10px 10px 0;
  left: -10px;
  top: 0;
}

.message.sag .messageText:before {
  border-width: 10px 0 0 10px;
  right: -10px;
  top: 30px;
}

.message .messageText:after {
  content: attr(data-time);
  color: rgba(255, 255, 255, 0.5);
  position: absolute;
  line-height: 20px;
  display: block;
  bottom: 2px;
  font-weight: 700;
  z-index: 1;
}

.message.sol .messageText:after {
  margin-left: 5px;
  left: 100%;
}

.message.sag .messageText:after {
  margin-right: 5px;
  right: 100%;
}

.topic-bg {
  border-bottom: 3px dotted #0a74a3;
}

.h {
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.em {
  float: left;
}

/* chat box new design */
.card {
  background: #fff;
  transition: 0.5s;
  border: 0;
  margin-bottom: 30px;
  border-radius: 0.55rem;
  position: relative;
  width: 100%;
  box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
}
.chat-app .people-list {
  width: 280px;
  position: absolute;
  left: 0;
  top: 0;
  padding: 20px;
  z-index: 7;
}

.chat-app .chat {
}

.people-list {
  -moz-transition: 0.5s;
  -o-transition: 0.5s;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.people-list .chat-list li {
  padding: 10px 15px;
  list-style: none;
  border-radius: 3px;
}

.people-list .chat-list li:hover {
  background: #efefef;
  cursor: pointer;
}

.people-list .chat-list li.active {
  background: #efefef;
}

.people-list .chat-list li .name {
  font-size: 15px;
}

.people-list .chat-list img {
  width: 45px;
  border-radius: 50%;
}

.people-list img {
  float: left;
  border-radius: 50%;
}

.people-list .about {
  float: left;
  padding-left: 8px;
}

.people-list .status {
  color: #999;
  font-size: 13px;
}

.chat {
  width: 100%;
}
.chat .chat-header {
  padding: 15px 20px;
  border-bottom: 2px solid #f4f7f6;
}

.chat .chat-header img {
  float: left;
  border-radius: 40px;
  width: 40px;
}

.chat .chat-header .chat-about {
  float: left;
  padding-left: 10px;
}

.chat .chat-history {
  border-bottom: 2px solid #fff;
}

.chat .chat-history ul {
  padding: 0;
}

.chat .chat-history ul li {
  list-style: none;
  margin-bottom: 30px;
}

.chat .chat-history ul li:last-child {
  margin-bottom: 0px;
}

.chat .chat-history .message-data {
  margin-bottom: 15px;
}

.chat .chat-history .message-data img {
  border-radius: 40px;
  width: 40px;
}

.chat .chat-history .message-data-time {
  color: #434651;
  padding-left: 6px;
}

.chat .chat-history .message {
  color: #444;
  padding: 18px 20px;
  line-height: 26px;
  font-size: 16px;
  border-radius: 7px;
  display: inline-block;
  position: relative;
}

.chat .chat-history .message:after {
  bottom: 100%;
  left: 7%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-bottom-color: #fff;
  border-width: 10px;
  margin-left: -10px;
}

.chat .chat-history .my-message {
  background: #efefef;
}

.chat .chat-history .my-message:after {
  bottom: 100%;
  left: 30px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-bottom-color: #efefef;
  border-width: 10px;
  margin-left: -10px;
}

.chat .chat-history .other-message {
  background: #e8f1f3;
  text-align: right;
}

.chat .chat-history .other-message:after {
  border-bottom-color: #e8f1f3;
  left: 93%;
}

.chat .chat-message {
  padding: 20px;
}

.online,
.offline,
.me {
  margin-right: 2px;
  font-size: 8px;
  vertical-align: middle;
}

.online {
  color: #86c541;
}

.offline {
  color: #e47297;
}

.me {
  color: #1d8ecd;
}

.float-right {
  float: right;
}

.clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}

@media only screen and (max-width: 767px) {
  .chat-app .people-list {
    height: 465px;
    width: 100%;
    overflow-x: auto;
    background: #fff;
    left: -400px;
    display: none;
  }
  .chat-app .people-list.open {
    left: 0;
  }
  .chat-app .chat {
    margin: 0;
  }
  .chat-app .chat .chat-header {
    border-radius: 0.55rem 0.55rem 0 0;
  }
  .chat-app .chat-history {
    height: 300px;
    overflow-x: auto;
  }
}

@media only screen and (min-width: 768px) and (max-width: 992px) {
  .chat-app .chat-list {
    height: 650px;
    overflow-x: auto;
  }
  .chat-app .chat-history {
    height: 600px;
    overflow-x: auto;
  }
}

@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
  .chat-app .chat-list {
    height: 480px;
    overflow-x: auto;
  }
  .chat-app .chat-history {
    height: calc(100vh - 350px);
    overflow-x: auto;
  }
}

.flex-container-report {
  display: flex;

  justify-content: space-between;
  align-items: stretch;
  height: 100%;
  padding: 15px;
  gap: 5px;
}

.flex-container-report > div {
  /* border: 1px solid #ffcc80; */
  border-radius: 5px;
  padding: 8px;
}

.item1-report {
  /* flex:1 1 auto; */
  flex-grow: 1;
}

.item2-report {
  /* flex:1 1 auto; */
  flex-grow: 1;
}
</style>
