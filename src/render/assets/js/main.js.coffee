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



class Message
	constructor: ($messageBox) ->
		@$messageBox = $messageBox
		@$closeBtn = @$messageBox.find '.close-message'
		
		# hook into page
		@$closeBtn.on 'click', (event) =>
			event.preventDefault()
			@$messageBox.css 'display', 'none'



# encapsulate jQuery
(($) ->

	# jQuery ready
	$ ->
		# instantiate objects
		# toggle nav
		toggleNav = new ToggleNav
		
		# message
		messageBoxes = [];
		$( '.form-message' ).each ->
			messageBoxes.push new Message $ @

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