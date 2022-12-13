<?php
$yes_no  = array(
	esc_html__('Yes', 'slz')       => 'yes',
	esc_html__('No', 'slz')        => 'no'
);

$vc_options = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Is Auto Play ?', 'slz' ),
		'param_name'    => 'slide_autoplay',
		'value'         => $yes_no,
		'std'           => 'no',
		'description'   => esc_html__( 'Choose YES to slide auto play.', 'slz' ),
		'group'         => esc_html__('Carousel Custom', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Is Dots Navigation ?', 'slz' ),
		'param_name'    => 'slide_dots',
		'value'         => $yes_no,
		'std'           => 'yes',
		'description'   => esc_html__( 'Choose YES to show dot navigation.', 'slz' ),
		'group'         => esc_html__('Carousel Custom', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Is Arrows Navigation ?', 'slz' ),
		'param_name'    => 'slide_arrows',
		'value'         => $yes_no,
		'std'           => 'yes',
		'description'   => esc_html__( 'Choose YES to show arrow navigation.', 'slz' ),
		'group'         => esc_html__('Carousel Custom', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Is Loop Infinite ?', 'slz' ),
		'param_name'    => 'slide_infinite',
		'value'         => $yes_no,
		'std'           => 'yes',
		'description'   => esc_html__( 'Choose YES to slide loop infinite.', 'slz' ),
		'group'         => esc_html__('Carousel Custom', 'slz')
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Speed Slide', 'slz' ),
		'param_name'    => 'slide_speed',
		'value'	        => '600',
		'description'   => esc_html__( 'Enter number value. Unit is millisecond. Example: 600.', 'slz' ),
		'group'         => esc_html__('Carousel Custom', 'slz')
	),

	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Color', 'slz' ),
		'param_name'    => 'color_slide_arrow',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide arrow for slide.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__('Color Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Color Hover', 'slz' ),
		'param_name'    => 'color_slide_arrow_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide arrow for slide when hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__('Color Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Background Color', 'slz' ),
		'param_name'    => 'color_slide_arrow_bg',
		'value'         => '',
		'description'   => esc_html__( 'Choose background color slide arrow for slide.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__('Color Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Background Color Hover', 'slz' ),
		'param_name'    => 'color_slide_arrow_bg_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose background color slide arrow for slide when hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__('Color Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Dots Color', 'slz' ),
		'param_name'    => 'color_slide_dots',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide dots for slide.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_dots',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__('Color Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Dots Color Active', 'slz' ),
		'param_name'    => 'color_slide_dots_at',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide dots for slide when active, hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_dots',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__('Color Custom', 'slz')
	)
);