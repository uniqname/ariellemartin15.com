<?php
/**
 * Tabs Widget Class
 *
 * The Nuntius Tabs widget lists posts by date and comment count in a tabbed display
 *
 * @package WordPress
 * @subpackage Nuntius
 */

  /**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'nuntius_load_widgets' );

/**
 * Register our widget.
 */
function nuntius_load_widgets() {
	register_widget( 'Nuntius_Widget_Tabs' );
}

class Nuntius_Widget_Tabs extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.1.0
	 */
	function Nuntius_Widget_Tabs() {

		$widget_ops = array( 'classname' => 'widget-tabs', 'description' => __( 'Displays posts by date and comments in tab format.', 'nuntius' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => "nuntius-widget-tabs" );
		$this->WP_Widget( "nuntius-widget-tabs", __( 'Nuntius Tabbed Widget', 'nuntius' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$args = array();
		$posts_per_page = intval( $instance['posts_per_page'] );
		$recent_tab_title = $instance['recent_tab_title'];
		$comments_tab_title = $instance['comments_tab_title'];

		echo $before_widget;

		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title; ?>


		<div class="tabbed-content">

			<div class="tabbed-content-wrap">

				<ul class="sidebar-tabs">
					<li><a href="#<?php echo $this->id . '-1'; ?>"><?php echo esc_html( $recent_tab_title ); ?></a></li>
					<li><a href="#<?php echo $this->id . '-2'; ?>"><?php echo esc_html( $comments_tab_title ); ?></a></li>
				</ul><!-- .sidebar-tabs -->

				<div id="<?php echo $this->id . '-1'; ?>" class="tab-content">

					<?php $loop = new WP_Query( array( 'post_type' => $post_type, 'caller_get_posts' => true, 'posts_per_page' => $posts_per_page, 'orderby' => 'date', 'order' => 'DESC' ) ); ?>

					<?php if ( $loop->have_posts() ) : ?>

						<ul class="xoxo">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a>' ); ?>
							</li>
						<?php endwhile; ?>

						</ul>

					<?php endif; ?>

				</div><!-- .tab-content -->

				<div id="<?php echo $this->id . '-2'; ?>" class="tab-content">

					<?php $loop = new WP_Query( array( 'post_type' => $post_type, 'caller_get_posts' => true, 'posts_per_page' => $posts_per_page,  'orderby' => 'comment_count' ) ); ?>

					<?php if ( $loop->have_posts() ) : ?>

						<ul class="xoxo">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a>' ); ?>
							<span class="count view-count"><?php printf( __( '(%1$s)', 'nuntius' ), get_comments_number() ); ?></span>
							</li>
						<?php endwhile; wp_reset_query(); ?>

						</ul>

					<?php endif; ?>

				</div><!-- .tab-content -->

			</div><!-- .tabbed-content-wrap -->

		</div><!-- .tabbed-content --> <?php

		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['recent_tab_title'] = strip_tags( $new_instance['recent_tab_title'] );
		$instance['comments_tab_title'] = strip_tags( $new_instance['comments_tab_title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 * @since 0.1.0
	 */
	function form( $instance ) {

		//Defaults
		$defaults = array(
			'title' => __( 'Most', 'nuntius' ),
			'posts_per_page' => 3,
			'recent_tab_title' => __( 'Recent', 'nuntius' ),
			'comments_tab_title' => __( 'Commented', 'nuntius' )
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'nuntius' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'nuntius' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'recent_tab_title' ); ?>"><?php _e( 'Recent Posts Tab Title:', 'nuntius' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'recent_tab_title' ); ?>" name="<?php echo $this->get_field_name( 'recent_tab_title' ); ?>" value="<?php echo $instance['recent_tab_title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'comments_tab_title' ); ?>"><?php _e( 'Comments Tab Title:', 'nuntius' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'comments_tab_title' ); ?>" name="<?php echo $this->get_field_name( 'comments_tab_title' ); ?>" value="<?php echo $instance['comments_tab_title']; ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}