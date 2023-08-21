<template>
  <div>
    <Head title="Call Flow Step" />

    <form data-form-unique-id="wbkv4rpi4kf" autocomplete="off">
      <div class="mb-8 space-y-4">
        <div>
          <h1 class="text-90 font-normal text-xl md:text-2xl mb-3">
            Create Call Flow Step
          </h1>
          <!--v-if-->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow w-full">
            <div class="w-full" index="0">
              <div
                class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
              >
                <div class="px-8 py-6 w-1/5">
                  <label for="name" class="inline-block pt-2 leading-tight"
                    >Name
                    <!----></label
                  >
                </div>
                <div class="py-6 px-8 w-1/2">
                    <input
                        type="text"
                        class="w-full form-control form-input form-input-bordered"
                        id="name-create-call-flow-step-text-field"
                        v-model="name"
                        placeholder="Name"
                        required
                    />
                  <!-- <input
                    type="text"
                    placeholder="Name"
                    class="w-full form-control form-input form-input-bordered"
                    id="name-create-call-flow-step-text-field"
                    dusk="name"
                    list="name-list"
                  /> -->
                </div>
              </div>
            </div>
            <div class="w-full" index="1">
              <div
                class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
              >
                <div class="px-8 py-6 w-1/5">
                  <label for="callFlow" class="inline-block pt-2 leading-tight"
                    >Call Flow
                  </label>
                </div>
                <div class="py-6 px-8 w-1/2">
                  <div class="flex items-center">


                    <div class="flex relative w-full">
                      <!-- <select
                        data-testid="call-flows-select"
                        dusk="callFlow"
                        class="w-full block form-control form-select form-select-bordered"
                      > -->
                      <select
                        v-model="call_flow_id"
                        placeholder="Select Call Flow"
                        class="w-full block form-control form-select form-select-bordered"
                        required
                      >
                        <option value="" selected>Select Call Flow</option>
                            <option
                                v-for="(call_flow, key) in call_flows"
                                :value="call_flow.id"
                                :key="key"
                            >
                            {{ call_flow.title }}
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
                  <!--teleport start--><!--teleport end--><!--v-if--><!----><!---->
                </div>
              </div>
            </div>
            <div class="w-full" index="2">
              <div
                class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
              >
                <div class="px-8 py-6 w-1/5">
                  <label for="step" class="inline-block pt-2 leading-tight"
                    >Step
                    <!----></label
                  >
                </div>
                <div class="py-6 px-8 w-1/2">
                  <div class="flex relative w-full">
                      <!-- <select
                        data-testid="call-flows-select"
                        dusk="callFlow"
                        class="w-full block form-control form-select form-select-bordered"
                      > -->
                      <select
                        v-model="step"
                        placeholder="Select Call Step"
                        class="w-full block form-control form-select form-select-bordered"
                        required
                      >
                        <option value="" selected>Select Step</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
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
              </div>
            </div>
            <div class="w-full" index="3">
              <div
                class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
              >
                <div class="px-8 py-6 w-1/5">
                  <label
                    for="call_flow_type"
                    class="inline-block pt-2 leading-tight"
                    >Call Flow Type
                  </label
                >
                </div>
                <div class="py-6 px-8 w-1/2">
                  <div class="flex relative w-full">
                    <select
                      v-model="call_flow_type"
                      id="call_flow_type"
                      dusk="call_flow_type"
                      @change="changeCallFlowType"
                      class="w-full block form-control form-select form-select-bordered"
                    >
                      <option disabled="">Choose an option</option>
                      <option value="greeting">Greeting</option>
                      <option value="forward-call">Forward Call</option>
                      <option value="voicemail">Voicemail</option>
                      <option value="multi-ringing">Multi Ringing</option>
                      <option value="call-tree-menu">Call Tree Menu</option>
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
              </div>
            </div>
            <div v-if="greeting_show == true">
                <div class="w-full" index="4">
                    <div
                        class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    >
                        <div class="px-8 py-6 w-1/5">
                            <label
                                for="greeting_flow"
                                class="inline-block pt-2 leading-tight"
                                >Type
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <div class="flex relative w-full">
                                <select
                                v-model="greeting_type"
                                id="greeting_type"
                                dusk="greeting_type"
                                @change="changeGreetingType"
                                class="w-full block form-control form-select form-select-bordered"
                                >
                                <option disabled="">Choose an option</option>
                                <option value="text_to_speech">Text To Speech</option>
                                <option value="play_audio">Play Audio</option>
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
                    </div>
                </div>

                <div class="w-full" index="5" v-if="greeting_text_to_speech_show == true">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="greeting_text_to_speech_message" class="inline-block pt-2 leading-tight">
                                Text To Speech Message
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="greeting_text_to_speech_message"
                                placeholder="Text To Speech Message"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full" index="5" v-if="greeting_play_audio_show == true">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="greeting_audio_file_path" class="inline-block pt-2 leading-tight">
                                Audio File Path
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="greeting_audio_file_path"
                                placeholder="Audio File Path"
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="forward_call_show == true">
                <div class="w-full" index="4">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="forward_call_forward_number" class="inline-block pt-2 leading-tight">
                                Forward Number
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <!-- <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="forward_call_forward_number"
                                placeholder="Forward The Call To a Specific Number"
                                required
                            /> -->
                            <phone-number
                                class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800 form-input-bordered" :value="forward_call_forward_number"  v-model="forward_call_forward_number" id="forward_call_forward_number" required
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full" index="5">
                    <div
                        class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    >
                        <div class="px-8 py-6 w-1/5">
                            <label
                                for="greeting_flow"
                                class="inline-block pt-2 leading-tight"
                                >Wait Time
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <div class="flex relative w-full">
                                <select
                                v-model="forward_call_wait"
                                id="forward_call_wait"
                                dusk="forward_call_wait"
                                class="w-full block form-control form-select form-select-bordered"
                                >
                                <option disabled="">Choose an option</option>
                                <option value="10">10 sec</option>
                                <option value="20">20 sec</option>
                                <option value="30">30 sec</option>
                                <option value="40">40 sec</option>
                                <option value="50">50 sec</option>
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
                    </div>
                </div>
            </div>

            <div v-if="voicemail_show == true">
                <div class="w-full" index="4">
                    <div
                        class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    >
                        <div class="px-8 py-6 w-1/5">
                            <label
                                for="greeting_flow"
                                class="inline-block pt-2 leading-tight"
                                >Type
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <div class="flex relative w-full">
                                <select
                                v-model="voicemail_type"
                                id="voicemail_type"
                                dusk="voicemail_type"
                                @change="changeVoicemailType"
                                class="w-full block form-control form-select form-select-bordered"
                                >
                                <option disabled="">Choose an option</option>
                                <option value="text_to_speech">Text To Speech</option>
                                <option value="play_audio">Play Audio</option>
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
                    </div>
                </div>

                <div class="w-full" index="5" v-if="voicemail_text_to_speech_show == true">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="voicemail_text_to_speech_message" class="inline-block pt-2 leading-tight">
                                Text To Speech Message
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="voicemail_text_to_speech_message"
                                placeholder="Text To Speech Message"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full" index="5" v-if="voicemail_play_audio_show == true">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="voicemail_audio_file_path" class="inline-block pt-2 leading-tight">
                                Audio File Path
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="voicemail_audio_file_path"
                                placeholder="Audio File Path"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full" index="6">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="voicemail_email" class="inline-block pt-2 leading-tight">
                                Notification Email
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="voicemail_email"
                                placeholder="Please Enter Emmail to send notification with a voicemail recording link."
                                required
                            />
                        </div>
                    </div>
                </div>

            </div>

            <div v-if="multi_ringing_show == true">
                <div class="w-full" index="4">
                    <div
                        class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    >
                        <div class="px-8 py-6 w-1/5">
                            <label
                                for="greeting_flow"
                                class="inline-block pt-2 leading-tight"
                                >Type
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <div class="flex relative w-full">
                                <select
                                    v-model="multi_ringing_type"
                                    id="multi_ringing_type"
                                    dusk="multi_ringing_type"
                                    class="w-full block form-control form-select form-select-bordered"
                                >
                                    <option disabled="">Choose an option</option>
                                    <option value="simul-ringing">Simul Ringing</option>
                                    <option value="round-robin">Round Robin</option>
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
                    </div>
                </div>

                <div class="w-full" index="5">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="multi_ringing_phone_numbers" class="inline-block pt-2 leading-tight">
                                Add Phone Numbers
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="multi_ringing_phone_numbers"
                                placeholder="You can add up to 10 numbers which are separated by commas."
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="call_tree_menu_show == true">
                <div class="w-full" index="4">
                    <div
                        class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row"
                    >
                        <div class="px-8 py-6 w-1/5">
                            <label
                                for="call_tree_type"
                                class="inline-block pt-2 leading-tight"
                                >Type
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <div class="flex relative w-full">
                                <select
                                v-model="call_tree_type"
                                id="call_tree_type"
                                dusk="call_tree_type"
                                @change="changeCallTreeType"
                                class="w-full block form-control form-select form-select-bordered"
                                >
                                <option disabled="">Choose an option</option>
                                <option value="text_to_speech">Text To Speech</option>
                                <option value="play_audio">Play Audio</option>
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
                    </div>
                </div>

                <div class="w-full" index="5" v-if="call_tree_text_to_speech_show == true">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="call_tree_text_to_speech_message" class="inline-block pt-2 leading-tight">
                                Text To Speech Message
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="call_tree_text_to_speech_message"
                                placeholder="Text To Speech Message"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full" index="5" v-if="call_tree_play_audio_show == true">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="call_tree_audio_file_path" class="inline-block pt-2 leading-tight">
                                Audio File Path
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="call_tree_audio_file_path"
                                placeholder="Audio File Path"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full" index="6">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="call_tree_forward_number_one" class="inline-block pt-2 leading-tight">
                                Forward Number One
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <!-- <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="forward_call_forward_number"
                                placeholder="Forward The Call To a Specific Number"
                                required
                            /> -->
                            <phone-number
                                class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800 form-input-bordered" :value="call_tree_forward_number_one"  v-model="call_tree_forward_number_one" id="call_tree_forward_number_one"
                                placeholder="If 1 is dialed, the call will get forwarded to:" required
                            />
                        </div>
                    </div>
                </div>

                 <div class="w-full" index="7">
                    <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row">
                        <div class="px-8 py-6 w-1/5">
                            <label for="call_tree_forward_number_two" class="inline-block pt-2 leading-tight">
                                Forward Number Two
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <!-- <input
                                type="text"
                                class="w-full form-control form-input form-input-bordered"
                                id="name-create-call-flow-step-text-field"
                                v-model="forward_call_forward_number"
                                placeholder="Forward The Call To a Specific Number"
                                required
                            /> -->
                            <phone-number
                                class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800 form-input-bordered" :value="call_tree_forward_number_two"  v-model="call_tree_forward_number_two" id="call_tree_forward_number_two"
                                placeholder="If 2 is dialed, the call will get forwarded to:" required
                            />
                        </div>
                    </div>
                </div>

            </div>

          </div>
        </div>
      </div>
      <!-- Create Button -->
      <div
        class="flex flex-col md:flex-row md:items-center justify-center md:justify-end space-y-2 md:space-y-0 space-x-3"
      >
        <button
          size="lg"
          align="center"
          component="button"
          tabindex="0"
          dusk="cancel-create-button"
          type="button"
          class="appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800"
        >
          Cancel
        </button>
        <!-- <BasicButton
            type="button"
            @click="submitForm(false)"
            class="mr-3 px-3 ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 disabled:opacity-75"
            >Send Now</BasicButton
        > -->
        <button
          size="lg"
          type="button"
          align="center"
          component="button"
          @click="submit"
          class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900"
        >
          <span class="">Create Call Flow Step</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import PhoneNumber from '../components/PhoneNumber.vue';

