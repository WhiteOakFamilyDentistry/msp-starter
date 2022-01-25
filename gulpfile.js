// Load all the modules from package.json
var gulp = require('gulp'),
  plugins = require('gulp-load-plugins')();
var events = require('events');
var emitter = new events.EventEmitter();
var path = require('path');
var currentTask = '';
var plumber = require('gulp-plumber'),
  watch = require('gulp-watch'),
  minifycss = require('gulp-clean-css'),
  jshint = require('gulp-jshint'),
  stylish = require('jshint-stylish'),
  uglify = require('gulp-uglify-es').default,
  rename = require('gulp-rename'),
  include = require('gulp-include'),
  sass = require('gulp-sass')(require('sass')),
  sourcemaps = require('gulp-sourcemaps'),
  postcss = require('gulp-postcss'),
  autoprefixer = require('autoprefixer');
  merge = require('merge-stream');


// Jshint outputs any kind of javascript problems you might have
// Only checks javascript files inside /src directory
gulp.task('jshint', function() {
  return (
    gulp
      .src('./assets/js/src/*.js')
      .pipe(jshint.reporter(stylish))
      .pipe(jshint.reporter('fail'))
  );
});

// Concatenates all files that it finds in the manifest
// and creates two versions: normal and minified.
// It's dependent on the jshint task to succeed.

gulp.task('scripts', function() {
  return gulp
    .src('./assets/js/manifest.js')
    .pipe(include())
    .pipe(rename({ basename: 'scripts' }))
    .pipe(gulp.dest('./assets/js/dist'))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./assets/js/dist'));
});

//----------------------------------------------
// SASS Compiling
// CSS Minification
// Sourcemap Creation
//----------------------------------------------

var files = ['./assets/scss/custom.scss', './assets/scss/editor.scss'];

gulp.task('scss', function() {
  return (gulp.src(files)
      
      // Init Sourcemaps
      .pipe(sourcemaps.init())

      // Compile SASS
      .pipe(sass())

      .pipe(sass().on('error', sass.logError))

      // Load Sourcemaps from SASS
      .pipe(sourcemaps.init({ loadMaps: true }))

      // Parse with PostCSS plugins.
      .pipe(
        postcss([
          autoprefixer()
        ])
      )
      
      .pipe(gulp.dest('./assets/css'))

      
      // Minify CSS
      .pipe(minifycss('./assets/scss/custom.scss'))
      .pipe(rename({ suffix: '.min' }))

    // Generate our new, super helpful sourcemaps
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/css'))
  );

  // Exit this task
});


// Watch files for change
gulp.task('watch', function() {

  // don't listen to whole js folder, it'll create an infinite loop
  gulp.watch(
    ['./assets/js/**/*.js', '!./assets/js/dist/*.js'],
    gulp.parallel(['scripts'])
  );
  gulp.watch('./assets/scss/**/*.scss', gulp.parallel(['scss']));
  
});

// Tired of running scripts and scss before pushing? or after reviewing PR? :P
gulp.task('build', gulp.series(['scripts', 'scss']));
gulp.task('default', gulp.series(['watch']));
