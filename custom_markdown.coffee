# load the marked module, also required by docpad-plugin-marked, so the former is available when the latter is installed
marked = require 'marked'

# create a new marked renderer instance
	# https://github.com/chjj/marked/blob/master/README.md#renderer
renderer = new marked.Renderer

# add your custom renderers
	# for all renderer methods, see https://github.com/chjj/marked/blob/master/README.md#block-level-renderer-methods and below
	# f.i. wrap divs around images
renderer.image = (href, title, text) ->
	output = 	'<span class="img-wpr">'
					# I should probably escape here...
	output += 		'<img src="' + href + '" alt="' + text + '" title="' + title + '" />'
	# output += 		'<div>'
	# output += 			text
	# output += 		'</div>'
	output += 	'</span>'

# export the renderer, so we can pass it in the plugin's settings
module.exports = renderer