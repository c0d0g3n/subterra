(function() {
  var Message, ToggleNav,
    bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  ToggleNav = (function() {
    function ToggleNav() {
      this.hide = bind(this.hide, this);
      this.show = bind(this.show, this);
      this.toggle = bind(this.toggle, this);
      this.$toggleBtn = $('#page-nav-toggle a');
      this.$nav = $('#page-nav');
      this.isHidden = false;
    }

    ToggleNav.prototype.toggle = function() {
      if (this.isHidden) {
        return this.show();
      } else {
        return this.hide();
      }
    };

    ToggleNav.prototype.show = function() {
      this.$nav.removeClass('nav-hidden');
      this.$nav.addClass('nav-shown');
      return this.isHidden = false;
    };

    ToggleNav.prototype.hide = function() {
      this.$nav.removeClass('nav-shown');
      this.$nav.addClass('nav-hidden');
      return this.isHidden = true;
    };

    return ToggleNav;

  })();

  Message = (function() {
    function Message($messageBox) {
      this.$messageBox = $messageBox;
      this.$closeBtn = this.$messageBox.find('.close-message');
      this.$closeBtn.on('click', (function(_this) {
        return function(event) {
          event.preventDefault();
          return _this.$messageBox.css('display', 'none');
        };
      })(this));
    }

    return Message;

  })();

  (function($) {
    return $(function() {
      var messageBoxes, toggleNav;
      toggleNav = new ToggleNav;
      messageBoxes = [];
      $('.form-message').each(function() {
        return messageBoxes.push(new Message($(this)));
      });
      toggleNav.hide();
      return $(toggleNav.$toggleBtn).on("click", function(event) {
        event.preventDefault();
        toggleNav.toggle();
        return $(':focus').blur();
      });
    });
  })(jQuery);

}).call(this);
