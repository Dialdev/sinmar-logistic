<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('tabs');
$ext_instance = slz()->extensions->get( 'shortcodes' );

if ( !is_admin() ) {

	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-tabs',
			$ext->locate_URI( '/static/js/tabs.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);	
}