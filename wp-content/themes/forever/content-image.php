<?php
/**
 * The template for displaying posts in the Image Post Format on index and archive pages
 *
 * @package Forever
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( '' != get_the_post_thumbnail() ) {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), full );
	?>
	<div class="entry-image">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'forever' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<img class="featured-image" src="<?php echo $thumbnail[0]; ?>" alt="">
		</a>
	</div>
	<?php } else {
		$first_image = null;

		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		$first_image = $matches[1][0];

		if ( ! empty( $first_image ) ) {
	?>
	<figure class="entry-image">
		<a href="<?php the_permalink(); ?>"><img class="featured-image" src="<?php echo esc_url( $first_image ); ?>" alt="<?php echo esc_attr( $first_attachment->post_title ); ?>" /></a>
	</figure>
	<?php
			} // ! empty( $first_image )
		} // '' != get_the_post_thumbnail()
	?>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'forever' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php forever_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<p class="comments-link"><?php comments_popup_link( '<span class="no-reply">' . __( '0', 'forever' ) . '</span>', __( '1', 'forever' ), __( '%', 'forever' ) ); ?></p>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'forever' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-summary -->

	<?php
		// translators: used between list items, there is a space after the comma
		$categories_list = get_the_category_list( __( ', ', 'forever' ) );

		// translators: used between list items, there is a space after the comma
		$tags_list = get_the_tag_list( '', __( ', ', 'forever' ) );

		// Check to see if there is a need for an article footer
		if (
			'post' == get_post_type() || $categories_list && forever_categorized_blog()
		) :
	?>
	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				if ( $categories_list && forever_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'forever' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'forever' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php edit_post_link( __( 'Edit', 'forever' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
