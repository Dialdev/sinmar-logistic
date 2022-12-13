<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'material-download' );

$vc_options = array(
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Block Title', 'slz' ),
        'param_name'  => 'title',
        'value'       => '',
        'description' => esc_html__( 'Material Download title. If it blank the block will not have a title', 'slz' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Block Title Color', 'slz' ),
        'param_name'  => 'title_color',
        'value'       => '',
        'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
    ),
    array(
        'type'           => 'attach_files',
        'heading'        => esc_html__( 'Upload Downloaded File', 'slz' ),
        'param_name'     => 'files',
        'description'    => esc_html__('Select file for downloading.', 'slz'),
    ),
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Extra Class', 'slz' ),
        'param_name'  => 'extra_class',
        'value'       => '',
        'description' => esc_html__( 'Add extra class to block', 'slz' )
    )
);

