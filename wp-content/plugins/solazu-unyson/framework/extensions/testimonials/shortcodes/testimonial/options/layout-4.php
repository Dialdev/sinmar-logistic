<?php
$yes_no  = array(
	esc_html__('Yes', 'slz')        => 'yes',
	esc_html__('No', 'slz')         => 'no'
);
$vc_options = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Ratings?', 'slz' ),
		'param_name'  	=> 'show_ratings',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show ratings.', 'slz' ),
	),
);