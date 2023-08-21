<template>
    <div>
        <div @click.stop="(openNumberConfigModal = true), getNumber(number.id)">
            <svg
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
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                ></path>
            </svg>
        </div>
        <Modal
            data-testid="preview-resource-modal"
            :show="openNumberConfigModal"
            @close-via-escape="openNumberConfigModal = false"
            role="alertdialog"
            maxWidth="2xl"
        >
            <LoadingCard
                :loading="false"
                class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
            >
                <slot>
                    <form @submit.prevent="submit">
                        <ModalHeader class="flex items-center">
                            Number Config
                        </ModalHeader>
                        <ModalContent class="px-8">
                            <div class="mt-2">
                                <div
                                    class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                >
                                    <label
                                        for="status-update-recording-upload-test-select-field"
                                        class="inline-block pt-2 leading-tight"
                                        >Name</label
                                    >
                                </div>
                                <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                    <!-- Search Input -->
                                    <!-- Select Input Field -->
                                    <div class="flex relative w-full">
                                        <input
                                            class="bg-white border focus:outline-none p-3 w-full w-full form-control form-input form-input-bordered"
                                            v-model="number.name"
                                            name="name"
                                            type="text"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div
                                    class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                >
                                    <label
                                        for="status-update-recording-upload-test-select-field"
                                        class="inline-block pt-2 leading-tight"
                                        >Description</label
                                    >
                                </div>
                                <div class="mt-1 md:mt-0 pb-1 w-full md:py-2">
                                    <!-- Search Input -->
                                    <!-- Select Input Field -->
                                    <div class="flex relative w-full">
                                        <input
                                            class="bg-white border focus:outline-none p-3 w-full w-full form-control form-input form-input-bordered"
                                            v-model="number.description"
                                            name="name"
                                            type="text"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <div>
                                    <label for="type">
                                        <input
                                            class="checkbox"
                                            v-model="number.ivr_enabled"
                                            :value="false"
                                            name="type"
                                            type="radio"
                                        />
                                        <span class="mlbz-radio-label"
                                            >Forward</span
                                        >
                                    </label>
                                </div>
                                <div>
                                    <label for="type">
                                        <input
                                            class="checkbox"
                                            v-model="number.ivr_enabled"
                                            :value="true"
                                            name="type"
                                            type="radio"
                                        />
                                        <span class="mlbz-radio-label"
                                            >Enable an IVR</span
                                        >
                                    </label>
                                </div>
                            </div>
                            <div v-if="number.ivr_enabled == 0">
                                <div
                                    class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                >
                                    <label
                                        for="status-update-recording-upload-test-select-field"
                                        class="inline-block pt-2 leading-tight"
                                        >Forward To Number</label
                                    >
                                </div>
                                <div>
                                    <text-field
                                        name="phoneNumber"
                                        type="tel"
                                        :value="number.forward_to_number"
                                        @input-updated="inputNumber"
                                        class="w-full form-control form-input form-input-bordered"
                                        id="number-update-client-number-1322731-text-field"
                                    />
                                </div>
                            </div>
                            <div v-if="number.ivr_enabled == 1">
                                <div>
                                    <div
                                        class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                    >
                                        <label
                                            for="status-update-recording-upload-test-select-field"
                                            class="inline-block pt-2 leading-tight"
                                            >Select Audio
                                            <!--v-if--></label
                                        >
                                    </div>
                                    <div
                                        class="mt-1 md:mt-0 pb-1 w-full md:py-2"
                                    >
                                        <!-- Search Input -->
                                        <!-- Select Input Field -->
                                        <div class="flex relative w-full">
                                            <select
                                                v-model="number.recording_id"
                                                id="status"
                                                dusk="status"
                                                class="w-full block form-control form-select form-select-bordered"
                                                @change="showRecording"
                                            >
                                                <option
                                                    disabled=""
                                                    :value="null"
                                                >
                                                    Choose a recording
                                                </option>
                                                <option
                                                    v-for="recording in recordings"
                                                    :value="recording.id"
                                                    :key="recording.id"
                                                >
                                                    {{ recording.name }}
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
                                        <div
                                            class="flex relative w-full mt-2"
                                            v-show="recordingOpen"
                                        >
                                            <audio id="recordingPlay" controls>
                                                <source
                                                    v-bind:src="track"
                                                    type="audio/wav"
                                                />
                                            </audio>
                                        </div>
                                        <!--v-if-->
                                        <!--v-if-->
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                    >
                                        <label
                                            for="status-update-recording-upload-test-select-field"
                                            class="inline-block pt-2 leading-tight"
                                            >Optin Digit</label
                                        >
                                    </div>
                                    <div
                                        class="mt-1 md:mt-0 pb-1 w-full md:py-2"
                                    >
                                        <!-- Search Input -->
                                        <!-- Select Input Field -->
                                        <div class="flex relative w-full">
                                            <select
                                                id="status"
                                                dusk="status"
                                                v-model="number.opt_in_digit"
                                                class="w-full block form-control form-select form-select-bordered"
                                            >
                                                <option disabled="" value="">
                                                    Optin Digit
                                                </option>
                                                <option
                                                    v-for="n in 10"
                                                    :value="n - 1"
                                                    :key="n - 1"
                                                >
                                                    {{ n - 1 }}
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
                                </div>
                                <div>
                                    <div
                                        class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                    >
                                        <label
                                            for="status-update-recording-upload-test-select-field"
                                            class="inline-block pt-2 leading-tight"
                                            >Opt Out Digit</label
                                        >
                                    </div>
                                    <div
                                        class="mt-1 md:mt-0 pb-1 w-full md:py-2"
                                    >
                                        <!-- Search Input -->
                                        <!-- Select Input Field -->
                                        <div class="flex relative w-full">
                                            <select
                                                id="status"
                                                dusk="status"
                                                v-model="number.opt_out_digit"
                                                class="w-full block form-control form-select form-select-bordered"
                                            >
                                                <option disabled="" value="">
                                                    Opt Out Digit
                                                </option>
                                                <option
                                                    v-for="n in 10"
                                                    :value="n - 1"
                                                    :key="n - 1"
                                                >
                                                    {{ n - 1 }}
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
                                </div>

                                <div>
                                    <div
                                        class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                    >
                                        <label
                                            for="status-update-recording-upload-test-select-field"
                                            class="inline-block pt-2 leading-tight"
                                            >Opt in forward to number</label
                                        >
                                    </div>
                                    <div
                                        class="mt-1 md:mt-0 pb-1 w-full md:py-2"
                                    >
                                        <!-- Search Input -->
                                        <!-- Select Input Field -->
                                        <div class="flex relative w-full">
                                            <text-field
                                                name="phoneNumber"
                                                type="tel"
                                                :value="number.opt_in_number"
                                                @input-updated="
                                                    inputOptInNumber
                                                "
                                                class="w-full form-control form-input form-input-bordered"
                                                id="number-update-client-number-1322731-text-field"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div
                                        class="mt-2 md:mt-0 w-full md:w-1/5 md:py-2"
                                    >
                                        <label
                                            for="status-update-recording-upload-test-select-field"
                                            class="inline-block pt-2 leading-tight"
                                            >DNC on opt out?</label
                                        >
                                    </div>
                                    <div
                                        class="mt-1 md:mt-0 pb-1 w-full md:py-2"
                                    >
                                        <!-- Search Input -->
                                        <!-- Select Input Field -->
                                        <div class="flex relative w-full">
                                            <label for="dnc_on_ivr">
                                                <input
                                                    id="dnc_on_ivr"
                                                    class="checkbox"
                                                    v-model="number.dnc_on_ivr"
                                                    name="type"
                                                    type="checkbox"
                                                />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ModalContent>

                        <ModalFooter>
                            <div class="ml-auto">
                                <LoadingButton
                                    type="submit"
                                    dusk="confirm-preview-button"
                                    class="mr-2"
                                >
                                    Save
                                </LoadingButton>
                                <LoadingButton
                                    @click.prevent="
                                        openNumberConfigModal = false
                                    "
                                    ref="confirmButton"
                                    dusk="confirm-preview-button"
                                >
                                    {{ __("Close") }}
                                </LoadingButton>
                            </div>
                        </ModalFooter>
                    </form>
                </slot>
            </LoadingCard>
        </Modal>
    </div>
