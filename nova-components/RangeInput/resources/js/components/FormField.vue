<template>
    <SmallField :field="field" :errors="errors" :show-help-text="showHelpText">
        <template #label>
            <div>{{label}}</div>
        </template>
        <template #field>
            <div class="flex-1">
                <div class="flex">
                    <input type="range" :id="field.attribute" v-model="value" min="0" max="250000" step="1000"
                        :placeholder="field.name">
                </div>
                <div class="flex-1 mt-2">
                    <input class="w-full form-control form-input form-input-bordered" type="number" :id="field.attribute" v-model="value" :min="0" :max="250000"
                        :placeholder="field.name">
                </div>
            </div>
        </template>
    </SmallField>
</template>

<script>
    import {
        FormField,
        HandlesValidationErrors
    } from 'laravel-nova'

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
        },
    }

</script>
