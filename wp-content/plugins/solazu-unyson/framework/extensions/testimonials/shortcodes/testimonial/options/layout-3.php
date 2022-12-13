<?php
$yes_no  = array(
	esc_html__('Yes', 'slz')        => 'yes',
	esc_html__('No', 'slz')         => 'no'
);
$vc_options = array(
	//////////////////////////////////////////////////////////
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Quote Icon Color', 'slz' ),
		'param_name'  => 'quote_icon_color',
		'description' => esc_html__( 'Please choose quote icon color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
);