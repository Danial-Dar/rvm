<template>
  <div class="shadow-lg">
    <div class="bg-white-normal header">
      <div class="container mx-auto">
        <div class="flex justify-between px-4 md:px-20 items-center">
          <router-link tag="div" to="/" class="py-2 cursor-pointer">
            <img width="120" height="56px" src="@/assets/images/logo.svg" class="mt-1" />
          </router-link>
          <div class="text-grey-dim font-bold relative">
            <span
              class="cursor-pointer hover:text-primary"
              @click="showDropDown = true"
            >
              Help?</span
            >
            <transition name="fade">
              <HelpDropDown v-if="showDropDown" @close="showDropDown = false" />
            </transition>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import HelpDropDown from "@/components/design/HelpDropDown.vue";
export default {
  data() {
    return {
      showDropDown: false
    };
  },
  components: {
    HelpDropDown
  }
};
</script>
