<template>
  <div>
    <span ref="chartContainer"></span>
    {{'('+field.value+ '%)'}}
  </div>
</template>

<script>
var ProgressBar = require("progressbar.js");
import { nextTick } from 'vue'

export default {
  props: ["resourceName", "field"],
  data() {
    return {
      bar: null,
      options: {
        strokeWidth: 4,
        color: "#FFEA82",
        percentage: 1.0,
        type: "line",
        sub: null
      }
    };
  },
  mounted:async function() {
    let vm = this;
    Nova.$on('change-progress-'+this.field.campaign.id, this.handleProgressChange)
    await nextTick();
    this.bar = new ProgressBar.Line(this.$refs.chartContainer, {
      strokeWidth: 4,
      easing: 'easeInOut',
      duration: 5000,
      color: '#62fc03',
      trailColor: '#eee',
      trailWidth: 1,
      svgStyle: {width: '100%', height: '100%'},
      from: {color: '#fc0303'},
      to: {color: '#62fc03'},
      step: (state, bar) => {
          bar.path.setAttribute('stroke', state.color);
      }
    });
    this.drawLine();
  },
  methods: {
    async handleProgressChange(payload) {
      this.field.value = parseFloat(payload.progress)
      Nova.info('Campaign Id: ' + this.field.campaign.id + ' completed its processing to '+(payload.progress) + '%');
      await nextTick();
      this.drawLine();
    },
    drawLine() {
      this.bar.animate(this.field.value / 100);
    }
  }
};
</script>
