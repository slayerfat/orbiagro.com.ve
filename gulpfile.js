var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  mix.sass('app.scss');
  mix.copy('vendor/bower_components/jquery/dist/jquery.min.js',
      'public/js/vendor/jquery.min.js')
     .copy('vendor/bower_components/jquery/dist/jquery.min.map',
        'public/js/vendor/jquery.min.map')
     .copy('vendor/bower_components/bootstrap-sass/assets/fonts/bootstrap',
        'public/fonts/bootstrap')
     .copy('vendor/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'public/js/vendor/bootstrap.min.js')
     .copy('vendor/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'public/js/vendor/bootstrap-datepicker.js')
     .copy('vendor/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js',
        'public/js/vendor/bootstrap-datepicker.es.js')
     .copy('vendor/bower_components/bootstrap-datepicker/css/datepicker.css',
        'public/css/vendor/datepicker.css')
     .copy('vendor/bower_components/bootstrap-table/src/bootstrap-table.css',
        'public/css/vendor/bootstrap-table.css')
     .copy('vendor/bower_components/bootstrap-table/src/bootstrap-table.js',
        'public/js/vendor/bootstrap-table.js')
     .copy('vendor/bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js',
        'public/js/vendor/bootstrap-table-es-CR.js')
     .copy('vendor/bower_components/formatter/dist/jquery.formatter.js',
        'public/js/vendor/jquery.formatter.js')
     .copy('vendor/bower_components/numeraljs/languages.js',
        'public/js/vendor/languages.js')
     .copy('vendor/bower_components/numeraljs/numeral.js',
        'public/js/vendor/numeral.js');
});
