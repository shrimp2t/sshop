
jQuery( document).ready( function( $ ){

    $( document.body ).bind( 'wc_fragments_loaded', function(){
        var cart = $( '.widget_shopping_cart_content').eq( 0 );
        var counter = $( '.cart-number-items');
        var n = $( '.cart_list li').length;
        counter.html( n );
        if ( n > 0 ) {
            counter.addClass( 'show' );
        } else {
            counter.removeClass( 'show' );
        }


    } );

    //setInterval( function(){
     //   $( document.body ).trigger( 'wc_fragments_loaded' );
    //} , 2000);

    $( document.body ).trigger( 'wc_fragments_loaded' );


    $(document).on( 'added_to_wishlist removed_from_wishlist', function(){
        var counter = $('.wishlist-number');
        $.ajax({
            url: yith_wcwl_l10n.ajax_url,
            data: {
                action: 'yith_wcwl_update_wishlist_count'
            },
            dataType: 'json',
            success: function( res ){
                counter.html(res.data);
                if ( res.data > 0 ) {
                    counter.addClass( 'show' );
                } else {
                    counter.removeClass( 'show' );
                }
            },
            beforeSend: function(){
                counter.block();
            },
            complete: function(){
                counter.unblock();
            }
        });
    } );


} );