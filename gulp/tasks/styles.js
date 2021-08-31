const plumber = require('gulp-plumber'),
      scss = require('gulp-sass'),
      autoprefixer = require('gulp-autoprefixer'),
      csso = require('gulp-csso'),
      csscomb = require('gulp-csscomb'),
      sourcemaps = require('gulp-sourcemaps'),
      rename = require('gulp-rename'),
      gcmq = require('gulp-group-css-media-queries'),
      stylesPATH = {
          "input": "./dev/static/styles/",
          "output": "./build/static/css/"
      };

module.exports = function () {
    $.gulp.task('styles:dev', () => {
        return $.gulp.src(stylesPATH.input + '**/*.scss')
            // .pipe(plumber())
            .pipe(scss({errLogToConsole: true}))
            .pipe(autoprefixer({
                 overrideBrowserslist:  ['last 3 versions'],
                 grid: 'autoplace',
            }))
            .pipe(gcmq())
            .pipe($.gulp.dest(stylesPATH.output))
            .on('end', $.browserSync.reload);
    });
    $.gulp.task('styles:build', () => {
        return $.gulp.src(stylesPATH.input + '**/*.scss')
            .pipe(plumber())
            .pipe(scss({errLogToConsole: true}))
            .pipe(autoprefixer({  
                 overrideBrowserslist:  ['last 3 versions'],
                 grid: 'autoplace',
            }))
            .pipe(autoprefixer())
            // .pipe(csscomb())
            .pipe(gcmq())
            .pipe($.gulp.dest(stylesPATH.output))
            .on('end', $.browserSync.reload);
    });
    $.gulp.task('styles:build-min', () => {
        return $.gulp.src(stylesPATH.input + 'styles.scss')
            .pipe(scss())
            .pipe(autoprefixer())
            .pipe(csscomb())
            .pipe(csso())
            .pipe(rename('styles.min.css'))
            .pipe(gcmq())
            .pipe($.gulp.dest(stylesPATH.output))
    });
};
