<template>
  <div class="sidebar-section" v-if="item.path || item.items.length > 0">
    <!-- Section title with link -->
    <Link
      v-if="item.path"
      :href="item.path"
      class="sidebar-section-title"
      @click="toggleMainMenu"
    >
      <span class="sidebar-label">
        <span class="sidebar-icon">
          <component
            :is="`heroicons-outline-${item.icon}`"
            height="24"
            width="24"
          />
        </span>

        <span
          :class="{ 'font-bold inertia-link-active': item.active }"
          class="sidebar-section-label"
        >
          {{ item.name }}
        </span>
      </span>
    </Link>

    <!-- Collapsable Section -->
    <button
      v-else-if="!item.path && item.collapsable"
      :aria-expanded="ariaExpanded"
      class="sidebar-section-title"
      @click="handleClick"
    >
      <span class="sidebar-label">
        <span class="sidebar-icon">
          <component
            :is="`heroicons-outline-${item.icon}`"
            height="24"
            width="24"
          />
        </span>

        <span class="sidebar-section-label">
          {{ item.name }}
        </span>
      </span>

      <CollapseButton :collapsed="collapsed" :to="item.path" class="ml-auto" />
    </button>

    <h3 v-else class="sidebar-section-title">
      <span class="sidebar-label">
        <span class="sidebar-icon">
          <component
            :is="`heroicons-outline-${item.icon}`"
            height="24"
            width="24"
          />
        </span>

        <span class="sidebar-section-label">
          {{ item.name }}
        </span>
      </span>
    </h3>

    <template v-if="!collapsed">
      <div class="mt-1 space-y-1">
        <component
          :is="item.component"
          v-for="item in item.items"
          :key="item.name"
          :item="item"
        />
      </div>
    </template>
  </div>
</template>

<script>
import { Collapsable } from '@/mixins'
import { mapMutations } from 'vuex'

export default {
  mixins: [Collapsable],

  props: ['item'],

  methods: {
    ...mapMutations(['toggleMainMenu']),

    handleClick() {
      this.toggleCollapse()
    },
  },
}
</script>
