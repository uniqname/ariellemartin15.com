<?php
/**
 * @package WordPress
 * @subpackage Bueno
 */
get_header();
?>

    <div id="content" class="col-full">
		<div id="main" class="col-left">

            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <h1 class="title"><?php the_title(); ?></h1>

                    <a class="date" href="<?php the_permalink(); ?>">
                    	<span class="day"><?php the_time('j'); ?></span>
                    	<span class="month"><?php the_time('M'); ?></span>
                    </a>

                    <div class="entry">
						<?php the_content( __( 'Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'woothemes' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<p class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</p>' ) ); ?>
						<?php the_tags( '<p>' . __( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>
						<?php edit_post_link( __( 'Edit This', 'woothemes' ), '<p>', '</p>' ); ?>
                    </div>

                    <div class="post-meta">

                    	<ul <?php if ( ! is_multi_author() ) echo 'class="single-author-meta"';?>>
							<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                    		<li class="comments">
                    			<span class="head"><?php _e('Comments', 'woothemes') ?></span>
                    			<span class="body"><?php comments_popup_link(__('Leave a Comment', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
                    		</li>
							<?php endif; ?>
                    		<li class="categories">
                    			<span class="head"><?php _e('Categories', 'woothemes') ?></span>
                    			<span class="body"><?php the_category(', ') ?></span>
                    		</li>
                    		<?php if ( is_multi_author() ) { ?>
	                    		<li class="author">
	                    			<span class="head"><?php _e('Author', 'woothemes') ?></span>
	                    			<span class="body"><?php the_author_posts_link(); ?></span>
	                    		</li>
                    		<?php } ?>
                    	</ul>

                    	<div class="fix"></div>

                    </div><!-- /.post-meta -->

					<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> %title' ) ); ?></div>
						<div class="nav-next"><?php next_post_link( '%link', __('%title <span class="meta-nav">&rarr;</span>') ); ?></div>
					</div><!-- #nav-below -->

                </div><!-- /.post -->

				<?php comments_template('', true); ?>

			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
  				</div><!-- /.post -->
           	<?php endif; ?>

		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>