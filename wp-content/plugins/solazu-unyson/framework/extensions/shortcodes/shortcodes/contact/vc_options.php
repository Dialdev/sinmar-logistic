<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'contact' );

$column = array(
    esc_html__( 'One', 'slz' )   => '1',
    esc_html__( 'Two', 'slz' )   => '2',
    esc_html__( 'Three', 'slz' ) => '3',
    esc_html__( 'Four', 'slz' )  => '4'
);

$param_info = array(
                array(
                    'type'           => 'textarea',
                    'heading'        => esc_html__( 'Title', 'slz' ),
                    'param_name'     => 'title',
                	'admin_label'    => true,
                    'description'    => esc_html__( 'Enter title for main information.', 'slz' )
                )
            );

$param_sub_info = array(
                array(
                    'type'           => 'textarea',
                    'heading'        => esc_html__( 'Title', 'slz' ),
                    'param_name'     => 'sub_info',
                	'admin_label'    => true,
                    'description'    => esc_html__( 'Enter title for sub information', 'slz' )
                )
            );
$icon_options = $shortcode->get_icon_library_options();

$params = array(
    array(
        'type'            => 'dropdown',
        'heading'         => esc_html__( 'Column', 'slz' ),
        'param_name'      => 'column',
        'value'           => $column,
        'std'             => '3',
        'description'     => esc_html__( 'Choose number of column for this contact.', 'slz' )
    ),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Add Contact Info', 'slz' ),
		'param_name'      => 'array_info',
		'params'          => array(
            array(
                'type'            => 'param_group',
                'heading'         => esc_html__( 'Main Information', 'slz' ),
                'param_name'      => 'array_info_item',
                'params'          => array_merge( $param_info, $icon_options )
            ),
            array(
                'type'            => 'param_group',
                'heading'         => esc_html__( 'Sub Information', 'slz' ),
                'param_name'      => 'array_sub_info_item',
                'params'          => array_merge( $param_sub_info, $icon_options )
            ),
            array(
                'type'        => 'textarea',
                'heading'     => esc_html__( 'Description', 'slz' ),
                'param_name'  => 'description',
                'value'       => '',
                'description' => esc_html__( 'Add description for block', 'slz' )
            )
		)
	),
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Extra Class', 'slz' ),
        'param_name'  => 'extra_class',
        'value'       => '',
        'description' => esc_html__( 'Add extra class for block', 'slz' )
    ),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Main Info Color', 'slz' ),
		'param_name'      => 'title_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select color for main information.', 'slz' )
	),
    array(
        'type'            => 'colorpicker',
        'heading'         => esc_html__( 'Main Info Background Color', 'slz' ),
        'param_name'      => 'main_bg_color',
        'value'           => '',
        'group'           => esc_html__( 'Custom Css', 'slz'),
        'description'     => esc_html__( 'Select background color for main information.', 'slz' )
    ),
    array(
        'type'            => 'colorpicker',
        'heading'         => esc_html__( 'Main Info Icon Color', 'slz' ),
        'param_name'      => 'main_icon_color',
        'value'           => '',
        'group'           => esc_html__( 'Custom Css', 'slz'),
        'description'     => esc_html__( 'Select color for main information icon.', 'slz' )
    ),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Sub Info Color', 'slz' ),
		'param_name'      => 'info_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select color for sub information.', 'slz' )
	),
    array(
        'type'            => 'colorpicker',
        'heading'         => esc_html__( 'Sub Info Icon Color', 'slz' ),
        'param_name'      => 'sub_icon_color',
        'value'           => '',
        'group'           => esc_html__( 'Custom Css', 'slz'),
        'description'     => esc_html__( 'Select color for sub information icon.', 'slz' )
    ),
    array(
        'type'            => 'colorpicker',
        'heading'         => esc_html__( 'Description Color', 'slz' ),
        'param_name'      => 'des_color',
        'value'           => '',
        'group'           => esc_html__( 'Custom Css', 'slz'),
        'description'     => esc_html__( 'Select color for description.', 'slz' )
    ),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Block Border Color', 'slz' ),
		'param_name'      => 'border_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select color for vertical separator between items..', 'slz' )
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Block Background Color', 'slz' ),
		'param_name'      => 'bg_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select background color for block.', 'slz' )
	)
);

$vc_options = array_merge( 
	$params
);