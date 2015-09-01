// laravel
var elixir = require('laravel-elixir'),
    gulp   = require('gulp'),
    notify = require('gulp-notify');

// git bump (v0.1.2) <-- gulp release|feature|patch|pre
var git         = require('gulp-git'),
    bump        = require('gulp-bump'),
    filter      = require('gulp-filter'),
    tag_version = require('gulp-tag-version');

// minificacion de imagenes
var imagemin    = require('gulp-imagemin');

/**
 * Bumping version number and tagging the repository with it.
 * Please read http://semver.org/
 *
 * You can use the commands
 *
 *     gulp pre       # makes v0.1.0 → v0.1.1-0
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
  new elixir.Task('img', function(){
    gulp.src('public/img/originals/*')
    .pipe(imagemin({
        progressive: true,
        svgoPlugins: [{removeViewBox: false}]
    }))
    .pipe(gulp.dest('public/img'));
  });
});

gulp.task('copy-app-files', function() {
  gulp
  .src('vendor/bower_components/jquery/dist/jquery.min.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/jquery/dist/jquery.min.map')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/slick.js/slick/ajax-loader.gif')
  .pipe(gulp.dest('public/css'));
  //  fontawesome
  gulp
  .src('vendor/bower_components/fontawesome/css/font-awesome.min.css')
  .pipe(gulp.dest('public/css/vendor'));
  gulp
  .src('vendor/bower_components/fontawesome/css/font-awesome.css.map')
  .pipe(gulp.dest('public/css/vendor'));
  gulp
  .src('vendor/bower_components/fontawesome/fonts/**/*')
  .pipe(gulp.dest('public/css/fonts'));
  // bootstrap
  gulp
  .src('vendor/bower_components/bootstrap-sass/assets/fonts/bootstrap/**/*')
  .pipe(gulp.dest('public/fonts/bootstrap'));
  gulp
  .src('vendor/bower_components/bootstrap/dist/js/bootstrap.min.js')
  .pipe(gulp.dest('public/js/vendor'));
  // datepicker
  gulp
  .src('vendor/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/bootstrap-datepicker/css/datepicker.css')
  .pipe(gulp.dest('public/css/vendor'));
  // bootstrap-table
  gulp
  .src('vendor/bower_components/bootstrap-table/src/bootstrap-table.css')
  .pipe(gulp.dest('public/css/vendor'));
  gulp
  .src('vendor/bower_components/bootstrap-table/src/bootstrap-table.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js')
  .pipe(gulp.dest('public/js/vendor'));
  // formatter.js
  gulp
  .src('vendor/bower_components/formatter/dist/jquery.formatter.js')
  .pipe(gulp.dest('public/js/vendor'));
  // numeral.js
  gulp
  .src('vendor/bower_components/numeraljs/languages.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/numeraljs/numeral.js')
  .pipe(gulp.dest('public/js/vendor'));
  // slick.js
  gulp
  .src('vendor/bower_components/slick.js/slick/fonts/**/*')
  .pipe(gulp.dest('public/css/fonts'));
  gulp
  .src('vendor/bower_components/slick.js/slick/slick.min.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/slick.js/slick/ajax-loader.gif')
  .pipe(gulp.dest('public'));
  // ckeditor
  gulp
  .src('vendor/bower_components/ckeditor/ckeditor.js')
  .pipe(gulp.dest('public/js/vendor/ckeditor'));
  gulp
  .src('vendor/bower_components/ckeditor/config.js')
   .pipe(gulp.dest('public/js/vendor/ckeditor'));
  gulp
  .src('vendor/bower_components/ckeditor/styles.js')
  .pipe(gulp.dest('public/js/vendor/ckeditor'));
  gulp
  .src('vendor/bower_components/ckeditor/skins/**/*')
  .pipe(gulp.dest('public/js/vendor/ckeditor/skins'));
  gulp
  .src('vendor/bower_components/ckeditor/plugins/**/*')
  .pipe(gulp.dest('public/js/vendor/ckeditor/plugins'));
  gulp
  .src('vendor/bower_components/ckeditor/lang/es.js')
  .pipe(gulp.dest('public/js/vendor/ckeditor/lang'));
  gulp
  .src('vendor/bower_components/ckeditor/lang/en.js')
  .pipe(gulp.dest('public/js/vendor/ckeditor/lang'));
  gulp
  .src('vendor/bower_components/ckeditor/contents.css')
  .pipe(gulp.dest('public/js/vendor/ckeditor'));
  // image upload/crop
  gulp
  .src('vendor/bower_components/cropper/dist/cropper.min.js')
  .pipe(gulp.dest('public/js/vendor'));
  gulp
  .src('vendor/bower_components/cropper/dist/cropper.min.css')
  .pipe(gulp.dest('public/css/vendor'));
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
  mix.sass('app.scss');
  mix.imgOptimizer();
  mix.phpUnit('phpunit.xml', { debug: false, notify: true });
});
