<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (! is_admin()) {
	wp_enqueue_script(
		'slz-extension-shortcodes-load-shortcodes-ajax',
		slz_ext('shortcodes')->get_uri('/static/js/shortcode-ajax.js'),
		array(),
		slz_ext('shortcodes')->manifest->get('version'),
		true
	);

	wp_localize_script(
		'slz-extension-shortcodes-load-shortcodes-ajax',
		'slzAjaxUrl',
		admin_url( 'admin-ajax.php', 'relative' )
	);

}

if (is_admin()) {
	wp_register_script(
		'slz-extension-shortcodes-editor-integration',
		slz_ext('shortcodes')->get_uri('/static/js/aggressive-coder.js'),
		array('slz'),
		slz_ext('shortcodes')->manifest->get('version'),
		true
	);

	wp_enqueue_script(
		'slz-extension-shortcodes-load-shortcodes-data',
		slz_ext('shortcodes')->get_uri('/static/js/load-shortcodes-data.js'),
		array('slz'),
		slz_ext('shortcodes')->manifest->get('version'),
		true
	);
}

