<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('audio');
$ext_instance = slz()->extensions->get( 'shortcodes' );

if ( !is_admin() ) {
    wp_styles()->dequeue('slz-extension-'. $ext_instance->get_name() .'-mep-libs');
	wp_enqueue_style(
		'slz-extension-'. $ext_instance->get_name() .'-mep-libs',
		$ext->locate_URI( '/static/libs/mejs/mep-feature-playlist.css' ),
		array(),
		slz_ext('shortcodes')->manifest->get('version')
	);

	wp_dequeue_script('slz-extension-'. $ext_instance->get_name() .'-mep-libs');
	wp_enqueue_script(
		'slz-extension-'. $ext_instance->get_name() .'-mep-libs',
		$ext->locate_URI( '/static/libs/mejs/mep-feature-playlist.js' ),
		array( 'jquery' ),
		slz()->manifest->get_version(),
		true
	);

    wp_dequeue_script('slz-extension-'. $ext_instance->get_name() .'-audio');
    wp_enqueue_script(
		'slz-extension-'. $ext_instance->get_name() .'-audio',
		$ext->locate_URI( '/static/js/audio.js' ),
		array( 'jquery' ),
		slz()->manifest->get_version(),
		true
	);
}