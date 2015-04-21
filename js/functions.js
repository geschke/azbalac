/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */
( function( $ ) {
	var body    = $( 'body' ),
		_window = $( window );


    var mediaSize = '';

    $.getHeaderImage = function(index, fallback) {
        var siteHeaderImage = '';
        var width = 0;
        var height = 0;
        var dontscale = 0;
        if (typeof tikvaHeaderImage[index].url != 'undefined') {
            siteHeaderImage = tikvaHeaderImage[index].url;
            height = tikvaHeaderImage[index].height;
            width = tikvaHeaderImage[index].width;
            dontscale = tikvaHeaderImage[index].dontscale;
        } else if (typeof tikvaHeaderImage[fallback].url != 'undefined') {
            siteHeaderImage  = tikvaHeaderImage[fallback].url;
            height = tikvaHeaderImage[fallback].height;
            width = tikvaHeaderImage[fallback].width;
            dontscale = tikvaHeaderImage[fallback].dontscale;
        }
        return { image: siteHeaderImage,
            width: width,
            height: height,
            dontscale: dontscale};
    }

    $.headerImageResize = function(mediaSize) {
        if (! $('#site-header-image').length) {
            return false;
        }
        var siteHeaderImage =  $('#site-header-image');

        var showImage = false;
        if (siteHeaderImage.attr('width') == 1) {
            // only after window load
            showImage = true;
        }

        var width, height;

        var newWidth = 0, newHeight = 0;
        var imgData = {};
        if (mediaSize == 'xs') {
            newWidth = $('#main').width() - 26;
            imgData = $.getHeaderImage(3,0);
            //newWidth = 244;
        } else if (mediaSize == 'sm') {
            imgData = $.getHeaderImage(2,0);
            newWidth = 690;
        } else if (mediaSize == 'md') {
            imgData = $.getHeaderImage(1,0);
            newWidth = 912;
        } else { // lg
            imgData = $.getHeaderImage(0,0);
            newWidth = 1114;
        }
        if (imgData.image != '') {
            $('#site-header').show();


            siteHeaderImage.attr('src', imgData.image);

            if (imgData.dontscale == 1) {
                newWidth = imgData.width;
                newHeight = imgData.height;
            } else {
                var ratio = imgData.width / imgData.height;
                newHeight = Math.round(newWidth / ratio);
            }
            siteHeaderImage.attr('width', newWidth);
            siteHeaderImage.attr('height', newHeight);
            siteHeaderImage.attr('data-width', newWidth);
            siteHeaderImage.attr('data-height', newHeight);

            if (showImage) {
                siteHeaderImage.fadeIn();
            }

        } else {

                $('#site-header').hide();

        }
    };

    $.checkMediaSize = function( ) {
        var elementSize = $('#media-width-detection-element').width();
        if (elementSize <= 749) { // 767
            mediaDetectSize = 'xs';
        } else if (elementSize >= 750 && elementSize < 970) { // 768 992
            mediaDetectSize = 'sm';
        } else if (elementSize >= 970 && elementSize < 1170) { // 1200
            mediaDetectSize = 'md';
        } else { // >= 1200
            mediaDetectSize = 'lg';
        }
        if (mediaDetectSize != mediaSize || mediaDetectSize == 'xs') {
            mediaSize = mediaDetectSize;
            $.headerImageResize(mediaSize);
        }

    };


    _window.resize(function () {
        $.checkMediaSize(false);
    });


	// Enable menu toggle for small screens.
	/*( function() {
		var nav = $( '#primary-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click.tikva', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();
*/
	/*
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
/*	_window.on( 'hashchange.tikva', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();

			// Repositions the window on jump-to-anchor to account for header height.
			window.scrollBy( 0, -80 );
		}
	} );
*/
	$( function() {
		// Search toggle.
		$( '.search-toggle' ).on( 'click.tikva', function( event ) {
			var that    = $( this ),
				wrapper = $( '.search-box-wrapper' );

			that.toggleClass( 'active' );
			wrapper.toggleClass( 'hide' );

			if ( that.is( '.active' ) || $( '.search-toggle .screen-reader-text' )[0] === event.target ) {
				wrapper.find( '.search-field' ).focus();
			}
		} );





		/*
		 * Fixed header for large screen.
		 * If the header becomes more than 48px tall, unfix the header.
		 *
		 * The callback on the scroll event is only added if there is a header
		 * image and we are not on mobile.
		 */
/*		if ( _window.width() > 781 ) {
			var mastheadHeight = $( '#masthead' ).height(),
				toolbarOffset, mastheadOffset;

			if ( mastheadHeight > 48 ) {
				body.removeClass( 'masthead-fixed' );
			}

			if ( body.is( '.header-image' ) ) {
				toolbarOffset  = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
				mastheadOffset = $( '#masthead' ).offset().top - toolbarOffset;

				_window.on( 'scroll.tikva', function() {
					if ( ( window.scrollY > mastheadOffset ) && ( mastheadHeight < 49 ) ) {
						body.addClass( 'masthead-fixed' );
					} else {
						body.removeClass( 'masthead-fixed' );
					}
				} );
			}
		}
*/
		// Focus styles for menus.
		/*$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.tikva blur.tikva', function() {
			$( this ).parents().toggleClass( 'focus' );
		} );
        */

	} );

	// Arrange footer widgets vertically.
	/*if ( $.isFunction( $.fn.masonry ) ) {
		$( '#footer-sidebar' ).masonry( {
			itemSelector: '.widget',
			columnWidth: function( containerWidth ) {
				return containerWidth / 4;
			},
			gutterWidth: 0,
			isResizable: true,
			isRTL: $( 'body' ).is( '.rtl' )
		} );
	}
*/
	// Initialize Featured Content slider.
/*	_window.load( function() {
		if ( body.is( '.slider' ) ) {
			$( '.featured-content' ).featuredslider( {
				selector: '.featured-content-inner > article',
				controlsContainer: '.featured-content'
			} );
		}
	} );
	*/
    _window.load(function() {
        if ($('#site-header-image').length) {
            $('#site-header-image').hide();
        }
        $.checkMediaSize();

    })

} )( jQuery );
