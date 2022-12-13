<?php

$style1_custom = array(
	esc_html__( '1 image or 1 Icon', 'transera' ) => '',
	esc_html__( 'Image with Effect', 'transera' ) => '1'
);

$style_layout_1 = array(
    esc_html__('Style 1', 'transera') => '1',
    esc_html__('Style 2', 'transera') => '2',
    esc_html__('Style 3', 'transera') => '3',
    esc_html__('Style 4', 'transera') => '4',
);

$align = array(
	esc_html__('Center', 'transera')    => 'center',
	esc_html__('Left', 'transera')      => 'left',
	esc_html__('Right', 'transera')     => 'right',
);

$icon_type = SLZ_Params::get('icon-type');

$icon_type_no_img = SLZ_Params::get('icon-type-no-img');

$icon_type = array(
	esc_html__( 'Visual Composer', 'transera' )  => '',
	esc_html__('Image Upload', 'transera')       => '02',
);

$general_params = array(

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

$params = array_merge( array(

	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Align', 'transera' ),
		'param_name'  => 'align',
		'value'       => $align,
		'std'         => 'center',
		'description' => esc_html__( 'Choose position of icon box', 'transera' ),
	),
	// setting icon
	array(
		'type'           => 'dropdown',
		'heading'        => esc_html__( 'Choose Type of Icon', 'transera' ),
		'param_name'     => 'icon_type',
		'value'          => $icon_type,
		'description'    => esc_html__( 'Choose style to display block.', 'transera' ),
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
			'value'    => array('')
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
			'value'    => array('')
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
			'value'    => array('')
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
			'value'    => array('')
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
        'description'    => esc_html__('Upload image.', 'transera'),
    ),
	// end setting icon

), $general_params);

$images_params =array_merge(array(
    array(
        'type'           => 'attach_image',
        'heading'        => esc_html__( 'Upload Image', 'transera' ),
        'param_name'     => 'img_up_custom_1',
        'description'    => esc_html__('Upload image.', 'transera'),
    ),
    array(
        'type'           => 'attach_image',
        'heading'        => esc_html__( 'Upload Hover Image', 'transera' ),
        'param_name'     => 'img_up_custom_2',
        'description'    => esc_html__('Upload hover image.', 'transera'),
    ),
), $general_params);

$vc_options = array(
    array(
        'type'           => 'dropdown',
        'heading'        => esc_html__( 'Choose Style to display', 'transera' ),
        'param_name'     => 'style_layout_1',
        'value'          => $style_layout_1,
        'description'    => esc_html__( 'Choose style to display.', 'transera' )
    ),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Icon Box - Items', 'transera' ),
		'param_name' => 'icon_box',
		'params'     => $params,
		'value'       => '',
		'description' => esc_html__( 'List of icon box', 'transera' ),
	),
);