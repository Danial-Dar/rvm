<template>
  <div>
      <span class="px-2">
        <Icon
          type="plus-circle"
          v-tooltip.click="__('Add Call Flow Step')"
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
        Nova.visit('/new-call-flow-step/'+this.id, { remote: false })
    },
  },
}
</script>
