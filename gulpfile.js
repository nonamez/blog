var gulp = require('gulp');

gulp.task('default', function() {
	gulp.src(['vendor/bower_components/jquery/dist/**/*']).pipe(gulp.dest('public/assets/plugins/jquery/'));
	gulp.src(['vendor/bower_components/bootstrap/dist/**/*']).pipe(gulp.dest('public/assets/plugins/bootstrap/'));
	gulp.src(['vendor/bower_components/fontawesome/css']).pipe(gulp.dest('public/assets/plugins/fontawesome/css'));
	gulp.src(['vendor/bower_components/fontawesome/fonts']).pipe(gulp.dest('public/assets/plugins/fontawesome/fonts'));
});