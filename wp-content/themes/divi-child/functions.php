<?php
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
function child_theme_enqueue_styles() {
	$patent_style = 'divi-style';
	$child_style = 'divi-child';
	wp_register_style($patent_style, get_template_directory_uri() . '/style.css' );
	wp_register_style($child_style, get_stylesheet_directory_uri() . '/style.css', array($patent_style) );
	wp_enqueue_style($child_style);
}

add_action( 'wp_enqueue_scripts', 'child_theme_register_scripts' );
function child_theme_register_scripts() {
	wp_register_script( 'underscore', 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js', array('jquery'), '1.8.3', false );
	wp_register_script( 'backbone', 'https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.1/backbone-min.js', array('jquery', 'underscore'), '1.2.1', false );
	
	wp_enqueue_script( 'underscore' );
	wp_enqueue_script( 'backbone' );
}

