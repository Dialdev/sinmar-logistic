<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_grid' );

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose layout to show.', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Position', 'slz' ),
		'param_name'  => 'position',
		'value'       => $shortcode->get_config('position'),
		'std'         => 'left',
		'description' => esc_html__( 'Choose layout position.', 'slz' ),
		'dependency' => array(
			'element' => 'style',
			'value' => array('style-1', 'style-2', 'style-3') ,
		)
	),
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
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt', 'slz' ),
		'param_name'  => 'show_excerpt',
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
			'element' => 'show_excerpt',
			'value' => 'show',
		)
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
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	)
);

$vc_options = array_merge( 
	$params,
	slz()->backend->get_param('shortcode_filter')
);
