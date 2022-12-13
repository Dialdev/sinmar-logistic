<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

if( is_plugin_active( 'newsletter/plugin.php' ) ) {
	$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Newsletter', 'slz' ),
		'description' => esc_html__ ( 'Extend from plugin newsletter', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-newsletter slz-vc-slzcore',
		'tag' => 'slz_newsletter'
	);
}

$cfg['styles'] = array(
	'1'  => esc_html__('Florida', 'slz'),
	'2'  => esc_html__('California', 'slz')
);

$cfg ['default_value'] = array (
	'style'                     => '',
	'title'                     => '',
	'description'               => '',
	'show_input_name'           => 'yes',
	'input_name_placeholder'    => 'Name',
	'input_email_placeholder'   => 'Email Address',
	'button_text'               => 'Get Notified',
	'extra_class'               => '',
	'title_color'               => '',
	'description_color'         => '',
	'color_input'               => '',
	'color_button'              => '',
	'color_button_hv'           => '',
	'color_button_bg'           => '',
	'color_button_bg_hv'        => '',
	'color_button_border'       => '',
	'color_button_border_hv'    => '',
);