const BOWER_DIR  = 'bower_components';
const PLUGIN_DIR = 'public/assets/plugins';

var gulp = require('gulp');

gulp.task('copy', function() {
	gulp.src([BOWER_DIR + '/jquery/dist/**/*']).pipe(gulp.dest(PLUGIN_DIR + '/jquery/'));
	gulp.src([BOWER_DIR + '/bootstrap/dist/**/*']).pipe(gulp.dest(PLUGIN_DIR + '/bootstrap/'));
	gulp.src(['css/**/*', 'fonts/**/*'], {'cwd': BOWER_DIR + '/fontawesome', 'base': BOWER_DIR + '/fontawesome'}).pipe(gulp.dest(PLUGIN_DIR + '/fontawesome/'));
	gulp.src(['highlight.pack.min.js', 'styles/vs.css'], {'cwd': BOWER_DIR + '/highlightjs', 'base': BOWER_DIR + '/highlightjs'}).pipe(gulp.dest(PLUGIN_DIR + '/highlightjs/'));
});

gulp.task('default', ['copy']);