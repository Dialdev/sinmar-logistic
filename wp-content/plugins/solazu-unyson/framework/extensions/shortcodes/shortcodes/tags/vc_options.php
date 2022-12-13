<?php
$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'slz' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number', 'slz' ),
		'param_name'  => 'number',
		'value'       => '5',
		'description' => esc_html__( 'Please input number of tags to show', 'slz' )
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

$custom_css = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Tag - Text Color', 'slz' ),
		'param_name'  => 'tag_text_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for tag text.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Tag - Text Hover Color', 'slz' ),
		'param_name'  => 'tag_text_hover_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for tag text hover.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Tag - Background Color', 'slz' ),
		'param_name'  => 'tag_bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for tag background.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Tag - Background Hover Color', 'slz' ),
		'param_name'  => 'tag_bg_hover_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for tag background hover.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' )
	),
);

$vc_options = array_merge( 
	$params,
	$extra_class,
	$custom_css
);