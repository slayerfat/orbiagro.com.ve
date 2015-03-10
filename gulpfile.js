var elixir      = require('laravel-elixir'),
    gulp        = require('gulp'),
    git         = require('gulp-git'),
    bump        = require('gulp-bump'),
    filter      = require('gulp-filter'),
    tag_version = require('gulp-tag-version');

/**
 * Bumping version number and tagging the repository with it.
 * Please read http://semver.org/
 *
 * You can use the commands
 *
 *     gulp patch     # makes v0.1.0 → v0.1.1
 *     gulp feature   # makes v0.1.1 → v0.2.0
 *     gulp release   # makes v0.2.1 → v1.0.0
 *
 * To bump the version numbers accordingly after you did a patch,
 * introduced a feature or made a backwards-incompatible release.
 */

function inc(importance) {
  // get all the files to bump version in
  return gulp.src(['./package.json', './bower.json'])
    // bump the version number in those files
    .pipe(bump({type: importance}))
    // save it back to filesystem
    .pipe(gulp.dest('./'))
    // commit the changed version number
    .pipe(git.commit('bumps package version'))

    // read only one file to get the version number
    .pipe(filter('package.json'))
    // **tag it in the repository**
    .pipe(tag_version());
}

gulp.task('pre',     function() { return inc('prerelease'); });
gulp.task('patch',   function() { return inc('patch'); });
gulp.task('feature', function() { return inc('minor'); });
gulp.task('release', function() { return inc('major'); });

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
