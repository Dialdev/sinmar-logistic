<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
$default = array(
	'default'   => array(
		'small' => array(
			'height' => 70,
			'src'    => TRANSERA_OPTION_IMG_URI . '/default.png'
		),
		'large' => array(
			'height' => 214,
			'src'    => TRANSERA_OPTION_IMG_URI . '/default.png'
		),
	)
);
$regist_sidebars = array_merge( array( 'default' => esc_html__('-- Default --', 'transera') ), SLZ_Com::get_regist_sidebars() );

// revolution slider
$revolution_sliders = slz_extra_get_revolution_slider();

$page_header = slz()->theme->get_options( 'page-options' );

// custom color
$site_default_colors = (array)slz()->theme->get_config('site_default_colors');
$site_custom_colors = (array) slz()->theme->get_config('site_custom_colors');
foreach( $site_custom_colors as $key => $variant ){
	$site_options[$key] = array(
		'label'   => $variant[1],
		'desc'    => $variant[2],
		'value'   => $variant[0],
		'choices' => $site_default_colors,
		'type'    => 'color-palette'
	);
}

$options = array(
	'page-settings'=> array(
		'type'    => 'box',
		'title'   => esc_html__(' Page Options','transera' ),
		'options' => array(
			'page-general-settings' => array(
				'title'   => esc_html__( 'General Settings', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'page-header-style' => array(
						'label'   => esc_html__( 'Header Style', 'transera' ),
						'type'    => 'image-picker',
						'attr'    => array('class' => 'slz-image-picker-max-width' ),
						'choices' => array_merge( $default, slz_ext('headers')->get_header_choices() ),
						'value'   => 'default'
					),
					'page-logo' => array(
						'type'        => 'upload',
						'label'       => esc_html__('Logo Image', 'transera'),
						'desc'        => esc_html__('Upload the site logo .png or .jpg', 'transera'),
						'images_only' => true,
					),
					'page-logo-transparent'   => array(
						'type'   => 'multi-picker',
						'label'  => false,
						'desc'   => false,
						'picker' => array(
							'logo_transparent_options' => array(
								'type'  => 'switch',
								'value' => 'disable',
								'label' => esc_html__( 'Logo Transparent', 'transera' ),
								'left-choice' => array(
									'value' => 'enable',
									'label' => esc_html__( 'Enable', 'transera' ),
								),
								'right-choice' => array(
									'value' => 'disable',
									'label' => esc_html__( 'Disable', 'transera' ),
								)
							),
						),
						'choices' => array(
							'enable' => array(
								'logo-transparent'	=>	array(
									'type'        => 'upload',
									'label'       => esc_html__('Logo Image Transparent', 'transera'),
									'desc'        => esc_html__('Upload the site logo .png or .jpg use for transparent', 'transera'),
									'images_only' => true,
								),
							),
						),
					),
					'page-slider'  => array(
						'type'     => 'select',
						'label'    => esc_html__('Revolution Slider', 'transera'),
						'desc'     => esc_html__('You can add revolution slider in header.','transera'),
						'choices'  => $revolution_sliders ,
						'value'    => ''
					),
					'page-footer-style' => array(
						'label'   => esc_html__( 'Footer Style', 'transera' ),
						'type'    => 'image-picker',
						'attr'    => array('class' => 'slz-image-picker-max-width' ),
						'choices' => array_merge( $default, slz_ext('footers')->get_footer_choices() ),
						'value'   => 'default'
					),
					'page-sidebar-layout' => array(
						'label' => esc_html__( 'Sidebar Layout', 'transera' ),
						'desc'  => esc_html__( 'Set how to display page sidebar.', 'transera' ),
						'type'  => 'image-picker',
						'attr'  => array('class' => 'slz-image-picker-max-width' ),
						'choices' => array_merge( $default, array(
							'left' => array(
								'small' => array(
									'height' => 50,
									'src'    => TRANSERA_OPTION_IMG_URI . '/sidebar/left.png'
								)
							),
							'right' => array(
								'small' => array(
									'height' => 50,
									'src'    => TRANSERA_OPTION_IMG_URI . '/sidebar/right.png'
								)
							),
							'none' => array(
								'small' => array(
									'height' => 50,
									'src'    => TRANSERA_OPTION_IMG_URI . '/sidebar/full.png'
								)
							),
						) ),
						'value' => 'default'
					),
					'page-sidebar' => array(
						'type'    => 'select',
						'label'   => esc_html__('Choose Sidebar', 'transera'),
						'desc'    => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
						'choices' => $regist_sidebars,
						'value'   => 'default'
					),
					'ct-padding-top' => array(
						'type'  => 'text',
						'label' => esc_html__( 'Content Padding Top', 'transera' ),
						'desc'  => esc_html__( 'Custom padding top for content (px).', 'transera' ),
						'value' => '',
					),
					'ct-padding-bottom' => array(
						'type'  => 'text',
						'label' => esc_html__( 'Content Padding Bottom', 'transera' ),
						'desc'  => esc_html__( 'Custom padding bottom for content (px).', 'transera' ),
						'value' => '',
					),
					'styling-skin-colors' => array(
						'type'         => 'multi-picker',
						'label'        => false,
						'desc'         => false,
						'picker'       => array(
							'custom-style' => array(
								'type'         => 'switch',
								'value'        => 'default',
								'label'        => esc_html__( 'Custom Colors', 'transera' ),
								'left-choice'  => array(
									'value' => 'default',
									'label' => esc_html__( 'Default', 'transera' ),
								),
								'right-choice' => array(
									'value' => 'custom',
									'label' => esc_html__( 'Custom', 'transera' ),
								),
							),
						),
						'choices'      => array(
							'custom' => $site_options,
						),
					),
				)
			),
			$page_header,
		)
	)
);