const BOWER_DIR  = 'bower_components';
const PLUGIN_DIR = 'public/assets/plugins';

var gulp = require('gulp');

gulp.task('copy', function() {
	gulp.src([BOWER_DIR + '/jquery/dist/**/*']).pipe(gulp.dest(PLUGIN_DIR + '/jquery/'));
	gulp.src([BOWER_DIR + '/bootstrap/dist/**/*']).pipe(gulp.dest(PLUGIN_DIR + '/bootstrap/'));
	gulp.src(['css/**/*', 'fonts/**/*'], {'cwd': BOWER_DIR + '/fontawesome', 'base': BOWER_DIR + '/fontawesome'}).pipe(gulp.dest(PLUGIN_DIR + '/fontawesome/'));
});

gulp.task('default', ['copy']);