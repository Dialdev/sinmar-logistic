<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

if ( !is_admin() ) {
	$ext_instance = slz()->extensions->get( 'testimonials' );
	//css
	wp_enqueue_style(
			'transera-slz-extension-testimonial',
			$ext_instance->locate_css_URI( 'transera-testimonial' ),
			array(),
			$ext_instance->manifest->get_version()
	);
}