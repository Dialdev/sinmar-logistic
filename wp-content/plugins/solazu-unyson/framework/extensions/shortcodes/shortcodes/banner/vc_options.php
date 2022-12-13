<?php
$number = array(
	esc_html__( 'None', 'slz' )   => '',
	esc_html__( 'One', 'slz' )    => '1',
	esc_html__( 'Two', 'slz' )    => '2',
);

$align = array(
	esc_html__('Left', 'slz')    => 'left',
	esc_html__('Right', 'slz')   => 'right',
);
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'banner' );


$styles = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'std'         => '1',
		'description' => esc_html__( 'Choose style to show', 'slz' )
	),
);

$yes_no  = array(
    esc_html__('Yes', 'slz')     => 'yes',
    esc_html__('No', 'slz')	     => 'no'
);

$button = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Number of Button', 'slz' ),
		'value'       => $number,
		'std'         => '',
		'param_name'  => 'number_btn',
		'description' => esc_html__( 'Choose number of button to show', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' )
	),	
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Cover Link', 'slz' ),
		'param_name'  => 'cover_link',
		'value'       => '',
		'description' => esc_html__( 'Please input cover link.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('')
		),
	),
	
	/* button 1 */
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button 1 - Text', 'slz' ),
		'param_name'  => 'button_text_1',
		'description' => esc_html__( 'Please input button text, it will not show button if you not input button text.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 1 - Show Icon', 'slz' ),
		'value'       => $yes_no,
		'std'         => 'no',
		'param_name'  => 'show_icon_1',
		'description' => esc_html__( 'Choose show or hide icon.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	)
);
$icon_dependency = array(
                        'element' => 'show_icon_1',
                        'value'   => array('yes')
                    );
$group = esc_html__( 'Button', 'slz' );
$icon_options = $shortcode->get_icon_library_options( $icon_dependency, $group );
$button_01 = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 1 - Icon Position', 'slz' ),
		'value'       => $align,
		'std'         => 'left',
		'param_name'  => 'icon_align_1',
		'description' => esc_html__( 'Choose position of icon to show on button', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'show_icon_1',
			'value'    => array('yes')
		),
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button 1 - Link', 'slz' ),
		'param_name'  => 'btn_link_1',
		'value'       => '',
		'description' => esc_html__( 'Please input button link.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Text Color', 'slz' ),
		'param_name'  => 'btn_text_color_1',
		'description' => esc_html__( 'Choose a custom color for button text.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Text Hover Color', 'slz' ),
		'param_name'  => 'btn_text_hover_color_1',
		'description' => esc_html__( 'Choose a custom hover color for button text.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Background Color', 'slz' ),
		'param_name'  => 'btn_background_color_1',
		'description' => esc_html__( 'Choose a custom color for button background.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Background Hover Color', 'slz' ),
		'param_name'  => 'btn_background_hover_color_1',
		'description' => esc_html__( 'Choose a custom hover color for button background.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Border Color', 'slz' ),
		'param_name'  => 'btn_border_color_1',
		'description' => esc_html__( 'Choose a custom color for button border.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Border Hover Color', 'slz' ),
		'param_name'  => 'btn_border_hover_color_1',
		'description' => esc_html__( 'Choose a custom hover color for button border.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),

	/* button 2 */
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button 2 - Text', 'slz' ),
		'param_name'  => 'button_text_2',
		'description' => esc_html__( 'Please input button text, it will not show button if you not input button text.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 2 - Show Icon', 'slz' ),
		'value'       => $yes_no,
		'std'         => 'no',
		'param_name'  => 'show_icon_2',
		'description' => esc_html__( 'Choose show or hide icon.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	)
);
$icon_dependency_02 = array(
                        'element' => 'show_icon_2',
                        'value'   => array('yes')
                    );
$icon_option_02 = $shortcode->get_icon_library_options( $icon_dependency_02, $group, '_2' );
$button_02 = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 2 - Icon Position', 'slz' ),
		'value'       => $align,
		'std'         => 'left',
		'param_name'  => 'icon_align_2',
		'description' => esc_html__( 'Choose position of icon to show on button', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'show_icon_2',
			'value'    => array('yes')
		),
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button 2 - Link', 'slz' ),
		'param_name'  => 'btn_link_2',
		'value'       => '',
		'description' => esc_html__( 'Please input button link.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Text Color', 'slz' ),
		'param_name'  => 'btn_text_color_2',
		'description' => esc_html__( 'Choose a custom color for button text.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Text Hover Color', 'slz' ),
		'param_name'  => 'btn_text_hover_color_2',
		'description' => esc_html__( 'Choose a custom hover color for button text.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Background Color', 'slz' ),
		'param_name'  => 'btn_background_color_2',
		'description' => esc_html__( 'Choose a custom color for button background.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Background Hover Color', 'slz' ),
		'param_name'  => 'btn_background_hover_color_2',
		'description' => esc_html__( 'Choose a custom hover color for button background.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Border Color', 'slz' ),
		'param_name'  => 'btn_border_color_2',
		'description' => esc_html__( 'Choose a custom color for button border.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Border Hover Color', 'slz' ),
		'param_name'  => 'btn_border_hover_color_2',
		'description' => esc_html__( 'Choose a custom hover color for button border.', 'slz' ),
		'group'       => esc_html__( 'Button', 'slz' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
);


$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'slz' ),
		'param_name'  => 'title',
		'description' => esc_html__( 'Title. If it blank the will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Choose a custom color for title.', 'slz' ),
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Banner Image', 'slz' ),
		'param_name'     => 'ads_img',
		'description'    => esc_html__('Choose a banner adsvertisement image to upload.', 'slz'),
	),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Background Color', 'slz' ),
        'param_name'  => 'background_color',
        'description' => esc_html__( 'Choose a custom background color.', 'slz' ),
    ),
	array(
		'type'        => 'textarea_html',
		'heading'     => esc_html__( 'Description', 'slz' ),
		'param_name'  => 'content',
		'value'       => '',
		'description' => esc_html__( 'Subtitle . If it blank will not have a description', 'slz' )
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
	$styles,
	$params,
	$button,
	$icon_options,
	$button_01,
	$icon_option_02,
	$button_02,
	$extra_class
);