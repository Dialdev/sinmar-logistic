<?php

$params = array(
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Add info to timeline', 'slz' ),
		'param_name' => 'timeline_info',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'admin_label' => true,
				'heading'     => esc_html__( 'Timeline', 'slz' ),
				'param_name'  => 'timeline',
				'description' => esc_html__( 'Timeline. If it blank the will not have timeline', 'slz' )
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Timeline Color', 'slz' ),
				'param_name'  => 'timeline_color',
				'description' => esc_html__( 'Choose a custom color for timeline.', 'slz' ),
			),
			array(
				'type'        => 'textfield',
				'admin_label' => true,
				'heading'     => esc_html__( 'Title', 'slz' ),
				'param_name'  => 'title',
				'description' => esc_html__( 'Title. If it blank the will not have a title', 'slz' )
			),
			array(
				'type'        => 'vc_link',
				'heading'     => esc_html__( 'Url', 'slz' ),
				'param_name'  => 'title_link',
				'value'       => '',
				'description' => esc_html__( 'Please input link to timeline.', 'slz' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Title Color', 'slz' ),
				'param_name'  => 'title_color',
				'description' => esc_html__( 'Choose a custom color for title.', 'slz' ),
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Description', 'slz' ),
				'param_name'  => 'description',
				'description' => esc_html__( 'Description. If it blank the will not have a description', 'slz' )
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Description Color', 'slz' ),
				'param_name'  => 'description_color',
				'description' => esc_html__( 'Choose a custom color for description.', 'slz' ),
			),
			array(
				'type'           => 'attach_image',
				'heading'        => esc_html__( 'Upload Image', 'slz' ),
				'param_name'     => 'image',
				'description'    => esc_html__('Upload Image.', 'slz'),
			),
		),
	),
);

$custom_css = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Milestone Point', 'slz' ),
		'param_name'  => 'milestone_point_color',
		'description' => esc_html__( 'Choose a custom color for milestone point.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Timeline Line', 'slz' ),
		'param_name'  => 'timeline_line_color',
		'description' => esc_html__( 'Choose a custom color for timeline line.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
);

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'slz' )
	)
);

$vc_options = array_merge( 
	$params,
	$custom_css,
	$extra_class
);