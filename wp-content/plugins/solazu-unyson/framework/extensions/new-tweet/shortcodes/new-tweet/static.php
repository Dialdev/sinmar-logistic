<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext_instance = slz()->extensions->get( 'new-tweet' );

wp_enqueue_script(
	'slz-extension-'. $ext_instance->get_name() .'-new-tweet',
	$ext_instance->locate_URI( '/shortcodes/new-tweet/static/js/new-tweet.js' ),
	array( 'jquery'),
	$ext_instance->manifest->get_version(),
	true
);