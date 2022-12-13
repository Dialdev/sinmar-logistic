<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'button' );

$v_alignment =  array(
	esc_html__('Left', 'slz')   => 'text-l',
	esc_html__('Right', 'slz')  => 'text-r',
	esc_html__('Center', 'slz') => 'text-c'
);

$postion_arr = array(
	esc_html__( 'Right', 'slz' ) => 'right',
	esc_html__( 'Left', 'slz' )  => 'left'
);

$alignment = array(
	array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( ' Button Alignment', 'slz' ),
        'param_name'  => 'alignment',
        'value'       => $v_alignment,
        'std'         => 'text-l',
        'description' => esc_html__( 'Choose alignment for show', 'slz' )
    )
);

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'slz' ),
		'param_name'  => 'title',
		'value'       => '',
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'description' => esc_html__( 'Enter text on button.', 'slz' )
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Button Box Shadow?', 'slz' ),
		'param_name'  => 'box_shadow',
		'description' => esc_html__( 'Add a box-shadow to button', 'slz' )
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button Link', 'slz' ),
		'param_name'  => 'button_link',
		'value'       => '',
		'description' => esc_html__( 'Choose button link.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Border Radius', 'slz' ),
		'param_name'  => 'border_radius',
		'value'       => '',
		'description' => esc_html__( 'Unit is px ( ex:50 ).', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Margin Right', 'slz' ),
		'param_name'  => 'margin_right',
		'value'       => '',
		'description' => esc_html__( 'Unit is px ( ex:50 ).', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color', 'slz' ),
		'param_name'  => 'bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom background color.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color Hover', 'slz' ),
		'param_name'  => 'bg_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom background color hover.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color', 'slz' ),
		'param_name'  => 'btn_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for button text.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color Hover', 'slz' ),
		'param_name'  => 'btn_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color hover for button text.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Border Color', 'slz' ),
		'param_name'  => 'btn_border_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom border color for button.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Border Color Hover', 'slz' ),
		'param_name'  => 'btn_border_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom border color hover for button.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	)
);
$icon_dependency = array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		);
$icon_options = $shortcode->get_icon_library_options( $icon_dependency );
$params_02 = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Icon Position', 'slz' ),
		'param_name'  => 'icon_position',
		'value'       => $postion_arr,
		'std'         => 'left',
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'description' => esc_html__( 'Select the display position for the icon.', 'slz' )
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Icon Box Shadow?', 'slz' ),
		'param_name'  => 'icon_box_shadow',
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'description' => esc_html__( 'Add a box-shadow to icon of button', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'slz' ),
		'param_name'  => 'icon_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for icon.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Color', 'slz' ),
		'param_name'  => 'icon_bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for background of icon.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Hover Color', 'slz' ),
		'param_name'  => 'icon_hv_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for icon when hover.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Hover Color', 'slz' ),
		'param_name'  => 'icon_bg_hv_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for background of icon when hover.', 'slz' ),
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column'
	),
	array(
		'type'        => 'attach_image',
		'heading'     => esc_html__( 'Upload Image', 'slz' ),
		'param_name'  => 'btn-image',
		'dependency'  => array(
			'element'  => 'layout',
			'value'    => array('layout-2')
		),
		'description' => esc_html__('Upload one image to make background for button.', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'slz' )
	)
);


$vc_options = array(
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Add New Button', 'slz' ),
		'param_name' => 'btn',
		'params'     => array_merge( $params, $icon_options, $params_02 ),
		'value'      => ''
	),
);

$vc_options = array_merge(
	$alignment, $vc_options
);
