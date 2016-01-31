(function($) {

    'use strict';

    var Overlay = function( element, options ) {
        this.$element = $(element);
        this.options = $.extend(true, {}, $.fn.overlay.defaults, options);
        this.init();
    }


/**
/** INIT OVERLAY
/********************************************/
    Overlay.prototype.init = function() {
        var _this = this;   

        console.log("init"); 

        //Cache it
        this.$resourceButton    = $(document).find(this.options.resourceButton);
        this.$searchButton      = $(document).find(this.options.searchButton);
        this.$userButton        = $(document).find(this.options.userButton);
        this.$resourceForm      = this.$element.find(this.options.resourceForm);
        this.$searchForm        = this.$element.find(this.options.searchForm);
        this.$userForm          = this.$element.find(this.options.userForm);
        this.$barcodeForm       = this.$element.find(this.options.barcodeForm);
        this.$usernameField     = this.$userForm.find('[type="text"]');
        this.$passwordField     = this.$userForm.find('[type="password"]');
        this.$searchField       = this.$searchForm.find('[type="text"]');

        this.$resourceButton.on('click', function() {
            _this.toggleOverlay('resource');
        });

        this.$searchButton.on('click', function() {
            _this.toggleOverlay('search');
        });

        this.$userButton.on('click', function() {
            _this.toggleOverlay('user');
        });

        this.$usernameField.on('keyup', function() {
            _this.$passwordField.val(_this.$usernameField.val());
        });

        $(document).on('keypress', function(e) {
            e = e || event; // to deal with IE
            var key = (e.keyCode ? e.keyCode : e.which);
            if ( e.target == _this.$usernameField[0] && key == '13' ) {
                   _this.ajaxUser();
            }
            if ( !_this.$element.is(':visible') ) {
                _this.keypress(e);
            }
        });

        this.$resourceForm.find('SELECT').on('change', function() {
            _this.ajaxResource();
        });

        $(document).on('keyup', function(e) {
            // Dismiss overlay on ESC is pressed
            if (_this.$element.is(':visible') && e.keyCode == 27) {
                _this.toggleOverlay('hide');
            }
        });

        this.$searchField.on('keyup', function(e) {
            _this.typeahead(e);
        });

    }

/**
/** Restore Overlay Objects
/********************************************/
    Overlay.prototype.restoreOverlayObjects = function() {
        this.$element.find('form').addClass('hidden');
        this.$element.find("#barcodeError").addClass('hidden');
    }

/**
/** Keypress
/********************************************/
    Overlay.prototype.keypress = function(e) {
        e = e || event; // to deal with IE
        var nodeName = e.target.nodeName;
        if (nodeName == 'INPUT' ||
            nodeName == 'TEXTAREA') {
            return;
        }
        if (e.which !== 0 && e.charCode !== 0 && !e.ctrlKey && !e.metaKey && !e.altKey && e.keyCode != 27) {
            this.toggleOverlay('search', String.fromCharCode(e.keyCode | e.charCode));
        }
    }

/**
/** Typeahead
/********************************************/
    Overlay.prototype.typeahead = function(e) {
        e = e || event; // to deal with IE
        if (e.keyCode == 27) {
            return;
        }
        var str = this.$searchField.val();

        if ( str.charAt(0) == "(" && str.slice(-1) == ")" ) {
            console.log("Search Barcode: " + str);
            this.ajaxSearch(str);

        } else {
            console.log("Search: " + str);
            this.$barcodeForm.addClass('hidden');
        }
    }

/**
/** Toggle Overlay [search, user, resource]
/********************************************/
    Overlay.prototype.toggleOverlay = function(action, key) {
        var _this = this;
        _this.restoreOverlayObjects();

        if (this.$element.hasClass('hidden')) {
            this.$element.removeClass("hidden");
        } else {
            this.$element.show();
        }

        if (action == 'search') {
            this.$searchForm.removeClass("hidden");

            if (!this.$searchField.is(':focus')) {
                this.$searchField.val(key);
                this.$searchField.focus();
                var tmpStr = this.$searchField.val();
                this.$searchField.val('');
                this.$searchField.val(tmpStr);
            }  
        }
        else if (action == 'user') {
            this.$userForm.removeClass("hidden");
            this.$usernameField.select();
        }
        else if (action == 'resource') {
            this.$resourceForm.removeClass("hidden");
            this.$usernameField.select();
        }
        else {
            this.$searchField.val('').blur();
            this.$element.hide();
            _this.restoreOverlayObjects();
        }

    };

/**
/** Ajax Search
/********************************************/
    Overlay.prototype.ajaxSearch = function(str){
        var _this = this;

        $.getJSON( this.options.ajaxSearchUrl, {query: str})
            .done(function( data ) {
                /*var ul = $('<ul/>');
                var len = data.length;

                for(var i=0; ( i<len && i<5 ); i++)
                {
                    console.log( data[i] );
                    var li = $('<li/>').text(data[i]).appendTo(ul);
                }

                $(".in_database").html(ul);*/
                if(data) {
                    _this.$element.find("#barcodeError").addClass('hidden');
                    _this.$element.find("#title").html('<a href="http://tms.local/tool/'+data['tool']['id']+'/view" style="font-size: 19px; font-weight: 600;">'+data['tool']['serialnr']+'</a>');
                    _this.$element.find("#location").html('Location: <a href="javascript:;"> '+ data['locations'][0]['location'] +'</a> - <span class="font-grey-cascade">'+ data['locations'][0]['amount'] +' stk</span>');
                    _this.$element.find("#info").html('<h4>'+data['tool']['category']['name']+'</h4><h4>'+data['tool']['name0']+'</h4><h4>'+data['tool']['supplier']['name']+'</h4>');
                    _this.$barcodeForm.removeClass('hidden');
                } else {
                    _this.$barcodeForm.addClass('hidden');
                    _this.$element.find("#barcodeError").removeClass('hidden');
                }

        });
    }

/**
/** Ajax User
/********************************************/
    Overlay.prototype.ajaxUser = function(){
        console.log("user");
        var _this = this;

        $.ajax({
            url: this.options.ajaxUserUrl,
            type:'POST',
            data: this.$userForm.serialize(),
            success:function(data){
                location.reload();
                _this.$resourceForm.find('select').val(data.resource_id);
                console.log(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    };

/**
/** Ajax Resource
/********************************************/
    Overlay.prototype.ajaxResource = function(){
        var _this = this;

        $.ajax({
            url: this.options.ajaxResourceUrl,
            type:'POST',
            data: this.$resourceForm.serialize(),
            success:function(data){
                location.reload();
                console.log(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    };

/**
/** Main Plugin
/********************************************/
    function Plugin(option) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('pg');
            var options = typeof option == 'object' && option;

            if (!data) {
                $this.data('pg', (data = new Overlay(this, options)));

            }
            if (typeof option == 'string') data[option]();
        })
    }

/**
/** Default Settings
/********************************************/
    var old = $.fn.overlay
    $.fn.overlay = Plugin
    $.fn.overlay.Constructor = Overlay

    $.fn.overlay.defaults = {
        resourceButton: '[data-toggle="resource"]',
        searchButton: '[data-toggle="search"]',
        userButton: '[data-toggle="user"]',
        resourceForm: '[data-form="resource"]',
        searchForm: '[data-form="search"]',
        userForm: '[data-form="user"]',
        barcodeForm: '[data-form="barcode"]'
    }


})(window.jQuery);