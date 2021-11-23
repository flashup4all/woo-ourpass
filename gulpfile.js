var gulp = require('gulp');
var babel = require('gulp-babel');
const cleanCSS = require('gulp-clean-css');
var gulpCopy = require('gulp-copy');

gulp.task('copy-html', () => {
    return gulp
        .src(['assets/src/index.html'])
        .pipe(gulpCopy('./assets/dist', { prefix: 2 }))
});

gulp.task('build-js', () => {
    return gulp.src('assets/src/*.js')
        .pipe(babel())
        .pipe(gulp.dest('./assets/dist'))
});

gulp.task('build-css', () => {
    return gulp.src('assets/src/*.css')
        .pipe(cleanCSS({ compatibility: 'ie8' }))
        .pipe(gulp.dest('./assets/dist'))
});

gulp.task('build', gulp.series('copy-html', 'build-css', 'build-js'));