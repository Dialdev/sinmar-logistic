<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_contact', 'slz' ),
	'name'           => esc_html__( 'SLZ: Contact', 'slz' ),
	'description'    => esc_html__( 'A block contact information.', 'slz' ),
	'classname'      => 'slz-widget-contact'
);
