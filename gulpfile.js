// Load all the modules from package.json
var gulp = require('gulp'),
  plugins = require('gulp-load-plugins')();
var events = require('events');
var emitter = new events.EventEmitter();
var path = require('path');
var gutil = require('gulp-util');
var currentTask = '';
var plumber = require('gulp-plumber'),
  watch = require('gulp-watch'),
  //livereload = require('gulp-livereload'),
  minifycss = require('gulp-clean-css'),
  jshint = require('gulp-jshint'),
  stylish = require('jshint-stylish'),
  uglify = require('gulp-uglify-es').default,
  rename = require('gulp-rename'),
  notify = require('gulp-notify'),
  include = require('gulp-include'),
  sass = require('gulp-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  imagemin = require('gulp-imagemin'),
  postcss = require('gulp-postcss'),
  autoprefixer = require('autoprefixer'),
  gutil = require('gulp-util');

// Set assets paths.
const paths = {
  'css': ['./*.css', '!*.min.css'],
  'icons': 'assets/images/svg-icons/*.svg',
  'images': ['assets/images/*', '!assets/images/*.svg'],
  'php': ['./*.php', './**/*.php'],
  'sass': 'assets/scss/**/*.scss',
  'concat_scripts': 'assets/js/concat/*.js',
  'scripts': ['assets/js/*.js', '!assets/scripts/*.min.js'],
  'sprites': 'assets/images/sprites/*.png'
};


// Default error handler
var reportError = function (error) {

  var lineNumber = (error.lineNumber) ? 'LINE ' + error.lineNumber + ' -- ' : '';
  var pluginName = (error.plugin) ? ': [' + error.plugin + ']' : '[' + currentTask + ']';

  plugins.notify({
    title: 'You F***ed Up! ' + pluginName,
    message: lineNumber + 'See console.'
  }).write(error);

  gutil.beep();

  var report = '';
  var chalk = gutil.colors.white.bgRed;

  report += chalk('TASK:') + pluginName + '\n';
  report += chalk('ERROR:') + ' ' + error.message + '\n';
  if (error.lineNumber) {
    report += chalk('LINE:') + ' ' + error.lineNumber + '\n';
  }
  if (error.fileName) {
    report += chalk('FILE:') + ' ' + error.fileName + '\n';
  }

  console.error(report);

  this.emit('end');
}


// Jshint outputs any kind of javascript problems you might have
// Only checks javascript files inside /src directory



gulp.task('jshint', function () {
  return gulp.src('./assets/js/src/*.js')
  //.pipe( jshint( '.jshintrc' ) ) uncomment for JS Debugging (Very Strict)
    .pipe(jshint.reporter(stylish))
    .pipe(jshint.reporter('fail'));
})


// Concatenates all files that it finds in the manifest
// and creates two versions: normal and minified.
// It's dependent on the jshint task to succeed.
gulp.task('scripts', function () {
  return gulp.src('./assets/js/manifest.js')
    .pipe(include())
    .pipe(rename({ basename: 'scripts' }))
    .pipe(gulp.dest('./assets/js/dist'))

    // .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./assets/js/dist'))
    //.pipe(livereload());
});

//----------------------------------------------
// SASS Compiling
// CSS Minification
// Sourcemap Creation
//----------------------------------------------

gulp.task('scss', function () {
  return gulp.src('./assets/scss/custom.scss')
    .pipe(plumber({ errorHandler: reportError }))

    // Init Sourcemaps
    .pipe(sourcemaps.init())

    // Compile SASS
    .pipe(sass())

    // Send to CSS file
    .pipe(gulp.dest('./assets/css'))

    // Load Sourcsmaps from SASS
    .pipe(sourcemaps.init({ loadMaps: true }))

    // Parse with PostCSS plugins.
    .pipe(postcss([
      autoprefixer({
        'browsers': ['last 2 version']
      })
    ]))

    // Minify CSS
    //.pipe(minifycss())

    // Rename file
    .pipe(rename({ suffix: '.min' }))

    // Generate our new, super helpful sourcemaps
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/css'))
    //.pipe(livereload());

  // Exit this task
});


// Start the livereload server and watch files for change
gulp.task('watch', function () {
  //livereload.listen();

  // don't listen to whole js folder, it'll create an infinite loop
  gulp.watch( ['./assets/js/**/*.js', '!./assets/js/dist/*.js'], gulp.parallel( ['scripts'] ) )
  gulp.watch('./assets/scss/**/*.scss', gulp.parallel( ['scss'] ) );
  gulp.watch('./**/*.php').on('change', function (file) {
    // reload browser whenever any PHP file changes
    //livereload.changed(file);
  });
});


/**
 * Optimize images.
 *
 * https://www.npmjs.com/package/gulp-imagemin
 */
gulp.task('imagemin', () =>
  gulp.src(paths.images)
    .pipe(plumber({ 'errorHandler': reportError }))
    .pipe(imagemin([imagemin.gifsicle({ interlaced: true }),
      imagemin.jpegtran({ progressive: true }),
      imagemin.optipng({ optimizationLevel: 5 }),
      imagemin.svgo({
        plugins: [
          { removeViewBox: true },
          { cleanupIDs: false }
        ],
      })
    ], {
      verbose: true // Let me know specifics!
    }))
    .pipe(gulp.dest('./assets/images'))
);


// TODO: Find a different way to run watch on default
gulp.task( 'default', gulp.series( ['watch'], function() {
  // Does nothing in this task, just triggers the dependent 'watch'
} ) );