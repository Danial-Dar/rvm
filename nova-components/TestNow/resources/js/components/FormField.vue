<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <!-- <input
        :id="field.attribute"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="value"
      /> -->
      <button
        size="lg"
        align="center"
        component="button"
        dusk="create-button"
        type="button"
        @click="placeApiCall"
        v-if="!showModal"
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
      >
        <span class="">Test</span>
      </button>
      <div v-if="showModal">
        <!-- <div class="px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
          <label
            for="recording-recording-belongs-to-field"
            class="inline-block pt-2 leading-tight"
            >From Number <span class="text-red-500 text-sm">*</span>
          </label>
        </div> -->
        <!-- <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
          <input
            id="Caller Id Forward"
            type="text"
            class="w-full form-control form-input form-input-bordered"
            placeholder="Caller Id Forward"
            im-insert="true"
            v-model="fromNumber"
          />
        </div> -->
        <div class="px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
          <label
            for="recording-recording-belongs-to-field"
            class="inline-block pt-2 leading-tight"
            >To Number <span class="text-red-500 text-sm">*</span>
          </label>
        </div>
        <div class="mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5">
          <input
            id="Caller Id Forward"
            type="text"
            class="w-full form-control form-input form-input-bordered"
            placeholder="Caller Id Forward"
            im-insert="true"
            v-model="toNumber"
          />
        </div>

        <button
          size="lg"
          align="center"
          component="button"
          dusk="create-button"
          type="button"
          @click="placeApiCall"
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
        >
          <span class="">Place Call</span>
        </button>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field"],

  data() {
    return {
      showModal: false,
      fromNumber: '1800',
      toNumber: null,
    };
  },
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || "";
    },
    testApiCallModal() {
      this.showModal = true;
    },
    async placeApiCall() {
      let from_number = 1800
      let to_number = document.getElementById('To Number').value

      let formdata = new FormData();

      let slug = document.getElementById('campaign_type').value;
      let rec = ''
      let rec_opt_in = ''
      let rec_opt_out = ''
      let opt_out_number = ''
      let opt_in_number = ''
      if(slug == 'rvm' || slug == 'rvm-test'){
        rec  = document.getElementById('recording_id').value;
      }else if(slug == 'press-1' || slug == 'ivr-test'){
       rec = document.getElementById('recording_id').value;
       rec_opt_in = document.getElementById('recording_optin_id').value;
       rec_opt_out = document.getElementById('optout_recording_id').value;
       opt_out_number = document.getElementById('opt_out_number').value;
       opt_in_number = document.getElementById('opt_in_number').value;

      formdata.append("opt_in", rec_opt_in);
      formdata.append("opt_out", rec_opt_out);
      formdata.append("opt_in_number", opt_in_number);
      formdata.append("opt_out_number", opt_out_number);

      }


      formdata.append("from_number", from_number);
      formdata.append("to_number", to_number);
      formdata.append("recording_id", rec);
      formdata.append("slug", slug);


     await Nova.request()
        .post("/nova-api/test/call", formdata)
        .then((res) => {
          Nova.success('Call sent successfully')
        });
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || "");
    },
  },
};
</script>
