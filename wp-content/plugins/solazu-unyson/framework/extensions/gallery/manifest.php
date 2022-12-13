<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = esc_html__( 'Gallery', 'slz' );
$manifest['description'] = esc_html__( 'This extension use add to gallery.', 'slz' );
$manifest['thumbnail'] = slz_get_framework_directory_uri( '/extensions/gallery/static/img/gallery.jpg');
$manifest['version'] = '1.0';
$manifest['display'] = true;
$manifest['standalone'] = true;