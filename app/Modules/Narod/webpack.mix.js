const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', __dirname + '../../../../public/narod/vue.js')
    .sass( __dirname + '/Resources/assets/app.scss', __dirname + '../../../../public/narod/css.css');

mix.copyDirectory(__dirname + '/Resources/assets/public', __dirname + '../../../../public/narod');

if (mix.inProduction()) {
    mix.version();
}

