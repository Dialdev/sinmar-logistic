<?php if ( ! defined( 'SLZ' ) ) {
    die( 'Forbidden' );
}
$align = array(
	'left'   => esc_html__('Left','transera'),
	'right'  => esc_html__('Right','transera'),
	'center' => esc_html__('Center','transera')
	);

$title_type = array(
	'default'   => esc_html__(' Default','transera'),
	'level'     => esc_html__('Level Title','transera'),
	);

$bg_attachment = array(
	'inherit'   => esc_html__('Inherit','transera'),
	'fixed'     => esc_html__('Fixed','transera'),
	);


 $options = array(
        '404-info' => array(
            'title'   => esc_html__( '404 Settings', 'transera' ),
            'type'    => 'tab',
            'options' => array(
            	'header-box' => array(
                    'title'   => esc_html__( '404 Settings', 'transera' ),
                    'type'    => 'box',
                    'options' => array(
                    	'background-image'	=> array(
							'label'   => esc_html__( 'Illustration Image', 'transera' ),
							'type'    => 'background-image',
							'value'   => 'none',
							'desc'    => esc_html__( 'Upload illustration image.',
								'transera' ),
						),
						'title'      => array(
							'type'  => 'text',
							'label' => esc_html__( 'Title', 'transera' ),
						),
						'description' => array(
						    'type'  => 'wp-editor',
						    'value' => 'default value',
						    'label' => esc_html__('Description', 'transera'),
						    'size' => 'large', // small, large
						    'editor_height' => 200,
						    'wpautop' => true,
						    'editor_type' => false, // tinymce, html
						),
						'btn-text'      => array(
							'type'  => 'text',
							'label' => esc_html__( 'Back To Home Text', 'transera' ),
						),
						'btn-02-text'      => array(
							'type'  => 'text',
							'label' => esc_html__( 'Button 02 Text', 'transera' ),
						),
						'social-link' => array(
							'label' => esc_html__( 'Button Link', 'transera' ),
							'desc'  => esc_html__( 'Enter link for button 02', 'transera' ),
							'type'  => 'text',
						)
                        
                    )
                )
            )
        )
    );
