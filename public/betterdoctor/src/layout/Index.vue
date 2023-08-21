<template>
  <transition
    :name="transitionName"
    :mode="transitionMode"
    :enter-active-class="transitionEnterActiveClass"
    @beforeLeave="beforeLeave"
    @enter="enter"
    ref="transition"
    @afterEnter="afterEnter"
  >
    <router-view></router-view>
  </transition>
</template>
<script>
export default {};
</script>
