<?php  get_header(); ?>
<?php get_sidebar(); ?>
<hr />
<div id="content">
<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php // Post dates off by default the_date('','<h2>','</h2>'); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h2>
		<?php if ( ! is_single() ) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'greenmarinee' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		<?php else : ?>
			<?php the_title(); ?>
		<?php endif; ?>
	</h2>
	<?php if ( ! is_page() ) : ?>
	<div class="meta">
		<?php _e('Posted in','greenmarinee'); ?> <?php the_category(',') ?> <?php _e('by','greenmarinee'); ?> <?php the_author() ?> <?php _e('on','greenmarinee'); ?> <?php the_time(get_option('date_format')) ?> <?php edit_post_link(__('Edit This','greenmarinee')); ?>
		<?php the_tags('<br />Tags: ', ', '); ?>
	</div>
	<?php endif; ?>
	<div class="main">
		<?php the_content(__('(more...)','greenmarinee')); ?>
	</div>
	</div>
	<div class="comments">
		<?php wp_link_pages(); ?>
		<?php if ( ! is_page() ) { comments_popup_link(__('Leave a Comment','greenmarinee'), __('<strong>1</strong> Comment','greenmarinee'), __('<strong>%</strong> Comments','greenmarinee')); } ?>
	</div>


<?php comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p><?php _e('Sorry, no posts matched your criteria, please try and search again.','greenmarinee'); ?></p>
</div>
<?php endif; ?>

<?php posts_nav_link(' &#8212; ',__('&laquo; Previous Page','greenmarinee'),__('Next Page &raquo;','greenmarinee')); ?>

	</div>
<!-- End float clearing -->
</div>
<!-- End content -->
<?php get_footer(); ?>
