<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'counterv2' );

$alignment =  array(
	esc_html__('Left', 'slz')   => 'counter-left',
	esc_html__('Right', 'slz')  => 'counter-right',
	esc_html__('Center', 'slz') => 'counter-center'
);
$icon_type = array(
	esc_html__( 'Visual Composer', 'slz' )  => '',
	esc_html__( 'Image Upload', 'slz' )     => '02'
);
$column_arr = array(
	esc_html__( 'None', 'slz' )    => '',
	esc_html__( 'One', 'slz' )     => '1',
	esc_html__( 'Two', 'slz' )     => '2',
	esc_html__( 'Three', 'slz' )   => '3',
	esc_html__( 'Four', 'slz' )    => '4'
);
$styles = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose style to show', 'slz' )
	)
);

$style_options = $shortcode->get_layout_options();

$params_group = array(
	array(
		'type'        => 'textfield',
		'admin_label' => true,
		'heading'     => esc_html__( 'Title', 'slz' ),
		'param_name'  => 'title',
		'description' => esc_html__( 'Title. If it blank the will not have a title', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'admin_label' => true,
		'heading'     => esc_html__( 'Number', 'slz' ),
		'param_name'  => 'number',
		'description' => esc_html__( 'Title. If it blank the will not have a number', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Suffix', 'slz' ),
		'param_name'  => 'suffix',
		'description' => esc_html__( 'Add suffix for number', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Choose Type of Icon', 'slz' ),
		'param_name'  => 'icon_type',
		'value'       => $icon_type,
		'description' => esc_html__( 'Choose style to display block.', 'slz' )
	)
);
$icon_dependency = array(
			'element'  => 'icon_type',
			'value'    => array('')
		);
$icon_options = $shortcode->get_icon_library_options( $icon_dependency );
$params_image = array(	
	array(
		'type'         => 'attach_image',
		'heading'      => esc_html__( 'Upload Image', 'slz' ),
		'param_name'   => 'img_up',
		'dependency'   => array(
			'element'  => 'icon_type',
			'value'    => array('02')
		),
		'description'  => esc_html__('Upload Image.', 'slz')
	)
);

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'value'       => $column_arr,
		'std'         => '',
		'description' => esc_html__( 'Choose number of columns to show', 'slz' )
	),
	array(
		"type"        => "dropdown",
		"heading"     => esc_html__( "Block Alignment", 'slz' ),
		"param_name"  => "alignment",
		'std'         => 'counter-center',
		"value"       => $alignment
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Counter Items', 'slz' ),
		'param_name'  => 'counter_items',
		'params'      => array_merge( $params_group, $icon_options, $params_image ),
		'description' => esc_html__( 'List of counter items', 'slz' )
	),
	array(
		"type"        => "checkbox",
		"heading"     => esc_html__( "Number Animation?", 'slz' ),
		"param_name"  => "animation",
		'group'       => esc_html__( 'Custom Options', 'slz' )
	),
	array(
		"type"        => "checkbox",
		"heading"     => esc_html__( "Show Number Line?", 'slz' ),
		"param_name"  => "show_line",
		'description' => esc_html__( 'Show line under number', 'slz' ),
		'group'       => esc_html__( 'Custom Options', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Choose custom color for title.', 'slz' ),
		'group'       => esc_html__( 'Custom Options', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Number Color', 'slz' ),
		'param_name'  => 'number_color',
		'description' => esc_html__( 'Choose custom color for number.', 'slz' ),
		'group'       => esc_html__( 'Custom Options', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'slz' ),
		'param_name'  => 'icon_color',
		'description' => esc_html__( 'Choose custom color for icon.', 'slz' ),
		'group'       => esc_html__( 'Custom Options', 'slz' )
	),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Icon Background Color', 'slz' ),
        'param_name'  => 'icon_bg_color',
        'description' => esc_html__( 'Choose custom background color for icon.', 'slz' ),
        'group'       => esc_html__( 'Custom Options', 'slz' )
    ),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Line Color', 'slz' ),
		'param_name'  => 'line_color',
		'description' => esc_html__( 'Choose line custom color.', 'slz' ),
		'dependency'     => array(
			'element'  => 'show_line',
			'value'    => 'true'
		),
		'group'       => esc_html__( 'Custom Options', 'slz' )
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