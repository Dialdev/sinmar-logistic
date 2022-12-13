<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'contact_form' );


$contact_form_arr = array( esc_html__( '-None-', 'slz' ) => '' );
$args = array (
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => -1,
			'status'         => 'publish'
		);
$post_arr = get_posts( $args );
foreach( $post_arr as $post ){
	$title = ( !empty( $post->post_title ) )? $post->post_title : $post->post_name;
	$contact_form_arr[$title] = $post->ID ;
}
	
$params = array(

	array(
		'type'           => 'dropdown',
		'heading'        => esc_html__('Choose Contact Form', 'slz' ),
		'param_name'     => 'ctf',
		'value'          => $contact_form_arr,
		'description'    => esc_html__('Choose contact form to display.', 'slz'),
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Box Shadow?', 'slz' ),
		'param_name'  => 'box_shadow',
		'description' => esc_html__( 'Add a box-shadow to contact form', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Padding Top', 'slz' ),
		'param_name'  => 'padding_top',
		'value'       => '',
		'description' => esc_html__( 'Add padding top for contact form(Unit is px)', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Padding Bottom', 'slz' ),
		'param_name'  => 'padding_bottom',
		'value'       => '',
		'description' => esc_html__( 'Add padding bottom for contact form(Unit is px)', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Padding Right', 'slz' ),
		'param_name'  => 'padding_right',
		'value'       => '',
		'description' => esc_html__( 'Add padding right for contact form(Unit is px)', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Padding Left', 'slz' ),
		'param_name'  => 'padding_left',
		'value'       => '',
		'description' => esc_html__( 'Add padding left for contact form(Unit is px)', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Background Image', 'slz' ),
		'param_name'     => 'bg_image',
		'description'    => esc_html__('Upload an background image for contact form.', 'slz
			'),
	),
	array(
		'type'           => 'colorpicker',
		'heading'        => esc_html__( 'Background Color', 'slz' ),
		'param_name'     => 'bg_color',
		'description'    => esc_html__('Choose background color for contact form.', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color', 'slz' ),
		'param_name'  => 'btn_bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom background color.', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'            => esc_html__('Button Settings','slz') 
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Background Color Hover', 'slz' ),
		'param_name'  => 'btn_bg_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom background color hover.', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'            => esc_html__('Button Settings','slz') 
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color', 'slz' ),
		'param_name'  => 'btn_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color for button text.', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'            => esc_html__('Button Settings','slz') 
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Text Color Hover', 'slz' ),
		'param_name'  => 'btn_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom color hover for button text.', 'slz' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group'            => esc_html__('Button Settings','slz') 
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to image', 'slz' )
	)
);

$vc_options = array_merge(
	$params
);