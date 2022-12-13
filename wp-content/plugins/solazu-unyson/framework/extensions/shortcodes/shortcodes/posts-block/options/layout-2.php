<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt?', 'slz' ),
		'param_name'  => 'main_show_excerpt_2',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show excerpt', 'slz' ),
		'group'       => esc_html__( 'Main Layout', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layouts', 'slz' ),
		'param_name'  => 'list_layout_2',
		'value'       => $shortcode->get_config('list_layout_2'),
		'std'         => 'list-layout-1',
		'description' => esc_html__( 'Choose list layout to show', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Feature Image?', 'slz' ),
		'param_name'  => 'list_show_image_2',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show feature image', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'list_layout_2',
			'value'    => array( 'list-layout-2' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt?', 'slz' ),
		'param_name'  => 'list_show_excerpt_2',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'no',
		'description' => esc_html__( 'Choose if want to show excerpt', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'list_layout_2',
			'value'    => array('list-layout-2' )
		),
	),
);