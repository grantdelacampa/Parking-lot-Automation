var gulp = require('gulp');
var plugins = require('gulp-load-plugins')({
    rename: {
        'gulp-webserver':  'webserver'
    }
});

// express server with live reload
gulp.task('serve', function() {
    gulp.src('./')
        .pipe(plugins.webserver({
            fallback: 'index.html',
            livereload: true,
            directoryListing: false,
            open: true
        }));
});
