<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'icon_box' );

$icon_type = SLZ_Params::get('icon-type');
$icon_type_no_img = SLZ_Params::get('icon-type-no-img');

$style_view = array(
	esc_html__('Horizontal', 'transera')  => '',
	esc_html__('Vertical', 'transera')  => '1',
);
$style1_custom = array(
	esc_html__( '1 image or 1 Icon', 'transera' ) => '',
	esc_html__( 'Multi image and Icon', 'transera' ) => '1'
);
$column_arr = array(
	esc_html__( 'None', 'transera' )  => '',
	esc_html__('One', 'transera')     => '1',
	esc_html__('Two', 'transera')     => '2',
	esc_html__('Three', 'transera')   => '3',
	esc_html__('Four', 'transera')    => '4',
);


$styles = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'transera' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'transera' ),
        'edit_field_class' => 'hidden',
	),

);

$columns = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'transera' ),
		'param_name'  => 'column',
		'value'       => $column_arr,
		'std'         => '',
		'description' => esc_html__( 'Choose number of columns to show', 'transera' )
	),
);

$params = $shortcode->get_layout_options();

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'transera' )
	)
);

$title = array(
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Title', 'transera' ),
        'param_name'  => 'title',
        'value'       => '',
        'description' => esc_html__( 'Title. If it blank the will not have a title', 'transera' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Title Color', 'transera' ),
        'param_name'  => 'title_color',
        'value'       => '',
        'description' => esc_html__( 'Choose a custom title text color.', 'transera' )
    ),
);

$vc_options = array_merge(
    $title,
	$styles,
	$columns,
	$params,
	$extra_class
);