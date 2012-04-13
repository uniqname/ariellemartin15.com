var farbtastic; // Link Color
var accentFarbtastic; // Accent Color

(function($){
	var pickColor = function(a) { // Link Color
		farbtastic.setColor(a);
		$('#primary-color').val(a);
		$('#link-color-example').css('background-color', a);
	};
	var accentpickColor = function(a) { // Accent Color
		accentFarbtastic.setColor(a);
		$('#accent-primary-color').val(a);
		$('#accent-link-color-example').css('background-color', a);
	};

	$(document).ready( function() {
		$('#default-color').wrapInner('<a href="#" />'); // Link Color
		$('#accent-default-color').wrapInner('<a href="#" />'); // Accent Color

		farbtastic = $.farbtastic('#colorPickerDiv', pickColor ); // Link Color
		accentFarbtastic = $.farbtastic('#accent-colorPickerDiv', accentpickColor ); // Accent Color

		pickColor( $('#primary-color').val() ); // Link Color
		accentpickColor( $('#accent-primary-color').val() ); // Accent Color

		$('.pickcolor').click( function(e) { // Link Color
			$('#colorPickerDiv').show();
			e.preventDefault();
		});
		$('.accent-pickcolor').click( function(e) { // Accent Color
			$('#accent-colorPickerDiv').show();
			e.preventDefault();
		});

		$('#primary-color').keyup( function() { // Link Color
			var a = $('#primary-color').val(),
				b = a;

			a = a.replace(/[^a-fA-F0-9]/, '');
			if ( '#' + a !== b )
				$('#primary-color').val(a);
			if ( a.length === 3 || a.length === 6 )
				pickColor( '#' + a );
		});
		$('#accent-primary-color').keyup( function() { // Accent Color
			var a = $('#accent-primary-color').val(),
				b = a;

			a = a.replace(/[^a-fA-F0-9]/, '');
			if ( '#' + a !== b )
				$('#accent-primary-color').val(a);
			if ( a.length === 3 || a.length === 6 )
				accentpickColor( '#' + a );
		});

		$(document).mousedown( function() { // Link Color
			$('#colorPickerDiv').hide();
		});
		$(document).mousedown( function() { // Accent Color
			$('#accent-colorPickerDiv').hide();
		});

		$('#default-color a').click( function(e) { // Link Color
			pickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
			e.preventDefault();
		});
		$('#accent-default-color a').click( function(e) { // Accent Color
			accentpickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
			e.preventDefault();
		});

		 /*
		  * Toggle value state for slider option on Triton Lite theme options page
		  */
		$('#triton-lite-slider-option-input').change(function() {
		 	var $input = $(this);

			if ( $input.prop( 'checked' ) )
				$input.val( 'yes' );
			else
				$input.val( 'no' );
		});
	});
})(jQuery);