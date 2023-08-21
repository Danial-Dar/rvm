<template>
    <div>

        <Head title="Edit Mynumber" />

        <Heading class="mb-6">Edit my number</Heading>
        <form @submit.prevent="submit">
            <Card class="flex flex-col pt-1 pb-1 px-2">


                <div>
                    <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                        <label for="status-update-recording-upload-test-select-field"
                            class="inline-block pt-2 leading-tight">Name</label>
                    </div>
                    <div class="flex">
                        <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                            <!-- Search Input -->
                            <!-- Select Input Field -->
                            <div class="relative w-full">
                                <input
                                    class="bg-white border focus:outline-none p-3 w-full w-full form-control form-input form-input-bordered"
                                    v-model="number.name" name="name" type="text" required />
                            </div>
                        </div>
                        <div class="ml-2 help-text-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="help-text help-text mt-2">This is the name that will be shown on the dashboard in reference to this campaign.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md:mt-0 w-full md:w-1/5 md:py-2">
                    <label for="status-update-recording-upload-test-select-field"
                        class="inline-block pt-2 leading-tight">Description</label>
                    </div>
                    <div class="flex">
                        <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                            <!-- Search Input -->
                            <!-- Select Input Field -->
                            <div class="relative w-full">
                                <input
                                    class="bg-white border focus:outline-none p-3 w-full w-full form-control form-input form-input-bordered"
                                    v-model="number.description" name="name" type="text" required />
                            </div>
                        </div>
                        <div class="ml-2 help-text-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="help-text help-text mt-2">The description is used to have a description of the number such as use or maybe additional notes.</p>
                        </div>
                    </div>
                </div>


                <div>
                    <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                        <label for="status-update-recording-upload-test-select-field"
                            class="inline-block pt-2 leading-tight">Select Type
                        </label>
                    </div>

                    <div class="flex">
                        <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                            <div class="relative w-full">
                                <select v-model="number.number_type" id="status" dusk="status"
                                    class="w-full block form-control form-select form-select-bordered">
                                    <option disabled="" :value="null">
                                        Choose Type
                                    </option>
                                    <option value="forward">Forward</option>
                                    <option value="ivr">IVR</option>
                                    <option value="sip">Sip Forward</option>

                                </select>
                                <svg class="flex-shrink-0 pointer-events-none form-select-arrow"
                                    xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                                    <path class="fill-current"
                                        d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-2 help-text-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="help-text help-text mt-2">There’s multiple ways in which your phone can be routed: IVR – puts your user through a series of questions and prompts them for input on their keypad before routing them.</p>
                        </div>
                    </div>
                </div>
                <div v-if="number.number_type == 'forward'">
                    <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                        <label for="status-update-recording-upload-test-select-field"
                            class="inline-block pt-2 leading-tight">Forward To Number</label>
                    </div>
                    <div>
                        <phone-number :value="number.forward_to_number" v-model="number.forward_to_number" class="w-full form-control form-input form-input-bordered" required />
                        <!-- <text-field name="phoneNumber" type="tel" :value="number.forward_to_number"
                            @input-updated="inputNumber" class="w-full form-control form-input form-input-bordered"
                            id="number-update-client-number-1322731-text-field" /> -->
                    </div>
                </div>
                <div v-if="number.number_type == 'sip'">
                    <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                        <label for="status-update-recording-upload-test-select-field"
                            class="inline-block pt-2 leading-tight">Sip End Point</label>
                    </div>
                    <div class="flex relative w-full">
                        <input
                            class="bg-white border focus:outline-none p-3 w-full w-full form-control form-input form-input-bordered"
                            v-model="number.sip_endpoint" name="name" type="text" required />
                    </div>
                </div>
                <div v-if="number.number_type == 'ivr'">
                    <div>
                        <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                            <label for="status-update-recording-upload-test-select-field"
                                class="inline-block pt-2 leading-tight">Select Audio
                                <!--v-if--></label>
                        </div>
                        <div class="flex">
                            <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                <!-- Search Input -->
                                <!-- Select Input Field -->
                                <div class="relative w-full">
                                    <select v-model="number.recording_id" id="status" dusk="status"
                                        class="w-full block form-control form-select form-select-bordered"
                                        @change="showRecording">
                                        <option disabled="" :value="null">
                                            Choose a recording
                                        </option>
                                        <option v-for="recording in recordings" :value="recording.id" :key="recording.id">
                                            {{ recording.name }}
                                        </option>
                                    </select>
                                    <svg class="flex-shrink-0 pointer-events-none form-select-arrow"
                                        xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                                        <path class="fill-current"
                                            d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex relative w-full mt-2" v-show="recordingOpen">
                                    <audio id="recordingPlay" controls>
                                        <source v-bind:src="track" type="audio/wav" />
                                    </audio>
                                </div>
                                <!--v-if-->
                                <!--v-if-->
                            </div>

                            <div class="ml-2 help-text-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="help-text help-text mt-2">This is the IVR audio that’s played to the customer when they call in giving them the option to opt in or opt out.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                            <label for="status-update-recording-upload-test-select-field"
                                class="inline-block pt-2 leading-tight">Optin Digit</label>
                        </div>
                        <div class="flex">
                            <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                <!-- Search Input -->
                                <!-- Select Input Field -->
                                <div class="relative w-full">
                                    <select id="status" dusk="status" v-model="number.opt_in_digit"
                                        class="w-full block form-control form-select form-select-bordered">
                                        <option disabled="" value="">
                                            Optin Digit
                                        </option>
                                        <option v-for="n in 10" :value="n - 1" :key="n - 1">
                                            {{ n - 1 }}
                                        </option>
                                    </select>
                                    <svg class="flex-shrink-0 pointer-events-none form-select-arrow"
                                        xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                                        <path class="fill-current"
                                            d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-2 help-text-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="help-text help-text mt-2">This is the digit a user inputs to continue with their phone call</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                            <label for="status-update-recording-upload-test-select-field"
                                class="inline-block pt-2 leading-tight">Opt Out Digit</label>
                        </div>
                        <div class="flex">
                            <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                <!-- Search Input -->
                                <!-- Select Input Field -->
                                <div class="relative w-full">
                                    <select id="status" dusk="status" v-model="number.opt_out_digit"
                                        class="w-full block form-control form-select form-select-bordered">
                                        <option disabled="" value="">
                                            Opt Out Digit
                                        </option>
                                        <option v-for="n in 10" :value="n - 1" :key="n - 1">
                                            {{ n - 1 }}
                                        </option>
                                    </select>
                                    <svg class="flex-shrink-0 pointer-events-none form-select-arrow"
                                        xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                                        <path class="fill-current"
                                            d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-2 help-text-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="help-text help-text mt-2">This is the digit a user inputs to opt out on their keypad.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                            <label for="status-update-recording-upload-test-select-field"
                                class="inline-block pt-2 leading-tight">Opt in forward to number</label>
                        </div>
                        <div class="flex">
                            <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                <!-- Search Input -->
                                <!-- Select Input Field -->
                                <div class="relative w-full">
                                    <phone-number :value="number.opt_in_number" v-model="number.opt_in_number" class="w-full form-control form-input form-input-bordered" required />
                                    <!-- <text-field name="phoneNumber" type="tel" :value="number.opt_in_number" @input-updated="
                                    inputOptInNumber
                                " class="w-full form-control form-input form-input-bordered"
                                        id="number-update-client-number-1322731-text-field" /> -->
                                </div>

                            </div>
                            <div class="ml-2 help-text-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="help-text help-text mt-2">This is the number in which calls are forwarded to when a user opts in</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2">
                            <label for="status-update-recording-upload-test-select-field"
                                class="inline-block pt-2 leading-tight">DNC on opt out?</label>
                        </div>
                        <!-- <div class="flex"> -->
                            <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                <!-- Search Input -->
                                <!-- Select Input Field -->
                                <div class="flex relative w-full">
                                    <label for="dnc_on_ivr">
                                        <input id="dnc_on_ivr" class="checkbox" v-model="number.dnc_on_ivr" name="type"
                                            type="checkbox" />
                                    </label>
                                </div>
                            </div>
                            <div class="ml-2 help-text-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" class="inline-block" role="presentation">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="help-text help-text mt-2" style="left: 2rem;">When a user opts out if this box is checked they will be placed on your companies do not call list.</p>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div class="ml-auto mt-2">
                    <LoadingButton type="submit" dusk="confirm-preview-button" class="mr-2">
                        Save
                    </LoadingButton>
                </div>
            </Card>

        </form>

        <div class="flex mt-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow relative px-6 py-4 md:col-span-4 min-h-40 h-full flex-1">
                <div class="h-6 flex items-center mb-4">
                    <h3 class="mr-3 leading-tight text-sm font-bold">Number Of Calls</h3>
                </div>
                <div class="flex items-center mb-4">
                    <div class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>

                    </div>
                    <div class="ml-4">
                        <p class="flex items-center text-4xl">{{ calls_count }}</p>
                        <div>
                            <p class="flex items-center font-bold text-sm">
                                <span class="text-gray-400 font-semibold"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ml-auto bg-white dark:bg-gray-800 rounded-lg shadow relative px-6 py-4 md:col-span-4 min-h-40 h-full flex-1 ml-2 mr-2">
                <div class="h-6 flex items-center mb-4">
                    <h3 class="mr-3 leading-tight text-sm font-bold">Average Call Duration</h3>
                </div>
                <div class="flex items-center mb-4">
                    <div class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                    </div>
                    <div class="ml-4">
                        <p class="flex items-center text-4xl">{{ average_call_duration }}</p>
                        <div>
                            <p class="flex items-center font-bold text-sm">
                                <span class="text-gray-400 font-semibold"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ml-auto bg-white dark:bg-gray-800 rounded-lg shadow relative px-6 py-4 md:col-span-4 min-h-40 h-full flex-1">
                <div class="h-6 flex items-center mb-4">
                    <h3 class="mr-3 leading-tight text-sm font-bold">Active Since</h3>
                </div>
                <div class="flex items-center mb-4">
                    <div class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>

                    </div>
                    <div class="ml-4">
                        <p class="flex items-center text-4xl">{{ active_since }} Days</p>
                        <div>
                            <p class="flex items-center font-bold text-sm">
                                <span class="text-gray-400 font-semibold"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Card class="flex flex-col items-center justify-center mt-2">
            <h1 class="pt-3 pb-3">Call Back Heat Map</h1>
            <div class="" ref="chartdivCallBack" style="margin-top: 2rem; height:300px; width: 100%;"></div>
        </Card>

        <Card class="flex flex-col items-center justify-center mt-2">
            <h1 class="pt-3 pb-3">Calls Received</h1>
            <div class="chart" ref="chartdivSendRate" style="margin-top: 2rem; height: 300px; width: 100%;"></div>
        </Card>

        <div class="mt-2">
            <div class="flex">
                <div class="relative h-9 md:flex-shrink-0" searchable="true">
                    <Heading class="mb-6" style="margin-left: 10px;">Incoming Call Logs</Heading>
                </div>

            </div>

            <Card class="flex flex-col items-left">
                <div>

                    <table class="w-full table-default card-scroll" cellpadding="0" cellspacing="0"
                        data-testid="resource-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>Date And Time</span>
                                </th>
                                <th
                                    class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>From Number</span>
                                </th>
                                <th
                                    class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                                    <span>To number</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="incoming_logs.length > 0">
                                <tr v-for="log in incoming_logs" :key="log.id" dusk="53-row" class="group"
                                addition-actions="[object Object]">
                                <!-- <tr class="group"> -->
                                <td
                                    class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{log.created_at}}
                                    </div>
                                </td>
                                <td
                                    class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{log.From}}
                                    </div>
                                </td>
                                <td
                                    class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                    <div class="text-left" resource="[object Object]">
                                        {{log.To }}
                                    </div>
                                </td>
                            </tr>
                            </template>

                        </tbody>
                    </table>
                    <ResourcePagination :allMatchingResourceCount="
                paginationDataIncoming.allMatchingResourceCount
            " :currentPage="paginationDataIncoming.currentPage" :currentResourceCount="
                paginationDataIncoming.currentResourceCount
            " :hasNextPage="paginationDataIncoming.hasNextPage" :hasPreviousPage="paginationDataIncoming.hasPreviousPage"
            :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="10"
            :resourceCountLabel="paginationDataIncoming.resourceCountLabel" :shouldShowPagination="true"
            :totalPages="paginationDataIncoming.totalPages" :selectPage="selectPageIncoming" />
                </div>
            </Card>
        </div>

    </div>
