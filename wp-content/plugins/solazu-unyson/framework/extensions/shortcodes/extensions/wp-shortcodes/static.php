<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (is_admin()) {
	$eds = slz_ext('wp-shortcodes');

	wp_enqueue_style( 'slz-ext-wp-shortcodes-css',
		$eds->locate_css_URI('styles'),
		array(),
		slz()->manifest->get_version()
	);

	wp_localize_script(
		'slz',
		'slz_ext_wp_shortcodes_localizations',
		array(
			'button_title' => __('Unyson Shortcodes', 'slz'),
			'default_shortcodes_list' => $eds->default_shortcodes_list(),
			'hide_button' => true,
		)
	);
}
