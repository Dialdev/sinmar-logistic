<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'info_box' );

$params = array(
 
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Show Icon or Image', 'slz' ),
        'param_name'  => 'icon_type',
        'value'       => array(
            esc_html__('Show Icon', 'slz') => '1',
            esc_html__('Show Image', 'slz') => '0'
        ),
        'std'         => '1',
        'description' => esc_html__( 'Show Icon or Show Image', 'slz' )
    ),
   array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon library', 'slz' ),
		'value' => array(
			esc_html__( 'Font Awesome', 'slz' ) => '',
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
			'value'    => array('1')
		),
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
			'value'    => array('')
		),
		'description' => esc_html__( 'Select icon from library.', 'slz' ),
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
	),
    array(
        'type'		 =>	'attach_image',
        'heading'    => esc_html__( 'Image', 'slz' ),
        'param_name' => 'img_up',
        'description' => esc_html__( 'Upload your image', 'slz' ),
        'dependency' => array(
            'element' => 'icon_type',
            'value'   => '0',
        ),
    ),
    array(
        'type'        => 'textarea_html',
        'heading'     => esc_html__( 'Information', 'slz' ),
        'param_name'  => 'content',
        'description' => esc_html__( 'Please input information', 'slz' )
    ),
);

$custom_css = array(
	 array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Icon Color', 'slz' ),
        'param_name'  => 'icon_color',
        'description' => esc_html__( 'Choose a custom color for icon.', 'slz' ),
        'group'       => esc_html__( 'Custom CSS', 'slz'),
        'dependency'  => array(
            'element' => 'icon_type',
            'value'   => array('1'),
        ),
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Information Color', 'slz' ),
        'param_name'  => 'des_color',
        'description' => esc_html__( 'Choose a custom color for information.', 'slz' ),
        'group'       => esc_html__('Custom CSS', 'slz'),
    ),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Background Color', 'slz' ),
		'param_name'  => 'background_color',
		'description' => esc_html__( 'Choose a custom color for background.', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Border Color', 'slz' ),
        'param_name'  => 'border_color',
        'description' => esc_html__( 'Choose a custom color for border.', 'slz' ),
        'group'       => esc_html__( 'Custom CSS', 'slz'),
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
	$params,
	$extra_class,
	$custom_css
);