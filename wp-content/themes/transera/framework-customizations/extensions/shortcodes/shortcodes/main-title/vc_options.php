<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'main_title' );

$align = SLZ_Params::get('align');

$style = array();
if( $style_cfg = $shortcode->get_styles() ) {
    $style = array(
        array(
            'type'        => 'dropdown',
            'admin_label' => true,
            'heading'     => esc_html__( 'Style', 'transera' ),
            'param_name'  => 'style',
            'value'       => $style_cfg ,
            'std'         => 'style-1',
            'description' => esc_html__( 'Choose style to display.', 'transera' )
        ),
    );
}
$params = array(
    array(
        'type'        => 'textfield',
        'admin_label' => true,
        'heading'     => esc_html__( 'Title', 'transera' ),
        'param_name'  => 'title',
        'description' => esc_html__( 'Title. If it blank the will not have a title', 'transera' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Title Color', 'transera' ),
        'param_name'  => 'title_color',
        'description' => esc_html__( 'Choose a custom color for title.', 'transera' ),
        'group'       => esc_html__('Custom Options', 'transera'),
    ),
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Sub Title', 'transera' ),
        'param_name'  => 'subtitle',
        'value'       => '',
        'description' => esc_html__( 'Subtitle . If it blank will not have a subtitle', 'transera' ),
        'dependency' => array(
            'element' => 'style',
            'value' => 'style-1',
        ),
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Align', 'transera' ),
        'param_name'  => 'align',
        'value'       => $align ,
        'std'         => 'left',
        'description' => esc_html__( 'Block title align', 'transera' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Sub Title Color', 'transera' ),
        'param_name'  => 'subtitle_color',
        'value'       => '',
        'description' => esc_html__( 'Choose a custom color for sub title.', 'transera' ),
        'group'       => esc_html__('Custom Options', 'transera'),
        'dependency' => array(
            'element' => 'style',
            'value' => 'style-1',
        ),
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Show Icon/Image', 'transera' ),
        'param_name'  => 'show_icon',
        'value'       => array(
            esc_html__('None', 'transera') => '2',
            esc_html__('Show Icon', 'transera') => '1',
            esc_html__('Show Image', 'transera') => '0'
        ),
        'description' => esc_html__( 'Show Icon/Image Above Title', 'transera' )
    ),
    array(
        'type' => 'iconpicker',
        'heading' => esc_html__( 'Icon', 'transera' ),
        'param_name' => 'icon_fontawesome',
        'settings' => array(
            'iconsPerPage' => 4000,
        ),
        'dependency' => array(
            'element' => 'show_icon',
            'value' => '1',
        ),
        'description' => esc_html__( 'Select icon from library.', 'transera' ),
    ),
    array(
        'type'       => 'attach_image',
        'heading'    => esc_html__( 'Image', 'transera' ),
        'param_name' => 'image',
        'description' => esc_html__( 'Upload your image', 'transera' ),
        'dependency' => array(
            'element' => 'show_icon',
            'value' => '0',
        ),
    ),
    array(
        'type'        => 'css_editor',
        'heading'     => esc_html__( 'CSS box', 'transera' ),
        'param_name'  => 'css',
        'group'       => esc_html__( 'Design Options', 'transera' ),
    ),
);

$extra_class = array(
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Extra Class', 'transera' ),
        'param_name'  => 'extra_class',
        'value'       => '',
        'description' => esc_html__( 'Add extra class to button', 'transera' )
    )
);

$vc_options = array_merge(
    $style,
    $params,
    $extra_class
);