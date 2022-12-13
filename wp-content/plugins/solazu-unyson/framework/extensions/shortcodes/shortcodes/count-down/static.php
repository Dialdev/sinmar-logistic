<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('count-down');
$ext_instance = slz()->extensions->get( 'shortcodes' );

if ( !is_admin() ) {

	wp_enqueue_script(
		'slz-extension-'. $ext_instance->get_name() .'-count-down',
		$ext->locate_URI( '/static/js/slz-count-down.js' ),
		array( 'jquery' ),
		slz()->manifest->get_version(),
		true
	);
}
