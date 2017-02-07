/**
 * Simple tasks for handle css, js and fonts files
 */

// Include gulp
var gulp = require('gulp');

// Include plugins
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var bower = require('gulp-bower');
var mainBowerFiles = require('main-bower-files');
var less = require('gulp-less');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');


// Config
var root='webroot/';
var config = {
   lessPath: './resources/less/',
  jsPath: './resources/js/',
   bowerDir: './bower_components/' ,
  publicCssPath: root+'css',
  publicJsPath: root+'js',
  publicFontsPath: root+'fonts'
};

// Task 'bower'
gulp.task('bower', function() { 
  return bower()
     .pipe(gulp.dest(config.bowerDir)) 
});

// Task 'js'
gulp.task('js', function() {
  var files = mainBowerFiles('**/*.js').concat([config.jsPath+'*.js']);
  gulp.src(files)
    .pipe(concat('main.js').on('error', function(err) {
      console.log(err);
    }))
    .pipe(uglify().on('error', function(err) {
      console.log(err);
    }))
    .pipe(rename({suffix: '.min'}).on('error', function(err) {
      console.log(err);
    }))
    .pipe(gulp.dest(config.publicJsPath));  
});

// Task 'css'
gulp.task('css', function() { 
  var files =mainBowerFiles('**/*.less').concat([config.lessPath+'*.less']);
  gulp.src(files)
    .pipe(less().on('error', function (err) {
      console.log(err);
    }))
    .pipe(concat('main.css').on('error', function(err) {
      console.log(err);
    }))
    .pipe(cssmin().on('error', function(err) {
      console.log(err);
    }))
    .pipe(rename({suffix: '.min'}).on('error', function(err) {
      console.log(err);
    }))
    .pipe(gulp.dest(config.publicCssPath));
});

// Task 'fonts'
gulp.task('fonts', function() { 
  return gulp.src(config.bowerDir + 'font-awesome/fonts/**.*') 
    .pipe(gulp.dest(config.publicFontsPath)); 
});

// Default task
gulp.task('default', ['js', 'css', 'fonts']);

// Rerun a task when a file changes
 gulp.task('watch', function() {
   gulp.watch([config.lessPath + '*.less'], ['css']); 
  gulp.watch(config.jsPath + '*.js', ['js']); 
});