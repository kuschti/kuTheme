var gulp = require('gulp'),
    sass = require('gulp-sass'),
    neat = require('node-neat').includePaths;

var paths = {
  scss: './src/sass/*.scss'
};

gulp.task('sass', function () {
  return gulp.src(paths.scss)
    .pipe(sass({
      includePaths: ['styles'].concat(neat)
    }))
    .pipe(gulp.dest('./dist/css'));
});

gulp.task('default', ['sass']);
