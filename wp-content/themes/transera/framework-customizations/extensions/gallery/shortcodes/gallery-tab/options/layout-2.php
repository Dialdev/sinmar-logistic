<?php 
$style = array(
	esc_html__( 'Style 1', 'transera' )    => 'style-1',
	esc_html__( 'Style 2', 'transera' )    => 'style-2',
	esc_html__( 'Style 3', 'transera' )    => 'style-3',
	esc_html__( 'Style 4', 'transera' )    => 'style-4',
	esc_html__( 'Style 5', 'transera' )    => 'style-5',
	esc_html__( 'Style 6', 'transera' )    => 'style-6',
	esc_html__( 'Style 7', 'transera' )    => 'style-7'
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