<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <text-field 
      type="tel"
      :value="field.value" 
      @input-updated="inputNumber" 
      name="phoneNumber"
      class="w-full form-control form-input form-input-bordered"
      id="number-update-client-number-1322731-text-field"
      />
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

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
    inputNumber(value) {
      this.field.value = value;
    }
  },
}
</script>
