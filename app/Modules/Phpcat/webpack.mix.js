const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();

// mix.js(__dirname + '/Resources/assets/js/app.js', 'js/phpcat.js')
//     .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/phpcat.css');


mix.copyDirectory(__dirname + '/Resources/assets/public', __dirname + '../../../../public/phpcat');
// mix.copyDirectory(__dirname + '/../../../../storage/app/phpcat-news', __dirname + '../../../../public/phpcat/phpcat-news');
// mix.copyDirectory(__dirname + '/Resources/assets/vendor', __dirname + '../../../../public/metrika/vendor');
// mix.copyDirectory(__dirname + '/Resources/assets/img', __dirname + '../../../../public/metrika/img' );

mix.js(__dirname + '/Resources/assets/js/app.js', 'public/phpcat/vue.js')
    .vue();


if (mix.inProduction()) {
    mix.version();
}