</template>
<script>
import { nextTick } from "vue";
export default {
    data() {
        return {
            openNumberConfigModal: false,
            value: null,
            type: 0,
            recordings: [],
            recordingOpen: false,
            track: "",
            number: {
                my_number: null,
                recording_id: null,
                forward_to_number: null,
                ivr_enabled: 0,
                continue_digit: null,
                opt_out_digit: null,
                opt_in_digit: null,
                opt_in_number: "",
                dnc_on_ivr: false,
            },
            // filename: ""
        };
    },
    mounted() {},
    async created() {
        console.log("asdasd");
        await Nova.request()
            .get("/nova-api/custom/recordings")
            .then((res) => {
                this.recordings = res.data;
            });
        await nextTick();
        if (this.$attrs.resource.fields) {
            if (
                this.$attrs.resource.fields.find(
                    (a) => a.attribute == "forward_to_number"
                )
            ) {
                this.number.forward_to_number =
                    this.$attrs.resource.fields.find(
                        (a) => a.attribute == "forward_to_number"
                    ).value;
            }
            if (this.$attrs.resource.fields.find((a) => a.attribute == "id")) {
                this.number.id = this.$attrs.resource.fields.find(
                    (a) => a.attribute == "id"
                ).value;
            }
            if (
                this.$attrs.resource.fields.find((a) => a.attribute == "name")
            ) {
                this.number.name = this.$attrs.resource.fields.find(
                    (a) => a.attribute == "name"
                ).value;
            }
            if (
                this.$attrs.resource.fields.find(
                    (a) => a.attribute == "description"
                )
            ) {
                this.number.description = this.$attrs.resource.fields.find(
                    (a) => a.attribute == "description"
                ).value;
            }
            if (
                this.$attrs.resource.fields.find(
                    (a) => a.attribute == "opt_in_number"
                )
            ) {
                this.number.opt_in_number = this.$attrs.resource.fields.find(
                    (a) => a.attribute == "opt_in_number"
                ).value;
            }
            if (
                this.$attrs.resource.fields.find(
                    (a) => a.attribute == "ivr_enabled"
                )
            ) {
                this.number.ivr_enabled = this.$attrs.resource.fields.find(
                    (a) => a.attribute == "ivr_enabled"
                ).value;
            }
        }
    },
    methods: {
        async getNumber(id) {
            let params = {
                id: id,
            };
            await Nova.request()
                .post("/nova-api/custom/get-my-number", params)
                .then((res) => {
                    let dt = res.data.number;
                    if (dt !== null) {
                        this.number.forward_to_number = dt.forward_to_number;
                        this.number.name = dt.name;
                        this.number.description = dt.description;
                        this.number.opt_in_number = dt.opt_in_number;
                        this.number.recording_id = dt.recording_id;
                        this.number.opt_out_digit = dt.opt_out_digit;
                        this.number.opt_in_digit = dt.opt_in_digit;
                        this.number.dnc_on_ivr = dt.dnc_on_ivr;
                    }
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
