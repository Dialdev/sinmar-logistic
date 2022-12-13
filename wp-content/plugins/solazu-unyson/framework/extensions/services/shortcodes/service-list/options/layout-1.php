<?php

$styles = array(
	esc_html__('Florida','slz')    => '',
	esc_html__('California','slz') => 'style-vertical'
);

$align = array(
	esc_html__('Center', 'slz')    => '',
	esc_html__('Left', 'slz')      => 'left',
	esc_html__('Right', 'slz')     => 'right'
);

$vc_options = array(
	array(
		'type'            => 'dropdown',
		'heading'         => esc_html__( 'Style', 'slz' ),
		'param_name'      => 'style',
		'value'           => $styles,
		'description'     => esc_html__( 'Choose style to display on frontend.', 'slz' ),
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Align', 'slz' ),
		'param_name'  	  => 'align',
		'value'       	  => $align,
		'description' 	  => esc_html__( 'Choose align for block.', 'slz' ),
		'dependency'      => array(
			'element'     => 'style',
			'value'       => array( 'style-vertical' )
		)
	)
);