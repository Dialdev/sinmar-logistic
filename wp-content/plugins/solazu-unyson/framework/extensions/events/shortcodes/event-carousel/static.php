<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext_instance = slz()->extensions->get( 'events' );

wp_enqueue_script(
	'slz-extension-'. $ext_instance->get_name() .'-event-carousel',
	$ext_instance->locate_URI( '/shortcodes/event-carousel/static/js/event-carousel.js' ),
	array( 'jquery'),
	$ext_instance->manifest->get_version(),
	true
);