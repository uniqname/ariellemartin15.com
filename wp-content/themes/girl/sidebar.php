<div class="rightimage"></div>
<div class="right">

<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>

<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" size="23" />
<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'search', 'girl' ); ?>" />
</form>
<br />


<div class="sideheading"><?php _e('about','girl'); ?></div>
<p style="padding-left: 10px; padding-right: 10px;"><?php bloginfo('description'); ?></p>

<div class="sideheading"><?php _e('pages','girl'); ?></div>
<ul><?php wp_list_pages('title_li= '); ?></ul>


<div class="sideheading"><?php _e('categories','girl'); ?></div>
<ul><?php wp_list_cats(); ?></ul>


<div class="sideheading"><?php _e('archive','girl'); ?></div>
<ul><?php wp_get_archives('type=monthly'); ?></ul>



 <?php
 $link_cats = get_categories("type=link&orderby=name&order=ASC&hierarchical=0");
 foreach ($link_cats as $link_cat) {
 ?>
  <div id="linkcat-<?php echo $link_cat->cat_ID; ?>" class="sideheading"><?php echo $link_cat->cat_name; ?></div>
   <ul>
    <?php wp_get_links($link_cat->cat_ID); ?>
   </ul>

 <?php } ?>

<?php endif; ?>

</ul>

<div class="sideheading"><?php _e('et cetera','girl'); ?></div>
<ul id="credit">
	<li><?php printf( __( 'Theme: %1$s by %2$s.', 'girl' ), '<a href="http://theme.wordpress.com/themes/girl/">Girl in Green</a>', '<a href="http://www.chasethestars.com" rel="designer">Stacey Leung</a>' ); ?></li>
	<li><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a></li>
</ul>
</div>
