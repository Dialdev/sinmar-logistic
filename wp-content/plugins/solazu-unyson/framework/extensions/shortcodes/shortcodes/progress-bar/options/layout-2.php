<?php

$column_arr = array(
	esc_html__( 'One', 'slz' )     => '1',
	esc_html__( 'Two', 'slz' )     => '2',
	esc_html__( 'Three', 'slz' )   => '3',
	esc_html__( 'Four', 'slz' )    => '4',
);

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'std'         => '1',
		'value'       => $column_arr,
		'description' => esc_html__( 'Choose number of columns to show.', 'slz' ),
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'List of Progress Bar', 'slz' ),
		'param_name' => 'progress_bar_list_3',
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
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Description', 'slz' ),
				'param_name'  => 'des',
				'value'       => '',
				'description' => esc_html__( 'Description. If it blank the block will not have a description', 'slz' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Line Width', 'slz' ),
				'param_name'  => 'line_width',
				'value'       => '5',
				'description' => esc_html__( 'Line Width. If it blank the block will not have line width', 'slz' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Track Width', 'slz' ),
				'param_name'  => 'track_width',
				'value'       => '1',
				'description' => esc_html__( 'Track Width. If it blank the block will not have track width', 'slz' ),
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
				'heading'     => esc_html__( 'Track Circle Color', 'slz' ),
				'param_name'  => 'track_circle_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom track circle color.', 'slz' ),
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
				'heading'     => esc_html__( 'Description Color', 'slz' ),
				'param_name'  => 'des_color',
				'value'       => '',
				'description' => esc_html__( 'Choose a custom description text color.', 'slz' ),
			),

		),
		'value'       => '',
	),
);