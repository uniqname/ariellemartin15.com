		<div id="side_one" class="side">
			<ul>
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bottom-bar' ) ) : // BEGIN  SECONDARY SIDEBAR WIDGETS ?>
			<h3><?php _e( 'About', 'fadtastic' ); ?></h3>
			<p><?php bloginfo( 'description' ); ?></p>

			<h3><?php _e( 'RSS', 'fadtastic' ); ?></h3>
			<ul>
				<li><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_rss.gif" alt="RSS Feed for <?php bloginfo( 'name' ); ?>" class="vertical_align" border="0"> <a href="<?php bloginfo( 'url' ); ?>/?feed=rss2"><?php _e( 'Complete Feed', 'fadtastic' ); ?></a></li>
				<li><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_rss.gif" alt="RSS Feed for <?php bloginfo( 'name' ); ?> comments" class="vertical_align" border="0"> <a href="<?php bloginfo( 'url' ); ?>/?feed=comments-rss2"><?php _e( 'Comments', 'fadtastic' ); ?></a></li>
			</ul>

			<h3><?php _e( 'Subscribe Via RSS', 'fadtastic' ); ?></h3>
			<ul>
				<li><a href="http://www.bloglines.com/sub/<?php bloginfo( 'rss2_url' ); ?>" target="subscriptions"><img src="http://www.bloglines.com/images/sub_modern1.gif" alt="Subscribe with Bloglines" width="94" height="20" /></a></li>
				<li><a href="http://www.newsburst.com/Source/?add=<?php bloginfo( 'rss2_url' ); ?>" target="subscriptions"><img src="http://i.i.com.com/cnwk.1d/i/newsbursts/btn/newsburst3.gif" alt="Add your feed to Newsburst from CNET News.com" width="96" height="20" /></a></li>
				<li><a href="http://www.google.com/reader/preview/*/feed/<?php bloginfo( 'rss2_url' ); ?>" title="Subscribe in Google Reader"><img src="<?php bloginfo( 'template_directory' ); ?>/images/subscribe/googleread2.jpg" alt="Subscribe in Google Reader" width="91" height="17" /></a></li>
				<li><a href="http://add.my.yahoo.com/rss?url=<?php bloginfo( 'rss2_url' ); ?>" title="Add to My Yahoo!" target="subscriptions"><img src="http://us.i1.yimg.com/us.yimg.com/i/us/my/addtomyyahoo4.gif" alt="Add to My Yahoo!" /></a></li>
				<li><a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=<?php bloginfo( 'rss2_url' ); ?>" title="Subscribe in NewsGator Online" target="subscriptions"><img src="http://www.newsgator.com/images/ngsub1.gif" alt="Subscribe in NewsGator Online" width="91" /></a></li>
				<li><a href="http://feeds.my.aol.com/add.jsp?url=<?php bloginfo( 'rss2_url' ); ?>" title="Subscribe in your AOL" target="subscriptions"><img src="<?php bloginfo( 'template_directory' ); ?>/images/subscribe/addtomyaol.gif" alt="<?php esc_attr_e( 'The latest comments to all posts in RSS' ); ?>" /></a></li>
			</ul>

			<h3><?php _e( 'Meta', 'fadtastic' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<?php wp_meta(); ?>
				</ul>
		<?php endif; // END SECONDARY SIDEBAR WIDGETS  ?>
			</ul>
		</div>

		<div id="side_two" class="side">
			<ul>
		<?php if (!function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'main-sidebar' ) ) : // BEGIN PRIMARY SIDEBAR WIDGETS ?>
			<h3><?php _e( 'Topics', 'fadtastic' ); ?></h3>
			<ul>
				<?php wp_list_cats( 'sort_column=name&optioncount=0' ); ?>
			</ul>

			<h3><?php _e( 'Archives', 'fadtastic' ); ?></h3>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>
		<?php endif; // END PRIMARY SIDEBAR WIDGETS  ?>
			</ul>
		</div>

		<div class="clear"></div>
