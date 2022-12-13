<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$manifest = array(
	'name'          => esc_html__('Instagram', 'slz'),
	'version'       => '1.0.0',
	'display'       => true,
	'thumbnail'     => slz_get_framework_directory_uri( '/extensions/instagram/static/img/instagram.jpg'),
	'standalone'    => true,
	'description'   => esc_html__('Display your Instagram image or video as gallery.', 'slz'),
	// 'github_update' => 'ThemeFuse/Unyson-Shortcodes-Extension'
);
