<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( str_replace( "-", "_", basename( dirname( __FILE__ ) ) ) );

$postion_arr = array(
	esc_html__( 'Default', 'slz' )  => '',
	esc_html__( 'Relative', 'slz' ) => 'relative',
);

$delay_time = array(
	esc_html__( '0.5 s', 'slz' )  => '0.5s',
	esc_html__( '1 s', 'slz' )    => '1s',
	esc_html__( '1.5 s', 'slz' )  => '1.5s',
	esc_html__( '2 s', 'slz' )    => '2s',
);

$animation =  SLZ_Params::get('animation');

$params = array(

	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Upload Image', 'slz' ),
		'param_name'     => 'img',
		'description'    => esc_html__('Upload an image.', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Image Position', 'slz' ),
		'param_name'  => 'image_position',
		'value'       => $postion_arr,
		'description' => esc_html__( 'if you choose "relative" you can custom top,left,right,bottom for image', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Margin Top', 'slz' ),
		'param_name'  => 'top',
		'value'       => '',
		'dependency' => array(
			'element'  => 'image_position',
				'value'    => array('relative')
		),
		'description' => esc_html__( 'Unit is px ( ex:50 )', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Margin Bottom', 'slz' ),
		'param_name'  => 'bottom',
		'value'       => '',
		'dependency' => array(
			'element'  => 'image_position',
				'value'    => array('relative')
		),
		'description' => esc_html__( 'Unit is px ( ex:50 )', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Margin Right', 'slz' ),
		'param_name'  => 'right',
		'value'       => '',
		'dependency' => array(
			'element'  => 'image_position',
				'value'    => array('relative')
		),
		'description' => esc_html__( 'Unit is px ( ex:50 )', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Margin left', 'slz' ),
		'param_name'  => 'left',
		'value'       => '',
		'dependency' => array(
			'element'  => 'image_position',
				'value'    => array('relative')
		),
		'description' => esc_html__( 'Unit is px ( ex:50 )', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Image Animation', 'slz' ),
		'param_name'  => 'image_animation',
		'value'       => $animation,
		'description' => esc_html__( 'Add animation for image', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Delay Time', 'slz' ),
		'param_name'  => 'delay_animation',
		'value'       => $delay_time,
		'description' => esc_html__( 'Choose delay time for animation', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to image', 'slz' )
	)
);

$vc_options = array_merge(
	$params
);