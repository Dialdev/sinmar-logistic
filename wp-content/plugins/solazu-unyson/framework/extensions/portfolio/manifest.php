<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = esc_html__( 'Portfolio', 'slz' );
$manifest['description'] = esc_html__( 'This extension use add to portfolio.', 'slz' );
$manifest['version'] = '1.0';
$manifest['display'] = true;
$manifest['standalone'] = true;