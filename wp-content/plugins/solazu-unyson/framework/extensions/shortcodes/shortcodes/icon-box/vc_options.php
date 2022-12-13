<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'icon_box' );

$icon_type = SLZ_Params::get('icon-type');
$icon_type_no_img = SLZ_Params::get('icon-type-no-img');

$animation =  SLZ_Params::get('animation');
$delay_time = array(
	esc_html__( '0.5 s', 'flexi' )  => '0.5s',
	esc_html__( '1 s', 'flexi' )    => '1s',
	esc_html__( '1.5 s', 'flexi' )  => '1.5s',
	esc_html__( '2 s', 'flexi' )    => '2s',
);

$style_view = array(
	esc_html__('Horizontal', 'slz')  => '',
	esc_html__('Vertical', 'slz')  => '1',
);
$style1_custom = array(
	esc_html__( '1 image or 1 Icon', 'slz' ) => '',
	esc_html__( 'Multi image and Icon', 'slz' ) => '1'
);
$column_arr = array(
	esc_html__( 'None', 'slz' )  => '',
	esc_html__('One', 'slz')     => '1',
	esc_html__('Two', 'slz')     => '2',
	esc_html__('Three', 'slz')   => '3',
	esc_html__('Four', 'slz')    => '4',
);

$styles = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Items Animation', 'flexi' ),
		'param_name'  => 'item_animation',
		'value'       => $animation,
		'description' => esc_html__( 'Add animation for items', 'flexi' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Delay Time', 'flexi' ),
		'param_name'  => 'delay_animation',
		'value'       => $delay_time,
		'description' => esc_html__( 'Choose delay time for animation', 'flexi' )
	),
);

$columns = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'value'       => $column_arr,
		'std'         => '',
		'description' => esc_html__( 'Choose number of columns to show', 'slz' )
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Show Numerical Order?', 'slz' ),
		'param_name'  => 'show_number',
		'description' => esc_html__( 'Displays the number order of each item', 'slz' ),
	),
);

$params = $shortcode->get_layout_options();

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	)
);

$title = array(
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Title', 'slz' ),
        'param_name'  => 'title',
        'value'       => '',
        'description' => esc_html__( 'Title. If it blank the will not have a title', 'slz' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Title Color', 'slz' ),
        'param_name'  => 'title_color',
        'value'       => '',
        'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
    ),
);

$vc_options = array_merge(
	$title,
    $styles,
	$columns,
	$params,
	$extra_class
);