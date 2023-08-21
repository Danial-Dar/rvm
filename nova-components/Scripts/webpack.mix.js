let mix = require('laravel-mix')
let path = require('path')

require('./nova.mix')

mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .vue({ version: 3 })
  .alias({'@': path.join(__dirname, '../../nova/resources/js/')})
  .css('resources/css/field.css', 'css')
  .nova('rvm/scripts')
