jQuery( document ).ready( function( $ ) {

	/**
	 * Invoke Slider
	 */
    $( '.feature-slider a' ).click( function( e ) {
        $( '.featured-posts div.featured' ).css( {
            opacity: 0,
            visibility: 'hidden'
        } );
        $( this.hash ).css( {
            opacity: 1,
            visibility: 'visible'
        } );
        $( '.feature-slider a' ).removeClass( 'active' );
        $( this ).addClass( 'active' );
        e.preventDefault();
    } );

	/**
	 * jQuery Masonry is used in archive views.
	 * The plugin imagesLoaded.js is needed to make sure that Masonry is only
	 * triggered after all images have been loaded into the archive views.
	 */
	var $container = $( '.lay1' );
	
	$container.imagesLoaded( function() {
		$container.masonry( {
			itemSelector: '.lay1 > div'
		} );
	} );
	
	/**
	 * Remove the right margin on posts that are in the last column on archive pages.
	 * Also, remove the right margin on the last Middle Row widget.
	 * This JS is in place for browsers that don't support nth-child pseudo-selectors.
	 */
	$( '.lay1 > div:nth-child( 3n ), #midrow .widget:nth-child( 3n ), #footer .widget:nth-child( 4n )' ).css( { 'margin-right' : '0' } );
		
	/**
	 * Clear left on Middle Row and Footer widgets that are at the far left of their containers.
	 * This JS is in place for browsers that don't support nth-child pseudo-selectors.
	 */
	$( '#midrow .widget:nth-child( 3n+1 ), #footer .widget:nth-child( 4n+1 )' ).css( { 'clear' : 'left' } );
		
	/**
	 * Remove the bottom border from posts that are in the last row on archive pages.
	 */
	$( '.lay1 > div' ).slice( -3 ).css( { 'border' : 'none' } );
	
	/**
	 * Fade images in archive view
	 */
	$( '.lay1 > div .imgwrap' ).css( { 'opacity' : '0.7' } );

	/**
	 * Brighten images in archive view upon hover. Re-dim the images when the hover has ended.
	 */
	$( '.lay1 > div' ).hover(
		function() { $( this ).find( '.imgwrap' ).stop().animate( { 'opacity' : '1' }, 300 ); },
		function() { $( this ).find( '.imgwrap' ).stop().animate( { 'opacity' : '0.7' }, 300 ); }
	);

	/**
	 * Hide the post/page dates and comment counts so that they can slide back into view on post/page hovers.
	 */
	$( '.lay1 > div .date-meta' ).css( { 'right' : '-300px' } );
	$( '.lay1 > div .block-comm' ).css( { 'left' : '-200px' } );
	
	/**
	 * Slide post/page meta and comment counts back into view on hover.
	 * When the hover is done we'll hide the post/page dates and comment counts.
	 */
	$( '.lay1 > div' ).hover(
		function() {
			$( this ).find( '.date-meta' ).stop().animate( { 'right' : '0px' }, 300 );
			$( this ).find( '.block-comm' ).stop().animate( { 'left' : '0px' }, 300 );
		},
		function() {
			$( this ).find( '.date-meta' ).stop().animate( { 'right' : '-300px' }, 300 );
			$( this ).find( '.block-comm' ).stop().animate( { 'left' : '-200px' }, 300 );
		}
	);

} );