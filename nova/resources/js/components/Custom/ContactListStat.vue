<template>
  <div>
      <span class="px-2">
        <Icon
          type="chart-bar"
          v-tooltip.click="__('View Contact List Stats')"
          @click.stop="update(id)"
        />
      </span>
  </div>
</template>
<script>
export default {
  props: {
    resource: {
      type: Object,
      default: {},
    },
  },
  data() {
    return {
      openResetModal() {
        this.showResetModal = true
      },
    }
  },
  computed: {
    id() {
      return this.resource.fields.find(a => a.attribute == 'id').value
    },
  },
  methods: {
    update(id) {
        console.log(this.id);
        Nova.visit('/contact-list-stat/'+this.id, { remote: false })
    },
  },
}
</script>