</template>

<script>
    import PhoneNumber from '../components/PhoneNumber.vue'
    import {
        nextTick
    } from "vue";
    export default {
        data() {
            return {
                openNumberConfigModal: false,
                value: null,
                type: 0,
                recordings: [],
                recordingOpen: false,
                track: "",
                number: {},
                incoming_logs: [],
                dataCallBack: [],
                data: [],
                dataSendRate: [],
                calls_count: 0,
                average_call_duration: 0,
                active_since: 0,
                paginationDataIncoming:[]
                // filename: ""
            };
        },
        components: {
            PhoneNumber
        },
        mounted() {
            this.getNumber()
            this.getDataIncoming();
            this.getCardsData();
            this.getCallBackData().then(() => {
                this.buildCallBackChart();
            });
            this.getSendRateData().then(() => {
                this.buildSendRateChart();
            });
        },
        props: ['id'],
        async created() {
            console.log("asdasd");
            await Nova.request()
                .get("/nova-api/custom/recordings")
                .then((res) => {
                    this.recordings = res.data;
                });
        },
        methods: {
            async getCardsData() {
                let baseUrl = "/nova-api/custom/get-number-cards-data/" + this.id;
                await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        this.calls_count = response.data.calls_count;
                        this.average_call_duration = response.data.avg_call_duration;
                        this.active_since = response.data.active_since;
                    });
            },
            async getDataIncoming() {

                let baseUrl = "/nova-api/custom/get-number-call-logs/" + this.id;
                await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        this.incoming_logs = response.data.logs.data;
                        console.log(this.incoming_logs);
                        console.log(this.incoming_logs.data);
                        this.paginationDataIncoming = {
                        allMatchingResourceCount: response.data.logs.data.length,
                            currentPage: response.data.logs.current_page,
                            currentResourceCount: response.data.logs.total,
                            hasNextPage: response.data.logs.next_page_url !== null,
                            hasPreviousPage: response.data.logs.prev_page_url !== null,
                            resourceCountLabel: response.data.logs.from +
                                "-" +
                                response.data.logs.to +
                                " of " +
                                response.data.logs.total,
                            totalPages: response.data.logs.last_page,
                    }
                        // this.paginationDataIncoming = this.incoming_logs;
                        // this.paginationDataIncoming.allMatchingResourceCount = this.incoming_logs.total;
                        // this.paginationDataIncoming.currentPage = this.incoming_logs.current_page;
                        // this.paginationDataIncoming.currentResourceCount = this.incoming_logs.data.length;
                        // this.paginationDataIncoming.hasNextPage = this.incoming_logs.next_page_url !== null ? this.incoming_logs.next_page_url : null;
                        // this.paginationDataIncoming.hasPreviousPage = this.incoming_logs.prev_page_url !== null ? this.incoming_logs.prev_page_url : null;
                        // currentResourceCount
                        console.log(this.paginationDataIncoming);
                    });
            },
            async selectPageIncoming(val) {
                let baseUrl = "/nova-api/custom/get-number-call-logs/" + this.id;
                await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        this.incoming_logs = response.data.logs.data;
                        console.log(this.incoming_logs);
                        console.log(this.incoming_logs.data);
                        this.paginationDataIncoming = {
                        allMatchingResourceCount: response.data.logs.data.length,
                            currentPage: response.data.logs.current_page,
                            currentResourceCount: response.data.logs.total,
                            hasNextPage: response.data.logs.next_page_url !== null,
                            hasPreviousPage: response.data.logs.prev_page_url !== null,
                            resourceCountLabel: response.data.logs.from +
                                "-" +
                                response.data.logs.to +
                                " of " +
                                response.data.logs.total,
                            totalPages: response.data.logs.last_page,
                        };
                        Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();
                    });

            },
            async getCallBackData() {

                let baseUrl = "/nova-api/custom/get-number-callbacks/" + this.id;
                return await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        if (response.data.query.length > 0) {
                            this.dataCallBack = response.data.query
                        }

                        console.log("2.callback ---->", response.data.query);
                    });
            },




            buildCallBackChart() {

                // Themes begin
                window.am4core.useTheme(window.am4themes_animated);

                // Create map instance
                var chart = am4core.create(this.$refs.chartdivCallBack, window.am4maps.MapChart);

                // Set map definition
                chart.geodata = window.am4geodata_usaLow;

                // Set projection
                chart.projection = new window.am4maps.projections.AlbersUsa();

                chart.chartContainer.wheelable = false;
                chart.seriesContainer.draggable = false;
                chart.seriesContainer.resizable = false;

                // Create map polygon series
                var polygonSeries = chart.series.push(
                    new window.am4maps.MapPolygonSeries()
                );

                //Set min/max fill color for each area
                polygonSeries.heatRules.push({
                    property: "fill",
                    target: polygonSeries.mapPolygons.template,
                    "min": am4core.color("#1fc0cd"),
                    "max": am4core.color("#158b94")
                });

                // Make map load polygon data (state shapes and names) from GeoJSON
                polygonSeries.useGeodata = true;

                polygonSeries.data = this.dataCallBack.length > 0 ? this.dataCallBack : [{}];

                // Set up heat legend
                let heatLegend = chart.createChild(am4maps.HeatLegend);
                heatLegend.series = polygonSeries;
                heatLegend.align = "right";
                heatLegend.valign = "bottom";
                heatLegend.height = window.am4core.percent(80);
                heatLegend.orientation = "vertical";
                heatLegend.valign = "middle";
                heatLegend.marginRight = window.am4core.percent(4);
                heatLegend.valueAxis.renderer.opposite = true;
                heatLegend.valueAxis.renderer.dx = -25;
                heatLegend.valueAxis.strictMinMax = false;
                heatLegend.valueAxis.fontSize = 9;
                heatLegend.valueAxis.logarithmic = true;

                // Configure series tooltip
                var polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}: {value}";
                polygonTemplate.nonScalingStroke = true;
                polygonTemplate.strokeWidth = 0.5;

                // Create hover state and set alternative fill color
                var hs = polygonTemplate.states.create("hover");
                hs.properties.fill = window.am4core.color("#1fc0cd");

                // heat legend behavior
                polygonSeries.mapPolygons.template.events.on(
                    "over",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                polygonSeries.mapPolygons.template.events.on(
                    "hit",
                    function (event) {
                        handleHover(event.target);
                    }
                );

                function handleHover(column) {
                    if (!isNaN(column.dataItem.value)) {
                        heatLegend.valueAxis.showTooltipAt(column.dataItem.value);
                    } else {
                        heatLegend.valueAxis.hideTooltip();
                    }
                }

                polygonSeries.mapPolygons.template.events.on(
                    "out",
                    function (event) {
                        heatLegend.valueAxis.hideTooltip();
                    }
                );

            },

            async getSendRateData() {

                let vm = this;
                let baseUrl = "/nova-api/custom/get-number-callreceviedrate/" + this.id;
                return await Nova.request()
                    .get(baseUrl)
                    .then((response) => {
                        if (response.data.query.numberReceivedRates.length > 0) {
                            let dateRange = response.data.query.numberReceivedRates;
                            dateRange.forEach((element) => {
                                let date = new Date(element.date);
                                this.dataSendRate.push({
                                    date: date.getTime(),
                                    value: element.value,
                                });
                            });
                        }

                        console.log("3.callsenttodestination------>", response.data.query.numberReceivedRates);
                    });
            },
            buildSendRateChart() {
                window.am4core.useTheme(window.am4themes_animated);
                let chart = window.am4core.create(this.$refs.chartdivSendRate, window.am4charts.XYChart);

                chart.paddingRight = 20;

                chart.data = this.dataSendRate;

                chart.colors.list = [
                    am4core.color("#1fc0cd"),
                ];

                let dateAxis = chart.xAxes.push(new window.am4charts.DateAxis());
                dateAxis.renderer.grid.template.location = 0;

                let valueAxis = chart.yAxes.push(new window.am4charts.ValueAxis());
                valueAxis.tooltip.disabled = true;
                valueAxis.renderer.minWidth = 35;

                let series = chart.series.push(new window.am4charts.LineSeries());
                series.dataFields.dateX = "date";
                series.dataFields.valueY = "value";

                series.tooltipText = "{valueY.value}";
                series.fillOpacity = 0.3;
                series.stroke = am4core.color("#1fc0cd");
                series.strokeWidth = 2;
                chart.cursor = new window.am4charts.XYCursor();
                series.fillOpacity = 0.3;

                let scrollbarX = new window.am4charts.XYChartScrollbar();
                scrollbarX.series.push(series);
                chart.scrollbarX = scrollbarX;

                this.chart = chart;
            },

            async getNumber() {

                await Nova.request()
                    .get("/nova-api/custom/get-my-number/" + this.id)
                    .then((res) => {
                        this.number = res.data.number;

                    });
            },
            async submit() {
                await Nova.request()
                    .post(
                        "/nova-api/custom/my-numbers/" + this.number.id,
                        this.number
                    )
                    .then(
                        (res) => {
                            Nova.success("Updated successfully");
                            Nova.visit("/resources/my-numbers");
                        },
                        (err) => {
                            for (const key in err.response.data.errors) {
                                Nova.error(err.response.data.errors[key]);
                            }
                        }
                    );
                this.openNumberConfigModal = false;
            },
            inputOptInNumber(value) {
                this.number.opt_in_number = value;
            },
            inputNumber(value) {
                this.number.forward_to_number = value;
            },
            showRecording(event) {
                this.recordingOpen = true;
                let recording_id = event.target.value;
                let rec = this.recordings.filter((value) => {
                    return value.id == recording_id;
                });
                let audio = document.getElementById("recordingPlay");
                // let filename = rec.length > 0 ?  rec[0].filename : '';
                if (rec.length > 0 && rec[0].filename) {
                    this.track =
                        "https://rvm.nyc3.digitaloceanspaces.com/RVM/" +
                        rec[0].filename;
                } else {
                    this.track = "";
                }
                audio.load();
            },
        },
    };

</script>
<style>
    .mlbz-radio-container:not(:last-child) {
        margin-right: 20px;
    }

    .mlbz-radio-label {
        padding-left: 5px;
    }

    .mlbz-radio-hint {
        padding-left: 24px;
    }

    .mlbz-hidden {
        display: none !important;
    }

</style>
