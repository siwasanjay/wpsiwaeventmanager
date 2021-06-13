(function ($) {

    // Filter post based on option selected.
	var filter = {
		init: function () {
			this.cacheDOM();
			this.eventListner();
		},
		cacheDOM: function () {
            this.$typeSelect = $('#ev_cat');
			this.$tagSelect = $('#ev_tag');
			this.$dateSelect = $('#ev_date');
            this.$fIlterWrapper = $('.event-wrapper');
            this.$button = $('#loadmore'); // loadmore button
		},
        eventListner: function () {
            this.$typeSelect.on('change', this.filterCat.bind(this));
            this.$tagSelect.on('change', this.filterCat.bind(this));
            this.$dateSelect.on('change', this.filterCat.bind(this));
            this.$button.on('click', this.loadMore.bind(this));
        },
        // Category and orderby select change.
        filterCat: function (e) {

            var selectedtype = this.$typeSelect.val();
            var selectedTag = this.$tagSelect.val();
            var selectedDate = this.$dateSelect.val();
            var limit = this.$fIlterWrapper.attr('data-limit');
            var postData = {
                action: 'wpsem_filter_event', // action
                curType: selectedtype, // selected type
                curTag: selectedTag, // selected tag
                curDate: selectedDate, // selected date order
                limit: limit,
            };
            $.ajax({
                url: WPSEM.ajaxurl,
                type: 'POST',
                data: postData,
                beforeSend: function(){
                	
                },
                success: function(response){
					$('.event-wrapper').html(response.content);
                },
            });
        },
        // loadmore
        loadMore: function() {
            var selectedtype = this.$typeSelect.val();
            var selectedTag = this.$tagSelect.val();
            var selectedDate = this.$dateSelect.val();
            var cPage = this.$button.attr('data-next');
            var limit = this.$fIlterWrapper.attr('data-limit');

            var postData = {
                action: 'wpsem_filter_event', // action
                curType: selectedtype, // selected type
                curTag: selectedTag, // selected tag
                curDate: selectedDate, // selected date order
                cPage: cPage, // current page
                limit: limit,
            };
            $.ajax({
                url: WPSEM.ajaxurl,
                type: 'POST',
                data: postData,
                beforeSend: function(){

                },
                success: function(response){

                    $('.event-wrapper').append(response.content);
                    if(response.nextpage) {
                        $('#loadmore').attr('data-next', response.nextpage );
                    } else {
                        $('#loadmore').hide();
                    }

                },
            });
        }
	};

    //rename PROJECTNAME
    var WPSIWAEM = {
        // All pages
        common: {
        	init: function() {
                // JavaScript to be fired on all pages
                filter.init();
            }
    	},

	};

    //common UTIL this doesn't change
    var PG_JS_UTIL = {

    	fire: function(func, funcname, args) {
            var namespace = WPSIWAEM; // indicate your obj literal namespace here for standard lets make it abbreviation of current project

            funcname = (funcname === undefined) ? 'init' : funcname;
            if (func !== '' && namespace[func]
            	&& typeof namespace[func][funcname] === 'function') {
            		namespace[func][funcname](args);
        	}
    	},

	    loadEvents: function() {

	    	var bodyId = document.body.id;

	        // hit up common first.
	        PG_JS_UTIL.fire('common');

	        // do all the classes too.
	        $.each(document.body.className.split(/\s+/), function(i, classnm) {
	        	PG_JS_UTIL.fire(classnm);
	        	PG_JS_UTIL.fire(classnm, bodyId);
	        });

	        PG_JS_UTIL.fire('common', 'finalize');

	    }
	};

	$(function() {
		PG_JS_UTIL.loadEvents();
	});


})(jQuery);
