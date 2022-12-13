<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_about_us', 'slz' ),
	'name'           => esc_html__( 'SLZ: About Us', 'slz' ),
	'description'    => esc_html__( 'A block information about us.', 'slz' ),
	'classname'      => 'slz-widget-about-us'
);
