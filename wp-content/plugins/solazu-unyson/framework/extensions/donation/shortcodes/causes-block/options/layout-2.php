<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'causes_block' );

$vc_options = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Social Share?', 'slz' ),
		'param_name'    => 'show_social_share_2',
		'std'           => 'no',
		'value'         => $shortcode->get_config( 'yes_no' ),
		'group'         => esc_html__( 'Options', 'slz' ),
		'description'   => esc_html__( 'Show or hide social share for cause.', 'slz' )
	),
	array(
		'type'          => 'param_group',
		'heading'       => esc_html__( 'List Of Social to Share', 'slz' ),
		'param_name'    => 'list_social_share_2',
		'params'        => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Choose social to share', 'slz' ),
				'param_name'  => 'social',
				'value'       => $shortcode->get_config('social'),
			)
		),
		'group'         => esc_html__( 'Options', 'slz' ),
		'dependency'    => array(
			'element'   => 'show_social_share_2',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'          => 'dropdown',
		'group'			=> esc_html__( 'Options', 'slz' ),
		'heading'       => esc_html__( 'Show Goal and Raised?', 'slz' ),
		'param_name'    => 'show_goal_raised2',
		'value'         => $shortcode->get_config( 'yes_no' ),
		'std'           => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show pagination.', 'slz' ),
	),
);