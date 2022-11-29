const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public/metrika').mergeManifest();

mix.copyDirectory(__dirname + '/Resources/assets/assets', __dirname + '../../../../public/metrika/assets');
mix.copyDirectory(__dirname + '/Resources/assets/vendor', __dirname + '../../../../public/metrika/vendor');
mix.copyDirectory(__dirname + '/Resources/assets/img', __dirname + '../../../../public/metrika/img' );

mix.js(__dirname + '/Resources/assets/js/app.js', 'public/metrika/vue.js')
    .vue();

// mix.js(
//     [
//         // __dirname + '/Resources/assets/js/app.js',
//         // __dirname + '/Resources/assets/assets/js/owl-carousel.js',
//         __dirname + '/Resources/assets/assets/js/animation.js',
//         __dirname + '/Resources/assets/assets/js/imagesloaded.js',
//         // __dirname + '/Resources/assets/assets/js/templatemo-custom.js'
//     ]
//     , 'public/metrika/metrika.js');

// mix.js(__dirname + '/Resources/assets/js/app.js', 'js/metrika.js')
//     .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/metrika.css');

if (mix.inProduction()) {
    mix.version();
}
