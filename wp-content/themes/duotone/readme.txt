===Duotone===

==Description==

A brilliant photoblogging theme with a dynamic background color based on the colors in your photos. Includes three widget areas, custom menu support, and EXIF display for photos. Duotone is a much-improved successor to Monotone.

==Changelog==

= 2.1 =
* Add languages directory.
* Add pot.

= 2.0 =
* Fix notices that display on activation.
* Add post_class() to appropriate elements.
* Replace image_orientation() with body_class(). Hook custom code into 'body_class' after reworking logic.
* Use appropriate functions instead of get_bloginfo().
* Add a textdomain to getText functions.
* Angled quotes replaced with arrows.
* Add required css classes.
* Remove partial() and replace all calls with get_template_part().
* Remove WP.org callback for the 'duotone_image_html' filter.
* Remove the thumb.php resize script.
* Menus should not overflow into site title and tagline.
* Conditionally set $content_width in functions.php
* Add "duotone_" prefix to all custom functions.
* Disabled $_GETreset? feature.
* Changed name of CSS_Color class to Duotone_CSS_Color.
* Removed unused duotone_save_postdata() function.
* Removed Theme Options page. Using core back functionality instead. Fixes #1027.
* Removed custom query from duotone_page_menu().
* Fixed notices with exif data.
* Added page-level docBlocks to all php files.
* Move the sidebar from the footer.php to sidebar.php.
* Conditionally display comments_popup_link() in post.php.
* Move all javascript into a single, stand-alone file.
* Fixed array merge issue with Duotone::get_image_info().
* Reworked style.css to reflect default color values.
* Custom styles will no longer be printed to wp_head when no image data is saved.
* Do not link-to-self in singular templates.
* Fixed the left-margin bug in h2s in the post_content.
* Remove public comment notice when posts are password-protected.
* Display 27 posts-per-page for archive and search results.
* Only set $themecolors on WP.com.
* Remove line 828 of inc/duotone.php.
* Fixed a few bugs with Duotone::get_the_image_id().
* Fixed a few bugs with Duotone::get_the_image_url_for_display().
* Escape all output of dump_image_data()