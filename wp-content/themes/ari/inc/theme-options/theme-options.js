var firstFarbtastic; // First Link Color
var secondFarbtastic; // Second Link color
var textFarbtastic; // Text Color

(function($){
	var firstPickColor = function(a) {
		firstFarbtastic.setColor(a);
		$('#first-link-color').val(a);
		$('#first-link-color-example').css('background-color', a);
	};

	var secondPickColor = function(a) {
		secondFarbtastic.setColor(a);
		$('#second-link-color').val(a);
		$('#second-link-color-example').css('background-color', a);
	};

	var textPickColor = function(a) {
		textFarbtastic.setColor(a);
		$('#text-color').val(a);
		$('#text-color-example').css('background-color', a);
	};

	$(document).ready( function() {
		$('#default-first-link-color').wrapInner('<a href="#" />');
		$('#default-second-link-color').wrapInner('<a href="#" />');
		$('#default-text-color').wrapInner('<a href="#" />');

		firstFarbtastic = $.farbtastic('#firstLinkColorPickerDiv', firstPickColor);
		secondFarbtastic = $.farbtastic('#secondLinkColorPickerDiv', secondPickColor);
		textFarbtastic = $.farbtastic('#textColorPickerDiv', textPickColor);

		firstPickColor( $('#first-link-color').val() );
		secondPickColor( $('#second-link-color').val() );
		textPickColor( $('#text-color').val() );

		$('.firstpickcolor').click( function(e) {
			$('#firstLinkColorPickerDiv').show();
			e.preventDefault();
		});

		$('.secondpickcolor').click( function(e) {
			$('#secondLinkColorPickerDiv').show();
			e.preventDefault();
		});

		$('.textpickcolor').click( function(e) {
			$('#textColorPickerDiv').show();
			e.preventDefault();
		});

		$('#first-link-color').keyup( function() {
			var a = $('#first-link-color').val(),
				b = a;

			a = a.replace(/[^a-fA-F0-9]/, '');
			if ( '#' + a !== b )
				$('#first-link-color').val(a);
			if ( a.length === 3 || a.length === 6 )
				firstPickColor( '#' + a );
		});

		$('#second-link-color').keyup( function() {
			var a = $('#second-link-color').val(),
				b = a;

			a = a.replace(/[^a-fA-F0-9]/, '');
			if ( '#' + a !== b )
				$('#second-link-color').val(a);
			if ( a.length === 3 || a.length === 6 )
				secondPickColor( '#' + a );
		});

		$('#text-color').keyup( function() {
			var a = $('#text-color').val(),
				b = a;

			a = a.replace(/[^a-fA-F0-9]/, '');
			if ( '#' + a !== b )
				$('#text-color').val(a);
			if ( a.length === 3 || a.length === 6 )
				textPickColor( '#' + a );
		});

		$(document).mousedown( function() {
			$('#firstLinkColorPickerDiv').hide();
		});

		$(document).mousedown( function() {
			$('#secondLinkColorPickerDiv').hide();
		});

		$(document).mousedown( function() {
			$('#textColorPickerDiv').hide();
		});

		$('#default-first-link-color a').click( function(e) {
			firstPickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
			e.preventDefault();
		});

		$('#default-second-link-color a').click( function(e) {
			secondPickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
			e.preventDefault();
		});

		$('#default-text-color a').click( function(e) {
			textPickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
			e.preventDefault();
		});

		$('.image-radio-option.color-scheme input:radio').change( function() {
			var currentFirstLinkColorDefault = $('#default-first-link-color a'),
				newFirstLinkColorDefault = $(this).closest('label').find('.default-first-link-color').val();

			var currentSecondLinkColorDefault = $('#default-second-link-color a'),
				newSecondLinkColorDefault = $(this).closest('label').find('.default-second-link-color').val();

			var currentTextColorDefault = $('#default-text-color a'),
				newTextColorDefault = $(this).closest('label').find('.default-text-color').val();

			if ( $('#first-link-color').val() == currentFirstLinkColorDefault.text() )
				firstPickColor( newFirstLinkColorDefault );

			if ( $('#second-link-color').val() == currentSecondLinkColorDefault.text() )
				secondPickColor( newSecondLinkColorDefault );

			if ( $('#text-color').val() == currentTextColorDefault.text() )
				textPickColor( newTextColorDefault );

			currentFirstLinkColorDefault.text( newFirstLinkColorDefault );

			currentSecondLinkColorDefault.text( newSecondLinkColorDefault );

			currentTextColorDefault.text( newTextColorDefault );

		});
	});
})(jQuery);