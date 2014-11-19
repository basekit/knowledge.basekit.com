// Create gulp variables
var gulp  = require('gulp');

// Plugins task
gulp.task('plugins', function() {
	return gulp.src('bower_components/**')
		.pipe(gulp.dest('addons/plugins'));
});
