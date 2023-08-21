<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      

      <vue-csv-import
      :id="field.attribute"
      v-model="field.value"
      :fields="{ phone: { required: true, label: 'Phone' } }"
      >
      <vue-csv-toggle-headers></vue-csv-toggle-headers>
     <br>
      <vue-csv-errors></vue-csv-errors>
      <br>
      <vue-csv-input></vue-csv-input>
      <br>
      <vue-csv-map :auto-match="true"></vue-csv-map>

      </vue-csv-import>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import {
  VueCsvToggleHeaders,
  VueCsvSubmit,
  VueCsvMap,
  VueCsvInput,
  VueCsvErrors,
  VueCsvImport,
} from 'vue-csv-import'
export default {
  components: {
    VueCsvImport,
    VueCsvErrors,
    VueCsvInput,
    VueCsvMap,
    VueCsvSubmit,
    VueCsvToggleHeaders,
  },
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
  },
}
</script>
