<?php

$styles = array(
	esc_html__('Style 1','transera') => 'style-1',
);

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'transera' ),
		'param_name'  => 'style',
		'value'       => $styles,
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'transera' ),
		'edit_field_class'   => 'hidden',
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'List of Progress Bar', 'transera' ),
		'param_name' => 'progress_bar_list_1',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Title', 'transera' ),
				'param_name'  => 'title',
				'admin_label'    => true,
				'value'       => '',
				'description' => esc_html__( 'Title. If it blank the block will not have a title', 'transera' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Number show', 'transera' ),
				'admin_label'    => true,
				'param_name'  => 'percent',
				'value'       => '',
				'description' => esc_html__( 'Please input percent of progress bar, Exp: if you want to show 80, please input 80, maximum number is 100', 'transera' )
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Progress Bar Color', 'transera' ),
				'param_name'  => 'progress_bar_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom progress bar color.', 'transera' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Title Color', 'transera' ),
				'param_name'  => 'title_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom title text color.', 'transera' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Percent Color', 'transera' ),
				'param_name'  => 'percent_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom percent text color.', 'transera' ),
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
		'heading'    => esc_html__( 'List of Progress Bar', 'transera' ),
		'param_name' => 'progress_bar_list_2',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Title', 'transera' ),
				'admin_label'    => true,
				'param_name'  => 'title',
				'value'       => '',
				'description' => esc_html__( 'Title. If it blank the block will not have a title', 'transera' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Number show', 'transera' ),
				'admin_label'    => true,
				'param_name'  => 'percent',
				'value'       => '',
				'description' => esc_html__( 'Please input percent of progress bar, Exp: if you want to show 80, please input 80, maximum number is 100', 'transera' )
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Progress Bar Color', 'transera' ),
				'param_name'  => 'progress_bar_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom progress bar color.', 'transera' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Title Color', 'transera' ),
				'param_name'  => 'title_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom title text color.', 'transera' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Percent Color', 'transera' ),
				'param_name'  => 'percent_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom percent text color.', 'transera' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Marker Color', 'transera' ),
				'param_name'  => 'marker_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom marker color.', 'transera' ),
			),
		),
		'value'       => '',
		'dependency'     => array(
			'element'  => 'style',
			'value'    => array('style-4')
		),
	),
);