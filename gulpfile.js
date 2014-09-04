var gulp = require('gulp'),
    sass = require('gulp-sass'),
    neat = require('node-neat').includePaths,
    notify = require("gulp-notify");

var paths = {
  sass: './src/sass/*.sass',
  sassFiles: './src/sass/**/*.sass'
};

gulp.task('sass', function () {
  return gulp.src(paths.sass)
    .pipe(sass({
      includePaths: ['./src/sass'].concat(neat),
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
