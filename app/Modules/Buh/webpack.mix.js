const dotenvExpand = require("dotenv-expand");
dotenvExpand(
    require("dotenv").config({ path: "../../.env" /*, debug: true*/ })
);

const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

// mix.setPublicPath("../../public").mergeManifest();

// mix.copyDirectory(
//     __dirname + "/Resources/assets/didrive",
//     __dirname + "../../../../public/didrive"
// );

mix.copyDirectory(
    __dirname + "/Resources/assets",
    __dirname + "../../../../public/module_buh"
);

mix.styles(
    [
        __dirname + "/Resources/assets/css/bootstrap.min.css",
        __dirname + "/Resources/assets/css/fancybox/jquery.fancybox.css",
        __dirname + "/Resources/assets/css/flexslider.css",
        // __dirname + "/Resources/assets/et-line-font/style.css",
        __dirname + "/Resources/assets/css/style.css",
        __dirname + "/Resources/assets/css.css"
    ],
    __dirname + "../../../../public/module_buh/all.css"
    // "/public/module_buh/css/all.css"
    // "/public/module_buh/css/all.css"
    // "/public/module_buh/all.css"
);

mix.js(
    [
        __dirname + "/Resources/assets/js/jquery.js",
        __dirname + "/Resources/assets/js/jquery.easing.1.3.js",
        __dirname + "/Resources/assets/js/bootstrap.min.js",
        __dirname + "/Resources/assets/js/jquery.fancybox.pack.js",
        __dirname + "/Resources/assets/js/jquery.fancybox-media.js",
        __dirname + "/Resources/assets/js/portfolio/jquery.quicksand.js",
        __dirname + "/Resources/assets/js/portfolio/setting.js",
        __dirname + "/Resources/assets/js/jquery.flexslider.js",
        __dirname + "/Resources/assets/js/animate.js",
        __dirname + "/Resources/assets/js/custom.js"
        // __dirname + "../../../../public/module_buh/js/custom.js"
    ],
    // __dirname + "../../../../public/module_buh/all.js"
    // "/public/module_buh/all.js"
    __dirname + '../../../../public/module_buh/js.js'
);


// .sass(
//     [__dirname + "/Resources/assets/sass/app.scss"],
//     "module_buh/css/all.css"
// );

// if (mix.inProduction()) {
//     mix.version();
// }
