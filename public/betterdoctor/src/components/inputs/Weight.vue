<template>
  <div class="mb-2">
    <div class="flex">
      <input
        @input="formatValidateAndInput"
        :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
        class="w-full rounded-tl-lg rounded-bl-lg bg-white border focus:outline-none p-1 md:p-3 w-"
        :placeholder="placeholder"
        :name="name"
        type="tel"
        :value="value"
        :required="required"
        min="0"
        :max="800"
        :size="800"
        :maxlength="800"
        @keydown.delete="$emit('backspace')"
      />
      <div class="p-3 bg-gray-300 rounded-tr-lg rounded-br-lg">lbs</div>
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
    // Card
  },
  props: {
    type: {
      type: String,
      default: ""
    },
    label: {
      type: String,
      default: ""
    },
    name: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    required: {
      type: Boolean,
      default: true
    },
    v: {
      type: Object,
      default: null
    },
    value: {
      type: Number,
      default: ""
    }
  },
  methods: {
    formatValidateAndInput(evt) {
      // alert('sdsdssd')
      let value = evt.target.value;

 let replacedInput = value.match(/[a-zA-Z]+/)
      if(value == 0){
        value= null
      this.$emit("input", value);
      this.$forceUpdate();
      return// alert(value)
      }else{
        if(replacedInput == null)
      { 
      if (parseInt(value, 10) > 800) {
        value = 800;
      }
      if(value.length === 0){
      this.$emit("input", value);
      }else{
      this.$emit("input", parseInt(value, 10));
      }
      this.$forceUpdate();      
      }
      else
      {
        let orgInput = value.match(/[0-9]+/);
        value= orgInput
      this.$emit("input", value);
      this.$forceUpdate();
      return      
      }
      }
     
    }
  }
};
</script>
