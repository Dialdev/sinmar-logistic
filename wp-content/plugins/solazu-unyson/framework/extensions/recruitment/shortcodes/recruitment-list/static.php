<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('recruitment-list');
$ext_instance = slz()->extensions->get( 'shortcodes' );
if ( !is_admin() ) {
	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-recruitment-list',
			$ext->locate_URI( '/static/js/recruitment-list.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);
}