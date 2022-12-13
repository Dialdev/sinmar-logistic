<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'tabs' );
$tab_align = array(
	esc_html__( 'Align Left', 'slz' ) => 'text-l',
	esc_html__( 'Align Center', 'slz' ) => 'text-c',
	esc_html__( 'Align Right', 'slz' ) => 'text-r'
); 
$attributes = 
	array(
	'type'        => 'attach_image',
	'heading'     => esc_html__( ' Add Image', 'slz' ),
	'param_name'  => 'image',
	'value'       => '',
	'dependency' => array(
		'element' => 'add_icon',
		'value_not_equal_to'   => 'true',
	),
	'description' => esc_html__( 'Add an image to show on tab.', 'slz' ), 
);

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	vc_add_param( 'vc_tta_section', $attributes );
	vc_remove_param( 'vc_tta_section', 'el_class' );
	vc_remove_param( 'vc_tta_section', 'i_position' );
}


$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'style',
		'std'         => 'style-1',
		'value'       => $shortcode->get_styles(),
		'description' => esc_html__( 'Choose style for tab.', 'slz'  ),
	),
	array(
		'type'		  => 'dropdown',
		'heading'	  => esc_html__( 'Tab Align', 'slz' ),
		'param_name'	  => 'tab_align',
		'value'		  => $tab_align,
		'description' 	  => esc_html__( 'Choose tab align for tab.', 'slz' )	
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Tab Color', 'slz' ),
		'param_name'  => 'tab_text_color',
		'value'       => '',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'       => esc_html__('Custom Css', 'slz'),
		'description' => esc_html__( 'Choose a custom tab text color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Tab Active Color', 'slz' ),
		'param_name'  => 'tab_active_text_color',
		'value'       => '',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'       => esc_html__('Custom Css', 'slz'),
		'description' => esc_html__( 'Choose a custom active tab text color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'slz' ),
		'param_name'  => 'icon_color',
		'value'       => '',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'       => esc_html__('Custom Css', 'slz'),
		'description' => esc_html__( 'Choose icon color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Hover Color', 'slz' ),
		'param_name'  => 'icon_hv_color',
		'value'       => '',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'       => esc_html__('Custom Css', 'slz'),
		'description' => esc_html__( 'Choose icon hover color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Color', 'slz' ),
		'param_name'  => 'icon_bg_color',
		'value'       => '',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'       => esc_html__('Custom Css', 'slz'),
		'description' => esc_html__( 'Choose icon background color.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Background Hover Color', 'slz' ),
		'param_name'  => 'icon_bg_hv_color',
		'value'       => '',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'       => esc_html__('Custom Css', 'slz'),
		'description' => esc_html__( 'Choose icon background hover color.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'description' => esc_html__( 'Please enter your extra class.', 'slz' ),
	),
);

$vc_options = $params;