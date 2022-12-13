<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (is_admin()) {
	// farbtastic color
	wp_enqueue_script('farbtastic');
	wp_enqueue_style('farbtastic');
	
	//css
	wp_enqueue_style(
			'slz-extension-widgets-admin-styles',
			slz_ext('widgets')->get_uri('/static/css/admin-styles.css')
	);
	//js
	wp_enqueue_script(
			'slz-extension-widgets-admin-scripts',
			slz_ext('widgets')->get_uri( '/static/js/admin-scripts.js' ),
			array( 'jquery', 'farbtastic' ),
			slz_ext('widgets')->manifest->get_version(),
			false
	);
	wp_enqueue_script(
			'slz-extension-widgets-newsletter-scripts',
			slz_ext('widgets')->get_uri( '/static/js/slz-newsletter.js' ),
			array( 'jquery', 'farbtastic' ),
			slz_ext('widgets')->manifest->get_version(),
			false
	);

	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');

	wp_enqueue_script(
			'slz-extension-widgets-upload-media',
			slz_ext('widgets')->get_uri( '/static/js/media-upload.js' ),
			array( 'jquery' ),
			slz_ext('widgets')->manifest->get_version(),
			false
	);
	
	wp_enqueue_script(
			'slz-extension-widgets-upload-image',
			slz_ext('widgets')->get_uri( '/static/js/slz-upload-image.js' ),
			array( 'jquery' ),
			slz_ext('widgets')->manifest->get_version(),
			false
	);
	
	wp_enqueue_script(
			'slz-extension-widgets-upload-attachment',
			slz_ext('widgets')->get_uri( '/static/js/slz-upload-attachment.js' ),
			array( 'jquery' ),
			slz_ext('widgets')->manifest->get_version(),
			false
	);	
}