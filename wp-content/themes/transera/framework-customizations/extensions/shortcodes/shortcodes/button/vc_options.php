<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'button' );

$v_alignment =  array(
	esc_html__('Left', 'transera')   => 'text-l',
	esc_html__('Right', 'transera')  => 'text-r',
	esc_html__('Center', 'transera') => 'text-c'
);

$postion_arr = array(
	esc_html__( 'Right', 'transera' ) => 'right',
	esc_html__( 'Left', 'transera' ) => 'left',
);

$alignment = array(
		array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( ' Button Alignment', 'transera' ),
				'param_name'  => 'alignment',
				'value'       => $v_alignment,
				'std'         => 'text-l',
				'description' => esc_html__( 'Choose alignment for show', 'transera' )
		),
);

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button Layout', 'transera' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'transera' ),
		'edit_field_class'  => 'hidden'
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'transera' ),
		'param_name'  => 'title',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'description' => esc_html__( 'Enter text on button.', 'transera' )
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Button Box Shadow?', 'transera' ),
		'param_name'  => 'box_shadow',
		'description' => esc_html__( 'Add a box-shadow to button', 'transera' ),
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button Link', 'transera' ),
		'param_name'  => 'button_link',
		'value'       => '',
		'description' => esc_html__( 'Choose button link.', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Border Radius', 'transera' ),
		'param_name'  => 'border_radius',
		'value'       => '',
		'description' => esc_html__( 'Unit is px ( ex:50 ).', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Margin Right', 'transera' ),
		'param_name'  => 'margin_right',
		'value'       => '',
		'description' => esc_html__( 'Unit is px ( ex:50 ).', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color', 'transera' ),
		'param_name'  => 'bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom background color.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color Hover', 'transera' ),
		'param_name'  => 'bg_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom background color hover.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color', 'transera' ),
		'param_name'  => 'btn_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for button text.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color Hover', 'transera' ),
		'param_name'  => 'btn_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color hover for button text.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Border Color', 'transera' ),
		'param_name'  => 'btn_border_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom border color for button.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Border Color Hover', 'transera' ),
		'param_name'  => 'btn_border_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom border color hover for button.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	// setting icon
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon library', 'transera' ),
		'value' => array(
			esc_html__( 'Font Awesome', 'transera' ) => 'vs',
			esc_html__( 'Open Iconic', 'transera' ) => 'openiconic',
			esc_html__( 'Typicons', 'transera' ) => 'typicons',
			esc_html__( 'Entypo', 'transera' ) => 'entypo',
			esc_html__( 'Linecons', 'transera' ) => 'linecons',
			esc_html__( 'Mono Social', 'transera' ) => 'monosocial',
		),
		'admin_label' => true,
		'param_name' => 'icon_library',
		'description' => esc_html__( 'Select icon library.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'transera' ),
		'param_name' => 'icon_vs',
		'settings' => array(
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'vs',
		),
		'description' => esc_html__( 'Select icon from library.', 'transera' ),
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'transera' ),
		'param_name' => 'icon_openiconic',
		'settings' => array(
			'type' => 'openiconic',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'openiconic',
		),
		'description' => esc_html__( 'Select icon from library.', 'transera' ),
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'transera' ),
		'param_name' => 'icon_typicons',
		'settings' => array( 
			'type' => 'typicons',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'typicons',
		),
		'description' => esc_html__( 'Select icon from library.', 'transera' ),
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'transera' ),
		'param_name' => 'icon_entypo',
		'settings' => array( 
			'type' => 'entypo',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'entypo',
		),
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'transera' ),
		'param_name' => 'icon_linecons',
		'settings' => array(
			'type' => 'linecons',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'linecons',
		),
		'description' => esc_html__( 'Select icon from library.', 'transera' ),
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'transera' ),
		'param_name' => 'icon_monosocial',
		'settings' => array(
			'type' => 'monosocial',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'monosocial',
		),
		'description' => esc_html__( 'Select icon from library.', 'transera' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Icon Position', 'transera' ),
		'param_name'  => 'icon_position',
		'value'       => $postion_arr,
		'std'       => 'left',
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'description' => esc_html__( 'Select the display position for the icon.', 'transera' ),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'transera' ),
		'param_name'  => 'icon_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for icon.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Color', 'transera' ),
		'param_name'  => 'icon_bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for background of icon.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Hover Color', 'transera' ),
		'param_name'  => 'icon_hv_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for icon when hover.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-1','layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Hover Color', 'transera' ),
		'param_name'  => 'icon_bg_hv_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for background of icon when hover.', 'transera' ),
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-3')
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Upload Image', 'transera' ),
		'param_name'     => 'btn-image',
		'dependency'     => array(
			'element'  => 'layout',
			'value'    => array('layout-2')
		),
		'description'    => esc_html__('Upload one image to make background for button.', 'transera'),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'transera' )
	)
);


$vc_options = array(
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Add New Button', 'transera' ),
		'param_name' => 'btn',
		'params'     => $params,
		'value'       => '',
	),		
);

$vc_options = array_merge( 
	$alignment, $vc_options
);