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

        var instantSearch = new Bloodhound({
            datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            limit: 10,
            remote: {
                url: this.options.ajaxSearchSerialnrUrl + '?query=%QUERY',
                wildcard: '%QUERY',
                filter: function(list) {
                    return $.map(list, function(d) { return { instantSearch: d }; });
                }
            }

        });

        instantSearch.initialize();

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

        this.$searchField.typeahead(null, {
            name: 'instantSearch',
            displayKey: 'instantSearch',
            source: instantSearch.ttAdapter()
        });

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
            e = e || event; // to deal with IE
            if (e.keyCode == 27) {
                return;
            }
            var str = _this.$searchField.val();

            if ( str.charAt(0) == "(" && str.slice(-1) == ")" ) {
                console.log("Search Barcode: " + str);
                _this.ajaxSearchByBarcode(str);

            } else {
                _this.$barcodeForm.addClass('hidden');
            }
        });

        this.$searchField.on('typeahead:selected', function(evt, item) {
            console.log("Selected: " + _this.$searchField.val());
            _this.ajaxSearchBySerialnr(_this.$searchField.val());
        })

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
    /** Ajax Instant Barcode Search
    /********************************************/
    Overlay.prototype.ajaxSearchByBarcode = function(str){
        var _this = this;
        $.getJSON( this.options.ajaxSearchBarcodeUrl, {query: str})
        .done(function( data ) {
            _this.paintData(data);
        });
    }

    /**
    /** Ajax Get Item by Serialnr Search
    /********************************************/
    Overlay.prototype.ajaxSearchBySerialnr = function(str){
        var _this = this;
        $.getJSON( this.options.ajaxFindItemBySerialnr, {query: str})
        .done(function( data ) {
            _this.paintData(data);
        });
    }

    /**
    /** Ajax Get Item by Serialnr Search
    /********************************************/
    Overlay.prototype.paintData = function(data){
        var _this = this;

        console.log(data);
        if(data) {
            _this.$element.find("#barcodeError").addClass('hidden');
            _this.$element.find("#picture").html('<img src="'+APP_URL+'/files" alt="" width="280px" style="vertical-align:middle;">');
            _this.$element.find("#title").html('<a href="'+APP_URL+'/tool/'+data['id']+'/view" style="font-size: 19px; font-weight: 600;">'+data['serialnr']+'</a>');
            _this.$element.find("#location").html('Location: <a href="javascript:;"> '+ '</a> - <span class="font-grey-cascade">'+ ' stk</span>');
            _this.$element.find("#info").html('<h4>'+data['category']['name']+'</h4><h4>'+data['name0']+'</h4><h4>'+data['suppliers']['name']+'</h4>');
            _this.$barcodeForm.removeClass('hidden');
        } else {
            _this.$barcodeForm.addClass('hidden');
            _this.$element.find("#barcodeError").removeClass('hidden');
        }
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
