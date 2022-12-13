<?php
$yes_no  = array(
	esc_html__('Yes', 'transera')        => 'yes',
	esc_html__('No', 'transera')         => 'no'
);
$style = array(
	esc_html__('Style 1', 'transera')    => 'style-1',
	esc_html__('Style 2', 'transera')    => 'style-2'
);
$vc_options = array(
	
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'transera' ),
		'param_name'  => 'style',
		'value'       => $style,
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'transera' ),
	),
);