<?php
$yes_no  = array(
	esc_html__('Yes', 'slz')        => 'yes',
	esc_html__('No', 'slz')         => 'no'
);
$style = array(
	esc_html__('Chennai', 'slz')    => 'style-1',
	esc_html__('Mumbai', 'slz')     => 'style-2'
);

$vc_options = array(

	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'layout_02_style',
		'value'       =>  $style,
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'slz' ),
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Picture Frame', 'slz' ),
		'param_name'     => 'image-upload',
		'dependency'     => array(
			'element'  => 'layout_02_style',
			'value'    => array('style-2')
		),
		'description'    => esc_html__('Upload one image to make frame for featured image.', 'slz'),
	),
);