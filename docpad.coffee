# DocPad Configuration File
# http://docpad.org/docs/config



# Define the DocPad Configuration
docpadConfig = {
	# port: 8080
	
	collections:
		menu: ->
			@getCollection("documents")
				.findAllLive({'inMenu':true},[{'menuOrder': 1}])

	templateData:
		site:
			title: "Subterra"
			tagLine: "Awesome recording studio"
			# url: 'https://c0d0g3n.github.io/subterra2'
			url: 'http://192.168.0.14/subterra'
			contactFileName: 'contact'

		pageTitle: ->
			if @document.title then "#{@document.title} - #{@site.title}" else @site.title

		getCss: ->
			if @environment is 'development'
				[@site.url + '/assets/css/normalize.css', @site.url + '/assets/css/font-awesome.css', @site.url + '/assets/css/screen.css']
			else
				[@site.url + '/dist/css/screen.min.css']

		getJs: ->
			if @environment is 'development'
				[@site.url + '/assets/js/jquery-3.1.1.js', @site.url + '/assets/js/main.js']
			else
				[@site.url + '/dist/js/stellar.min.js']

		bodyClass: ->
			if @document.isHome is true
				'home'

	plugins:
		gulp:
			writeAfter: ['cssmin', 'jsmin']
			generateAfter: false
			background: true
		marked:
			markedRenderer:
				image: (href, title, text) ->
					output = 	'<span class="img-wpr">'
									# I should probably escape here...
					output += 		'<img src="' + href + '" alt="' + text + '" title="' + title + '" />'
					# output += 		'<div>'
					# output += 			text
					# output += 		'</div>'
					output += 	'</span>'
		livereload:
			enabled: false
	
	
	enabledPlugins:
		livereload: false



	environments:
		static:
			templateData:
				environment: 'static'

		development:
			templateData:
				site:
					url: 'http://192.168.0.14/subterra'
				environment: 'development'
			# plugins:
				# gulp:
					# dont need minified and concaterated files in development mode
					# writeAfter: false
}

# Export the DocPad Configuration
module.exports = docpadConfig