<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('partner');
$ext_instance = slz()->extensions->get( 'shortcodes' );
if ( !is_admin() ) {

	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-partner',
			$ext->locate_URI( '/static/js/partner.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);
}