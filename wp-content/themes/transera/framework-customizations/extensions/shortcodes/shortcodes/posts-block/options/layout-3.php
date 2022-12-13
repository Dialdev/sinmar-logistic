<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layouts', 'transera' ),
		'param_name'  => 'list_layout_3',
		'value'       => $shortcode->get_config('list_layout'),
		'std'         => 'list-layout-1',
		'description' => esc_html__( 'Choose list layout to show', 'transera' ),
		'group'       => esc_html__( 'List Layout', 'transera' ),
		'edit_field_class' => 'hidden'
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Columns', 'transera' ),
		'param_name'  => 'list_column_3',
		'value'       => $shortcode->get_config('column'),
		'std'         => '1',
		'description' => esc_html__( 'Choose number of column.', 'transera' ),
		'group'       => esc_html__( 'List Layout', 'transera' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-1', 'list-layout-3' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Read More Button?', 'transera' ),
		'param_name'  => 'list_show_read_more_3',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show read more button', 'transera' ),
		'group'       => esc_html__( 'List Layout', 'transera' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-1' )
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'transera' ),
		'param_name'  => 'list_read_more_text_3',
		'value'       => 'Read More',
		'description' => esc_html__( 'Button text. If it blank the read more button will not have a text', 'transera' ),
		'group'       => esc_html__( 'List Layout', 'transera' ),
		'dependency'     => array(
			'element'  => 'list_show_read_more_3',
			'value'    => array( 'yes' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Left and Right layout?', 'transera' ),
		'param_name'  => 'list_show_left_right_3',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show left and right layout', 'transera' ),
		'group'       => esc_html__( 'List Layout', 'transera' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-2' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt?', 'transera' ),
		'param_name'  => 'list_show_excerpt_3',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show excerpt', 'transera' ),
		'group'       => esc_html__( 'List Layout', 'transera' ),
		'dependency'     => array(
			'element'  => 'list_layout_3',
			'value'    => array( 'list-layout-1', 'list-layout-2' )
		),
	),
);