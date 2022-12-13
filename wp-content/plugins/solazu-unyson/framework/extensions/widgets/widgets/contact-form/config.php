<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_contact_form', 'slz' ),
	'name'           => esc_html__( 'SLZ: Contact Form', 'slz' ),
	'description'    => esc_html__( 'A block contact form.', 'slz' ),
	'classname'      => 'slz-widget-contact-form'
);
