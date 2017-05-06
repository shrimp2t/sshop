
jQuery( document).ready( function( $ ){

    //departments menu
    $( '.list-departments li').each( function(){
        if ( $( '> ul', $( this )).length > 0 ) {
            $( this ).addClass( 'has-child' );
            $( this).find( '>a' ).append( '<span class="fa fa-angle-right"></span>' );
        }
    } );

    $( '.shop-by-departments .shop-by-button').on( 'click', function(){
        $( this).parent().toggleClass( 'active' );
    } );

    // Layout tabs widget
    jQuery( '.layout-tabs').each( function(){
        var tab = $( this );
        var headingLabel = $( '.widget-title', tab );
        var filter = $( '.nav-tabs-filter', tab );
        var subLi = $( '.subfilter-more', filter );
        var ajaxUrl = tab.data( 'ajax' );
        var instance = tab.data( 'instance' ) || {};
        instance.action = 'sshop_tabs_content_ajax';

        var number_item = tab.data( 'number' ) || 5;

        var slickArgs = {
            accessibility: false,
            slidesToShow: number_item,
            slidesToScroll: 1,
            autoplay: false,
            infinite: true,
            autoplaySpeed: 2000,
            prevArrow: $( '.slider-prev', tab ),
            nextArrow: $( '.slider-next', tab ),
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: number_item,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: number_item-1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        };

        var setup = function( ){
            // Reset all sub filters
            $( '.subfilter-more ul li', filter).each( function(){
                filter.append( $( this ) );
            });
            var headingWidth = 0;
            if ( headingLabel.length > 0 ){
                headingWidth = headingLabel.outerWidth();
            }
            var tabWidth = tab.innerWidth();

            var w = 0;
            var filterW = tabWidth - headingWidth - 20 - 65; // slick nav width
            var more_width = $( '.subfilter-more .a-more', tab).outerWidth();
            filterW = filterW - more_width;

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
                var contentLayout = $('.tabs-layout-contents', tab);
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

                    var $html = $( '<div>'+html+'</div>' );
                    $('.tabs-item-inside', $html ).addClass('animate');
                    if (  typeof delay === "undefined" ) {
                        delay = 500;
                    }
                    setTimeout(function () {
                        contentLayout.addClass('animate');
                        var $content = $( '.tabs-layout-contents', $html );
                        contentLayout.html( $content );
                        var t = 0;

                        spinner.animate({
                            opacity: 0,
                        }, t - 100, function () {
                            // Animation complete.
                            tab.removeClass('loading');
                            spinner.remove();
                        });

                        if ( $( '.tabs-content-items .tabs-item-inside', tab).length > 0 ) {
                            $('.tabs-content-items', tab ).slick( slickArgs );
                        }


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
