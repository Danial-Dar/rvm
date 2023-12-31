<template>
  <div class="sidebar-item">
    <Link
      v-if="useInertiaLink"
      v-bind="linkAttributes"
      class="sidebar-item-title"
      :class="{ 'inertia-link-active': item.active }"
      @click="handleClick"
    >
      <span class="sidebar-item-icon" />
      <span class="sidebar-item-label">
        {{ item.name }}
      </span>
    </Link>

    <a
      v-else
      :href="item.path"
      target="_blank"
      class="sidebar-item-title"
      @click="handleClick"
    >
      <span class="sidebar-item-icon sidebar-icon" />
      <span class="sidebar-item-label">
        {{ item.name }}
      </span>
    </a>
  </div>
</template>

<script>
import pickBy from 'lodash/pickBy'
import identity from 'lodash/identity'
import { mapGetters, mapMutations } from 'vuex'

export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  methods: {
    ...mapMutations(['toggleMainMenu']),

    handleClick() {
      if (this.mainMenuShown) {
        this.toggleMainMenu()
      }
    },
  },

  computed: {
    ...mapGetters(['mainMenuShown']),

    requestMethod() {
      return this.item.method || 'GET'
    },

    useInertiaLink() {
      return !(this.item.external && this.requestMethod === 'GET')
    },

    linkAttributes() {
      let method = this.requestMethod

      return pickBy(
        {
          href: this.item.path,
          method: method !== 'GET' ? method : null,
          headers: this.item.headers || {},
          data: this.item.data || {},
          as: method !== 'GET' ? 'button' : null,
          type: method !== 'GET' ? 'button' : null,
        },
        identity
      )
    },
  },
}
</script>
