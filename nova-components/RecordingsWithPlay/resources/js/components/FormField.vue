<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <div class="w-full">
      <div class="flex relative w-full">
        <select
          data-testid="recordings-select"
          dusk="recording"
          class="w-full block form-control form-select form-select-bordered"
          @change="updateAudio"
          :id="field.attribute"
          v-model="value"
        >
          <option value="">—</option>
          <option v-for="recording in recordings" :key="recording.id" :value="recording.id">
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
      <div class="flex relative w-full">
        <span v-if="!showSlot" style="color: red"
          >* Please Select audio file to see preview</span
        >
        <div class="flex relative w-full mt-2" >
          <audio :id="field.attribute + 'audio'" v-show="showSlot"  controls>
            <source :src="audioPath" type="audio/wav" />
          </audio>
        </div>
      </div>
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
      recordings: null,
      showSlot: true,
      audioPath: '',
    };
  },
  mounted() {
    
    let audio = document.getElementById(this.field.attribute + 'audio')
    // let audio = this.$refs.recordingPlay
    console.log(audio)
    this.getRecordings();
  },
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    updateAudio(e){
       this.showSlot = true

      console.log('rec????',e.target.value)
      let currentRecording = this.recordings.find(a => a.id == e.target.value)
      console.log(currentRecording) 
      this.audioPath = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/'+currentRecording.filename

    let audio = document.getElementById(this.field.attribute + 'audio')
    audio.load()
    this.$forceUpdate()
    // audio.play()
    },
    async getRecordings() {
      let vm = this;
      await Nova.request()
        .post("/nova-api/recordings/get", { data: "data" })
        .then((res) => {
          if (res.data.status) {
            console.log(res.data.recordings);
            vm.recordings = res.data.recordings;
          }
        });
    },
    setInitialValue() {
      this.value = this.field.value || "";
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
