<?php

$icon_type = array(
	esc_html__( 'Visual Composer', 'transera' )  => '',
	esc_html__('Image Upload', 'transera')       => '02',
);
$params = array(
	array(
		'type'           => 'dropdown',
		'heading'        => esc_html__( 'Choose Type of Icon', 'transera' ),
		'param_name'     => 'icon_type',
		'value'          => $icon_type,
		'description'    => esc_html__( 'Choose style to display block.', 'transera' )
	),
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
			'element'  => 'icon_type',
			'value'    => array('')
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
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'transera' ),
		'param_name'  => 'icon_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon color.', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Hover Color', 'transera' ),
		'param_name'  => 'icon_hv_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon hover color.', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Color', 'transera' ),
		'param_name'  => 'icon_bg_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon background color.', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Hover Color', 'transera' ),
		'param_name'  => 'icon_bg_hv_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon background hover color.', 'transera' )
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Upload Image', 'transera' ),
		'param_name'     => 'img_up',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('02')
		),
		'description'    => esc_html__('Upload Image.', 'transera'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Image Hover Color', 'transera' ),
		'param_name'  => 'image_hv_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('02')
		),
		'description' => esc_html__( 'Choose background color for image when hover.', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'transera' ),
		'admin_label'    => true,
		'param_name'  => 'title',
		'value'       => '',
		'description' => esc_html__( 'Title. If it blank the block will not have a title', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'transera' ),
		'param_name'  => 'title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'transera' )
	),
	array(
		'type'        => 'textarea',
		'heading'     => esc_html__( 'Description', 'transera' ),
		'param_name'  => 'des',
		'value'       => '',
		'description' => esc_html__( 'Description. If it blank the block will not have a title', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Description Color', 'transera' ),
		'param_name'  => 'des_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom description text color.', 'transera' )
	),

	/* button */
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'transera' ),
		'param_name'  => 'button_text',
		'value'       => '',
		'description' => esc_html__( 'Button Text. If it blank the block will not have a button', 'transera' ),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color', 'transera' ),
		'param_name'  => 'button_text_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom button text color.', 'transera' ),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color', 'transera' ),
		'param_name'  => 'button_background_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom button background color.', 'transera' ),
	),

	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button Link', 'transera' ),
		'param_name'  => 'button_link',
		'value'       => '',
		'description' => esc_html__( 'Please input button link and button info.', 'transera' ),
	),
);

$vc_options = array(
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Icon Box - Items', 'transera' ),
		'param_name' => 'icon_box_2',
		'params'     => $params,
		'value'       => '',
		'description' => esc_html__( 'List of icon box', 'transera' ),
	),
);