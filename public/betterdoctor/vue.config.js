const webpack = require('webpack')

module.exports = {
  configureWebpack: {
    plugins: [
      new webpack.optimize.LimitChunkCountPlugin({
        maxChunks: 50
      })
    ]
  },
  chainWebpack:
    config => {
      config.optimization.delete('splitChunks')
      config.amd(false)
    },
    lintOnSave: false,
  // devServer: {
  //   host: 'better-forms.test',
  //   port: 8081,
  //   https: false
  // },
  filenameHashing: false,
  lintOnSave: false,
  publicPath: './'
}
