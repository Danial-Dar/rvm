<template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="redirect"
        class="
          flex-shrink-0
          shadow
          rounded
          focus:outline-none
          ring-primary-200
          dark:ring-gray-600
          focus:ring
          bg-primary-500
          hover:bg-primary-400
          active:bg-primary-600
          text-white
          dark:text-gray-800
          inline-flex
          items-center
          font-bold
          px-4
          h-9
          text-sm
          flex-shrink-0
        "
      >
        Create Phrase
      </button>
    </div>
    <!-- <vue-csv-import
      v-model="csv"
      ref="csv"
      :fields="{ phone: { required: true, label: 'Phone' } }"
    > -->
        <!-- </vue-csv-import> -->
  </div>
</template>

<script>
export default {
  components: {
  },
  data() {
    return {
    }
  },
  methods: {
    redirect(event) {
         Nova.visit('/resources/phrases/new',{remote:false})
    },
  },
}
</script>

<style scoped>
</style>

