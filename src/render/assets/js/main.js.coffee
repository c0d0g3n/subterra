class ToggleNav 
	# ToggleNav constructor
	constructor: ->
		@$toggleBtn = $('#page-nav-toggle a')
		@$nav = $('#page-nav')
		@isHidden = false				# (bool) current status of nav menu

	# ToggleNav methods
	toggle: =>
		if @isHidden
			@show()
		else
			@hide()

	show: =>
		# show
		@$nav.removeClass('nav-hidden')
		@$nav.addClass('nav-shown')

		# update status
		@isHidden = false

	hide: =>
		# hide
		@$nav.removeClass('nav-shown')
		@$nav.addClass('nav-hidden')

		# update status
		@isHidden = true



# encapsulate jQuery
(($) ->

	# jQuery ready
	$ ->
		# instantiate objects
		toggleNav = new ToggleNav

		# hide nav on load
		toggleNav.hide()

		# bind events
		$( toggleNav.$toggleBtn )
			# toggle on click
			.on "click", (event) ->
				# prevent default (following # link)
				event.preventDefault()

				# trigger toggle method
				toggleNav.toggle()

				# remove focus (cleaner)
				$(':focus').blur()

) jQuery