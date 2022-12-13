<?php if ( ! defined( 'SLZ' ) ) {
    die( 'Forbidden' );
}

$header_ext = slz_ext('headers');

if ( $header_ext != null )
{
    $options = array(
        'header_tab' => array(
            'title'   => esc_html__( 'Header', 'transera' ),
            'type'    => 'tab',
            'options' => array(
                'header-box' => array(
                    'title'   => esc_html__( 'Header Settings', 'transera' ),
                    'type'    => 'box',
                    'options' => array(
                        'slz-header-style-group' => array(
                            'type'         => 'multi-picker',
                            'label'        => false,
                            'desc'         => false,
                            'picker'       => array(
                                'slz-header-style' => array(
                                    'label' => esc_html__( 'Header Style', 'transera' ),
                                    'type'    => 'image-picker',
                                    'choices' => $header_ext->get_header_choices(),
                                    'value'   => SLZ_Com::get_first( $header_ext->get_header_choices() ),
                                )
                            ),
                            'choices'      => $header_ext->get_header_options(),
                            'show_borders' => true,
                        )
                    )
                )
            )
        )
    );
}
