<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('counterv2');
$ext_instance = slz()->extensions->get( 'shortcodes' );
if ( !is_admin() ) {
	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-counterv2',
			$ext->locate_URI( '/static/js/counterv2.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);
}
