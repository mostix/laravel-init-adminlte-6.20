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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


mix.less('resources/adminlte/bootstrap-less/bootstrap.less', 'public/css')
    .less('resources/adminlte/less/AdminLTE.less', 'public/css/admin.css')
    .less('resources/adminlte/less/skins/_all-skins.less', 'public/css/skins.css')

mix.scripts([
    'resources/js/jquery.min.js',
    'resources/js/bootstrap.min.js',
    'resources/adminlte/plugins/bootstrap-slider/bootstrap-slider.js',
    'resources/adminlte/plugins/iCheck/icheck.min.js',
    'resources/adminlte/plugins/toastr/toastr.min.js',
    'resources/adminlte/plugins/bootstrap-datepicker.min.js',
    'resources/adminlte/plugins/datatables/jquery.dataTables.min.js',
    'resources/adminlte/plugins/datatables/dataTables.bootstrap.min.js',
    'resources/adminlte/plugins/select2.min.js',
    'resources/adminlte/plugins/moment.min.js',
    'resources/adminlte/js/adminlte.min.js',
    'resources/adminlte/main.js'
], 'public/js/admin.js');


mix.styles([
    'resources/adminlte/font-awesome/css/font-awesome.min.css',
    'resources/adminlte/plugins/bootstrap-slider/slider.css',
    'resources/adminlte/plugins/iCheck/square/_all.css',
    'resources/adminlte/plugins/toastr/toastr.min.css',
    'resources/adminlte/plugins/timepicker/bootstrap-timepicker.min.css',
    'resources/adminlte/plugins/bootstrap-datepicker3.min.css',
    'resources/adminlte/plugins/datatables/dataTables.bootstrap.min.css',
    'resources/adminlte/plugins/select2.min.css',
    'resources/adminlte/AdminLTE.css',
    'resources/adminlte/main.css',
], 'public/css/admin.css');
