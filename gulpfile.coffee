# requirements
gulp = 			require 'gulp'
cssmin = 		require 'gulp-cssmin'
jsmin = 		require 'gulp-jsmin'
concat = 		require 'gulp-concat'
rename = 		require 'gulp-rename'
autoprefixer = 	require 'gulp-autoprefixer'
imageResize = 	require 'gulp-image-resize'

# default task
gulp.task 'default', [
	'cssmin'
	'jsmin'
]


# csspre(fix) task
gulp.task 'csspre', ->
	gulp
		.src 'out/assets/css/screen.css'
		.pipe autoprefixer
			browsers: ['last 2 versions', 'firefox >= 18'],
			cascade: false
		.pipe gulp.dest 'out/assets/css'


# cssconcat task
gulp.task 'cssconcat', ['csspre'], ->
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


# image resize task
gulp.task 'imgres', ->
	console.log 'RESIZING IMAGES'
	gulp
		.src 'out/assets/images/full/*@(.jpg|.JPG|.png|.PNG)'
		.pipe imageResize
			width: 400
		.pipe gulp.dest 'out/assets/images/400'

	gulp
		.src 'out/assets/images/full/*@(.jpg|.JPG|.png|.PNG)'
		.pipe imageResize
			width: 600
		.pipe gulp.dest 'out/assets/images/600'

	gulp
		.src 'out/assets/images/full/*@(.jpg|.JPG|.png|.PNG)'
		.pipe imageResize
			width: 800
		.pipe gulp.dest 'out/assets/images/800'

	gulp
		.src 'out/assets/images/full/*@(.jpg|.JPG|.png|.PNG)'
		.pipe imageResize
			width: 1200
		.pipe gulp.dest 'out/assets/images/1200'

	gulp
		.src 'out/assets/images/full/*@(.jpg|.JPG|.png|.PNG)'
		.pipe imageResize
			width: 1600
		.pipe gulp.dest 'out/assets/images/1600'

	gulp
		.src 'out/assets/images/full/*@(.jpg|.JPG|.png|.PNG)'
		.pipe imageResize
			width: 2400
		.pipe gulp.dest 'out/assets/images/2400'
