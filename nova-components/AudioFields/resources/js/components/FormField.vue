<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <input
        type="file"
        :id="field.attribute"
        class="w-full form-control form-input form-input-bordered"
        :placeholder="field.name"
        :value="value"
        @input="setAudio"
      />
      <input type="hidden"  :id="field.attribute + 'temp'" value="">
      <span v-if="!showSlot" style="color: red">* Please Upload audio file to see preview</span>
      <div class="flex relative w-full mt-2" v-if="showSlot" >
          <audio id="recordingPlay" controls>
              <source :src="audioPath" type="audio/wav">
          </audio>
      </div>
      <input type="hidden" id="hidden" v-model="field.value">
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import axios from 'axios'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],
data(){
  return {
    audioPath: null,
    showSlot: false,
    tempValue: null,

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
      console.log('value',this.field.name)
      this.showSlot = true
      this.audioPath = URL.createObjectURL(e.target.files[0])

      let formdata = new FormData();

      const headers = { 'Content-Type': 'multipart/form-data' };

      formdata.append('file',e.target.files[0]);
      formdata.append('name',this.field.name);

let vm = this
      Nova.request().post('/nova-api/survey/save',formdata, headers).then(res => {

        if(res.data.status){
        this.field.value = res.data.id;
        vm.tempValue = res.data.id;
        
        this.value = this.field.value;
        document.getElementById(this.field.attribute + 'temp').value = res.data.id
        console.log('res.data.id',res.data.id)
        this.$forceUpdate();
        }
      })
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
