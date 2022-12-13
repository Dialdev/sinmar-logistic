<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('image_carousel');
$ext_instance = slz()->extensions->get( 'shortcodes' );
if ( !is_admin() ) {

	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-image-carousel',
			$ext->locate_URI( '/static/js/image-carousel.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);

}