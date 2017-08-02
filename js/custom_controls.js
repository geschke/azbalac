

(function ($) {

   /********* Multi Input Custom control ***********/
	$( '.customize_multi_input' ).each(function() {
		var $this = $( this );
		var multi_saved_value = $this.find( '.customize_multi_value_field' ).val();
		if (multi_saved_value.length > 0) {
			var multi_saved_values = multi_saved_value.split( "|" );
			$this.find( '.customize_multi_fields' ).empty();
			$.each(multi_saved_values, function( index, value ) {
				$this.find( '.customize_multi_fields' ).append( '<div class="set"><input type="text" value="' + value + '" class="customize_multi_single_field" /><span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
			});
		}
	});

	function mytheme_customize_multi_add_field(e) {
		var $this = $( e.currentTarget );
		e.preventDefault();
		if ( ! $this.data( 'lockedAt' ) || + new Date() - $this.data( 'lockedAt' ) > 300 ) {
			var $control = $this.parents( '.customize_multi_input' );
			$control.find( '.customize_multi_fields' ).append( '<div class="set"><input type="text" value="" class="customize_multi_single_field" /><span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
			mytheme_customize_multi_write( $control );
		}
		$this.data( 'lockedAt', + new Date() );
	}

	function mytheme_customize_multi_single_field() {
		var $control = $( this ).parents( '.customize_multi_input' );
		mytheme_customize_multi_write( $control );
	}

	function mytheme_customize_multi_remove_field(e) {
		e.preventDefault();
		var $this = $( this );
		var $control = $this.parents( '.customize_multi_input' );
		$this.parent().remove();
		mytheme_customize_multi_write( $control );
	}

	function mytheme_customize_multi_write( $element) {
		var customize_multi_val = '';
		$element.find( '.customize_multi_fields .customize_multi_single_field' ).each(function() {
			customize_multi_val += $( this ).val() + '|';
		});
		$element.find( '.customize_multi_value_field' ).val( customize_multi_val.slice( 0, -1 ) ).change();
    }
    
   $( document ).on( 'click', '.customize_multi_add_field', mytheme_customize_multi_add_field )
	 	.on( 'change', '.customize_multi_single_field', mytheme_customize_multi_single_field )
		.on( 'click', '.customize_multi_remove_field', mytheme_customize_multi_remove_field );
        
        

})(jQuery);