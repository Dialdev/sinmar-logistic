<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'pageable' );
$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Margin Bottom', 'slz' ),
		'param_name'  => 'bottom',
		'dependency'     => array(
    		'element'  => 'style',
  			'value'    => array('style-2')
  		),
		'description' => esc_html__( 'Please enter margin bottom of block (ex: 12px).', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'description' => esc_html__( 'Please enter your extra class.', 'slz' )
	)
);