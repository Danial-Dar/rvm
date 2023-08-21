export default {
  methods: {
    copyValueToClipboard(value) {
      if (navigator.clipboard) {
        navigator.clipboard.writeText(value)
      } else if (window.clipboardData) {
        window.clipboardData.setData('Text', value)
      }
    },
  },
}
