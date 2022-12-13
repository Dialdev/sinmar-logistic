<?php
$icon_type = SLZ_Params::get('icon-type');

$vc_options = array(
	array(
		'type'           => 'dropdown',
		'heading'        => esc_html__( 'Choose Type of Icon', 'slz' ),
		'param_name'     => 'icon_type',
		'value'          => $icon_type,
		'description'    => esc_html__( 'Choose style to display block.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon library', 'slz' ),
		'value' => array(
			esc_html__( 'Font Awesome', 'slz' ) => 'vs',
			esc_html__( 'Open Iconic', 'slz' ) => 'openiconic',
			esc_html__( 'Typicons', 'slz' ) => 'typicons',
			esc_html__( 'Entypo', 'slz' ) => 'entypo',
			esc_html__( 'Linecons', 'slz' ) => 'linecons',
			esc_html__( 'Mono Social', 'slz' ) => 'monosocial',
		),
		'admin_label' => true,
		'param_name' => 'icon_library',
		'description' => esc_html__( 'Select icon library.', 'slz' ),
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('')
		),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'slz' ),
		'param_name' => 'icon_vs',
		'settings' => array(
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'vs',
		),
		'description' => esc_html__( 'Select icon from library.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'slz' ),
		'param_name' => 'icon_openiconic',
		'settings' => array(
			'type' => 'openiconic',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'openiconic',
		),
		'description' => esc_html__( 'Select icon from library.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'slz' ),
		'param_name' => 'icon_typicons',
		'settings' => array( 
			'type' => 'typicons',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'typicons',
		),
		'description' => esc_html__( 'Select icon from library.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'slz' ),
		'param_name' => 'icon_entypo',
		'settings' => array( 
			'type' => 'entypo',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'entypo',
		),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'slz' ),
		'param_name' => 'icon_linecons',
		'settings' => array(
			'type' => 'linecons',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'linecons',
		),
		'description' => esc_html__( 'Select icon from library.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type' => 'iconpicker',
		'heading' => esc_html__( 'Icon', 'slz' ),
		'param_name' => 'icon_monosocial',
		'settings' => array(
			'type' => 'monosocial',
			'iconsPerPage' => 4000,
		),
		'dependency' => array(
			'element' => 'icon_library',
			'value' => 'monosocial',
		),
		'description' => esc_html__( 'Select icon from library.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Upload Image', 'slz' ),
		'param_name'     => 'img_up',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('02')
		),
		'description'    => esc_html__('Upload Image.', 'slz'),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'slz' ),
		'param_name'  => 'icon_color',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose a custom color for icon.', 'slz' ),
		'group'          => esc_html__( 'Icon Settings', 'slz' )
	),
);

