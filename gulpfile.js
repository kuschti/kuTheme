var gulp      = require('gulp'),
    sass      = require('gulp-sass'),
    concat    = require('gulp-concat'),
    bourbon   = require('node-bourbon'),
    neat      = require('node-neat').includePaths,
    minifyCSS = require('gulp-minify-css'),
    rename    = require('gulp-rename'),
    notify    = require("gulp-notify");

var paths = {
  style: './src/scss/style.scss',
  sassFiles: './src/scss/**/*.scss'
};

gulp.task('sass', function () {
  return gulp.src(paths.style)
    .pipe(sass({
      includePaths: neat,
      onError: function(err) {
        return notify().write(err);
      }
    }))
    .pipe(gulp.dest('./dist/css'));
});

gulp.task('watch', function() {
  gulp.watch(paths.sassFiles, ['sass']);
});

gulp.task('default', ['sass', 'watch']);