export default {
  components: {
    PhoneNumber,
  },
  data() {
        return {
            name : null,
            call_flows: {},
            call_flow_id: null,
            step: null,
            call_flow_type: null,
            greeting_show: false,
            greeting_type: null,
            greeting_text_to_speech_message: null,
            greeting_audio_file_path: null,
            forward_call_show: false,
            forward_call_forward_number: null,
            forward_call_wait: null,
            voicemail_show: false,
            voicemail_type: null,
            voicemail_text_to_speech_message: null,
            voicemail_audio_file_path: null,
            voicemail_email: null,
            multi_ringing_show: false,
            multi_ringing_type: null,
            multi_ringing_phone_numbers: null,
            call_tree_menu_show: false,
            call_tree_type: null,
            call_tree_text_to_speech_message: null,
            call_tree_audio_file_path: null,
            call_tree_forward_number_one: null,
            call_tree_forward_number_two: null,
            greeting_text_to_speech_show: false,
            greeting_play_audio_show: false,
            voicemail_text_to_speech_show: false,
            voicemail_play_audio_show: false,
            call_tree_text_to_speech_show: false,
            call_tree_play_audio_show: false,
        };
  },
  async mounted() {
    await Nova.request().get('/nova-api/custom/call-flows')
            .then(res => {
                this.call_flows = res.data.call_flows
                console.log('this.companies')
                console.log(this.call_flows.length)
            }, err => {

            })
  },
  methods:{
    changeCallFlowType()
    {
        let value = event.target.value;
        if (value == 'greeting') {
            this.greeting_show = true;
            this.forward_call_show = false;
            this.voicemail_show = false;
            this.multi_ringing_show = false;
            this.call_tree_menu_show = false;
        } else if (value == 'forward-call') {
            this.greeting_show = false;
            this.forward_call_show = true;
            this.voicemail_show = false;
            this.multi_ringing_show = false;
            this.call_tree_menu_show = false;
        } else if (value == 'voicemail') {
            this.greeting_show = false;
            this.forward_call_show = false;
            this.voicemail_show = true;
            this.multi_ringing_show = false;
            this.call_tree_menu_show = false;
        } else if (value == 'multi-ringing') {
            this.greeting_show = false;
            this.forward_call_show = false;
            this.voicemail_show = false;
            this.multi_ringing_show = true;
            this.call_tree_menu_show = false;
        } else if (value == 'call-tree-menu') {
            this.greeting_show = false;
            this.forward_call_show = false;
            this.voicemail_show = false;
            this.multi_ringing_show = false;
            this.call_tree_menu_show = true;
        }
    },
    changeGreetingType()
    {
        let value = event.target.value;
        if (value == 'text_to_speech') {
            this.greeting_text_to_speech_show = true;
            this.greeting_play_audio_show = false;
        } else if (value == 'play_audio') {
            this.greeting_play_audio_show = true;
            this.greeting_text_to_speech_show = false;
        }
    },
    changeVoicemailType()
    {
        let value = event.target.value;
        if (value == 'text_to_speech') {
            this.voicemail_text_to_speech_show = true;
            this.voicemail_play_audio_show = false;
        } else if (value == 'play_audio') {
            this.voicemail_play_audio_show = true;
            this.voicemail_text_to_speech_show = false;
        }
    },
    changeCallTreeType()
    {
        let value = event.target.value;
        if (value == 'text_to_speech') {
            this.call_tree_text_to_speech_show = true;
            this.call_tree_play_audio_show = false;
        } else if (value == 'play_audio') {
            this.call_tree_play_audio_show = true;
            this.call_tree_text_to_speech_show = false;
        }
    },
    async submit()
    {
        let params = {};
        params.name = this.name;
        params.call_flow_id = this.call_flow_id;
        params.step = this.step;
        params.call_flow_type = this.call_flow_type;
        if (this.call_flow_type == 'greeting') {
            params.greeting_type = this.greeting_type;
            if (this.greeting_type == 'text_to_speech') {
                params.greeting_text_to_speech_message = this.greeting_text_to_speech_message;
            } else if (this.greeting_type == 'play_audio')
            {
                params.greeting_audio_file_path = this.greeting_audio_file_path;
            }
        }
        else if (this.call_flow_type == 'forward-call') {
            params.forward_call_forward_number = this.forward_call_forward_number;
            params.forward_call_wait = this.forward_call_wait;
        }
        else if (this.call_flow_type == 'voicemail') {
            params.voicemail_type = this.voicemail_type;
            if (this.voicemail_type == 'text_to_speech') {
                params.voicemail_text_to_speech_message = this.voicemail_text_to_speech_message;
            } else if (this.voicemail_type == 'play_audio')
            {
                params.voicemail_audio_file_path = this.voicemail_audio_file_path;
            }
            params.voicemail_email = this.voicemail_email;
        }
        else if (this.call_flow_type == 'multi-ringing') {
            params.multi_ringing_type = this.multi_ringing_type;
            params.multi_ringing_phone_numbers = this.multi_ringing_phone_numbers;
        }
        else if (this.call_flow_type == 'call-tree-menu') {
            params.call_tree_type = this.call_tree_type;
            if (this.call_tree_type == 'text_to_speech') {
                params.call_tree_text_to_speech_message = this.call_tree_text_to_speech_message;
            } else if (this.call_tree_type == 'play_audio')
            {
                params.call_tree_audio_file_path = this.call_tree_audio_file_path;
            }
            params.call_tree_forward_number_one = this.call_tree_forward_number_one;
            params.call_tree_forward_number_two = this.call_tree_forward_number_two;
        }
        console.log(params);

        await Nova.request()
                .post('/nova-api/custom/call-flow-step', params)
                .then((response) => {
                    // console.log(response);
                    if (response.status == 200) {
                        if (response.data.status == "success") {
                            Nova.info(response.data.message);
                            Nova.visit("/resources/call-flow-steps");
                        } else {
                            Nova.error("An error accured");
                            Nova.log("Call Flow Step Creation:Error");
                        }
                    }
                })
                .catch((error) => {
                    Nova.error("An error accured!");
                    console.log("Call Flow Step Creation:Error", error);
                });
    }
  },

};
</script>

<style>
/* Scoped Styles */
</style>
