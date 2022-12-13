<?php

$styles = array(
	esc_html__('Florida','slz')    => 'style-1',
	esc_html__('California','slz') => 'style-2',
	esc_html__('Georgia','slz')    => 'style-3',
	esc_html__('New York','slz')   => 'style-4',
	esc_html__('Illinois','slz')   => 'style-5'
);


$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $styles,
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'slz' ),
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'List of Progress Bar', 'slz' ),
		'param_name' => 'progress_bar_list_1',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Title', 'slz' ),
				'param_name'  => 'title',
				'admin_label'    => true,
				'value'       => '',
				'description' => esc_html__( 'Title. If it blank the block will not have a title', 'slz' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Number show', 'slz' ),
				'admin_label'    => true,
				'param_name'  => 'percent',
				'value'       => '',
				'description' => esc_html__( 'Please input percent of progress bar, Exp: if you want to show 80, please input 80, maximum number is 100', 'slz' )
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Progress Bar Color', 'slz' ),
				'param_name'  => 'progress_bar_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom progress bar color.', 'slz' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Title Color', 'slz' ),
				'param_name'  => 'title_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom title text color.', 'slz' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Percent Color', 'slz' ),
				'param_name'  => 'percent_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom percent text color.', 'slz' ),
			),
		),
		'value'       => '',
		'dependency'     => array(
			'element'  => 'style',
			'value'    => array('style-1','style-2','style-3','style-5')
		),
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'List of Progress Bar', 'slz' ),
		'param_name' => 'progress_bar_list_2',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Title', 'slz' ),
				'admin_label'    => true,
				'param_name'  => 'title',
				'value'       => '',
				'description' => esc_html__( 'Title. If it blank the block will not have a title', 'slz' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Number show', 'slz' ),
				'admin_label'    => true,
				'param_name'  => 'percent',
				'value'       => '',
				'description' => esc_html__( 'Please input percent of progress bar, Exp: if you want to show 80, please input 80, maximum number is 100', 'slz' )
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Progress Bar Color', 'slz' ),
				'param_name'  => 'progress_bar_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom progress bar color.', 'slz' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Title Color', 'slz' ),
				'param_name'  => 'title_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom title text color.', 'slz' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Percent Color', 'slz' ),
				'param_name'  => 'percent_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom percent text color.', 'slz' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Marker Color', 'slz' ),
				'param_name'  => 'marker_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom marker color.', 'slz' ),
			),
		),
		'value'       => '',
		'dependency'     => array(
			'element'  => 'style',
			'value'    => array('style-4')
		),
	),
);