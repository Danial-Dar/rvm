<template>
  <div class="checkbox">
    <div
      v-for="option in options"
      :key="option.value"
      class="border rounded bg-white-light p-3 mb-2"
      :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
    >
      <input
        type="checkbox"
        :id="option.text"
        :name="name"
        @click="nextOrNot(option, $event.target.value, $event)"
        :checked="value.some(a =>  (a ==option.value))"
        :disabled="value.some(a =>  (option.value == null && a == null))"
        :value="option.value"
        class="mr-3"
      />
      <label class="text-grey-light text-lg" :for="option.text">{{
        option.text
      }}</label>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      checks: []
    };
  },
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
      type: Array,
      default: () => {
        return [];
      }
    },
    v: {
      type: Object,
      default: null
    }
  },
  methods: {
    nextOrNot(option, value, evt) {
      console.log('clicked')
      console.log(this.value.length)
      console.log('value')
      if(this.value === null){
      console.log('deselect')

      }
      const temp = this.value

      temp.map(item => {
        if(item === null){
          let checkedItems = this.value.filter(a => a !== null);
          this.value = checkedItems
          this.$emit("input", checkedItems);
        }
      })
      let vm = this;
      if (option.action && option.action == "failed") {
        this.$emit("failed", option.failedText);
        evt.preventDefault();
        return;
      }
      if (option.next && evt.target.checked == true) {
        this.$emit("input", [null]);
        this.$emit("next");
      } else if (this.value.find(a => a === value)) {
        let checkedItems = this.value.filter(a => a !== value);
        this.$emit("input", checkedItems);
      } else {
        let checkedItems = this.value;
        checkedItems.push(value);
        this.$emit("input", checkedItems);
      }
    }
  },
  mounted(){
    console.log(this.value)
    const temp = this.value
    if(this.value.length > 1){

    temp.map(item => {
      if(item === null){
        let checkedItems = this.value.filter(a => a !== 'noneofthese');
        this.$emit("input", checkedItems);
      }
    })}
  }
};
</script>
