<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @param array $attributes Encoded attributes
 * @param $shortcode_tag 'button', 'section', etc.
 * @param $post_id
 * @return array|WP_Error
 * @since 1.3.0
 */
function slz_ext_shortcodes_decode_attr(array $attributes, $shortcode_tag, $post_id) {
	/**
	 * @var SLZ_Extension_Shortcodes $shortcodes_ext
	 */
	$shortcodes_ext = slz_ext('shortcodes');

	foreach ($shortcodes_ext->get_attr_coder() as $coder) {
		if ($coder->can_decode($attributes, $shortcode_tag, $post_id)) {
			return $coder->decode($attributes, $shortcode_tag, $post_id);
		}
	}

	return $attributes;
}

/**
 * Parse string, extract shortcodes and enqueue their static files
 * @param string $content 'Hello [shortcode1 attr1="..."] World'
 * @since 1.3.17
 */
function slz_ext_shortcodes_enqueue_shortcodes_static($content) {
	/**
	 * @var SLZ_Extension_Shortcodes $shortcodes_ext
	 */
	$shortcodes_ext = slz_ext('shortcodes');

	$shortcodes_ext->enqueue_shortcodes_static($content);
}

/**
 * Enqueue admin scripts for each shortcode
 * @since 1.3.18
 */
function slz_ext_shortcodes_enqueue_shortcodes_admin_scripts() {
	static $has_run = false;

	if ($has_run) {
		return;
	}

	$has_run = true;

	/**
	 * @var SLZ_Extension_Shortcodes $shortcodes_ext
	 */
	$shortcodes_ext = slz_ext('shortcodes');

	foreach ($shortcodes_ext->get_shortcodes() as $shortcode) {
		slz()->backend->enqueue_options_static($shortcode->get_options());
	}

	do_action('slz:ext:shortcodes:enqueue-shortcodes-admin-scripts');
}
