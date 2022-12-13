<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'newsletter' );
$yes_no = array(
	esc_html__('Yes', 'slz')  => 'yes',
	esc_html__('No', 'slz')   => 'no',
);

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

$params = array(
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Title', 'slz' ),
		'value'			=> '',
		'param_name'    => 'title',
		'description'   => esc_html__( 'Please input title if want to show.', 'slz' ),
	),
	array(
		'type'          => 'textarea',
		'heading'       => esc_html__( 'Description', 'slz' ),
		'value'			=> '',
		'param_name'    => 'description',
		'description'   => esc_html__( 'Please input descripton if want to show.', 'slz' ),
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Input Name?', 'slz' ),
		'value'			=> $yes_no,
		'std'           => 'yes',
		'param_name'    => 'show_input_name',
		'description'   => esc_html__( 'Choose if want to show input name.', 'slz' ),
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Name Input Place Holder', 'slz' ),
		'value'			=> esc_html( 'Name', 'slz' ),
		'param_name'    => 'input_name_placeholder',
		'description'   => esc_html__( 'Enter place holder for input', 'slz' ),
		'dependency' => array(
			'element'   => 'show_input_name',
			'value'     => 'yes',
		),
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Email Input Place Holder', 'slz' ),
		'value'			=> esc_html( 'Email Address', 'slz' ),
		'param_name'    => 'input_email_placeholder',
		'description'   => esc_html__( 'Enter place holder for input', 'slz' ),
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Text Button Submit', 'slz' ),
		'value'			=> esc_html( 'Get Notified', 'slz' ),
		'param_name'    => 'button_text',
		'description'   => esc_html__( 'Enter text for button submit.', 'slz' ),
	),
);

$extra_class = array(
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Extra Class', 'slz' ),
		'param_name'    => 'extra_class',
		'description'   => esc_html__( 'Enter extra class name.', 'slz' ),
	),
);

$custom_css = array(
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Title Color', 'slz' ),
		'param_name'      => 'title_color',
		'description'     => esc_html__( 'Choose color for title.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Description Color', 'slz' ),
		'param_name'      => 'description_color',
		'description'     => esc_html__( 'Choose color for description.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Input Text Color', 'slz' ),
		'param_name'      => 'color_input',
		'description'     => esc_html__( 'Choose color for input text.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Text Color', 'slz' ),
		'param_name'      => 'color_button',
		'description'     => esc_html__( 'Choose color for button.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Text Color Hover', 'slz' ),
		'param_name'      => 'color_button_hv',
		'description'     => esc_html__( 'Choose color for button when hover.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Background Color', 'slz' ),
		'param_name'      => 'color_button_bg',
		'description'     => esc_html__( 'Choose background color for button.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Background Color Hover', 'slz' ),
		'param_name'      => 'color_button_bg_hv',
		'description'     => esc_html__( 'Choose background color for button when hover.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Border Color', 'slz' ),
		'param_name'      => 'color_button_border',
		'description'     => esc_html__( 'Choose border color for button.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Border Color Hover', 'slz' ),
		'param_name'      => 'color_button_border_hv',
		'description'     => esc_html__( 'Choose border color for button when hover.', 'slz' ),
		'group'           => esc_html__('Custom CSS', 'slz'),
	),
);

$vc_options = array_merge( 
	$styles,
	$params,
	$extra_class,
	$custom_css
);