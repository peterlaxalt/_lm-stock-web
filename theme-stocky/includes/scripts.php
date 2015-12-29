<?php

function dcs_load_scripts() {

	// load WP's included jQuery library
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-masonry');

	// global scripts
	wp_enqueue_script('jquery-fancybox', get_template_directory_uri() . '/includes/fancybox/jquery.fancybox.pack.js');
	wp_enqueue_script('jquery-stellar', get_template_directory_uri() . '/includes/js/jquery.stellar.js');
	wp_enqueue_script('jquery-mobilemenu', get_template_directory_uri() . '/includes/js/jquery.mobilemenu.js');
	wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/includes/js/jquery.fitvids.js');

	// sticky header
	if (of_get_option('sticky_header') == 'yes') {
		wp_enqueue_script('jquery-sticky', get_template_directory_uri() . '/includes/js/jquery.sticky.js');
	}

	// load singular (posts and pages) scripts
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' ); //enable nested comments
	}

	// global styles
	wp_enqueue_style('css-stocky', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('jquery-fancybox', get_template_directory_uri() . '/includes/fancybox/jquery.fancybox.css');
	wp_enqueue_style('font-Roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,400italic,700,700italic');
	wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

}
add_action('wp_enqueue_scripts', 'dcs_load_scripts');

// load in header
function dcs_add_header_css() {
	get_template_part('includes/cssoptions');
}
add_action('wp_head', 'dcs_add_header_css');

// load in header
function dcs_add_header_js() {
	get_template_part('includes/js/stockyjs');
}
add_action('wp_head', 'dcs_add_header_js');