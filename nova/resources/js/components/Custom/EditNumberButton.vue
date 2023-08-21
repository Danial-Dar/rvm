<template>
  <div>
      <span class="px-2">
        <Icon
          type="pencil"
          v-tooltip.click="__('Edit')"
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
        Nova.visit('/edit-mynumber/'+this.id, { remote: false })
    },
  },
}
</script>