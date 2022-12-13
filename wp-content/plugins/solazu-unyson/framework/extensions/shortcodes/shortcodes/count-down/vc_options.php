<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'count_down' );
$params = array(
    array(
        'type'            => 'datetime_picker',
        'heading'         => esc_html__( 'Time Release', 'slz' ),
        'param_name'      => 'date',
        'description'     => esc_html__( 'Enter Time Release',  'slz'  ),
    ),
    array(
        'type'            => 'colorpicker',     
        'heading'         => esc_html__( 'Items Background Color', 'slz' ),
        'param_name'      => 'bg_color',
        'value'           => '',
        'description'     => esc_html__( 'Select background color for items.', 'slz' ),
        'group'           => esc_html__('Customs Css', 'slz'),
    ),
    array(
        'type'            => 'colorpicker',     
        'heading'         => esc_html__( 'Number Color', 'slz' ),
        'param_name'      => 'number_color',
        'value'           => '',
        'description'     => esc_html__( 'Select color for number.', 'slz' ),
        'group'           => esc_html__('Customs Css', 'slz'),
    ),
    array(
        'type'            => 'colorpicker',     
        'heading'         => esc_html__( 'Title Color', 'slz' ),
        'param_name'      => 'title_color',
        'value'           => '',
        'description'     => esc_html__( 'Select color for text under number.', 'slz' ),
       'group'           => esc_html__('Customs Css', 'slz'),
    ),
    array(
        'type'            => 'colorpicker',     
        'heading'         => esc_html__( 'Colon Color', 'slz' ),
        'param_name'      => 'colon_color',
        'value'           => '',
        'description'     => esc_html__( 'Select color for colon.', 'slz' ),
        'group'           => esc_html__('Customs Css', 'slz'),
    ),
    array(
        'type'          => 'textfield',
        'heading'       => esc_html__( 'Extra Class', 'slz' ),
        'param_name'    => 'extra_class',
        'description'   => esc_html__( 'Enter extra class name.', 'slz' )
    ),
    array(
        'type'            => 'colorpicker',     
        'heading'         => esc_html__( 'Animation Color', 'slz' ),
        'param_name'      => 'animation_color',
        'value'           => '',
        'description'     => esc_html__( 'Select color for Animation.', 'slz' ),
        'group'           => esc_html__('Customs Css', 'slz'),
    ),
);

$vc_options = array_merge( 
	$params
);