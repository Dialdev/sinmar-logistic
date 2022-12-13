<?php

$icon_type = array(
	esc_html__( 'Visual Composer', 'slz' )  => '',
	esc_html__('Image Upload', 'slz')       => '02'
);
$params = array(
	array(
		'type'           => 'dropdown',
		'heading'        => esc_html__( 'Choose Type of Icon', 'slz' ),
		'param_name'     => 'icon_type',
		'value'          => $icon_type,
		'description'    => esc_html__( 'Choose style to display block.', 'slz' )
	)
);
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'icon_box' );
$icon_dependency = array(
                        'element' => 'icon_type',
                        'value'   => array('')
                    );
$icon_options = $shortcode->get_icon_library_options( $icon_dependency );

$params_02 = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'slz' ),
		'param_name'  => 'icon_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Hover Color', 'slz' ),
		'param_name'  => 'icon_hv_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon hover color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Color', 'slz' ),
		'param_name'  => 'icon_bg_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon background color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Hover Color', 'slz' ),
		'param_name'  => 'icon_bg_hv_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('','03')
		),
		'description' => esc_html__( 'Choose icon background hover color.', 'slz' )
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Upload Image', 'slz' ),
		'param_name'     => 'img_up',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('02')
		),
		'description'    => esc_html__('Upload Image.', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Image Hover Color', 'slz' ),
		'param_name'  => 'image_hv_color',
		'value'       => '',
		'dependency'     => array(
			'element'  => 'icon_type',
			'value'    => array('02')
		),
		'description' => esc_html__( 'Choose background color for image when hover.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'slz' ),
		'admin_label'    => true,
		'param_name'  => 'title',
		'value'       => '',
		'description' => esc_html__( 'Title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
	),
	array(
		'type'        => 'textarea',
		'heading'     => esc_html__( 'Description', 'slz' ),
		'param_name'  => 'des',
		'value'       => '',
		'description' => esc_html__( 'Description. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Description Color', 'slz' ),
		'param_name'  => 'des_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom description text color.', 'slz' )
	),

	/* button */
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'slz' ),
		'param_name'  => 'button_text',
		'value'       => '',
		'description' => esc_html__( 'Button Text. If it blank the block will not have a button', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color', 'slz' ),
		'param_name'  => 'button_text_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom button text color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color', 'slz' ),
		'param_name'  => 'button_background_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom button background color.', 'slz' )
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button Link', 'slz' ),
		'param_name'  => 'button_link',
		'value'       => '',
		'description' => esc_html__( 'Please input button link and button info.', 'slz' )
	)
);

$vc_options = array(
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Icon Box - Items', 'slz' ),
		'param_name'  => 'icon_box_2',
		'params'      => array_merge( $params, $icon_options, $params_02 ),
		'value'       => '',
		'description' => esc_html__( 'List of icon box', 'slz' ),
	),
);