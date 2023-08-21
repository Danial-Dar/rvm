<template>
  <div class="font-bold mb-2">{{ label }}</div>
</template>
<script>
export default {
  props: {
    label: {
      type: String,
      default: ""
    }
  }
};
</script>
