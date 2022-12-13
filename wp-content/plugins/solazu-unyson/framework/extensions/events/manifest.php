<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = esc_html__( 'Events', 'slz' );
$manifest['description'] = esc_html__( 'This extension use add to events.', 'slz' );
$manifest['thumbnail'] = slz_get_framework_directory_uri( '/extensions/events/static/img/events.png');
$manifest['version'] = '1.0';
$manifest['display'] = true;
$manifest['standalone'] = true;