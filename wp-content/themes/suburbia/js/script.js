(function($) {
	$(document).ready( function() {
        $('img').lazyload({
            effect : 'fadeIn'
        });
	});
	$(window).load( function() {
        var high = 0;
        var blocks = $('.bottom');
        blocks.each(function(){
            var height = $(this).height();
            if (high <= height) high = height;
        });
        blocks.each(function(){
            $(this).height(high);
        });
	});
})(jQuery);