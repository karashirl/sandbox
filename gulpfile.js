var gulp = require('gulp');
// Requires the gulp-sass plugin
var sass = require('gulp-sass');
var browserify = require('browserify');
// var browserify = require('gulp-browserify-globs');
var uglify = require('gulp-uglify');
var source_stream = require('vinyl-source-stream');
var concat = require('gulp-concat');
var plumber = require('gulp-plumber');
var gutil = require('gulp-util');
var glob = require('glob');


// config
var project_slug = 'divi-child'
    path_theme = 'wp-content/themes/' + project_slug + '/',
    path_bower = 'bower_components/';
    path_bootstrap = './node_modules/bootstrap-sass/'


function handleErrors(e) {
	gutil.log(gutil.colors.red.bold('BEG Gulp Error:'));
	gutil.log(gutil.colors.red(e.message));
	gutil.log(gutil.colors.red.bold('END Gulp Error:'));
  this.emit('end');
}

// compile sass
gulp.task('sass', function() {
	return gulp.src(path_theme + 'src/scss/style.scss')
    .pipe(plumber({
      errorHandler: handleErrors
  }))
    .pipe(sass({
     includePaths: [path_bootstrap + 'assets/stylesheets/']
		})) // Converts Sass to CSS with gulp-sass
    .pipe(gulp.dest(path_theme))
});

// complile fonts for boostrap
gulp.task('fonts', function() {
    return gulp.src(path_bootstrap + 'assets/fonts/**/*')
    .pipe(plumber({
        errorHandler: handleErrors
    }))
    .pipe(gulp.dest(path_theme + '/fonts'));
});

// browserify our JS - install all dependencies via npm or figure out how to tie in bower dependancies
gulp.task('browserify', function() {
    // Grabs the app.js file
    return browserify('./' + path_theme + 'src/js/app.js')
      // bundles it and creates a file called main.js
      .bundle().on('error', handleErrors)
      .pipe(source_stream('app.js'))
      // saves it the public/js/ directory
      .pipe(gulp.dest(path_theme + 'js/'));
  });

// gulp.task('browserify', function() {
//     var all = glob.sync('**/*.js');
//     return browserify({entries: all})
//         // bundles it and creates a file called main.js
//         .bundle().on('error', handleErrors)
//         .pipe(source_stream('app.js'))
//         // saves it the public/js/ directory
//         .pipe(gulp.dest(path_theme + 'js/'));

// });


// gulp.task('concat', function() {
// 	console.log(path_theme + 'src/jquery/dist/');
// 	return gulp.src([
// 		path_theme + 'src/js/jquery/dist/jquery.min.js',
// 		path_theme + 'src/js/underscore/underscore-min.js',
// 		path_theme + 'src/js/backbone/backbone-min.js'
// 	])
//     .pipe(concat('dependancies.js'))
//     .pipe(gulp.dest(path_theme + 'js/'));
// });

// gulp.task('browserify', function () {
//   return browserify([path_theme + 'src/js/**/*.js'], {
//     debug: false,
//     // transform: [reactify],
//     uglify: true
//   })
//   .pipe(gulp.dest(path_theme + 'src/js/app.js'));
// });

gulp.task('watch', function() {
    gulp.watch('**/*.scss', ['sass']); 
    // gulp.watch(path_theme + 'src/js/app.js', ['browserify']); 
    gulp.watch(path_theme + '**/*.js', ['browserify']); 
});


gulp.task('build', ['sass', 'fonts', 'browserify'], function() {});