<template>
  <div class="radio">
    <div class="flex">
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 1 == value
        }"
        @click="input(1)"
      >
        <img src="@/assets/images/hair/1.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 2 == value
        }"
        @click="input(2)"
      >
        <img src="@/assets/images/hair/2.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 3 == value
        }"
        @click="input(3)"
      >
        <img src="@/assets/images/hair/3.png" alt="" srcset="" width="100px" />
      </div>
    </div>
    <div class="flex">
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 4 == value
        }"
        @click="input(4)"
      >
        <img src="@/assets/images/hair/4.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 5 == value
        }"
        @click="input(5)"
      >
        <img src="@/assets/images/hair/5.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 6 == value
        }"
        @click="input(6)"
      >
        <img src="@/assets/images/hair/6.png" alt="" srcset="" width="100px" />
      </div>
    </div>
    <div class="flex">
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 7 == value
        }"
        @click="input(7)"
      >
        <img src="@/assets/images/hair/7.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 8 == value
        }"
        @click="input(8)"
      >
        <img src="@/assets/images/hair/8.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 9 == value
        }"
        @click="input(9)"
      >
        <img src="@/assets/images/hair/9.png" alt="" srcset="" width="100px" />
      </div>
    </div>
    <div class="flex">
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 10 == value
        }"
        @click="input(10)"
      >
        <img src="@/assets/images/hair/10.png" alt="" srcset="" width="100px" />
      </div>
      <div
        class="border rounded bg-white-light p-3 mb-2 mr-4"
        :class="{
          'border-red-300 placeholder-red-300': v && v.$error,
          'border-primary': 11 == value
        }"
        @click="input(11)"
      >
        <img src="@/assets/images/hair/11.png" alt="" srcset="" width="100px" />
      </div>
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
    input(value) {
      this.$emit("input", value);
    }
  }
};
</script>
