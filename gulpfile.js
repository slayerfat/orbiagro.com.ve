var elixir      = require('laravel-elixir'),
    gulp        = require('gulp'),
    git         = require('gulp-git'),
    bump        = require('gulp-bump'),
    filter      = require('gulp-filter'),
    tag_version = require('gulp-tag-version'),
    imagemin    = require('gulp-imagemin'),
    codecept    = require('gulp-codeception'),
    notify      = require('gulp-notify'),
    _           = require('underscore');

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

elixir.extend('imgOptimizer', function() {

  gulp.task('img', function(){
    gulp.src('public/img/originals/*')
    .pipe(imagemin({
        progressive: true,
        svgoPlugins: [{removeViewBox: false}]
    }))
    .pipe(gulp.dest('public/img'));
  });
  return this.queueTask('img');

});


/**
 * codeception
 * https://github.com/JeffreyWay/laravel-elixir-codeception
 */
elixir.extend('codeception', function(baseDir, options) {

  baseDir = baseDir || 'tests';
  options = _.extend({
    clear: true, notify: true
  }, options);

  gulp.task('codeception', function() {
    gulp.src('')
        .pipe(codecept('', options))
        .on('error', notify.onError({
           title: 'Red!',
           message: 'Your Codeception tests failed!',
           icon: __dirname + '/node_modules/laravel-elixir/icons/fail.png'
        }))
        .pipe(notify({
           title: 'Green!',
           message: 'Your Codeception tests passed!',
           icon: __dirname + '/node_modules/laravel-elixir/icons/pass.png'
        }));
  });

  this.queueTask('codeception');

  this.registerWatcher('codeception', [
    baseDir + '/**/*+(Test|Cept|Cest).php',
    'app/**/*.php'
  ], 'tdd');

});
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
  mix.sass('app.scss')
     .imgOptimizer()
     .codeception();
  mix.copy('vendor/bower_components/jquery/dist/jquery.min.js',
      'public/js/vendor/jquery.min.js')
      .copy('vendor/bower_components/jquery/dist/jquery.min.map',
         'public/js/vendor/jquery.min.map')
      //  fontawesome
      .copy('vendor/bower_components/fontawesome/css/font-awesome.min.css',
        'public/css/vendor/font-awesome.min.css')
      .copy('vendor/bower_components/fontawesome/css/font-awesome.css.map',
        'public/css/vendor/font-awesome.css.map')
      .copy('vendor/bower_components/fontawesome/fonts',
        'public/css/fonts')
      // bootstrap
      .copy('vendor/bower_components/bootstrap-sass/assets/fonts/bootstrap',
        'public/fonts/bootstrap')
      .copy('vendor/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'public/js/vendor/bootstrap.min.js')
      // datepicker
      .copy('vendor/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'public/js/vendor/bootstrap-datepicker.js')
      .copy('vendor/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js',
        'public/js/vendor/bootstrap-datepicker.es.js')
      .copy('vendor/bower_components/bootstrap-datepicker/css/datepicker.css',
        'public/css/vendor/datepicker.css')
      // bootstrap-table
      .copy('vendor/bower_components/bootstrap-table/src/bootstrap-table.css',
        'public/css/vendor/bootstrap-table.css')
      .copy('vendor/bower_components/bootstrap-table/src/bootstrap-table.js',
        'public/js/vendor/bootstrap-table.js')
      .copy('vendor/bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js',
        'public/js/vendor/bootstrap-table-es-CR.js')
      // formatter.js
      .copy('vendor/bower_components/formatter/dist/jquery.formatter.js',
        'public/js/vendor/jquery.formatter.js')
      // numeral.js
      .copy('vendor/bower_components/numeraljs/languages.js',
        'public/js/vendor/languages.js')
      .copy('vendor/bower_components/numeraljs/numeral.js',
        'public/js/vendor/numeral.js')
      // slick.js
      .copy('vendor/bower_components/slick.js/slick/fonts',
        'public/css/fonts')
      .copy('vendor/bower_components/slick.js/slick/slick.min.js',
        'public/js/vendor/slick.min.js')
        .copy('vendor/bower_components/slick.js/slick/ajax-loader.gif',
        'public/ajax-loader.gif')
      // ckeditor
      .copy('vendor/bower_components/ckeditor/ckeditor.js',
        'public/js/vendor/ckeditor/ckeditor.js')
      .copy('vendor/bower_components/ckeditor/config.js',
         'public/js/vendor/ckeditor/config.js')
      .copy('vendor/bower_components/ckeditor/styles.js',
        'public/js/vendor/ckeditor/styles.js')
      .copy('vendor/bower_components/ckeditor/skins',
        'public/js/vendor/ckeditor/skins')
      .copy('vendor/bower_components/ckeditor/plugins',
        'public/js/vendor/ckeditor/plugins')
      .copy('vendor/bower_components/ckeditor/lang/es.js',
        'public/js/vendor/ckeditor/lang/es.js')
      .copy('vendor/bower_components/ckeditor/contents.css',
        'public/js/vendor/ckeditor/contents.css')
      // migration/tests files
      .copy('storage/1500x1500.gif', 'public/1500x1500.gif')
      .copy('storage/file.pdf', 'public/file.pdf')
      .copy('storage/1500x1500.gif', 'tests/_output/1500x1500.gif')
      .copy('storage/file.pdf', 'tests/_output/file.pdf');
});
