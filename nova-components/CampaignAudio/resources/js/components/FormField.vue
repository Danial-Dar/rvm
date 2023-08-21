<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <div v-show="showAudio">
        <audio controls id="campaignPlayAudio" >
          <source v-bind:src="track" type="audio/wav">
        </audio>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  data(){
    return {
      src:"",
      showAudio:false,
      track:''
    }
  },
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],
  mounted(){
    let rec = document.querySelectorAll('select[data-testid="recordings-select"]')[0];
      rec.addEventListener('change',this.setSrc)
  },

  methods: {
    setSrc(event) {
      this.showAudio = true;
      let rec_id = event.target.value;
      let params ={
        'id' : rec_id
      }
      Nova.request().post('/nova-api/campaigns/get-recording-filename',params).then(response => {
          let audio = document.getElementById('campaignPlayAudio')
          this.track = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/'+response.data.filename;
          audio.load();
          Nova.success('Recording fetched successfully.')
      })
      
    },
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
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
