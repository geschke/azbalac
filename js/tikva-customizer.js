

(function($){

    // Realtime view of site name
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
            $( '#site-header-text a' ).text( to );
		} );
	} );

	// Realtime view of description
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );  
    
})(jQuery);