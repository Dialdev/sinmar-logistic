<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'featured_list' );

$column_arr = array(
	esc_html__( 'None', 'slz' )  => '',
	esc_html__('One', 'slz')     => '1',
	esc_html__('Two', 'slz')     => '2',
	esc_html__('Three', 'slz')   => '3',
	esc_html__('Four', 'slz')    => '4'
);

$yes_no  = array(
    esc_html__('Yes', 'slz')     => 'yes',
    esc_html__('No', 'slz')	     => 'no'
);

$param_title =  array(
			array(
				'type'           => 'textarea',
				'heading'        => esc_html__( 'Text', 'slz' ),
				'param_name'     => 'text',
				'admin_label'    => true,
				'description'    => esc_html__( 'Please input text of item', 'slz' )
			),
			array(
				'type'           => 'dropdown',
				'heading'        => esc_html__( 'Options', 'slz' ),
				'param_name'     => 'show_options',
				'value'          => $shortcode->get_config('show_options'),
				'std'            => 'icon'
			)
		);
$icon_dependency = array(
                    'element'    => 'show_options',
                    'value'      => array('icon')
                );
$icon_options = $shortcode->get_icon_library_options( $icon_dependency );

$param_image =  array(
			array(
				'type'           => 'attach_image',
				'heading'        => esc_html__( 'Upload Image', 'slz' ),
				'param_name'     => 'image',
				'description'    => esc_html__('Upload Image.', 'slz'),
				'dependency'     => array(
					'element'    => 'show_options',
					'value'      => array('image')
				)
			)
		);

$params = array(
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Style', 'slz' ),
    	'admin_label' => true,
        'param_name'  => 'styles',
        'value'       => $shortcode->get_config( 'styles' ),
        'std'         => 'style-1',
        'description' => esc_html__( 'Choose style of feature list', 'slz' )
    ),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'value'       => $column_arr,
		'std'         => '',
		'description' => esc_html__( 'Choose number of columns to show', 'slz' )
	),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Show number ? ', 'slz' ),
        'param_name'  => 'show_number',
        'value'       => $yes_no,
        'std'         => 'yes',
        'dependency'  => array(
            'element' => 'styles',
            'value'   => array('style-2'),
        ),
        'description' => esc_html__( 'If choose Yes, block will show number.', 'slz' )
    ),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Featured Items', 'slz' ),
		'param_name'  => 'feature_list',
		'params'      => array_merge( $param_title, $icon_options, $param_image ),
		'value'       => '',
        'dependency'  => array(
            'element' => 'styles',
            'value'   => array('style-1')
        )
	),
    array(
        'type'        => 'param_group',
        'heading'     => esc_html__( 'List of Feature', 'slz' ),
        'param_name'  => 'feature_list2',
        'params'      => array(
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Title', 'slz' ),
                'param_name'  => 'title',
                'description' => esc_html__( 'Please input title of item', 'slz' )
            ),
            array(
                'type'        => 'textarea',
                'heading'     => esc_html__( 'Description', 'slz' ),
                'param_name'  => 'description',
                'description' => esc_html__( 'Please input description of item', 'slz' )
            )
        ),
        'value'       => '',
        'dependency'  => array(
            'element' => 'styles',
            'value'   => array('style-2')
        )
    )
);

$custom_css = array(
	 array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Number Color', 'slz' ),
        'group'       => esc_html__('Custom CSS', 'slz'),
        'param_name'  => 'number_color',
        'description' => esc_html__( 'Choose a custom color for number.', 'slz' ),
        'dependency'  => array(
            'element' => 'show_number',
            'value'   => array('yes')
        )
    ),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Text Color', 'slz' ),
		'param_name'  => 'text_color',
		'description' => esc_html__( 'Choose a custom color for text.', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Description Color', 'slz' ),
        'param_name'  => 'des_color',
        'description' => esc_html__( 'Choose a custom color for description.', 'slz' ),
        'group'       => esc_html__('Custom CSS', 'slz'),
        'dependency'  => array(
            'element' => 'styles',
            'value'   => array('style-2')
        )
    ),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Background Color', 'slz' ),
		'param_name'  => 'background_color',
		'description' => esc_html__( 'Choose a custom color for background.', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Border Color', 'slz' ),
        'param_name'  => 'border_color',
        'description' => esc_html__( 'Choose a custom color for border.', 'slz' ),
        'group'       => esc_html__( 'Custom CSS', 'slz')
    ),
	array(
		'type'        => 'attach_image',
		'heading'     => esc_html__( 'Background Image', 'slz' ),
		'param_name'  => 'background_img',
		'description' => esc_html__('Background Image.', 'slz'),
		'group'       => esc_html__('Custom CSS', 'slz')
	)
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