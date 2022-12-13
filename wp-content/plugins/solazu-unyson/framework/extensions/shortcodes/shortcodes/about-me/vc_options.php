<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'about_me' );
$icon_options = $shortcode->get_icon_library_options();

$icon_options[] = array(
        'type'        => 'vc_link',
        'heading'     => esc_html__( 'Social URL (Link)', 'slz' ),
        'param_name'  => 'link',
        'description' => esc_html__( 'Add link to social network.', 'slz' )
    );

$layout = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'slz' )
	)
);

$params = array(
	array(
		'type'		 =>	'textfield',
		'heading'    => esc_html__( 'Block title', 'slz' ),
		'param_name' => 'block_title',
		'description' => esc_html__( 'Enter block title.', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
	),
	array(
		'type'		 =>	'textfield',
		'heading'    => esc_html__( 'Name', 'slz' ),
		'param_name' => 'name',
		'description' => esc_html__( 'Enter your name.', 'slz' )
	),
	array(
		'type'		 =>	'attach_image',
		'heading'    => esc_html__( 'Avatar', 'slz' ),
		'param_name' => 'avatar',
		'description' => esc_html__( 'Upload your avatar (100x100px).', 'slz' )
	),
	array(
		'type'		 =>	'textarea',
		'heading'    => esc_html__( 'Detail', 'slz' ),
		'param_name' => 'detail',
		'description' => esc_html__( 'Introduce yourself.', 'slz' )
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Social Profile', 'slz' ),
		'param_name' => 'social',
		'params'     => $icon_options
	),
	array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Extra class name', 'slz' ),
		'param_name' => 'extra_class',
		'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'slz' )
	)
);

$vc_options = array_merge(
	$layout,
	$params
);