<?php
/**
 * @package Splendio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type()  ) : ?>
			<div class="entry-date">
				<?php splendio_posted_on(); ?>
			</div><!-- .entry-date -->
		<?php endif; ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<ul class="entry-meta fade">
	<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<li class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'splendio' ), __( '1 Comment', 'splendio' ), __( '% Comments', 'splendio' ) ); ?></li>
	<?php endif; ?>
	</ul><!-- .entry-meta -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'splendio' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'splendio' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<ul class="entry-meta fade">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search

			$category_list = get_the_category_list( __( ', ', 'splendio' ) );
			$tag_list = get_the_tag_list( '', ', ' );

			if ( ! splendio_categorized_blog() ) {
				if ( '' != $tag_list ) {
					$meta_text = __( '<li class="meta-info"><span class="author-link">Posted by <a href="%1$s" title="%2$s" rel="author">%3$s</a></span>.</li> <li class="tag-links">Tagged: %5$s</li>', 'splendio' );
				} else {
					$meta_text = __( '<li class="meta-info">Posted by <a href="%1$s" title="%2$s" rel="author">%3$s</a>.</li>', 'splendio' );
				}
			} else {
				if ( '' != $tag_list ) {
					$meta_text = __( '<li class="cat-links">Posted by <span class="author-link"><a href="%1$s" title="%2$s" rel="author">%3$s</a></span> in %4$s</li> <li class="tag-links">Tagged: %5$s</li>', 'splendio' );
				} else {
					$meta_text = __( '<li class="cat-links">Posted by <span class="author-link"><a href="%1$s" title="%2$s" rel="author">%3$s</a></span> in %4$s</li>', 'splendio' );
				}
			}
			printf(
				$meta_text,
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'splendio' ), get_the_author_meta( 'display_name' ) ) ),
				esc_attr( get_the_author_meta( 'display_name' ) ),
				$category_list,
				$tag_list
			);

		endif; // End if 'post' == get_post_type() ?>




		<?php edit_post_link( __( 'Edit', 'splendio' ), '<li class="edit-link">', '</li>' ); ?>
	</ul><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description, show a bio on their entries  ?>
	<div id="entry-author-info">
		<div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 60 ); ?>
		</div><!-- #author-avatar -->
		<div id="author-description">
			<h2><?php printf( esc_attr__( 'About %s', 'splendio' ), get_the_author() ); ?></h2>
			<?php the_author_meta( 'description' ); ?>
			<div id="author-link">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'splendio' ), get_the_author() ); ?>
				</a>
			</div><!-- #author-link	-->
		</div><!-- #author-description -->
	</div><!-- #entry-author-info -->
<?php endif; ?>