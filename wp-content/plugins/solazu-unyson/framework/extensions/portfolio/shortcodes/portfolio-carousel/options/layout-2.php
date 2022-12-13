<?php
$style = array(
	esc_html__ ( 'Chennai', 'slz' ) => 'style-1',
	esc_html__ ( 'Mumbai', 'slz' )  => 'style-2',
	esc_html__ ( 'Pune', 'slz' )    => 'style-3'
);
$vc_options = array(
	array (
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'layout_style_2',
		'value'       => $style,
		'description' => esc_html__( 'Choose style will be displayed.', 'slz' )
	)
);