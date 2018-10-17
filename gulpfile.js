// Load all the modules from package.json
var gulp = require( 'gulp' ),
plugins = require('gulp-load-plugins')();
map = require('map-stream');
events = require('events');
emitter = new events.EventEmitter();
path = require('path');
gutil = require('gulp-util');
currentTask = '';
  plumber = require( 'gulp-plumber' ),
  watch = require( 'gulp-watch' ),
  livereload = require( 'gulp-livereload' ),
  minifycss = require( 'gulp-minify-css' ),
  jshint = require( 'gulp-jshint' ),
  stylish = require( 'jshint-stylish' ),
  uglify = require( 'gulp-uglify' ),
  rename = require( 'gulp-rename' ),
  notify = require( 'gulp-notify' ),
  include = require( 'gulp-include' ),
  sass = require( 'gulp-sass' );



// Default error handler
var reportError = function (error) {

    var lineNumber = (error.lineNumber) ? 'LINE ' + error.lineNumber + ' -- ' : '';
    var pluginName = (error.plugin) ? ': ['+error.plugin+']' : '['+currentTask+']';

    plugins.notify({
        title: 'You F***ed Up! '+ pluginName,
        message: lineNumber + 'See console.'
    }).write(error);

    gutil.beep();

    var report = '';
    var chalk = gutil.colors.white.bgRed;

    report += chalk('TASK:') + pluginName+'\n';
    report += chalk('ERROR:') + ' ' + error.message + '\n';
    if (error.lineNumber) { report += chalk('LINE:') + ' ' + error.lineNumber + '\n'; }
    if (error.fileName) { report += chalk('FILE:') + ' ' + error.fileName + '\n'; }

    console.error(report);

    this.emit('end');
}


// Jshint outputs any kind of javascript problems you might have
// Only checks javascript files inside /src directory
gulp.task( 'jshint', function() {
  return gulp.src( './js/src/*.js' )
    //.pipe( jshint( '.jshintrc' ) )
    .pipe( jshint.reporter( stylish ) )
    .pipe( jshint.reporter( 'fail' ) );
})


// Concatenates all files that it finds in the manifest
// and creates two versions: normal and minified.
// It's dependent on the jshint task to succeed.
gulp.task( 'scripts', ['jshint'], function() {
  return gulp.src( './js/manifest.js' )
    .pipe( include() )
    .pipe( rename( { basename: 'scripts' } ) )
    .pipe( gulp.dest( './js/dist' ) )
    // Normal done, time to create the minified javascript (scripts.min.js)
    // remove the following 3 lines if you don't want it
    .pipe( uglify() )
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( gulp.dest( './js/dist' ) )
    .pipe( livereload() );
} );

// As with javascripts this task creates two files, the regular and
// the minified one. It automatically reloads browser as well.
gulp.task('scss', function() {
  return gulp.src('./scss/custom.scss')
    .pipe( plumber( { errorHandler: reportError } ) )
    .pipe( sass() )
    .pipe( gulp.dest( './css' ) )
    // Normal done, time to do minified (custom.min.css)
    // remove the following 3 lines if you don't want it
    .pipe( minifycss() )
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( gulp.dest( './css' ) )
    .pipe( livereload() );
});


// Start the livereload server and watch files for change
gulp.task( 'watch', function() {
  livereload.listen();

  // don't listen to whole js folder, it'll create an infinite loop
  gulp.watch( [ './js/**/*.js', '!./js/dist/*.js' ], [ 'scripts' ] )

  gulp.watch( './scss/**/*.scss', ['scss'] );

  gulp.watch( './**/*.php' ).on( 'change', function( file ) {
    // reload browser whenever any PHP file changes
    livereload.changed( file );
  } );
} );

gulp.task( 'default', ['watch'], function() {
 // Does nothing in this task, just triggers the dependent 'watch'
} );