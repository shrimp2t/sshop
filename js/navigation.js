/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, menu, links, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();




jQuery( document).ready( function( $ ){
    jQuery( '.layout-tabs').each( function(){
        var tab = $( this );
        var headingLabel = $( '.heading-label', tab );
        var filter = $( '.nav-tabs-filter', tab );
        var subLi = $( '.subfilter-more', filter );
        var ajaxUrl = tab.data( 'ajax' );
        var instance = tab.data( 'instance' ) || {};
        instance.action = 'sshop_tabs_content_ajax';

        var slickArgs = {
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            infinite: true,
            autoplaySpeed: 2000,
            prevArrow: $( '.slider-prev', tab ),
            nextArrow: $( '.slider-next', tab ),
        };

        var setup = function( ){
            // Reset all sub filters
            $( '.subfilter-more ul li', filter).each( function(){
                filter.append( $( this ) );
            });
            var headingWidth = headingLabel.outerWidth();
            var tabWidth = tab.innerWidth();

            console.log( 'tabWidth', tabWidth );

            var w = 0;
            headingWidth = 0;
            var filterW = tabWidth - headingWidth - 20;
            console.log( 'filterW', filterW );
            $( 'li', filter).not('.subfilter-more').each( function(){
                var width = $( this ).outerWidth();

                w += width;
                if ( filterW < w + width ) {
                    var li = $( this );
                    subLi.find( '.sub-filters' ).append( li );
                }
            } );

            // Move sub filter to the end of list
            filter.append( subLi );
            var l = $( '.subfilter-more ul li', filter ).length;

            if ( l > 0 ) {
                $( '> li', filter ).eq ( $( '> li', filter ).length - 2).removeClass( 'last' );
                subLi.show();
            } else {
                $( '> li', filter ).eq ( $( '> li', filter ).length - 2).addClass( 'last');
                subLi.hide();
            }

            if ( $( 'li.active', filter).length <= 0 ) {
                $( 'li', filter).eq( 0 ).addClass( 'active' );
            }

            $('.tabs-content-items', tab ).slick( slickArgs );

        };

        setup();

        $( window).resize( function(){
            setup();
        } );

        // Ajax load posts
        tab.on( 'click', '.nav-tabs-filter a, .tab-paging-wrap .tab-paging', function( e ){
            e.preventDefault();
            var a  = $( this );
            var id = a.data( 'term-id' ) || '';
            var paged = 1;
            var canSend = false;

            if ( id ) {
                canSend = 1;
                $( 'a, li', filter ).removeClass( 'active' );
                a.parent().addClass( 'active' );
            }

            if (  a.hasClass( 'tab-paging' ) ) {
                if ( ! a.hasClass( 'disable' ) ) {
                    canSend = 2;
                    paged = a.attr( 'data-paged' ) || '';
                }
            }

            if ( canSend ) {
                var contentLayout = $('.tabs-layout-content', tab);
                //var ch = contentLayout.height();
                //contentLayout.css( 'min-height', ch );
                var spinner = '<div class="loading-spinner">' +
                    '<div class="loading-bg"></div>' +
                    '<div class="loading-spinner-icon">' +
                    '<div class="spinner">'
                    + '<div class="rect1"></div>'
                    + '<div class="rect2"></div>'
                    + '<div class="rect3"></div>'
                    + '<div class="rect4"></div>'
                    + '<div class="rect5"></div>'
                    + '</div>' +
                    '</div>' +
                    '</div>';

                spinner = $(spinner);

                tab._lastSent = instance;
                if (id) {
                    tab._lastSent.viewing = id;
                }
                tab._lastSent.paged = paged;

                if (tab._jqxhr) {
                    tab._jqxhr.abort();
                }

                var appendTabContent = function (html, delay ) {

                    if ( $('.tabs-content-items', tab).length > 0 ) {
                        $('.tabs-content-items', tab ).slick('unslick');
                    }

                    html = '<div>' + html + '</div>';
                    var $html = $(html);
                    $('.tabs-item-inside', $html ).addClass('animate');
                    if (  typeof delay === "undefined" ) {
                        delay = 500;
                    }
                    setTimeout(function () {
                        contentLayout.addClass('animate');
                        contentLayout.find('.tabs-content-items-wrapper').html($html);
                        var t = 0;
                        $('.dt-news-post', $html).each(function (index) {
                            var dt = $(this);
                            var _t = ( index + 1 ) * 100;
                            t = _t;
                            setTimeout(function () {
                                dt.removeClass('animate');
                            }, _t);
                        });

                        spinner.animate({
                            opacity: 0,
                        }, t - 100, function () {
                            // Animation complete.
                            tab.removeClass('loading');
                            spinner.remove();
                        });


                        $('.tabs-content-items', tab ).slick( slickArgs );

                    }, delay );


                };

                var cacheData = a.data( '_ajaxData' ) || '';

                if ( canSend == 1 &&  cacheData ) {
                    contentLayout.removeClass('animate');
                    appendTabContent( cacheData, 0 );
                    tab._jqxhr = false;
                } else {

                    tab.addClass('loading');
                    contentLayout.append(spinner);

                    tab._jqxhr = $.get(ajaxUrl, tab._lastSent, function (html) {
                        //contentLayout.html('');
                        contentLayout.removeClass('animate');
                        if ( canSend == 1) {
                            a.data( '_ajaxData', html );
                        }
                        appendTabContent(html);
                        tab._jqxhr = false;

                    })
                        .done(function () {
                            tab._jqxhr = false;
                            //tab.removeClass( 'loading' );
                            //spinner.remove();
                        })
                        .fail(function () {
                            tab._jqxhr = false;
                            //tab.removeClass( 'loading' );
                            //spinner.remove();
                        })
                        .always(function () {
                            tab._jqxhr = false;
                            //tab.removeClass( 'loading' );
                            //spinner.remove();
                        });
                }
            }


        } );



    } );

} );
