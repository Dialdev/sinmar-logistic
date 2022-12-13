<?php

$yes_no  = array(
	esc_html__('Yes', 'slz')        => 'yes',
	esc_html__('No', 'slz')         => 'no'
);

$vc_options = array(
	array(
		'type'            => 'dropdown',
		'heading'         => esc_html__( 'Show Quote ?', 'slz' ),
		'param_name'      => 'show_quote',
		'value'           => $yes_no,
		'std'      	      => 'yes',
		'description'     => esc_html__( 'If choose Yes, block will be show quote.', 'slz' )
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Quote Color', 'slz' ),
		'param_name'      => 'color_quote',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for quote text.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Quote Icon Color', 'slz' ),
		'param_name'      => 'color_quote_icon',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for quote icon.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Carousel Navigation Arrow Color', 'slz' ),
		'param_name'      => 'color_carousel_arrow',
		'value'           => '',
		'description'     => esc_html__( 'Choose color arrow for slide.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Carousel Navigation Arrow Color Hover', 'slz' ),
		'param_name'      => 'color_carousel_arrow_hv',
		'value'           => '',
		'description'     => esc_html__( 'Choose color arrow for slide when hover.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Carousel Navigation Arrow Background Color', 'slz' ),
		'param_name'      => 'color_carousel_arrow_bg',
		'value'           => '',
		'description'     => esc_html__( 'Choose background color arrow for slide.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Carousel Navigation Arrow Background Color Hover', 'slz' ),
		'param_name'      => 'color_carousel_arrow_bg_hv',
		'value'           => '',
		'description'     => esc_html__( 'Choose background color arrow for slide when hover.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	)
);