<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_admin() ) {
	$ext_instance = slz()->extensions->get( 'footers' );

	wp_enqueue_script(
		'slz-extension-'. $ext_instance->get_name() .'-footers',
		$ext_instance->locate_js_URI( 'footers' ),
		array( 'jquery'),
		$ext_instance->manifest->get_version(),
		true
	);
}