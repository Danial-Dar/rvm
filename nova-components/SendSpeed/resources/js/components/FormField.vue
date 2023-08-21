<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <div class="">
        <div class="flex align-center">
          <div class="flex-1 mt-2">
            <Slider v-model="value" :min="1000" :max="250000" :step="2000" @change="check"/>
          </div>
        </div>
          <div class="mt-2">
            <input type="text" v-model="value" class="w-full form-control form-input form-input-bordered">
          </div>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Slider from '@vueform/slider'
export default {
  mixins: [FormField, HandlesValidationErrors],
  components: {
    Slider
  },
  props: ['resourceName', 'resourceId', 'field'],
mounted(){
console.log('field.value',this.field.value)
},
  data() {
    return {
      sendSpeed: (this.field.value) ? this.field.value : 100,
    }
  },
  methods: {
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

    check(){
      console.log('change') 
    }
  },
}
</script>
<style>

.slider {
  /* overwrite slider styles */
  width: 200px;
}
.slider-connect {
  background-color: rgba(var(--colors-primary-500)) !important;
}
.slider-tooltip {
  background: rgba(var(--colors-primary-500)) !important;
}
</style> 

<style src="@vueform/slider/themes/default.css"></style>