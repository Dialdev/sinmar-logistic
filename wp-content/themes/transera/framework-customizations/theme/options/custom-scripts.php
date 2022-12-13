<?php if ( ! defined( 'SLZ' ) ) {
    die( 'Forbidden' );
}

$header_ext = slz_ext('headers');

if ( $header_ext != null )
{
    $options = array(
        'custom_scripts_tab' => array(
            'title'   => esc_html__( 'Custom Scripts', 'transera' ),
            'type'    => 'tab',
            'options' => array(
                'custom_scripts' => array(
                    'type'  => 'code-editor',
                    'mode'  =>  'javascript',
                    'label' => esc_html__('Custom Scripts', 'transera'),
                    'desc'  => esc_html__('Custom Scripts changes that will be applied to the theme', 'transera'),
                )
            )
        )
    );
}
