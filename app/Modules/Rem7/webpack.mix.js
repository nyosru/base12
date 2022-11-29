const dotenvExpand = require("dotenv-expand");
dotenvExpand(
    require("dotenv").config({ path: "../../.env" /*, debug: true*/ })
);

const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

// mix.setPublicPath("../../public").mergeManifest();

// mix
// .js(__dirname + '/Resources/assets/js/app.js', 'module_rem7/js/rem7.js')
// .sass( __dirname + '/Resources/assets/sass/app.scss', 'module_rem7/css/rem7.css');

// if (mix.inProduction()) {
//     mix.version();
// }

mix.copyDirectory(
    __dirname + "/Resources/assets",
    __dirname + "../../../../public/module_rem7"
);

mix.js(
    [
        __dirname + "/Resources/assets/js/jquery-min.js",
        __dirname + "/Resources/assets/js/popper.min.js",
        __dirname + "/Resources/assets/js/bootstrap.min.js",
        __dirname + "/Resources/assets/js/owl.carousel.min.js",
        __dirname + "/Resources/assets/js/wow.js",
        __dirname + "/Resources/assets/js/jquery.nav.js",
        __dirname + "/Resources/assets/js/scrolling-nav.js",
        __dirname + "/Resources/assets/js/jquery.easing.min.js",
        __dirname + "/Resources/assets/js/slick.min.js",
        // block otzuvu
        // __dirname + '/Resources/assets/js/jquery.slicknav.js',
    ],
    __dirname + "../../../../public/module_rem7/js/all.js"
);

mix.styles(
    [
        __dirname + "/Resources/assets/css/bootstrap.min.css",
        __dirname + "/Resources/assets/css/slicknav.css",
        __dirname + "/Resources/assets/css/owl.carousel.min.css",
        __dirname + "/Resources/assets/css/owl.theme.css",
        __dirname + "/Resources/assets/css/slick.css",
        __dirname + "/Resources/assets/css/slick-theme.css",
        __dirname + "/Resources/assets/css/animate.css",
        __dirname + "/Resources/assets/css/main.css",
        __dirname + "/Resources/assets/css/responsive.css",
        // __dirname + '/Resources/assets/SpaceDynamic/assets/css/animated.css',
        // //__dirname + '/Resources/assets/SpaceDynamic/assets/css/fontawesome.css',
        // __dirname + '/Resources/assets/SpaceDynamic/assets/css/owl.css',
        // // __dirname + '/Resources/assets/SpaceDynamic/assets/css/templatemo-space-dynamic.css',
    ],
    __dirname + "../../../../public/module_rem7/css/all.css"
);

// mix// .browserSync('zz1.php-cat.com');

// .sass(
//     __dirname + '/Resources/assets/sass/app.scss', 'css/kadastr.css'
//     )
// ;

// if (mix.inProduction()) {
//     mix.version();
// }
