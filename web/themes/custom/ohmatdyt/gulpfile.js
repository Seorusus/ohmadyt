const gulp = require('gulp');
const sass = require('gulp-sass')(require('node-sass'));
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');

const sassOptions = {
  outputStyle: 'expanded'
};

const autoprefixerOptions = {
  browsers: ['last 2 versions'],
  cascade: false
};

gulp.task('sass', function () {
  return gulp
    .src('./sass/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./css'));
});

gulp.task('watch', function () {
  gulp.watch('./sass/**/*.scss', gulp.series('sass'));
});

gulp.task('build', gulp.series('sass'));

gulp.task('default', gulp.series('build'));
