<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'counter' );

$alignment =  array(
	esc_html__('Left', 'slz')   => 'counter-left',
	esc_html__('Right', 'slz')  => 'counter-right',
	esc_html__('Center', 'slz') => 'counter-center'
	);
$styles = array(
	array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Layout', 'slz' ),
        'param_name'  => 'layout',
        'value'       => $shortcode->get_layouts(),
        'std'         => 'layout-1',
        'description' => esc_html__( 'Choose style to show', 'slz' )
    ),
);

$style_options = $shortcode->get_layout_options();

$params = array(

	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'slz' ),
		'param_name'  => 'title',
		'description' => esc_html__( 'Title. If it blank the will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Choose a custom color for title.', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number', 'slz' ),
		'param_name'  => 'number',
		'description' => esc_html__( 'Title. If it blank the will not have a number', 'slz' ),
		'group'       => esc_html__( 'Number Settings', 'slz' )

	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Number Color', 'slz' ),
		'param_name'  => 'number_color',
		'description' => esc_html__( 'Choose a custom color for number.', 'slz' ),
		'group'       => esc_html__( 'Number Settings', 'slz' )
	),
	array(
		"type"        => "checkbox",
		"heading"     => esc_html__( "Number Animation?", 'slz' ),
		"param_name"  => "animation",
		'group'       => esc_html__( 'Number Settings', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Add suffix', 'slz' ),
		'param_name'  => 'suffix',
		'description' => esc_html__( 'Add suffix for number', 'slz' ),
		'group'       => esc_html__( 'Number Settings', 'slz' )
	),
	array(
		"type"        => "checkbox",
		"heading"     => esc_html__( "Show Line?", 'slz' ),
		"param_name"  => "show_line",
		'description' => esc_html__( 'Show line under number', 'slz' ),
		'group'       => esc_html__( 'Number Settings', 'slz' )
	),
	array(
		"type"        => "dropdown",
		"heading"     => esc_html__( " Block Alignment", 'slz' ),
		"param_name"  => "alignment",
		'std'         => 'counter-center',
		"value"       => $alignment,
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
	$styles,
	$params,
	$style_options,
	$extra_class
);