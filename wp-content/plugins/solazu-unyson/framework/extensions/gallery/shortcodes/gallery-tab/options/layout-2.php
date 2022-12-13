<?php 
$style = array(
	esc_html__( 'Chennai', 'slz' )    => 'style-1',
	esc_html__( 'Mumbai', 'slz' )     => 'style-2',
	esc_html__( 'Pune', 'slz' )       => 'style-3',
	esc_html__( 'Jaipur', 'slz' )     => 'style-4',
	esc_html__( 'Noida', 'slz' )      => 'style-5',
	esc_html__( 'New Delhi', 'slz' )  => 'style-6',
	esc_html__( 'Bengaluru', 'slz' )  => 'style-7'
);
$vc_options = array(

	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $style,
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'slz' ),
	),
	
);