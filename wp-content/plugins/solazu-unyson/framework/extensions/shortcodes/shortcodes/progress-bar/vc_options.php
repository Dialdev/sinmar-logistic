<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'progress_bar' );

$styles = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'admin_label'    => true,
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'slz' )
	),
);

$style_options = $shortcode->get_layout_options();


$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Unit', 'slz' ),
		'param_name'  => 'unit',
		'value'       => '%',
		'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'slz' )
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
	$styles,
	$style_options,
	$extra_class
);
