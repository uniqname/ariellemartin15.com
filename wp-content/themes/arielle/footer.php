
	<footer>
	<h1>Sponsors</h1>
		<section class="primary sponsors clearfix">
			<figure class="">
				<a href="http://www.the-industries.com/"><img src="/wp-content/themes/sandbox/img/the.png" alt="the" /></a>
			</figure>
			<figure class="">
				<a href="http://www.intensebmx.com/"><img src="/wp-content/themes/sandbox/img/headtubbadge.png" alt="headtubbadge" /></a>
			</figure>
			<figure class="">
				<a href="http://www.sinz-racing.com/"><img src="/wp-content/themes/sandbox/img/Sinz.png" alt="Sinz" /></a>
			</figure>
			</section>
		<section class="sponsors clearfix">
			<figure class="">
				<a href="http://www.flyracing.com/"><img src="/wp-content/themes/sandbox/img/flyracing_logoOn.png" alt="flyracing_logoOn" /></a>
			</figure>
			<figure class="">
				<a href="http://www.leatt-brace.com/"><img src="/wp-content/themes/sandbox/img/Leatt.png" alt="Leatt" /></a>
			</figure>
			<figure class="">
				<a href="http://www.profileracing.com/"><img src="/wp-content/themes/sandbox/img/profile.png" alt="Profile Racing" /></a>
			</figure>
			<figure class="">
				<a href="http://www.oakley.com/sports/bmxracing"><img src="/wp-content/themes/sandbox/img/oakley.png" alt="oakley" /></a>
			</figure>
			<figure class="">
				<a href="http://www.sidiamerica.com/"><img src="/wp-content/themes/sandbox/img/SIDI.png" alt="SIDI" /></a>
			</figure>
			<figure class="">
				<a href="http://www.rennendesigngroup.com/"><img src="/wp-content/themes/sandbox/img/Rennen.png" alt="Rennen" /></a>
			</figure>
		</section>		
		<p><a href="http://www.room265.com">Conceived and sired by Room265</a></p>
	</footer>

</div><!-- #wrapper .hfeed -->

<?php wp_footer() ?>
<script>
		(function($){
			var $h1a_s = $('h1>a'),
					$h1_s = $('h1').not($h1a_s.parent()),
					$titles = $($h1a_s).add($h1_s);
			/* $titles.lettering(); */
			$('h1 span').each(function(){
				var sign = Math.round(Math.random()) ? '-' : '';
						deg = sign + (Math.random() *12);
			
				$(this).css({
					'-webkit-transform' : 'rotate(' + deg + 'deg)',
					'-moz-transform' : 'rotate(' + deg + 'deg)',
					'transform' : 'rotate(' + deg + 'deg)'
				});
			});
			
			/*
			* TODO: Make this a plugin
			*/
			$('.gallery').each(function (){
					var $current = $(this).find('li').first();
					if ($current.siblings().length){
						(function advance(){
							var $next = ($current.next().length) ? $current.next() : $current.parent().children().first(),
									$prev = ($current.prev().length) ? $current.prev() : $current.parent().children().last();
								
							$current.delay(5000).fadeOut(500, function(){
								$next.fadeIn(500, function(){
									$current = $next;
									advance();
								});
							
							});
						}());
					}
			});
		}(jQuery));
	</script>
</body>
</html>