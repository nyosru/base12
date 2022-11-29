const dotenvExpand = require("dotenv-expand");
dotenvExpand(
    require("dotenv").config({ path: "../../.env" /*, debug: true*/ })
);

const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

// mix.setPublicPath('../../public').mergeManifest();

mix.copyDirectory(
    __dirname + "/Resources/assets",
    __dirname + "../../../../public/billiard"
);

// mix.js(__dirname + '/Resources/assets/js/app.js', 'js/billiard.js')
//     .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/billiard.css');

mix
    // .options({
    //     postCss: [
    //         // require('postcss-css-variables')(),
    //         processCssUrls: false
    //     ]
    // })
    // ;

    // mix
    .styles(
        [
            __dirname + "/Resources/assets/css/main.css",
            __dirname + "/Resources/assets/css/extras.css",
            __dirname + "/Resources/assets/css/responsive.css",
            __dirname + "/Resources/assets/css/animate.css",
            //             __dirname + '/Resources/assets/assets/css/headroom.css',
            //             __dirname + '/Resources/assets/assets/css/animate.css',
            //             // __dirname + '/Resources/assets/assets/css/bardy.icon.css',
            //             __dirname + '/Resources/assets/assets/css/swiper.min.css',
            //             __dirname + '/Resources/assets/assets/css/fancybox.min.css',
            //             __dirname + '/Resources/assets/assets/css/slicknav.css',
            //             __dirname + '/Resources/assets/assets/css/aos.min.css',
            //             // __dirname + '/Resources/assets/assets/css/style.css',
        ],
        __dirname + "../../../../public/billiard/css.css"
    )
    .sass(
        __dirname + "/Resources/assets/css.scss",
        __dirname + "../../../../public/billiard/scss.css"
        // , {
        //     precision: 5
        // }
        )
    ;

if (mix.inProduction()) {
    mix.version();
}
//----------
// const dotenvExpand = require('dotenv-expand');

// //dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

// const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');

// // mix.setPublicPath( '../../public/kadastr' ).mergeManifest();
// // mix.setPublicPath( '../../public/kadastr' ).mergeManifest();

// mix.copyDirectory(__dirname + '/Resources/assets', __dirname + '../../../../public/kadastr' );

// mix.js(
//     [
//         // __dirname + '/Resources/assets/js/app.js',

//         // __dirname + '/Resources/assets/SpaceDynamic/vendor/jquery/jquery.min.js',
//         __dirname + '/Resources/assets/SpaceDynamic/vendor/bootstrap/js/bootstrap.bundle.min.js',
//         // __dirname + '/Resources/assets/SpaceDynamic/assets/js/owl-carousel.js',
//         // __dirname + '/Resources/assets/SpaceDynamic/assets/js/animation.js',
//         __dirname + '/Resources/assets/SpaceDynamic/assets/js/imagesloaded.js',
//         __dirname + '/Resources/assets/SpaceDynamic/assets/js/templatemo-custom.js'
//     ], __dirname + '../../../../public/kadastr/js.js'
//     )

//     .styles(
//         [
//             __dirname + '/Resources/assets/SpaceDynamic/assets/css/animated.css',
//             //__dirname + '/Resources/assets/SpaceDynamic/assets/css/fontawesome.css',
//             __dirname + '/Resources/assets/SpaceDynamic/assets/css/owl.css',
//             // __dirname + '/Resources/assets/SpaceDynamic/assets/css/templatemo-space-dynamic.css',
//         ], __dirname + '../../../../public/kadastr/css.css'
//     );

//     // mix// .browserSync('zz1.php-cat.com');

//     // .sass(
//     //     __dirname + '/Resources/assets/sass/app.scss', 'css/kadastr.css'
//     //     )
//         // ;

// if (mix.inProduction()) {
//     mix.version();
// }
