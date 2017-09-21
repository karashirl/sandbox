<?php
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
function child_theme_enqueue_styles() {
	$parent_style = 'divi-style';
	$child_style = 'divi-child';
	wp_register_style($parent_style, get_template_directory_uri() . '/style.css' );
	wp_register_style($child_style, get_stylesheet_directory_uri() . '/style.css', array($parent_style) );
	wp_enqueue_style($child_style);
}

add_action( 'wp_enqueue_scripts', 'child_theme_register_scripts' );
function child_theme_register_scripts() {
	wp_register_script( 'app', get_stylesheet_directory_uri() . '/js/app.js', array(), '1.0.0', true );
	wp_enqueue_script( 'app' );
}

function load_fonts() {
            wp_register_style('et-googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300');
            wp_enqueue_style( 'et-googleFonts');
        }
    add_action('wp_print_styles', 'load_fonts');
