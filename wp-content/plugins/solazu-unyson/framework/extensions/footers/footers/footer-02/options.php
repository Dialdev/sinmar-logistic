<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$palette_color = SLZ_Com::get_palette_color();

$regist_sidebars = array_merge( array( '' => esc_html__('-- Select widget area --', 'slz') ), SLZ_Com::get_regist_sidebars() );

$regist_menu = array( 'default' => esc_html__('-- Select Menu --', 'slz') ) + SLZ_Com::get_regist_menu();

$menu_locations = get_nav_menu_locations();

$footer_style = array(
	''          => esc_html__('Light','slz'),
	'slz-dark'  => esc_html__('Dark','slz')
);

$options = array(
	'top-box' => array(
	    'type' => 'box',
	    'title' => esc_html__('Footer Top Settings', 'slz'),
	    'options' => array(
	        'footer-top'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'status' => array(
						'label'        => esc_html__( 'Enable Footer Top', 'slz' ),
						'desc'         => esc_html__( 'Enable the footer top?', 'slz' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'enable',
							'label' => esc_html__( 'Enable', 'slz' )
						),
						'left-choice'  => array(
							'value' => 'disable',
							'label' => esc_html__( 'Disable', 'slz' )
						),
						'value'        => 'disable',
					)
				),
				'choices'      => array(
					'enable' => array(
						'top-widget' => array(
                            'type'   => 'addable-option',
                            'attr'   => array( 'class' => 'slz-footer-top-addable-option-02' ),
                            'label'  => esc_html__( 'Choose Widget Area', 'transera' ),
                            'desc'  => esc_html__('Choose widget area will show in footer top', 'slz'),
                            'option' => array(
                                'type'     => 'select',
                                'choices'  => $regist_sidebars
                            )
                        ),
						'styling' => array(
							'type'          => 'popup',
							'attr'          => array( 'class' => 'slz-advanced-button' ),
							'label'         => esc_html__( 'Custom Style', 'slz' ),
							'desc'          => esc_html__( 'Change the style of footer top', 'slz' ),
							'button'        => esc_html__( 'Styling', 'slz' ),
							'size'          => 'medium',
							'popup-options' => array(
								'bg-color'     => array(
									'label'   => esc_html__( 'Background Color', 'slz' ),
									'desc'    => esc_html__( "Select background color for footer top", "slz" ),
									'value'   => '',
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'bg-image'	=>	array(
								    'type'  => 'upload',
								    'label' => esc_html__('Background Image', 'slz'),
								    'desc'  => esc_html__('Upload the background image .png or .jpg', 'slz'),
								    'images_only' => true,
								),
								'bg-attachment' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Attachment', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-attachment'),
								),
								'bg-size' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Size', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-size'),
								),
								'bg-position' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Position', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-position'),
								),
								'border-color' =>array(
								    'type'  => 'rgba-color-picker',
								    'label' => esc_html__('Border Bottom Color', 'slz'),
								    'desc'  => esc_html__('Choose border top color', 'slz'),
								),
								'text-color'      => array(
									'label'   => esc_html__( 'Text Color', 'slz' ),
									'desc'    => esc_html__( 'Select footer\'s top bar text color', 'slz' ),
									'value'   => '',
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'text-align' => array(
									'label'   => esc_html__( 'Text Alignment', 'slz' ),
									'desc'    => esc_html__( 'Setting text alignment', 'slz' ),
									'attr'    => array( 'class' => 'slz-checkbox-float-left' ),
									'type'    => 'radio',
									'value'   => 'text-l',
									'choices' => array(
										'text-l' => esc_html__( 'Left', 'slz' ),
										'text-c' => esc_html__( 'Center', 'slz' ),
										'text-r' => esc_html__( 'Right', 'slz' ),
									),
								),
							)
						),
					),
				),
				'show_borders' => true,
			),
	    ),
	    'show_borders' => true,
	),
	'content-box' => array(
	    'type' => 'box',
	    'title' => esc_html__('Footer Content Settings', 'slz'),
	    'options' => array(
	    	'footer-main'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'footer-main-enable' => array(
						'label'        => esc_html__( 'Enable Footer Main', 'slz' ),
						'desc'         => esc_html__( 'Enable the footer main?', 'slz' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'enable',
							'label' => esc_html__( 'Enable', 'slz' )
						),
						'left-choice'  => array(
							'value' => 'disable',
							'label' => esc_html__( 'Disable', 'slz' )
						),
						'value'        => 'disable',
					),
				),
				'choices'      => array(
					'enable' => array(
						'styling'	=>	array(
						    'type'  => 'select',
						    'label' => esc_html__('Footer Style', 'slz'),
						    'choices' => $footer_style ,
						),
						'custom-style' => array(
							'type'          => 'popup',
							'attr'          => array( 'class' => 'slz-advanced-button' ),
							'label'         => esc_html__( 'Custom Style', 'slz' ),
							'desc'          => esc_html__( 'Change the style of footer main', 'slz' ),
							'button'        => esc_html__( 'Styling', 'slz' ),
							'size'          => 'medium',
							'popup-options' => array(
								'ft-bg-color'     => array(
									'label'   => esc_html__( 'Footer Background Color', 'slz' ),
									 'desc'  => esc_html__('Choose background color for footer main.', 'slz'),
									'type'    => 'rgba-color-picker'
								),
								'ft-background'=> array(
									'label'   => esc_html__( 'Footer Background Image', 'slz' ),
									'type'    => 'background-image',
									'value'   => 'none',
									'desc'    => esc_html__( 'Upload background image.',
										'slz' ),
								),
								'ft-bg-attachment' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Attachment', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-attachment'),
								),
								'ft-bg-size' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Size', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-size'),
								),
								'ft-bg-position' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Position', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-position'),
								),
							)
						),
				        'widget-01'	=>	array(
						    'type'  => 'select',
						    'label' => esc_html__('Choose Widget Area 01', 'slz'),
						    'desc'  => esc_html__('Choose widget area will show in footer collumn 1', 'slz'),
						    'choices' => $regist_sidebars,
						),
						'widget-02'	=>	array(
						    'type'  => 'select',
						    'label' => esc_html__('Choose Widget Area 02', 'slz'),
						    'desc'  => esc_html__('Choose widget area will show in footer collumn 2', 'slz'),
						    'choices' => $regist_sidebars,
						),
						'widget-03'	=>	array(
						    'type'  => 'select',
						    'label' => esc_html__('Choose Widget Area 03', 'slz'),
						    'desc'  => esc_html__('Choose widget area will show in footer collumn 3', 'slz'),
						    'choices' => $regist_sidebars,
						),
					),
				),
				'show_borders' => true,
			),
	    ),
	),
	'bottom-box' => array(
	    'type' => 'box',
	    'title' => esc_html__('Footer Bottom Settings', 'slz'),
	    'options' => array(
	        'footer-bottom'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'status' => array(
						'label'        => esc_html__( 'Enable Footer Bottom', 'slz' ),
						'desc'         => esc_html__( 'Enable the footer bottom?', 'slz' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'enable',
							'label' => esc_html__( 'Enable', 'slz' )
						),
						'left-choice'  => array(
							'value' => 'disable',
							'label' => esc_html__( 'Disable', 'slz' )
						),
						'value'        => 'enable',
					)
				),
				'choices'      => array(
					'enable' => array(
						'styling' => array(
							'type'          => 'popup',
							'attr'          => array( 'class' => 'slz-advanced-button' ),
							'label'         => esc_html__( 'Custom Style', 'slz' ),
							'desc'          => esc_html__( 'Change the style of footer bottom', 'slz' ),
							'button'        => esc_html__( 'Styling', 'slz' ),
							'size'          => 'medium',
							'popup-options' => array(
								'bg-color'     => array(
									'label'   => esc_html__( 'Background Color', 'slz' ),
									'desc'    => esc_html__( "Select the footer bottom background color", "slz" ),
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'bg-image'	=>	array(
								    'type'  => 'upload',
								    'label' => esc_html__('Background Image', 'slz'),
								    'desc'  => esc_html__('Upload the background image .png or .jpg', 'slz'),
								    'images_only' => true,
								),
								'bg-attachment' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Attachment', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-attachment'),
								),
								'bg-size' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Size', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-size'),
								),
								'bg-position' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Background Position', 'slz'),
								    'choices' => SLZ_Params::get('option-bg-position'),
								),
								'border-color' =>array(
								    'type'  => 'rgba-color-picker',
								    'label' => esc_html__('Border Top Color', 'slz'),
								    'desc'  => esc_html__('Choose border top color', 'slz'),
								),
								'text-color'      => array(
									'label'   => esc_html__( 'Text Color', 'slz' ),
									'desc'    => esc_html__( 'Select footer bottom text color', 'slz' ),
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'social-color'       => array(
									'label'   => esc_html__( 'Social Color', 'slz' ),
									'desc'    => esc_html__( 'Select the social icons color', 'slz' ),
									'value'   => '',
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'social-hover-color' => array(
									'label'   => esc_html__( 'Social Hover Color', 'slz' ),
									'desc'    => esc_html__( 'Select the social icons hover color', 'slz' ),
									'value'   => '',
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'social-icon-size'           => array(
									'type'  => 'short-text',
									'label' => esc_html__( 'Social Icon Size', 'slz' ),
									'desc'  => esc_html__( 'Enter icon size in pixels. Ex: 16', 'slz' ),
									'value' => '16',
								),
							)
						),
						'left-area-tab' => array(
							'type'          => 'tab',
							'title'         => esc_html__( 'Left Area Content', 'slz' ),
							'options' => array(
								'area-left-content' => array(
									'type'    => 'box',
									'options' => array(
										'area-left' => array(
											'label'        => esc_html__( 'Show/Hide This Area', 'slz' ),
											'type'         => 'switch',
											'desc'         => esc_html__( 'Show or hide Left Area Content', 'slz'),
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'copyright-left' => array(
											'type'          => 'textarea',
											'label'         => esc_html__( 'Text', 'slz' ),
											'desc'          => esc_html__( 'Write text will display in this area', 'slz'),
											'value'			=> '',
										),
										'social-left' => array(
											'label'        => esc_html__( 'Social', 'slz' ),
											'type'         => 'switch',
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'desc'         => esc_html__( 'Show social icon in footer bottom? Change social in the "General" settings', 'slz' ),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'navigation-left' => array(
											'label'        => esc_html__( 'Navigation', 'slz' ),
				                          	'desc'  => esc_html__('Show navigation in this area? Please choose locations is "Bottom menu" in ','slz').' <br><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" >'.esc_html__('Appearance','slz').' > '.esc_html__('Menus','slz').'</a>',
											'type'         => 'switch',
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'image-left'=> array(
											'label'   => esc_html__( ' Add Image', 'slz' ),
											'type'    => 'background-image',
											'value'   => 'none',
											'desc'    => esc_html__( 'Upload an image to display in footer bottom.',
												'slz' ),
										),
										'btn-left'=>array(
											'type'  => 'multi-picker',
											'label' => false,
											'picker' => array(
												'btn-enable' => array(
													'label'        => esc_html__( 'Button', 'slz' ),
													'desc'         => esc_html__( 'Show button in this area', 'slz' ),
													'type'         => 'switch',
													'right-choice' => array(
														'value' => 'show',
														'label' => esc_html__( 'Show', 'slz' )
													),
													'left-choice'  => array(
														'value' => 'hide',
														'label' => esc_html__( 'Hide', 'slz' )
													),
													'value'        => 'hide',
													'show_borders' => false,
												),
																
											),
											'choices' => array(
												'show' => array(
													'custom'=> array(
														'type'          => 'popup',
														'attr'          => array( 'class' => 'slz-advanced-button' ),
														'label'         => esc_html__( 'Button Settings', 'slz' ),
														'desc'          => esc_html__( 'Setting for button', 'slz' ),
														'button'        => esc_html__( 'Settings', 'slz' ),
														'size'          => 'medium',
														'popup-options' => array(
															'btn-text'      => array(
															'type'  => 'text',
															'label' => esc_html__( 'Button Text', 'slz' ),
															),
															'btn-link'      => array(
															'type'  => 'text',
															'label' => esc_html__( 'Button Link', 'slz' ),
															),
															'bg-color'     => array(
																'label'   => esc_html__( 'Background Color', 'slz' ),
																'desc'    => esc_html__( "Select background color", "slz" ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'text-color'      => array(
																'label'   => esc_html__( 'Text Color', 'slz' ),
																'desc'    => esc_html__( 'Select text color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'border-color'      => array(
																'label'   => esc_html__( 'Border Color', 'slz' ),
																'desc'    => esc_html__( 'Select border color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'bg-hv-color'     => array(
																'label'   => esc_html__( 'Background Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'text-hv-color'      => array(
																'label'   => esc_html__( 'Text Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'border-hv-color'      => array(
																'label'   => esc_html__( 'Border Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
														),
													)
												)

											),
											'show_borders' => false,
										),
									)
								)
							),
						),
						'center-area-tab' => array(
							'type'          => 'tab',
							'title'         => esc_html__( 'Center Area Content', 'slz' ),
							'options' => array(
								'area-center-content' => array(
									'type'    => 'box',
									'options' => array(
										'area-center' => array(
											'label'        => esc_html__( 'Show/Hide This Area', 'slz' ),
											'type'         => 'switch',
											'desc'         => esc_html__( 'Show or hide Center Area Content', 'slz'),
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'show',
										),
										'copyright-center' => array(
											'type'          => 'textarea',
											'label'         => esc_html__( 'Text', 'slz' ),
											'desc'          => esc_html__( 'Write text will display in this area', 'slz'),
											'value'			=> esc_html__('© Designed by SWLABS.','slz'),
										),
										'social-center' => array(
											'label'        => esc_html__( 'Social', 'slz' ),
											'type'         => 'switch',
											'desc'         => esc_html__( 'Show social icon in footer bottom? Change social in the "General" settings', 'slz' ),
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'navigation-center' => array(
											'label'        => esc_html__( 'Navigation', 'slz' ),
					                      'desc'  => esc_html__('Show navigation in this area? Please choose locations is "Bottom menu" in ','slz').' <br><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" >'.esc_html__('Appearance','slz').' > '.esc_html__('Menus','slz').'</a>',
											'type'         => 'switch',
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'image-center'=> array(
											'label'   => esc_html__( ' Add Image', 'slz' ),
											'type'    => 'background-image',
											'value'   => 'none',
											'desc'    => esc_html__( 'Upload an image to display in footer bottom.',
												'slz' ),
										),
										'btn-center'=>array(
											'type'  => 'multi-picker',
											'label' => false,
											'picker' => array(
												'btn-enable' => array(
													'label'        => esc_html__( 'Button', 'slz' ),
													'desc'         => esc_html__( 'Show button in this area', 'slz' ),
													'type'         => 'switch',
													'right-choice' => array(
														'value' => 'show',
														'label' => esc_html__( 'Show', 'slz' )
													),
													'left-choice'  => array(
														'value' => 'hide',
														'label' => esc_html__( 'Hide', 'slz' )
													),
													'value'        => 'hide',
													'show_borders' => false,
												),
																
											),
											'choices' => array(
												'show' => array(
													'custom'=> array(
														'type'          => 'popup',
														'attr'          => array( 'class' => 'slz-advanced-button' ),
														'label'         => esc_html__( 'Button Settings', 'slz' ),
														'desc'          => esc_html__( 'Setting for button', 'slz' ),
														'button'        => esc_html__( 'Settings', 'slz' ),
														'size'          => 'medium',
														'popup-options' => array(
															'btn-text'      => array(
															'type'  => 'text',
															'label' => esc_html__( 'Button Text', 'slz' ),
															),
															'btn-link'      => array(
															'type'  => 'text',
															'label' => esc_html__( 'Button Link', 'slz' ),
															),
															'bg-color'     => array(
																'label'   => esc_html__( 'Background Color', 'slz' ),
																'desc'    => esc_html__( "Select background color", "slz" ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'text-color'      => array(
																'label'   => esc_html__( 'Text Color', 'slz' ),
																'desc'    => esc_html__( 'Select text color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'border-color'      => array(
																'label'   => esc_html__( 'Border Color', 'slz' ),
																'desc'    => esc_html__( 'Select border color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'bg-hv-color'     => array(
																'label'   => esc_html__( 'Background Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'text-hv-color'      => array(
																'label'   => esc_html__( 'Text Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'border-hv-color'      => array(
																'label'   => esc_html__( 'Border Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
														),
													)
												)

											),
											'show_borders' => false,
										),
									)
								)
							),
						),
						'right-area-tab' => array(
							'type'          => 'tab',
							'title'         => esc_html__( 'Right Area Content', 'slz' ),
							'options' => array(
								'area-right-content' => array(
									'type'    => 'box',
									'options' => array(
										'area-right' => array(
											'label'        => esc_html__( 'Show/Hide This Area', 'slz' ),
											'type'         => 'switch',
											'desc'         => esc_html__( 'Show or hide Right Area Content', 'slz'),
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'copyright-right' => array(
											'type'          => 'textarea',
											'label'         => esc_html__( 'Text', 'slz' ),
											'desc'          => esc_html__( 'Write text will display in this area', 'slz'),
											'value'			=> '',
										),
										'social-right' => array(
											'label'        => esc_html__( 'Social', 'slz' ),
											'type'         => 'switch',
											'desc'         => esc_html__( 'Show social icon in footer bottom? Change social in the "General" settings', 'slz' ),
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'hide',
										),
										'navigation-right' => array(
											'label'        => esc_html__( 'Navigation', 'slz' ),
					                      'desc'  => esc_html__('Show navigation in this area? Please choose locations is "Bottom menu" in ','slz').' <br><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" >'.esc_html__('Appearance','slz').' > '.esc_html__('Menus','slz').'</a>',
											'type'         => 'switch',
											'right-choice' => array(
												'value' => 'show',
												'label' => esc_html__( 'Show', 'slz' )
											),
											'left-choice'  => array(
												'value' => 'hide',
												'label' => esc_html__( 'Hide', 'slz' )
											),
											'value'        => 'show',
										),
										'image-right'=> array(
											'label'   => esc_html__( ' Add Image', 'slz' ),
											'type'    => 'background-image',
											'value'   => 'none',
											'desc'    => esc_html__( 'Upload an image to display in footer bottom.',
												'slz' ),
										),
										'btn-right'=>array(
											'type'  => 'multi-picker',
											'label' => false,
											'picker' => array(
												'btn-enable' => array(
													'label'        => esc_html__( 'Button', 'slz' ),
													'desc'         => esc_html__( 'Show button in this area', 'slz' ),
													'type'         => 'switch',
													'right-choice' => array(
														'value' => 'show',
														'label' => esc_html__( 'Show', 'slz' )
													),
													'left-choice'  => array(
														'value' => 'hide',
														'label' => esc_html__( 'Hide', 'slz' )
													),
													'value'        => 'hide',
													'show_borders' => false,
												),
																
											),
											'choices' => array(
												'show' => array(
													'custom'=> array(
														'type'          => 'popup',
														'attr'          => array( 'class' => 'slz-advanced-button' ),
														'label'         => esc_html__( 'Button Settings', 'slz' ),
														'desc'          => esc_html__( 'Setting for button', 'slz' ),
														'button'        => esc_html__( 'Settings', 'slz' ),
														'size'          => 'medium',
														'popup-options' => array(
															'btn-text'      => array(
															'type'  => 'text',
															'label' => esc_html__( 'Button Text', 'slz' ),
															),
															'btn-link'      => array(
															'type'  => 'text',
															'label' => esc_html__( 'Button Link', 'slz' ),
															),
															'bg-color'     => array(
																'label'   => esc_html__( 'Background Color', 'slz' ),
																'desc'    => esc_html__( "Select background color", "slz" ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'text-color'      => array(
																'label'   => esc_html__( 'Text Color', 'slz' ),
																'desc'    => esc_html__( 'Select text color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'border-color'      => array(
																'label'   => esc_html__( 'Border Color', 'slz' ),
																'desc'    => esc_html__( 'Select border color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'bg-hv-color'     => array(
																'label'   => esc_html__( 'Background Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'text-hv-color'      => array(
																'label'   => esc_html__( 'Text Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
															'border-hv-color'      => array(
																'label'   => esc_html__( 'Border Hover Color', 'slz' ),
																'value'   => '',
																'choices' => $palette_color,
																'type'    => 'color-palette'
															),
														),
													)
												)

											),
											'show_borders' => false,
										),
									)
								)
							),
						),
					),
				),
				'show_borders' => true,
			),
	    ),
	    'show_borders' => true,
	),
);