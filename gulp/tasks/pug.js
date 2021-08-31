const plumber = require('gulp-plumber'),
    pug = require('gulp-pug'),
    cached = require('gulp-cached');

module.exports = function () {
    $.gulp.task('pug', () => {
        return $.gulp.src('./dev/pug/pages/*.pug')
            .pipe(plumber())
            .pipe(cached('pug')) // very important part, speed up pug compile time a lot 
            .pipe(pug({
                pretty: true
            }))
            .pipe(plumber.stop())

            .pipe($.gulp.dest('./build/'))
            .on('end', $.browserSync.reload);
    });
};
