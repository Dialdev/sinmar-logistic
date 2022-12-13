<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('map');
$ext_instance = slz()->extensions->get( 'shortcodes' );
if ( !is_admin() ) {
	$keyMapAPI = '';
	$keyMapAPIOption = slz_get_db_settings_option( 'map-key-api', '');
	if ( !empty($keyMapAPIOption) ) {
		$keyMapAPI = 'key='.trim($keyMapAPIOption).'&';
	}

	wp_enqueue_script(
		'google-map-api',
		'http://maps.googleapis.com/maps/api/js?'.$keyMapAPI.'libraries=places'
	);

	wp_enqueue_script(
		'slz-extension-'. $ext_instance->get_name() .'-map',
		$ext->locate_URI( '/static/js/map.js' ),
		array( 'jquery' ),
		slz()->manifest->get_version(),
		true
	);
	
}