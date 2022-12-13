<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'image_carousel' );

$vc_options = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Mobile Image', 'slz' ),
		'param_name'  => 'mobile_img_2',
		'value'       => $shortcode->get_config('yes_no'),
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show mobile image or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Slider', 'slz' )
	),
	array(
		'type'        => 'attach_image',
		'heading'     => esc_html__( 'Upload mobile image', 'slz' ),
		'param_name'  => 'upload_mobile_img_2',
		'value'       => '',
		'group'       => esc_html__( 'Custom Slider', 'slz' ),
		'dependency' => array(
			'element' => 'mobile_img_2',
			'value'   => 'yes',
		),
	),
// 	array(
// 		'type'        => 'dropdown',
// 		'heading'     => esc_html__( 'Arrow', 'slz' ),
// 		'param_name'  => 'arrow_2',
// 		'value'       => $shortcode->get_config('yes_no'),
// 		'std'         => 'yes',
// 		'description' => esc_html__( 'Choose if want to show arrow or not.', 'slz' ),
// 		'group'       => esc_html__( 'Custom Slider', 'slz' )
// 	),
);