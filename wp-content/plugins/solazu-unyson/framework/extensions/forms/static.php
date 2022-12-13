<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!is_admin()) {
	wp_enqueue_style('slz-ext-builder-frontend-grid');

	wp_enqueue_style(
		'slz-ext-forms-default-styles',
		slz()->extensions->get('forms')->get_declared_URI('/static/css/frontend.css'),
		array(),
		slz()->manifest->get_version()
	);
}

