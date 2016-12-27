# DocPad Configuration File
# http://docpad.org/docs/config

# Define the DocPad Configuration
docpadConfig = {
	collections:
		menu: ->
			@getCollection("html").findAllLive({'inMenu':true})

	templateData:
		site:
			title: "Subterra"
			tagLine: "Awesome recording studio"
			url: 'https://c0d0g3n.github.io/subterra2'

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

	plugins:
		gulp:
			writeAfter: false
			generateAfter: ['cssmin', 'jsmin']



	environments:
		static:
			templateData:
				environment: 'static'

		development:
			templateData:
				site:
					url: 'http://192.168.0.7:9778'
				environment: 'development'
			plugins:
				gulp:
					# dont need minified and concaterated files in development mode
					generateAfter: false
}

# Export the DocPad Configuration
module.exports = docpadConfig