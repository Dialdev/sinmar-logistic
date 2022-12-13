<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layouts', 'slz' ),
		'param_name'  => 'list_layout_3',
		'value'       => $shortcode->get_config('list_layout_3'),
		'std'         => 'list-layout-1',
		'description' => esc_html__( 'Choose list layout to show', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Columns', 'slz' ),
		'param_name'  => 'list_column_3',
		'value'       => $shortcode->get_config('column'),
		'std'         => '1',
		'description' => esc_html__( 'Choose number of column.', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-1', 'list-layout-3' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Left and Right layout?', 'slz' ),
		'param_name'  => 'list_show_left_right_3',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show left and right layout', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-2' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt?', 'slz' ),
		'param_name'  => 'list_show_excerpt_3',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show excerpt', 'slz' ),
		'group'       => esc_html__( 'List Layout', 'slz' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-1', 'list-layout-2' )
		),
	)
);