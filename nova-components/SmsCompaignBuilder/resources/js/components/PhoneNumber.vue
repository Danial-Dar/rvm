<template>
    <input
        type="text"
        ref="input"
        class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
        :required="required"
        @change="handleChange"
        :value="value"
    />
</template>

<script>
import PhoneMasks from '../data/phone-masks.json';
import Inputmask from 'inputmask';
import { HandlesValidationErrors } from 'laravel-nova';
import { map, filter } from 'lodash';

export default {
    mixins: [HandlesValidationErrors],
    props: ['value', 'required'],

    data() {
        return {
            builtInMasks: [],
            customMasks: [],
        };
    },
    computed: {
        availableMasks() {
            let masks = this.builtInMasks.concat(this.customMasks);
            masks = masks.sort();
            masks = map(masks, mask => this.formatToInputmask(mask));

            return !masks.length ? '9{1,20}' : masks;
        },
    },
    mounted() {
        this.setBuiltInMasks();

        this.setCustomMasks();

        Inputmask(this.availableMasks).mask(this.$refs.input);
    },
    methods: {
        setInitialValue() {
            this.value = '';
        },
        setBuiltInMasks() {
            let countries = [];

            let masks = !countries.length ? PhoneMasks : this.loadMasksForCountries(countries);

            this.builtInMasks = map(masks, obj => obj.mask);
        },
        setCustomMasks() {
            this.customMasks = [];
        },
        loadMasksForCountries(countries) {
            return filter(PhoneMasks, obj => {
                return countries.includes(obj.country_code);
            });
        },
        formatToInputmask(value) {
            return value ? value.replace(/9/gi, '\\9').replace(/#/gi, '9') : '';
        },
        handleChange(event) {
            this.$emit('update:modelValue', event.target.value)
            this.$forceUpdate()
        },
    },
};
</script>
