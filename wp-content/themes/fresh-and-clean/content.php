<?php
/**
 * @package Fresh & Clean
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>
	<?php if ( is_sticky() && is_front_page() ) : ?>
		<div class="sticky-header">
			<span class="sticky-label"><?php _e( 'Featured', 'fresh-and-clean' ); ?></span>
		</div>
	<?php endif; ?>
	<?php if ( ! is_singular() && has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permanent Link to %s', 'fresh-and-clean' ), the_title_attribute( 'echo=0' ) ) ); ?>">
				<?php the_post_thumbnail( 'fresh-and-clean-thumbnail', array( 'class' => 'post-thumbnail', 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
			</a>
		</div><!-- .entry-thumbnail -->
	<?php endif; ?>

	<header class="entry-header">
		<h2 class="entry-title">
			<?php if ( is_single() || is_page() ) : ?>
				<?php the_title(); ?>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'fresh-and-clean' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php endif; ?>
		</h2>
		<?php if ( 'post' == get_post_type() && is_single() ) : ?>
		<div class="entry-meta">
			<?php fresh_and_clean_post_meta(); ?>
			<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'fresh-and-clean' ), __( '1 Comment', 'fresh-and-clean' ), __( '% Comments', 'fresh-and-clean' ) ); ?></span>
			<?php endif; ?>
			<?php edit_post_link( __( '(Edit)', 'fresh-and-clean' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( ! is_singular() ) :
			if ( ! post_password_required() ) :
				the_excerpt();
			endif;
		 else :
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fresh-and-clean' ) );
		endif;
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'fresh-and-clean' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php if ( ! is_singular() || is_page() ) : ?>
		<footer class="entry-meta">

			<?php if ( '' == get_the_title() && ! is_page() ) :
				printf( __( '<span class="entry-date"><a href="%1$s" rel="bookmark" title="%3$s">%2$s</a> // </span>', 'fresh-and-clean' ),
					get_permalink(),
					get_the_date(),
					esc_attr( get_the_time() )
				);
			endif;

			if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'fresh-and-clean' ), __( '1 Comment', 'fresh-and-clean' ), __( '% Comments', 'fresh-and-clean' ) ); ?></span>
			<?php endif; ?>
			<?php edit_post_link( __( '(Edit)', 'fresh-and-clean' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
	// If comments are open or we have at least one comment, load up the comment template
	if ( is_single() || is_page() ) :
		if ( comments_open() || '0' != get_comments_number() )
			comments_template( '', true );
	endif;
?>