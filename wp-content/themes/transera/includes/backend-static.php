<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

wp_enqueue_media();

if ( defined( 'SLZ' ) ) {
    $transera_version = slz()->theme->manifest->get_version();
} else {
    $transera_version = '1.0';
}

wp_enqueue_style(
	'css-theme-admin',
	TRANSERA_STATIC_URI . '/css/theme-admin.css',
	array(),
    $transera_version
);

wp_enqueue_script(
	'js-theme-admin',
	TRANSERA_STATIC_URI . '/js/theme-admin.js',
	array( 'jquery', ),
    $transera_version,
	true
);

