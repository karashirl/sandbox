<?php
/* Plugin Name: My first plugin
* Description: My first plugin
* Version 0.0.1
* Author: Kara Anderson
* Tested with: 4.3.1
*/

define('MFP_SLUG', 'my_first_plugin');

add_shortcode(MFP_SLUG, 'shortcode_my_first_plugin');
function shortcode_my_first_plugin($atts, $content = null) {
	$settings = shortcode_atts( array(
		'color' => '#000',
		'donkies' => 0
	), $atts );
	ob_start();
		include(plugin_dir_path( __FILE__ ) . 'templates/my-first-template.php' );
	return ob_get_clean();
}

add_action('wp_enqueue_scripts', 'setup_' . MFP_SLUG);
function setup_my_first_plugin() {
	wp_register_style(MFP_SLUG, plugin_dir_url(__FILE__) . MFP_SLUG . '.css', array('divi-child') );
	wp_enqueue_style(MFP_SLUG);

	wp_register_script(MFP_SLUG, plugin_dir_url(__FILE__) . MFP_SLUG . '.js', array('jquery', 'underscore', 'backbone'), '0.0.1' , true );
	wp_enqueue_script(MFP_SLUG);
}

add_shortcode('city_slider', 'shortcode_city_slider');
function shortcode_city_slider() {
	ob_start();
		include(plugin_dir_path( __FILE__ ) . 'templates/city_slider.php' );
	return ob_get_clean();
}


?>