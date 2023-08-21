<template>
  <div
    class="absolute text-right right-0 mt-8 z-50 bg-black text-white-normal help-drop-down rounded-lg"
    v-click-outside="closeModal"
  >
    <button class="mt-1 px-2 focus:outline-none" @click="closeModal">
      <font-awesome-icon icon="times" />
    </button>
    <div class="text-left pb-5 px-5">
      <h1 class="text-3xl font-bold mb-3">Need help?</h1>
      <p class="text-base font-normal mb-1">
        <font-awesome-icon icon="envelope" />
        &nbsp;<span
          >Email us anytime at&nbsp;:
          <br>
          <a
            class="text-teal-400 underline"
            href="mailto:hello@getbetterdoctor.com"
            >hello@getbetterdoctor.com</a
          ></span
        >
      </p>
      <p class="text-base font-normal mb-3">
        <font-awesome-icon icon="phone" />&nbsp;<span
          >Call or text us at&nbsp;:
          <br>
          <a class="text-teal-400 underline" href="tel:+1 (855) 785-1636"
            >+1 (855) 785-1636</a
          >
        </span>
      </p>
      <p class="text-xs">
        (Mon – Fri: 9:30am - 9pm EST). Message and data rates may apply.
      </p>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    closeModal() {
      this.$emit("close");
    }
  }
};
</script>
