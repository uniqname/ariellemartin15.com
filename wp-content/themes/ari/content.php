<?php
/**
 * @package Ari
 * @since Ari 1.1.2
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear-fix' ); ?>>
	<?php if ( is_sticky() ) : ?>
		<span class="sticky-label"><?php _e( 'Featured', 'ari' ); ?></span>
	<?php endif; ?>

	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'ari' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'ari' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'ari' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<span class="posted-on">
				<?php ari_posted_on(); ?>
			</span>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'ari' ) );
				if ( $categories_list && ari_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Categories: %1$s', 'ari' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'ari' ) );
				if ( $tags_list ) :
			?>
			<span class="sep"> | </span>
			<span class="tag-links">
				<?php printf( __( 'Tags: %1$s', 'ari' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'ari' ), __( '1 Comment', 'ari' ), __( '% Comments', 'ari' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit &rarr;', 'ari' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>

		<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
		<div id="author-info" class="clear-fix">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'ari_author_bio_avatar_size', 50 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php echo esc_html( sprintf( __( 'About %s', 'ari' ), get_the_author() ) ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'ari' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
		<?php endif; ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
