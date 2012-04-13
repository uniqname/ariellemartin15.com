jQuery( document ).ready( function( $ ) {
    if ( !$.browser.msie )
        $( "#wrapper ul.fade li" ).hover( function() {
        	$( this ).siblings().stop().fadeTo( 400,0.4 );
        },
    function() {
        $( this ).siblings().stop().fadeTo( 400,1 );
    });
        $( "#secondary ul li" ).hover( function() {
        	$( this ).siblings().stop().fadeTo( 400,0.4 );
        },
    function() {
        $( this ).siblings().stop().fadeTo( 400,1 );
    });
        $( ".menu-header ul li" ).hover( function() {
        	$( this ).siblings().stop().fadeTo( 400,0.8 );
        },
    function() {
        $( this ).siblings().stop().fadeTo( 400,1 );
    });
});