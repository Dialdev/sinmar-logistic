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
		'heading'     => esc_html__( 'Template', 'slz' ),
		'param_name'  => 'template',
		'value'       => array(
			esc_html__('Grid', 'slz') 		=>	'grid',
			esc_html__('Slider', 'slz')		=>	'slider'
		),
		'std'		  => 'grid',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Instagram ID', 'slz'),
		'param_name'  => 'instagram_id',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Number images', 'slz'),
		'param_name'  => 'limit_image',
		'value'       => '12',
		'description' => '',
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'value'       => array(
			esc_html__('3', 'slz') 		=>	3,
			esc_html__('4', 'slz')	=>	4
		),
		'std'		  => 4,
		'dependency' => array(
			'element' => 'template',
			'value' => 'grid',
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Number items', 'slz'),
		'param_name'  => 'number_items',
		'value'       => '6',
		'description' => '',
		'dependency' => array(
			'element' => 'template',
			'value' => 'slider',
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
);