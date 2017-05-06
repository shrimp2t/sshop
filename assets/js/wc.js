
jQuery( document).ready( function( $ ){

    $( document.body ).bind( 'wc_fragments_loaded', function(){
        console.log( 'loadeddd' );
        var cart = $( '.widget_shopping_cart_content').eq( 0 );
        var n = $( '.cart_list li').length;
        $( '.cart-number-items').html( n );
    } );

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
                counter.html( res.data );
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
