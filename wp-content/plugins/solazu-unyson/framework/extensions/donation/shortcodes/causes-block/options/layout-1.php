<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'causes_block' );

$vc_options = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Column', 'slz' ),
		'param_name'    => 'column_1',
		'std'           => '1',
		'value'         => $shortcode->get_config( 'column' ),
		'group'         => esc_html__( 'Options', 'slz' ),
		'description'   => esc_html__( 'Choose number of column to show', 'slz' )
	),
	array(
		'type'          => 'dropdown',
		'group'			=> esc_html__( 'Options', 'slz' ),
		'heading'       => esc_html__( 'Show Goal and Raised?', 'slz' ),
		'param_name'    => 'show_goal_raised',
		'value'         => $shortcode->get_config( 'yes_no' ),
		'std'           => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show pagination.', 'slz' ),
	),
);