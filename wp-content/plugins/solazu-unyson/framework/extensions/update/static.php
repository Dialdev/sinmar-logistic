<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$extension = slz()->extensions->get('update');

if (slz_current_screen_match(array('only' => array(array('id' => 'update-core'))))) {
	// Include only on update page

	wp_enqueue_style(
		'slz-ext-'. $extension->get_name() .'-update-page',
		$extension->get_declared_URI('/static/css/admin-update-page.css'),
		array(),
		$extension->manifest->get_version()
	);
}
