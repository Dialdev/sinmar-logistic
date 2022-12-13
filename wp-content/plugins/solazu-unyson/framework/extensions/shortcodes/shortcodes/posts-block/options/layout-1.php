<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layouts', 'slz' ),
		'param_name'  => 'main_layout',
		'value'       => $shortcode->get_config('main_layout'),
		'std'         => 'main-layout-1',
		'description' => esc_html__( 'Choose main layout to show', 'slz' ),
		'group'       => esc_html__( 'Main Layout', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt?', 'slz' ),
		'param_name'  => 'main_show_excerpt',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show excerpt', 'slz' ),
		'group'       => esc_html__( 'Main Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'main_layout',
			'value'    => array( 'main-layout-1', 'main-layout-2', 'main-layout-3' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layouts', 'slz' ),
		'param_name'  => 'list_layout',
		'value'       => $shortcode->get_config('list_layout'),
		'std'         => 'list-layout-1',
		'description' => esc_html__( 'Choose list layout to show', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Columns', 'slz' ),
		'param_name'  => 'list_column',
		'value'       => $shortcode->get_config('column'),
		'std'         => '1',
		'description' => esc_html__( 'Choose number of column.', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Feature Image?', 'slz' ),
		'param_name'  => 'list_show_image',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show feature image', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'list_layout',
			'value'    => array( 'list-layout-2' )
		),
	),
);