<template>
  <input
      @input="formatValidateAndInput"
      :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
      class="bg-white border focus:outline-none p-3 w-full"
      :placeholder="placeholder"
      :name="name"
      :type="type"
      :value="value"
      :required="required"
      :readonly="readonly"
      min="0"
      :max="max"
      :maxlength="max"
      :size="max"
      :pattern="name == 'phoneNumber' ? `\\d*` : ''"
      @keydown.delete="$emit('backspace')"
      :ref="name"
    />
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
    readonly: {
      type: String,
      default: null
    },    
    required: {
      type: Boolean,
      default: true,
    },
    v: {
      type: Object,
      default: null,
    },
    question: {
      type: String,
      default: null,
    },
    value: {
      type: String,
      default: "",
    },
  },
  methods: {
    formatValidateAndInput(evt) {
      let value = evt.target.value;
      console.log(this.name)
      if (this.name == "phoneNumber") {
        let replacedInput = value
          .replace(/\D/g, "")
          .match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        if (value.match(/[a-zA-Z]\D+/) != null) {
          // alert('Please Remove Alphabets')
          this.errorMessage = "Alphabets Or Special Characters are not allowed";
        } else {
          this.errorMessage = null;
        }
        value = !replacedInput[2]
          ? replacedInput[1]
          : "(" +
            replacedInput[1] +
            ") " +
            replacedInput[2] +
            (replacedInput[3] ? "-" + replacedInput[3] : "");
      } else if (this.name == "height") {
        // alert('sd')
        value = value.replaceAll("'", "");
        let replacedInput = value
          .replace(/\D/g, "")
          .match(/(\d{0,1})(\d{0,2})/);
        if (value.length > 1) {
          if (parseInt(replacedInput[1], 10) > 9) {
            replacedInput[2] = "9";
          }
          if (parseInt(replacedInput[2], 10) > 12) {
            replacedInput[2] = "12";
          }
          value = replacedInput[1] + "'" + replacedInput[2] + `''`;
        }
      } else if (this.name == "firstName") {
        let replacedInput = value.match(/[a-zA-Z]+/);

        if (replacedInput == null) {
          this.$refs.firstName.value = replacedInput
          value = replacedInput
        //  alert(this.$refs.firstName.value)
        } else {
          value = replacedInput;
        }
        // } else {
        //   value = replacedInput;
        // }
      } else if (this.name == "lastName") {
        let replacedInput = value.match(/[a-zA-Z]+/);

        if (replacedInput == null) {
          this.$refs.lastName.value = replacedInput
          value = replacedInput
        } else {
          value = replacedInput;
        }
      }else if(this.name == "state" ){
         let replacedInput = value.match(/[a-zA-Z]+/);
         console.log(replacedInput)

        if (replacedInput == null) {
          this.$refs.state.value = replacedInput
          value = replacedInput
        } else {
          value = replacedInput;
        }
      }else if(this.name == "city"){
         let replacedInput = value.match(/^[a-zA-Z ]*$/);
         console.log(replacedInput)

        if (replacedInput == null) {
          this.$refs.city.value = replacedInput
          value = replacedInput
        } else {
          value = replacedInput;
        }
      }else if(this.name == "country"){
         let replacedInput = value.match(/[a-zA-Z]+/);
         console.log(replacedInput)

        if (replacedInput == null) {
          this.$refs.country.value = replacedInput
          value = replacedInput
        } else {
          value = replacedInput;
        }
      }
      this.$emit("input-updated", value);
    },
  },
  computed: {
    max() {
      switch (this.name) {
        case "height":
          return 6;
        case "phoneNumber":
          return 14;
        default:
          return null;
          break;
      }
    },
  },
  data() {
    return {
      errorMessage: null,
    };
  },
};
</script>
