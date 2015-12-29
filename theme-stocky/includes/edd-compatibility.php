<?php
// Easy Digital Downloads specific settings / functions
if( function_exists('edd_get_settings') ) {

	// remove EDD styles
//	remove_action('wp_enqueue_scripts', 'edd_register_styles');

	// remove the automatic purchase link EDD pre 1.1
	remove_filter('the_content', 'edd_append_purchase_link');
	// remove the automatic purchase link EDD >= 1.1
	remove_filter('edd_after_download_content', 'edd_append_purchase_link');

}
