<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style_4',
		'value'       => $shortcode->get_config('layout_4_style'),
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'slz' ),
	),
);