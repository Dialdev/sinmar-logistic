<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext_instance = slz()->extensions->get( 'donation' );
wp_enqueue_script(
	'slz-extension-'. $ext_instance->get_name() .'-causes-carousel',
	$ext_instance->locate_URI( '/shortcodes/causes-carousel/static/js/causes-carousel.js' ),
	array( 'jquery'),
	$ext_instance->manifest->get_version(),
	true
);