<template>
  <div>
    <div class="tabs">
      <div class="flex border-b">
        <div
          v-for="tab in tabs"
          class="xl:p-2 p-1 lg:p-2 md:p-2 sm:p-2 border rounded-t-sm cursor-pointer"
          :class="{
            'active text-primary': tab.isActive,
            'border-transparent': !tab.isActive
          }"
          @click="selectTab(tab)"
        >
          <div>{{ tab.name }}</div>
        </div>
      </div>
    </div>

    <div class="tabs-details">
      <slot></slot>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return { tabs: [] };
  },

  created() {
    this.tabs = this.$children;
  },
  methods: {
    selectTab(selectedTab) {
      this.tabs.forEach(tab => {
        tab.isActive = tab.name == selectedTab.name;
      });
    }
  }
};
</script>
