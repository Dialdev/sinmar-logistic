<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

$block_title = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'transera' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'transera' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'transera' )
	),
);

$layouts = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layouts', 'transera' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-3',
		'description' => esc_html__( 'Choose layout to show', 'transera' ),
		'edit_field_class' => 'hidden'
	),
);

$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'transera' ),
		'param_name'  => 'limit_post',
		'value'       => '5',
		'description' => esc_html__( 'The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Posts', 'transera' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display. If you want to start on record 6, using offset 5', 'transera' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'transera' ),
		'param_name'  => 'sort_by',
		'value'       => slz()->backend->get_param('sort_blog'),
		'description' => esc_html__( 'Choose criteria to display.', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Excerpt Length', 'transera' ),
		'param_name'  => 'excerpt_length',
		'value'       => '15',
		'description' => esc_html__( 'Enter number of excerpt length', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'transera' )
	)
);
$style_options = $shortcode->get_layout_options();

$vc_options = array_merge(
	$block_title,
	$layouts,
	$style_options,
	$params,
	slz()->backend->get_param('shortcode_filter'),
	slz()->backend->get_param('shortcode_paging_no_load_more'),
	slz()->backend->get_param('shortcode_ajax_filter')
);
