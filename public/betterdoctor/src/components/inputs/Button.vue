<template>
  <button
    class="bg-primary px-3 py-2 rounded text-white-normal mr-3"
    @click="$emit(action)"
  >
    {{ label }}{{ value }}
  </button>
</template>
<script>
export default {
  props: {
    label: {
      default: null,
      type: String
    },
    action: {
      default: null,
      type: String
    },
    value: {
      default: null,
      type: String
    }
  }
};
</script>
