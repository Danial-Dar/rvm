<template>
  <FieldWrapper :stacked="field.stacked" v-if="field.visible">
    <div
      class="px-8 mt-2 md:mt-0"
      :class="field.stacked ? 'md:pt-5 w-full' : 'w-full md:w-1/5 md:py-5'"
    >
      <slot>
        <FormLabel
          :label-for="labelFor || field.uniqueKey"
          class="field-label"
          :class="{ 'mb-2': showHelpText && field.helpText }"
        >
          {{ fieldLabel }}
          <span v-if="field.required" class="text-red-500 text-sm">
            {{ __('*') }}
          </span>
        </FormLabel>
      </slot>
    </div>

    <div
      class="mt-1 md:mt-0 pb-5 px-8 flex"
      :class="field.stacked ? 'md:pt-5 w-full' : 'w-full md:w-3/5 md:py-5'"
    >
      <div class="w-full">
        <slot name="field" />
        <div class="error-help-text" v-if="showErrors && hasError">
          {{ firstError }}
        </div>
      </div>
      <div class="ml-2 help-text-wrapper"  v-if="showHelpText">
        <Icon type="exclamation-circle" :solid="true" />
        <HelpText
            class="help-text mt-2"
            v-if="showHelpText"
            v-html="field.helpText"
          />
      </div>
    </div>
  </FieldWrapper>
</template>

<script>
import { HandlesValidationErrors, mapProps } from '@/mixins'

export default {
  mixins: [HandlesValidationErrors],

  props: {
    field: { type: Object, required: true },
    fieldName: { type: String },
    showErrors: { type: Boolean, default: true },
    fullWidthContent: { type: Boolean, default: false },
    labelFor: { default: null },
    ...mapProps(['showHelpText']),
  },

  computed: {
    /**
     * Return the label that should be used for the field.
     */
    fieldLabel() {
      // If the field name is purposefully an empty string, then let's show it as such
      if (this.fieldName === '') {
        return ''
      }

      return this.fieldName || this.field.name || this.field.singularLabel
    },
  },
}
</script>
<style>
.help-text-wrapper {
  position: relative;
  margin-top: 0.35rem;
}
.help-text-wrapper:hover .help-text {
  display: block;
}
.help-text {
  position: absolute;
  background: #fff;
  padding: 0.75rem;
  /* left: 2rem; */
  display: none;
  top: 2px;
  right: 1rem;
  width: 300px;
  border: 1px solid;
  z-index: 100000;
  border-radius: 10px;
}
.error-help-text {
  --tw-text-opacity: 1;
    color: rgba(var(--colors-red-500), var(--tw-text-opacity));
}
</style>
