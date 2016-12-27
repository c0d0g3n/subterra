# requirements
gulp = 			require 'gulp'
cssmin = 		require 'gulp-cssmin'
jsmin = 		require 'gulp-jsmin'
concat = 		require 'gulp-concat'
rename = 		require 'gulp-rename'

# default task
gulp.task 'default', [
	'cssmin'
	'jsmin'
]

# cssconcat task
gulp.task 'cssconcat', ->
	gulp
		.src 'out/assets/css/*.css'
		.pipe concat 'screen.css'
		.pipe gulp.dest 'out/dist/css'


# cssmin task
gulp.task 'cssmin', ['cssconcat'], ->
	gulp
		.src 'out/dist/css/screen.css'
		.pipe cssmin()
		.pipe rename
			suffix: '.min'
		.pipe gulp.dest 'out/dist/css'


# jsconcat task
gulp.task 'jsconcat', ->
	gulp
		.src 'out/assets/js/*.js'
		.pipe concat 'stellar.js'
		.pipe gulp.dest 'out/dist/js'


# jsmin task
gulp.task 'jsmin', ['jsconcat'], ->
	gulp
		.src 'out/dist/js/stellar.js'
		.pipe jsmin()
		.pipe rename
			suffix: '.min'
		.pipe gulp.dest 'out/dist/js'