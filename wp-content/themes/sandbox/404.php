<?php get_header() ?>

	<section id="">
			<div id="post-0" class="post error404 not-found">
				<h2 class="entry-title"><?php _e( 'Not Found', 'sandbox' ) ?></h2>
				<div class="entry-content">
					<p><?php _e( 'Oh snap! You broke the interwebz!', 'sandbox' ) ?></p>
					<p><?php _e( 'Naw, It\' my bad, I couldn\'t find what you wanted.', 'sandbox' ) ?></p>
					<p><?php _e( 'Maybe try searchin\' with my fatty search box.', 'sandbox' ) ?></p>
				</div>
				<form id="searchform-404" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="s-404" name="s" class="text" type="text" placeholder="My! What a big search box you have." value="<?php the_search_query() ?>" size="40" />
						<input class="button" type="submit" value="<?php _e( 'Find', 'sandbox' ) ?>" />
					</div>
				</form>
			</div><!-- .post -->

	</section><!-- # -->

<?php /* get_sidebar() */ ?>
<?php get_footer() ?>