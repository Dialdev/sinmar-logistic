<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'video' );

$video_type = array(
	esc_html__('Youtube', 'slz')         => 'youtube',
	esc_html__('Vimeo', 'slz')           => 'vimeo'
);

$align = array(
    esc_html__( 'Left', 'slz' )      => 'text-l',
    esc_html__( 'Right', 'slz' )      => 'text-r',
    esc_html__( 'Center', 'slz' )      => 'text-c',
);

$styles = array(
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Style', 'slz' ),
        'param_name'  => 'style',
        'value'       => $shortcode->get_styles(),
        'std'         => 'style-1',
        'description' => esc_html__( 'Choose style to show', 'slz' )
    ),
);

$params = array(
    array(
        'type'           => 'attach_image',
        'heading'        => esc_html__( 'Add Video Background Image', 'slz' ),
        'param_name'     => 'image_video',
        'value'          => '',
        'description'    => esc_html__( 'Choose background image to add.', 'slz' )
    ),
    array(
        'type'           => 'textfield',
        'heading'        => esc_html__( 'Video height', 'slz' ),
        'param_name'     => 'height',
        'value'          => '',
        'description'    => esc_html__( 'Set height for video. Example: 75% - means video height by 75% video width.', 'slz' )
    ),
    array(
        'type'           => 'textfield',
        'heading'        => esc_html__( 'Video Title', 'slz' ),
        'param_name'     => 'title',
        'value'          => '',
        'description'    => esc_html__( 'Set title for video.', 'slz' )
    ),
    array(
        'type'        => 'textarea_html',
        'heading'     => esc_html__( 'Description', 'slz' ),
        'param_name'  => 'content',
        'value'       => '',
        'description' => esc_html__( 'Description for this video.', 'slz' )
    ),
    array(
        'type'           => 'dropdown',
        'heading'        => esc_html__( 'Video Type', 'slz' ),
        'param_name'     => 'video_type',
        'value'          => $video_type,
        'description'    => esc_html__( 'Choose Type of Video.', 'slz' )
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Align', 'slz' ),
        'param_name'  => 'align',
        'value'       => $align,
        'std'         => 'text-l',
        'description' => esc_html__( 'Choose align for video box', 'slz' )
    ),
    array(
        'type'           => 'textfield',
        'heading'        => esc_html__( 'Youtube ID', 'slz' ),
        'param_name'     => 'id_youtube',
        'value'          => '',
        'description'    => esc_html__( 'Example: the Video ID for https://www.youtube.com/watch?v=PDWvcsTloJo is ', 'slz' )
            .'<strong>PDWvcsTloJo</strong>',
        'dependency'     => array(
            'element'    => 'video_type',
            'value'      => array( 'youtube' )
        )
    ),
    array(
        'type'           => 'textfield',
        'heading'        => esc_html__( 'Vimeo ID', 'slz' ),
        'param_name'     => 'id_vimeo',
        'value'          => '',
        'description'    => esc_html__( 'Example: the Video ID for https://vimeo.com/162913890 is ', 'slz' ) . '<strong>162913890</strong>',
        'dependency'     => array(
            'element'    => 'video_type',
            'value'      => array( 'vimeo' )
        )
    ),
    array(
        'type'           => 'textfield',
        'heading'        => esc_html__( 'Extra Class', 'slz' ),
        'param_name'     => 'extra_class',
        'value'          => '',
        'description'    => esc_html__( 'Enter extra class name.', 'slz' )
    )
);

$vc_options = array_merge( $styles, $params );