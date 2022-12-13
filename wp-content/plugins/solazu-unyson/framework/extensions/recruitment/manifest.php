<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = esc_html__( 'Recruitment', 'slz' );
$manifest['thumbnail']   = slz_get_framework_directory_uri( '/extensions/recruitment/static/img/recruitment.jpg');
$manifest['description'] = esc_html__( 'This extension use for recruitment service', 'slz' );
$manifest['version'] = '1.0';
$manifest['display'] = true;
$manifest['standalone'] = true;