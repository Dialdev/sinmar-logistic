<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = esc_html__( 'Donation', 'slz' );
$manifest['description'] = esc_html__( 'This extension use add to donation.', 'slz' );
$manifest['thumbnail'] = slz_get_framework_directory_uri( '/extensions/donation/static/img/donation.png');
$manifest['version'] = '1.0';
$manifest['display'] = true;
$manifest['standalone'] = true;