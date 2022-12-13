<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (is_admin()) {

	wp_enqueue_script(
		'slz-ext-custom-sidebar-load-widget-page',
		slz_ext('custom-sidebar')->get_uri('/static/js/load-widgets-page.js'),
		array('slz'),
		slz_ext('custom-sidebar')->manifest->get('version'),
		true
	);

	wp_enqueue_style(
		'slz-ext-custom-sidebar-widget-page',
		slz_ext('custom-sidebar')->get_uri('/static/css/widgets-page.css'),
		array(),
		slz_ext('custom-sidebar')->manifest->get_version()
	);
}
