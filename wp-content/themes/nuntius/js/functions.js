jQuery( document ).ready( function( $ ) {
	/**
	 * Nuntius sidebar tabbed widget
	 * Reveal the container with CSS (was hidden in CSS to prevent FOUC)
	 */
	$( '.tabbed-content' ).show();
	$( '.tab-content' ).hide();
	$( 'ul.sidebar-tabs li:first' ).addClass( 'active' ).show();
	$( '.tab-content:first' ).show();

	$( 'ul.sidebar-tabs li' ).click(function() {
		// Find the href attribute value to identify the active tab + content
		var activeTab = $( this ).find( 'a' ).attr( 'href' );

		$( 'ul.sidebar-tabs li' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		$( '.tab-content' ).hide();
		$( activeTab ).fadeIn();

		return false;
	} );

	/**
	 * Nuntius home page template slideshow
	 *
	 * Only load slideshow if it's "active" (more than 1 sticky post exist)
	 * Reveal the container with CSS (was hidden in CSS to prevent FOUC)
	 */
	//if ( $( '#feature' ).hasClass( 'active-sticky' ) ) {
		$( '#feature' ).show();

		// Set slideshow opacity
		$( '.page-template-page-template-home-php .slideshow-caption-text p' ).css( 'opacity', 0.85 );

		// Slideshow cycle
		$( 'div.slideshow-items' ).cycle( {
				fx: 'scrollHorz',
				prev: 'a.slider-prev',
				next: 'a.slider-next',
				pager: '.slideshow-pager',
				timeout: 0,
				speed: 800
			}
		);
	//}
} );