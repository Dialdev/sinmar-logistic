<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext_instance = slz()->extensions->get( 'events' );

// Load js for Event Block Shortcode
wp_enqueue_script(
    'slz-extension-'. $ext_instance->get_name() .'-event-block',
    $ext_instance->locate_URI( '/shortcodes/event-block/static/js/event-block.js' ),
    array( 'jquery' ),
    $ext_instance->manifest->get_version(),
    true
);