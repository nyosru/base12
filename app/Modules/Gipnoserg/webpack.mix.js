const dotenvExpand = require('dotenv-expand')
dotenvExpand(require('dotenv')
.config({ path: '../../.env' /*, debug: true*/ }))

const mix = require('laravel-mix')
require('laravel-mix-merge-manifest')

// mix.setPublicPath('../../public').mergeManifest()

// mix.js(__dirname + '/Resources/assets/js/app.js', 'js/gipnoserg.js')
//     .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/gipnoserg.css');

mix.copyDirectory(
  __dirname + '/Resources/assets/public',
  __dirname + '../../../../public/gipnoserg',
)

mix.js(__dirname + '/Resources/assets/js/app.js', 'public/gipnoserg/vue.js').vue();
// mix.js(__dirname + '/Resources/assets/js/app.js', 'public/gipnoserg/vue.js')

if (mix.inProduction()) {
  mix.version()
}
