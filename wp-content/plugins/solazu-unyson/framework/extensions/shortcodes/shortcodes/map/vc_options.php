<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'map' );
$param_title = array(
					array(
						'type'           => 'textfield',
						'heading'        => esc_html__( 'Title', 'slz' ),
						'param_name'     => 'title',
						'description'    => esc_html__( 'Enter title for this session.', 'slz' )
					)
				);
$icon_options = $shortcode->get_icon_library_options();
$param_more_title = array(
						array(
							'type'           => 'textfield',
							'heading'        => esc_html__( 'Contact Information', 'slz' ),
							'param_name'     => 'more_title'
						)
					);
$param_address = array(
					array(
						'type'           => 'textfield',
						'heading'        => esc_html__( 'Address', 'slz' ),
						'param_name'     => 'address',
						'description'    => esc_html__( 'Enter Address.', 'slz' )
					),
					array(
						'type'            => 'param_group',
						'heading'         => esc_html__( 'Add New Information', 'slz' ),
						'param_name'      => 'array_info_item',	
						'params'          => array_merge( $icon_options, $param_more_title )
					)
				);
$params = array(
	//group contact info
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Add New Place', 'slz' ),
		'param_name'      => 'array_info',
		'params'          => array_merge( $param_title, $icon_options, $param_address )
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Show Block Information?', 'slz' ),
		'param_name'  => 'show_block_info',
		'description' => esc_html__( 'Show/Hide block information next to map.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Contact Form ID', 'slz' ),
		'param_name'  => 'contact_form',
		'value'       => '',
		'description' => esc_html__( 'Add shortcode id of contact form 7 plugin', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Map Height', 'slz' ),
		'param_name'  => 'map_height',
		'value'       => '',
		'description' => esc_html__( 'Unit is px (ex:200)', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'slz' )
	),
	array(
		"type"        => "attach_image",
		"heading"     => esc_html__( 'Map Marker Image', 'slz' ),
		"param_name"  => "map_marker",
		'value'       => '',
		'group'       => esc_html__( 'Map Setting', 'slz')
	),
	array(
		'type'           => 'textfield',
		'heading'        => esc_html__( 'Zoom', 'slz' ),
		'param_name'     => 'zoom',
		'value'          => '11',
		'description'    => esc_html__( 'Enter zoom number of map. Number between 0 (farthest) and 22 that sets the zoom level of the map.', 'slz' ),
		'group'       => esc_html__( 'Map Setting', 'slz')
	),	
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Title Color', 'slz' ),
		'param_name'      => 'title_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select color for title.', 'slz' )
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Information  Color', 'slz' ),
		'param_name'      => 'info_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select color for contact information.', 'slz' )
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Block Border Color', 'slz' ),
		'param_name'      => 'border_color',
		'value'           => '',
		'group'           => esc_html__( 'Custom Css', 'slz'),
		'description'     => esc_html__( 'Select color for horizontal separator betwen items.', 'slz' )
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