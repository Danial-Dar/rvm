<template>
  <div class="radio">
    <div
      v-for="option in options"
      :key="option.value"
      class="border rounded bg-white-light p-3 mb-2"
    >
      <input
        type="radio"
        :id="option.value"
        :name="name"
        @click="input(option, $event)"
        class="mr-3"
        :value="option.value"
        :checked="option.value == value"
      />
      <label class="text-grey-light text-lg" :for="option.value">{{
        option.text
      }}</label>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    options: {
      type: Array,
      default: null
    },
    name: {
      type: String,
      default: ""
    },
    value: {
      type: String,
      default: null
    },
    v: {
      type: Object,
      default: null
    }
  },
  methods: {
    input(option, event) {
      // alert(option.value)
      if(option.value == "Never been seen for depression"){
// alert('d')
        this.$emit("input", event.target.value, true);
        this.$router.push('11')
      }else{
      if (option.action && option.action == "failed") {
        this.$emit("failed", option.failedText);
        event.preventDefault();
        return;
      } else if (option.move == true) {
        this.$emit("input", event.target.value, true);
      } else {
        if (option.commit) {
          this.$store.commit(option.commit);
        }
        this.$emit("input", event.target.value);
      }
      }
      
    }
  }
};
</script>
