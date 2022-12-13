<?php

$vc_options = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'slz' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => array(
			esc_html__('Florida', 'slz') 		=>	1,
			esc_html__('California', 'slz') 	=>	2
		),
		'std'		  => 1,
		'description' => esc_html__( 'Choose a style for display.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Facebook User:', 'slz'),
		'param_name'  => 'facebook',
		'value'       => '',
		'description' => '',
		'group'       => esc_html__('Channel', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Twitter User:', 'slz'),
		'param_name'  => 'twitter',
		'value'       => '',
		'description' => '',
		'group'       => esc_html__('Channel', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Google Plus ID:', 'slz'),
		'param_name'  => 'google',
		'value'       => '',
		'description' => '',
		'group'       => esc_html__('Channel', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Instagram User:', 'slz'),
		'param_name'  => 'instagram',
		'value'       => '',
		'description' => '',
		'group'       => esc_html__('Channel', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Vimeo ID:', 'slz'),
		'param_name'  => 'vimeo',
		'value'       => '',
		'description' => '',
		'group'       => esc_html__('Channel', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Soundcloud User:', 'slz'),
		'param_name'  => 'soundcloud',
		'value'       => '',
		'description' => '',
		'group'       => esc_html__('Channel', 'slz')
	),
);