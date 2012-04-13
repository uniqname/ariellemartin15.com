<?php
/*
Plugin Name: No Image Width or Height
Plugin URI: 
Description: Stops the media uploader from using a width/height on an image when inserting into a post.
Author: Ronald Huereca
Version: 0.1
Author URI: http://www.weblogtoolscollection.com
Generated At: www.wp-fun.co.uk;
*/ 

/*  Copyright 2008  Ronald Huereca  (email : ronalfy + wltc [at] gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('no_image_width_or_height')) {
    class no_image_width_or_height	{

		
		/**
		* PHP 4 Compatible Constructor
		*/
		function no_image_width_or_height(){$this->__construct();}
		
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){	




		}
		//Uses WordPress filter for image_downsize
		function image_downsize($value = false,$id = 0, $size = "medium") {
			if ( !wp_attachment_is_image($id) )
				return false;
			$img_url = wp_get_attachment_url($id);
			//Mimic functionality in image_downsize function in wp-includes/media.php
			if ( $intermediate = image_get_intermediate_size($id, $size) ) {
				$img_url = str_replace(basename($img_url), $intermediate['file'], $img_url);
			}
			elseif ( $size == 'thumbnail' ) {
				// fall back to the old thumbnail
				if ( $thumb_file = wp_get_attachment_thumb_file() && $info = getimagesize($thumb_file) ) {
					$img_url = str_replace(basename($img_url), basename($thumb_file), $img_url);
				}
			}
			if ( $img_url)
				return array($img_url, 0, 0);
			return false;
		}
		


    } //End class no_image_width_or_height
}

//instantiate the class
if (class_exists('no_image_width_or_height')) {
	$no_image_width_or_height = new no_image_width_or_height();
	add_filter('image_downsize', array($no_image_width_or_height, 'image_downsize'),1,3);
}
?>