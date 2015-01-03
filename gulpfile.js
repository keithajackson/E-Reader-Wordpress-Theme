/*!
 * gulp
 * $ npm install gulp-ruby-sass gulp-autoprefixer gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-imagemin gulp-notify gulp-rename gulp-livereload gulp-cache del --save-dev
 */

// Load plugins
var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');

var server_root = "out/";
// Styles
gulp.task('styles', function() {
  return gulp.src('styles/main.scss')
    .pipe(sass({ style: 'expanded', }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
 //   .pipe(gulp.dest(server_root + 'css'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(minifycss())
//    .pipe(minifycss({keepBreaks:true}))
    .pipe(gulp.dest(server_root + 'css'))
    .pipe(notify({ message: 'Styles task complete' }));
});

// Scripts
gulp.task('scripts', function() {
  return gulp.src('scripts/*.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('main.js'))
//    .pipe(gulp.dest(server_root + 'js'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest(server_root + 'js'))
//    .pipe(notify({ message: 'Scripts task complete' }));
});

// Images
gulp.task('images', function() {
  return gulp.src('images/*')
    .pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
    .pipe(gulp.dest(server_root + 'img'))
//    .pipe(notify({ message: 'Images task complete' }));
});

// php minify
gulp.task('copy-php', function() {
  gulp.src('*.php')
    .pipe(gulp.dest(server_root))
});

gulp.task('copy-media', function(){
  gulp.src('media/*')
    .pipe(gulp.dest(server_root + 'media'));
});

// Clean
gulp.task('clean', function(cb) {
  del(['out/*'], function (err, deletedFiles) {
    console.log('Files deleted:', deletedFiles.join(', '));
    cb();
  });
});

// Default task
gulp.task('default', ['clean'], function() {
    gulp.start('styles', 'scripts', 'images', 'copy-php', 'copy-media');
});

// Watch
gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch('styles/*.scss', ['styles']);

  // Watch .js files
  gulp.watch('scripts/*.js', ['scripts']);

  // Watch image files
  gulp.watch('images/*', ['images']);

  // Create LiveReload server
  livereload.listen();

  // Watch any files in dist/, reload on change
  gulp.watch([server_root]).on('change', livereload.changed);

});