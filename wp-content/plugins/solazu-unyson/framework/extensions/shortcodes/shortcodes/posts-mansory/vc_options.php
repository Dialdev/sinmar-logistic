<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_mansory' );

$block_title = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'slz' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
	),
);

$layouts = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'		  => 'layout-1',
		'description' => esc_html__( 'Choose a layout to show.', 'slz' )
	),
);

$layout_options = $shortcode->get_layout_options();

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt', 'slz' ),
		'param_name'  => 'excerpt',
		'value'       => array(
			esc_html__('Show', 'slz')	=>	'show',
			esc_html__('Hide', 'slz')	=>	'hide'
		),
		'std'         => 'show',
		'description' => esc_html__( 'Show or hide post excerpt', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Excerpt Length', 'slz' ),
		'param_name'  => 'excerpt_length',
		'value'       => '15',
		'description' => esc_html__( 'Input number of excerpt length.', 'slz' ),
		'dependency' => array(
			'element' => 'excerpt',
			'value' => 'show',
		),
	),
);

$query_options = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '6',
		'description' => esc_html__( 'The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Posts', 'slz' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display. If you want to start on record 6, using offset 5', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'slz' ),
		'param_name'  => 'sort_by',
		'value'       => slz()->backend->get_param('sort_blog'),
		'description' => esc_html__( 'Choose criteria to display.', 'slz' )
	),
);

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	)
);

$vc_options = array_merge(
	$block_title,
	$layouts,
	$params,
	$layout_options,
	slz()->backend->get_param('shortcode_filter'),
	slz()->backend->get_param('shortcode_paging'),
	slz()->backend->get_param('shortcode_ajax_filter'),
	$query_options,
	$extra_class
);
