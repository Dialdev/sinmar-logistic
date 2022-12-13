<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_block' );

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
		'heading'     => esc_html__( 'Layouts', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'slz' )
	),
);

$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '5',
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
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Excerpt Length', 'slz' ),
		'param_name'  => 'excerpt_length',
		'value'       => '15',
		'description' => esc_html__( 'Enter number of excerpt length', 'slz' )
	),
	array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Button "Read More" Text', 'slz' ),
        'param_name'  => 'btn_read_more',
        'value'       => esc_html__('Read More','slz'),
        'dependency'     => array(
			'element'  => 'layout',
			'value_not_equal_to' => array( 'layout-4' )
		),
        'description' => esc_html__( 'Enter text for button "read more"', 'slz' )
    ),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
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
