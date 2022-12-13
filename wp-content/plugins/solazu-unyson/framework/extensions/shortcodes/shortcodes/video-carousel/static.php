<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('video_carousel');
$ext_instance = slz()->extensions->get( 'shortcodes' );

if ( !is_admin() ) {

	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-video-carousel',
			$ext->locate_URI( '/static/js/video-carousel.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);	
}