const dotenvExpand = require('dotenv-expand');

//dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath( '../../public/kadastr' ).mergeManifest();
// mix.setPublicPath( '../../public/kadastr' ).mergeManifest();

mix.copyDirectory(__dirname + '/Resources/assets', __dirname + '../../../../public/kadastr' );

mix.js(
    [
        // __dirname + '/Resources/assets/js/app.js',

        // __dirname + '/Resources/assets/SpaceDynamic/vendor/jquery/jquery.min.js',
        __dirname + '/Resources/assets/SpaceDynamic/vendor/bootstrap/js/bootstrap.bundle.min.js',
        // __dirname + '/Resources/assets/SpaceDynamic/assets/js/owl-carousel.js',
        // __dirname + '/Resources/assets/SpaceDynamic/assets/js/animation.js',
        __dirname + '/Resources/assets/SpaceDynamic/assets/js/imagesloaded.js',
        __dirname + '/Resources/assets/SpaceDynamic/assets/js/templatemo-custom.js'
    ], __dirname + '../../../../public/kadastr/js.js'
    )

    .styles(
        [
            __dirname + '/Resources/assets/SpaceDynamic/assets/css/animated.css',
            //__dirname + '/Resources/assets/SpaceDynamic/assets/css/fontawesome.css',
            __dirname + '/Resources/assets/SpaceDynamic/assets/css/owl.css',
            // __dirname + '/Resources/assets/SpaceDynamic/assets/css/templatemo-space-dynamic.css',
        ], __dirname + '../../../../public/kadastr/css.css'
    );


    // mix// .browserSync('zz1.php-cat.com');

    // .sass(
    //     __dirname + '/Resources/assets/sass/app.scss', 'css/kadastr.css'
    //     )
        // ;


if (mix.inProduction()) {
    mix.version();
}
