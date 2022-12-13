<?php
$column = array(
    esc_html__('One', 'slz')     => '1',
    esc_html__('Two', 'slz')     => '2'
);

$vc_options = array(
    array(
        'type'        	=> 'dropdown',
        'heading'     	=> esc_html__( 'Slides To Show', 'slz' ),
        'param_name'  	=> 'column',
        'value'       	=> $column,
        'std'      		=> '1',
        'description' 	=> esc_html__( 'Please input number of item show in slider.', 'slz' ),
    ),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Quote Icon Color', 'slz' ),
		'param_name'  => 'quote_icon_color',
		'description' => esc_html__( 'Please choose quote icon color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
);