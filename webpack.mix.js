const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const commonThemeScripts = [
  './public/vendor/jquery/jquery.min.js',
  './public/js/popper.min.js',
  './public/vendor/bootstrap/js/bootstrap.js',
  './public/js/bootstrap.min.js',
  './public/js/jquery-migrate.min.js',
  './public/js/bpopup.js',
  './public/js/Jquery_validation/jquery.validate.js',
  './public/js/Jquery_validation/additional-methods.js',
  './public/js/Jquery_validation/jquery.form.min.js',
  //'./public/js/bootstrap-datepicker.min.js',
  './public/js/pincode_input/bootstrap-pincode-input.js',
  './public/js/jquery.sticky.js',
  './public/js/star-rating.js',
  './public/js/jquery-confirm.min.js',
  // './public/js/css3-animate-it.js',
  // './public/js/main.js',
  './public/js/slick.js',

  './public/js/custom.js',

];

const commonThemeStyles = [
  './public/css/bootstrap.min.css',
  //'./public/css/bootstrap-datepicker.min.css',
  './public/css/pincode_input/bootstrap-pincode-input.css',
  './public/css/jquery-confirm.min.css',
  './public/css/animations.css',
  './public/css/style.css',
  './public/css/responsive.css',
  './public/css/bpopup.css',
  './public/css/star-rating.css',
];

function setupSiteResources(){
  mix.styles([
    ...commonThemeStyles,
  ], 'public/css/styles.css').minify('public/css/styles.css');

  mix.scripts([
    ...commonThemeScripts,
  ], 'public/js/scripts.js').minify('public/js/scripts.js');
}

setupSiteResources();

//if (mix.inProduction()) {
    mix.version();
//}