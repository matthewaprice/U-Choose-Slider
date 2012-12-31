<?php
/*
Plugin Name: U Choose Slider
Plugin URI: http://matthewaprice.com
Description: This plugin allows you to store information for a slider in the database and then gives you a function to use on your template.  YOu can then use ANY js slider that you want.  It stores the following: title, description, link, url to image, and an active/inactive button to manage your slider images.
Version: 1.0
Author: Matthew Price
Author URI: http://matthewaprice.com
License: GPL2
*/

/**
 * Include the classes that register the settings pages and menu items
 */
$ucs_homepage_classes = array( 'UCS_Base', 'UCS_Slider' );
foreach ( $ucs_homepage_classes as $ucs_homepage_class ) :
	include( "classes/" . $ucs_homepage_class . ".php" );
endforeach;

/**
 * Create instance of UCS_Base to activate the settings pages and menu items
 */
$ucs_slider = new UCS_Base();

/**
 * Set up plugin table on registration
 */
register_activation_hook( __FILE__, array( 'UCS_Base', 'UCSPluginActivation' ) );

/**
 * This function is what you can use as a template tag to get access to the slider images for your theme
 */		
function get_ucs_slider_images() {
	return UCS_Slider::UCSGetSliderImages();
}
?>