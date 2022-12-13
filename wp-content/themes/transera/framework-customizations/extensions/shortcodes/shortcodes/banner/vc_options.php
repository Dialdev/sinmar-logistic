<?php
$number = array(
	esc_html__( 'None', 'transera' )   => '',
	esc_html__( 'One', 'transera' )    => '1',
	esc_html__( 'Two', 'transera' )    => '2',
);

$align = array(
	esc_html__('Left', 'transera')    => 'left',
	esc_html__('Right', 'transera')   => 'right',
);
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'banner' );

$icon_type = array(
	esc_html__('No Show Icon', 'transera')  => 'none',
	esc_html__('Font Awsome', 'transera')   => 'font_awsome',
);

$button = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Number of Button', 'transera' ),
		'value'       => $number,
		'std'         => '',
		'param_name'  => 'number_btn',
		'description' => esc_html__( 'Choose number of button to show', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' )
	),	
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Cover Link', 'transera' ),
		'param_name'  => 'cover_link',
		'value'       => '',
		'description' => esc_html__( 'Please input cover link.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('')
		),
	),
	
	/* button 1 */
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button 1 - Text', 'transera' ),
		'param_name'  => 'button_text_1',
		'description' => esc_html__( 'Please input button text, it will not show button if you not input button text.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 1 - Icon Type', 'transera' ),
		'value'       => $icon_type,
		'std'         => 'none',
		'param_name'  => 'icon_type_1',
		'description' => esc_html__( 'Choose icon type.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'           => 'iconpicker',
		'heading'        => esc_html__( 'Choose Icon', 'transera' ),
		'param_name'     => 'icon_fontawsome_1',
		'description'    => esc_html__( 'Choose icon to display.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'icon_type_1',
			'value'    => array('font_awsome')
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 1 - Icon Position', 'transera' ),
		'value'       => $align,
		'std'         => 'left',
		'param_name'  => 'icon_align_1',
		'description' => esc_html__( 'Choose position of icon to show on button', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'icon_type_1',
			'value'    => array('font_awsome', 'flaticon')
		),
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button 1 - Link', 'transera' ),
		'param_name'  => 'btn_link_1',
		'value'       => '',
		'description' => esc_html__( 'Please input button link.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Text Color', 'transera' ),
		'param_name'  => 'btn_text_color_1',
		'description' => esc_html__( 'Choose a custom color for button text.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Text Hover Color', 'transera' ),
		'param_name'  => 'btn_text_hover_color_1',
		'description' => esc_html__( 'Choose a custom hover color for button text.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Background Color', 'transera' ),
		'param_name'  => 'btn_background_color_1',
		'description' => esc_html__( 'Choose a custom color for button background.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Background Hover Color', 'transera' ),
		'param_name'  => 'btn_background_hover_color_1',
		'description' => esc_html__( 'Choose a custom hover color for button background.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Border Color', 'transera' ),
		'param_name'  => 'btn_border_color_1',
		'description' => esc_html__( 'Choose a custom color for button border.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 1 - Border Hover Color', 'transera' ),
		'param_name'  => 'btn_border_hover_color_1',
		'description' => esc_html__( 'Choose a custom hover color for button border.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('1', '2')
		),
	),

	/* button 2 */
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button 2 - Text', 'transera' ),
		'param_name'  => 'button_text_2',
		'description' => esc_html__( 'Please input button text, it will not show button if you not input button text.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 2 - Icon Type', 'transera' ),
		'value'       => $icon_type,
		'std'         => 'none',
		'param_name'  => 'icon_type_2',
		'description' => esc_html__( 'Choose icon type.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'           => 'iconpicker',
		'heading'        => esc_html__( 'Choose Icon', 'transera' ),
		'param_name'     => 'icon_fontawsome_2',
		'description'    => esc_html__( 'Choose icon to display.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'icon_type_2',
			'value'    => array('font_awsome')
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Button 2 - Icon Position', 'transera' ),
		'value'       => $align,
		'std'         => 'left',
		'param_name'  => 'icon_align_2',
		'description' => esc_html__( 'Choose position of icon to show on button', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'icon_type_2',
			'value'    => array('font_awsome','flaticon')
		),
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button 2 - Link', 'transera' ),
		'param_name'  => 'btn_link_2',
		'value'       => '',
		'description' => esc_html__( 'Please input button link.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Text Color', 'transera' ),
		'param_name'  => 'btn_text_color_2',
		'description' => esc_html__( 'Choose a custom color for button text.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Text Hover Color', 'transera' ),
		'param_name'  => 'btn_text_hover_color_2',
		'description' => esc_html__( 'Choose a custom hover color for button text.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Background Color', 'transera' ),
		'param_name'  => 'btn_background_color_2',
		'description' => esc_html__( 'Choose a custom color for button background.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Background Hover Color', 'transera' ),
		'param_name'  => 'btn_background_hover_color_2',
		'description' => esc_html__( 'Choose a custom hover color for button background.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Border Color', 'transera' ),
		'param_name'  => 'btn_border_color_2',
		'description' => esc_html__( 'Choose a custom color for button border.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button 2 - Border Hover Color', 'transera' ),
		'param_name'  => 'btn_border_hover_color_2',
		'description' => esc_html__( 'Choose a custom hover color for button border.', 'transera' ),
		'group'       => esc_html__( 'Button', 'transera' ),
		'dependency'     => array(
			'element'  => 'number_btn',
			'value'    => array('2')
		),
	),
);


$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'transera' ),
		'param_name'  => 'title',
		'description' => esc_html__( 'Title. If it blank the will not have a title', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'transera' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Choose a custom color for title.', 'transera' ),
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Banner Image', 'transera' ),
		'param_name'     => 'ads_img',
		'description'    => esc_html__('Choose a banner adsvertisement image to upload.', 'transera'),
	),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Background Color', 'transera' ),
        'param_name'  => 'background_color',
        'description' => esc_html__( 'Choose a custom background color.', 'transera' ),
    ),
	array(
		'type'        => 'textarea_html',
		'heading'     => esc_html__( 'Description', 'transera' ),
		'param_name'  => 'content',
		'value'       => '',
		'description' => esc_html__( 'Subtitle . If it blank will not have a description', 'transera' )
	),
);

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'transera' )
	)
);

$vc_options = array_merge(
	$params,
	$button,
	$extra_class
);