<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'counter' );

$alignment =  array(
	esc_html__('Left', 'transera')   => 'counter-left',
	esc_html__('Right', 'transera')  => 'counter-right',
	esc_html__('Center', 'transera') => 'counter-center'
	);
$styles = array(
	array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Layout', 'transera' ),
        'param_name'  => 'layout',
        'value'       => $shortcode->get_layouts(),
        'std'         => 'layout-1',
        'description' => esc_html__( 'Choose style to show', 'transera' ),
		'edit_field_class' => 'hidden'
    ),
);

$style_options = $shortcode->get_layout_options();

$params = array(

	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'transera' ),
		'param_name'  => 'title',
		'description' => esc_html__( 'Title. If it blank the will not have a title', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'transera' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Choose a custom color for title.', 'transera' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number', 'transera' ),
		'param_name'  => 'number',
		'description' => esc_html__( 'Title. If it blank the will not have a number', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Number Color', 'transera' ),
		'param_name'  => 'number_color',
		'description' => esc_html__( 'Choose a custom color for number.', 'transera' ),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Border Color', 'transera' ),
		'param_name'  => 'border_color',
		'description' => esc_html__( 'Choose a custom color for border.', 'transera' ),
	),
	array(
		"type"        => "checkbox",
		"heading"     => esc_html__( "Number Animation?", 'transera' ),
		"param_name"  => "animation",
	),
	array(
		"type"        => "dropdown",
		"heading"     => esc_html__( " Block Alignment", 'transera' ),
		"param_name"  => "alignment",
		'std'         => 'counter-left',
		"value"       => $alignment
	),

);

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'transera' )
	)
);

$vc_options = array_merge( 
	$styles,
	$params,
	$style_options,
	$extra_class
);