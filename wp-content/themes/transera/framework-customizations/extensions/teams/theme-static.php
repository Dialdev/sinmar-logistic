<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

if ( !is_admin() ) {
	$ext_instance = slz()->extensions->get( 'teams' );

	wp_enqueue_script(
		'transera-slz-extension-'. $ext_instance->get_name() .'-scripts',
		$ext_instance->locate_js_URI( 'team-custom' ),
		array( 'jquery'),
		$ext_instance->manifest->get_version(),
		true
	);
}