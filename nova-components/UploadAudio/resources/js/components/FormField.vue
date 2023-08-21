<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <input
        :id="field.attribute"
        type="file"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        :value="value"
        @input="setAudio"
      />
      <span v-if="!showSlot" style="color: red">* Please Upload audio file to see preview</span>
      <div class="flex relative w-full mt-2" v-if="showSlot" >
          <audio id="recordingPlay" controls>
              <source :src="audioPath" type="audio/wav">
          </audio>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],
data(){
  return {
    audioPath: null,
    showSlot: false
  }
},
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    setAudio(e) {
      console.log('value',URL.createObjectURL(e.target.files[0]))
      this.showSlot = true
      this.audioPath = URL.createObjectURL(e.target.files[0])

    },
    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },
  },
}
</script>
