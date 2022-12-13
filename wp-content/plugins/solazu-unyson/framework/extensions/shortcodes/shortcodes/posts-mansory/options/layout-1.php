<?php

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Readmore Button', 'slz' ),
		'param_name'  => 'readmore',
		'value'       => array(
			esc_html__('Show', 'slz')	=>	'show',
			esc_html__('Hide', 'slz')	=>	'hide'
		),
		'std'         => 'show',
		'description' => esc_html__( 'Show or hide readmore button', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'value'       => array(
			esc_html__('Two Column', 'slz')			=>	'2',
			esc_html__('Three Column', 'slz')		=>	'3',
			esc_html__('Four Column', 'slz')			=>	'4',
		),
		'std'		  => '2',
		'description' => esc_html__( 'Choose a column for display block.', 'slz' )
	),
);