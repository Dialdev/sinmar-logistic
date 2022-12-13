<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

if( is_plugin_active( 'newsletter/plugin.php' ) ) {
	$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Newsletter', 'transera' ),
		'description' => esc_html__ ( 'Extend from plugin newsletter', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-newsletter slz-vc-slzcore',
		'tag' => 'slz_newsletter'
	);
}

$cfg['styles'] = array(
	'1'  => esc_html__('Style 1', 'transera'),
	'2'  => esc_html__('Style 2', 'transera')
);

$cfg ['default_value'] = array (
	'style'                     => '',
	'title'                     => '',
	'description'               => '',
	'show_input_name'           => 'yes',
	'input_name_placeholder'    => esc_html__('Name', 'transera'),
	'input_email_placeholder'   => esc_html__('Email Address', 'transera'),
	'button_text'               => esc_html__('Get Notified', 'transera'),
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