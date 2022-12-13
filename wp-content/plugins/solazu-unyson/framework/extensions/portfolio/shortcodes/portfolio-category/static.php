<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$ext = slz_ext( 'shortcodes' )->get_shortcode('portfolio_category');
$ext_instance = slz()->extensions->get( 'shortcodes' );

if ( !is_admin() ) {
	
	wp_enqueue_script(
			'slz-extension-'. $ext_instance->get_name() .'-portfolio-category',
			$ext->locate_URI( '/static/js/portfolio-category.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
	);
}