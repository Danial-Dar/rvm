const tailwindcss = require("tailwindcss");
const autoprefixer = require("autoprefixer");

// postcss.config.js
const purgecss = require("@fullhuman/postcss-purgecss")({
  // Specify the paths to all of the template files in your project
  content: [
    "./src/**/*.html",
    "./src/**/*.vue",
    "./src/**/*.jsx"
    // etc.
  ],

  // This is the function used to extract class names from your templates
  defaultExtractor: content => {
    // Capture as liberally as possible, including things like `h-(screen-1.5)`
    const broadMatches = content.match(/[^<>"'`\s]*[^<>"'`\s:]/g) || [];

    // Capture classes within other delimiters like .block(class="w-1/2") in Pug
    const innerMatches = content.match(/[^<>"'`\s.()]*[^<>"'`\s.():]/g) || [];

    return broadMatches.concat(innerMatches);
  },
  safelist: [
    /-(leave|enter|appear)(|-(to|from|active))$/,
    /^(?!(|.*?:)cursor-move).+-move$/,
    /^router-link(|-exact)-active$/,
    /^vue-slider./,
    /data-v-.*/
  ]
});

module.exports = {
  chainWebpack: (config) => {

    /* 
       Disable (or customize) prefetch, see:
       https://cli.vuejs.org/guide/html-and-static-assets.html#prefetch
    */
    config.plugins.delete('prefetch')

    /* 
       Configure preload to load all chunks
       NOTE: use `allChunks` instead of `all` (deprecated)
    */
    config.plugin('preload').tap((options) => {
      options[0].include = 'allChunks'
      return options
    })
  },
  plugins: [
    tailwindcss("./tailwind.config.js"),
    autoprefixer({
      add: true
    }),
    // require('@fullhuman/postcss-purgecss')({
    //   content: [ `./public/**/*.html`, `./src/**/*.vue` ],
    //   defaultExtractor (content) {
    //     const contentWithoutStyleBlocks = content.replace(/<style[^]+?<\/style>/gi, '')
    //     return contentWithoutStyleBlocks.match(/[A-Za-z0-9-_/:]*[A-Za-z0-9-_/]+/g) || []
    //   },
    //   whitelist: [],
    //   whitelistPatterns: [ /-(leave|enter|appear)(|-(to|from|active))$/, /^(?!(|.*?:)cursor-move).+-move$/, /^router-link(|-exact)-active$/ ],
    // })
  ]
};
