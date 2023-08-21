<template>
  <div class="mb-2">
    <div class="flex">
      <div class="flex w-2/2 mb-0 sm:mr-2 sm:ml-0 -mr-5 -ml-2">
        <input
          :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
          class="
            w-full
            rounded-tl-lg rounded-bl-lg
            bg-white
            border
            focus:outline-none
            p-1
            md:p-3
          "
          :placeholder="placeholder"
          :name="name"
          type="tel"
          v-model="result['feet']"
          :required="required"
          @input="moveToInches"
          min="0"
          :max="800"
          :size="800"
          :maxlength="800"
          @keydown.delete="$emit('backspace')"
        />
        <div class="md:p-3 p-2 bg-gray-300 rounded-tr-lg rounded-br-lg">Feet</div>
      </div>
      
    </div>
    <div class="flex">

     <div class="flex w-2/2 mt-5 sm:mr-2 sm:ml-0 -mr-5 -ml-2 ">
        <input
          :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
          class="
            w-full
            rounded-tl-lg rounded-bl-lg
            bg-white
            border
            focus:outline-none
            p-1
            md:p-3
          "
          placeholder="Inches (Less then 12)"
          :name="name"
          type="tel"
          v-model="result['inches']"
          :required="required"
          @input="validateInches"
          ref="inches"
          min="0"
          :max="800"
          :size="800"
          :maxlength="800"
          @keydown.delete="$emit('backspace')"
        />
        <div class="md:p-3 p-2 bg-gray-300 rounded-tr-lg rounded-br-lg">Inches</div>
      </div>
    </div>
    <template v-if="v">
      <span
        class="text-red-500 text-xs ml-1"
        v-if="v.$anyError && v.required == false"
        >Field is required</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-if="v.$anyError && v.email == false"
        >Email is not valid</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-else-if="v.$anyError && v.minLength == false"
        >Field value is not in minimum allowed range</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-else-if="v.$anyError && v.maxLength == false"
        >Field value is beyond maximum allowed range</span
      >
      <span v-else></span>
    </template>
  </div>
</template>
<script>
// import Card from "@/components/design/Card.vue";
export default {
  components: {
    // Card,
  },
  props: {
    type: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    required: {
      type: Boolean,
      default: true,
    },
    result: {
      type: Object,
      default: null,
    },
    v: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    this.$emit("update-validation", [
      {
        name: "feet",
      },
      {
        name: "inches",
      },
    ]);
  },
  methods: {
    formatValidateAndInput(evt) {
      let value = evt.target.value;
      if (parseInt(value, 10) > 800) {
        value = 800;
      }
      this.$emit("input", parseInt(value, 10));
      this.$forceUpdate();
    },
    moveToInches(evt) {
      let value = evt.target.value;

      let replacedInput = value.match(/[a-zA-Z@$-/:-?{-~!"^_`\[\]]+/);

      if(value == 0 || value == null ) {
        this.result["feet"] = null; 
      // value = 1
        // alert('isd')
      }else{

if (replacedInput == null) {
        value = parseInt(value.toString(), 10);
        if (value !== null && value !== undefined && value !== "") {
          if (value > 10) {
            this.result["feet"] = 9;
          }
          this.$refs.inches.focus();
        }
      }else {
        this.result["feet"] = null;
      }
      }
      
    },
    validateInches(evt) {
      let value = evt.target.value;

      let replacedInput = value.match(/[a-zA-Z@$-/:-?{-~!"^_`\[\]]+/);

      if (replacedInput == null) {
        value = parseInt(value.toString(), 10);
        if (value !== null && value !== undefined && value !== "") {
          if (value > 11) {
            this.result["inches"] = 11;
          }
        }
      } else {
        this.result["inches"] = null;
      }
    },
  },
};
</script>
