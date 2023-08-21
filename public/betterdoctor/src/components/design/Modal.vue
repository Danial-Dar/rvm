<template>
  <transition name="modal">
    <div :style="{ zIndex: zIndex }" class="modal-mask">
      <div class="modal-wrapper">
        <div
          v-click-outside="closeModal"
          :class="{ wide: wide, 'ultra-wide': ultraWide }"
          class="modal-container rounded-lg"
        >
          <div
            v-if="!forGuide"
            class="modal-header bg-primary text-white-normal px-2 rounded-t-lg"
          >
            <slot name="header"></slot>
          </div>

          <div :class="{ 'no-padd': forGuide }" class="modal-body text-center">
            <slot name="body"></slot>
          </div>

          <div v-if="hidefooter == false" class="modal-footer">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    forGuide: {
      type: Boolean,
      default: false
    },
    hidefooter: {
      type: Boolean,
      default: false
    },
    canvas: {
      type: Boolean,
      default: false
    },
    wide: {
      type: Boolean,
      default: false
    },
    ultraWide: {
      type: Boolean,
      default: false
    },
    zIndex: {
      type: Number,
      default: 10000
    }
  },
  methods: {
    closeModal: function() {
      if (this.canvas == false) this.$emit("close");
    }
  }
};
</script>
