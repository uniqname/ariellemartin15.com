<?php
/**
 * @package Splendio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() && ! is_sticky() ) : ?>
			<div class="entry-date">
				<?php splendio_posted_on(); ?>
			</div><!-- .entry-date -->
		<?php endif; ?>
		<?php if ( is_home() || is_archive() || is_search() || is_page_template( 'showcase.php' ) ) : ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'splendio' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php else: ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ! is_singular() ) : ?><div class="entry-thumbnail"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'splendio' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large' ); ?></a></div><?php endif; ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'splendio' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'splendio' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<ul class="entry-meta fade">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'splendio' ) );
				if ( $categories_list && splendio_categorized_blog() ) :
			?>
			<li class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'splendio' ), $categories_list ); ?>
			</li>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'splendio' ) );
				if ( $tags_list ) :
			?>
			<li class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'splendio' ), $tags_list ); ?>
			</li>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<li class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'splendio' ), __( '1 Comment', 'splendio' ), __( '% Comments', 'splendio' ) ); ?></li>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'splendio' ), '<li class="edit-link">', '</li>' ); ?>
	</ul><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->