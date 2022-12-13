<?php if ( ! defined( 'SLZ' ) ) {
    die( 'Forbidden' );
}
$title_type = array(
	'default'    => esc_html__(' Default','transera'),
	'title'      => esc_html__(' Post Title','transera'),
	'level'      => esc_html__(' Category','transera'),
	'custom'     => esc_html__(' Custom','transera'),
);
if( is_admin() ) {
	$screen = get_current_screen();
	if($screen && $screen->post_type == 'page' ) {
		$title_type = array(
			'default'    => esc_html__(' Default','transera'),
			'title'      => esc_html__(' Page Title','transera'),
			'custom'     => esc_html__(' Custom','transera'),
		);
	}
}
$options = array(
	'page-title' => array(
		'title'   => esc_html__( 'Page Header', 'transera' ),
		'type'    => 'tab',
		'options' => array(
			'pagetitle-options'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'enable-page-option' => array(
						'type'         => 'switch',
						'value'        => 'disable',
						'label'        => esc_html__( 'Default Setting', 'transera' ),
						'left-choice'  => array(
							'value' => 'disable',
							'label' => esc_html__( 'Default', 'transera' ),
						),
						'right-choice' => array(
							'value' => 'enable',
							'label' => esc_html__( 'Custom', 'transera' ),
						)
					),
				),
				'choices'      => array(
					'enable' => array(
						'group-pagetitle'   => array(
							'type'         => 'multi-picker',
							'label'        => false,
							'desc'         => false,
							'picker'       => array(
								'enable-page-title' => array(
									'type'         => 'switch',
									'value'        => 'enable',
									'label'        => esc_html__( 'Page Header Area', 'transera' ),
									'left-choice'  => array(
										'value' => 'disable',
										'label' => esc_html__( 'Disable', 'transera' ),
									),
									'right-choice' => array(
										'value' => 'enable',
										'label' => esc_html__( 'Enable', 'transera' ),
										
									)
								),
							),
							'choices'      => array(
								'enable' => array(
									'bg-image'   => array(
										'type'         => 'multi-picker',
										'label'        => false,
										'desc'         => false,
										'picker'       => array(
											'bg-image-type'	=> array(
												'type'  => 'radio',
												'value' => 'upload-image',
												'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
												'label' => esc_html__('Background Image', 'transera'),
												'choices' => array(
													'upload-image' => esc_html__('Upload Image', 'transera'),
													'feature-image' => esc_html__('Featured Image', 'transera'),
												),
												'inline' => true,
											),
										),
										'choices'      => array(
											'upload-image' => array(
												'background-image'	=> array(
													'label'   => esc_html__( 'Image', 'transera' ),
													'type'    => 'background-image',
													'value'   => 'none',
													'desc'    => esc_html__( 'Upload an image to make background image',
														'transera' ),
			
												),
											)
										),
									),
									'height'        => array(
										'type'  => 'short-text',
										'label' => esc_html__( 'Page Header Height', 'transera' ),
										'desc'  => esc_html__( 'Enter heigth in pixels. Ex:80 ', 'transera' ),
										'value' => '30',
									),
									'enable-pt-title' => array(
										'type'         => 'switch',
										'value'        => 'enable',
										'label'        => esc_html__( 'Title On Page Header', 'transera' ),
										'left-choice'  => array(
											'value' => 'disable',
											'label' => esc_html__( 'Disable', 'transera' ),
										),
										'right-choice' => array(
											'value' => 'enable',
											'label' => esc_html__( 'Enable', 'transera' ),
										)
									),
									'type-of-title'	=>	array(
										'type'         => 'multi-picker',
										'label'        => false,
										'desc'         => false,
										'picker'       => array(
											'title-type' => array(
												'type'  => 'radio',
												'value' => '',
												'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
												'label' => esc_html__('Choose Title', 'transera'),
												'choices' => $title_type,
												'desc'    => esc_html__( 'Choose title to display in page header. To get setting from "Theme Setting", choose "Default"','transera' ),
												'inline' => true,
											),
										),
										'choices'      => array(
											'custom' => array(
												'custom-title' => array(
													'label'   => esc_html__( 'Custom Title', 'transera' ),
													'type'    => 'text',
													'value'   => '',
													'desc'    => esc_html__( 'Enter custom title to display in page header', 'transera' ),
												),
											)
										),
									),
									'enable-pt-breadcrumb' => array(
										'type'         => 'switch',
										'value'        => 'enable',
										'label'        => esc_html__( 'Breadcrumb On Page Header', 'transera' ),
										'left-choice'  => array(
											'value' => 'disable',
											'label' => esc_html__( 'Disable', 'transera' ),
										),
										'right-choice' => array(
											'value' => 'enable',
											'label' => esc_html__( 'Enable', 'transera' ),
										)
									),
								),
							),
						),
					),
				),
				'show_borders' => true,
			),
		)
	),
);