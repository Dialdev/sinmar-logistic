<?php if ( ! defined( 'SLZ' ) ) {
    die( 'Forbidden' );
}

$header_ext = slz_ext('headers');

if ( $header_ext != null )
{
    $options = array(
        'custom_styles_tab' => array(
            'title'   => esc_html__( 'Custom Styles', 'transera' ),
            'type'    => 'tab',
            'options' => array(
                'custom_styles' => array(
                    'type'  => 'code-editor',
                    'mode'  =>  'css',
                    'label' => esc_html__('Custom Styles', 'transera'),
                    'desc'  => esc_html__('Custom Styles changes that will be applied to the theme', 'transera'),
                )
            )
        )
    );
}
