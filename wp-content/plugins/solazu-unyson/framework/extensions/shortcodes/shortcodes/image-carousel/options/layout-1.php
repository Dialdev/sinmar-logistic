<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'image_carousel' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'std'         => '1',
		'description' => esc_html__( 'Choose style to show', 'slz' )
	),
// 	array(
// 		'type'        => 'textfield',
// 		'heading'     => esc_html__( 'Slide to Show', 'slz' ),
// 		'param_name'  => 'slidetoshow',
// 		'value'       => '2',
// 		'description' => esc_html__( 'Choose number of item show.', 'slz' ),
// 		'group'       => esc_html__( 'Custom Slider', 'slz' )
// 	),
);