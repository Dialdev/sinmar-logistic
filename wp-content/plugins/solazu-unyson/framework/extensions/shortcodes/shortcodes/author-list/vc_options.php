<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'author_list' );

$show_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show', 'slz' ),
		'param_name'  => 'show_options',
		'std'         => 'one',
		'value'       => $shortcode->get_config('show_options'),
		'description' => esc_html__( 'Choose option to show.', 'slz' )
	),
);

$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'User ID', 'slz' ),
		'param_name'  => 'user_id',
		'description' => esc_html__( 'Please input the user id to show.', 'slz' ),
		'dependency' => array(
			'element' => 'show_options',
			'value' => 'one',
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Perpage', 'slz' ),
		'param_name'  => 'limit_author',
		'value'       => '6',
		'description' => esc_html__( 'The number of authors to display in one page. If it blank the number posts will be the number from Settings -> Reading', 'slz' ),
		'dependency' => array(
			'element' => 'show_options',
			'value' => 'multiple',
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort by', 'slz' ),
		'param_name'  => 'sort_by',
		'value'       => $shortcode->get_config('sort-author'),
		'description' => esc_html__( 'Sort author list by.', 'slz' ),
		'dependency' => array(
			'element' => 'show_options',
			'value' => 'multiple',
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Order Sort', 'slz' ),
		'param_name'  => 'order_sort',
		'value'       => $shortcode->get_config('order-sort'),
		'description' => esc_html__( 'Order Sort author list.', 'slz' ),
		'dependency' => array(
			'element' => 'show_options',
			'value' => 'multiple',
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Filter by role', 'slz' ),
		'param_name'  => 'role_author',
		'value'       => $shortcode->get_config('role-author'),
		'description' => esc_html__( 'Filter author list by role.', 'slz' ),
		'dependency' => array(
			'element' => 'show_options',
			'value' => 'multiple',
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show pagination', 'slz' ),
		'param_name'  => 'show_pagination',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show pagination.', 'slz' ),
		'dependency' => array(
			'element' => 'show_options',
			'value' => 'multiple',
		),
	),
);

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'slz' )
	)
);

$vc_options = array_merge(
	$show_options,
	$params,
	$extra_class
);