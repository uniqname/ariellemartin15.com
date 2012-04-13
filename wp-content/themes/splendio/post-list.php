<?php
/**
 * @package Splendio
 */
?>

<div id="other-news">
	<span class="other-news-title"><strong><?php _e( 'In other news', 'splendio' ); ?></strong></span>
	<ul class="fade">
	<?php
		// Display 10 latest posts, excluding the most recent one.
		global $post;
		$args = array(
			'numberposts' => 10,
			'offset' => 1,
			'post__not_in' => get_option( 'sticky_posts' ),
		);
		$other_news = get_posts( $args );

		foreach( $other_news as $post ) : setup_postdata( $post );
		?>
			<li>
				<span class="post-date"><?php splendio_posted_on(); ?></span>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'splendio' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
				<span class="post-comments"><?php comments_popup_link( __( 'Leave a comment', 'splendio' ), __( '1 Comment', 'splendio' ), __( '% Comments', 'splendio' ) ); ?></span>
				<?php endif; ?>
			</li>
    <?php endforeach; ?>
   </ul>
</div><!-- #other-news -->