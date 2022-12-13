<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'general' => array(
		'title'   => esc_html__( 'General', 'transera' ),
		'type'    => 'tab',
		'options' => array(
			'general-tab' => array(
				'title'   => esc_html__( 'General', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'general-box' => array(
						'title'   => esc_html__( 'Global Settings', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'layout-group' => array(
		                        'type'         => 'multi-picker',
		                        'label'        => false,
		                        'desc'         => false,
		                        'picker'       => array(
		                            'layout'    => array(
										'label' => esc_html__( 'Site Layout', 'transera' ),
										'desc'  => esc_html__( 'This option will change layout for all pages of theme.', 'transera' ),
										'type'  => 'image-picker',
										'choices' => array(
											'full' => array(
												'small' => array(
													'height' => 70,
													'src'    => TRANSERA_OPTION_IMG_URI .'/layout-full.jpg'
												),
												'large' => array(
													'height' => 214,
													'src'    => TRANSERA_OPTION_IMG_URI .'/layout-full.jpg'
												),
											),
											'boxed' => array(
												'small' => array(
													'height' => 70,
													'src'    => TRANSERA_OPTION_IMG_URI .'/layout-boxed.jpg'
												),
												'large' => array(
													'height' => 214,
													'src'    => TRANSERA_OPTION_IMG_URI .'/layout-boxed.jpg'
												),
											),
										),
										'value' => 'full'
									),
		                        ),
		                        'choices'      => array(
		                        	'boxed'	=>	array(
		                        		'boxed-width'	=>	array(
										    'type'  => 'slider',
										    'value' => 1200,
										    'properties' => array(
										        'min' => 700,
										        'max' => 1920,
										        'step' => 1,
										    ),
										    'label' => esc_html__('Boxed Width', 'transera'),
										    'desc'  => esc_html__('Select the website width', 'transera'),
										),
										'bg-color'     => array(
											'label'   => esc_html__( 'Background Color', 'transera' ),
											'desc'    => esc_html__( "Select the boxed background color", 'transera' ),
											'value'   => '',
											'choices' => SLZ_Com::get_palette_color(),
											'type'    => 'color-palette'
										),
										'boxed-background'	=> array(
											'label'   => esc_html__( 'Background Image', 'transera' ),
											'type'    => 'background-image',
											'value'   => 'none',
											'choices' => array(
												'none' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/no_pattern.jpg',
													'css' => 'none',
												),
												'bg-1' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/diagonal_bottom_to_top_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-2' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/diagonal_top_to_bottom_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-3' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/dots_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-4' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/romb_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-5' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/square_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-6' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/noise_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-7' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/vertical_lines_pattern_preview.jpg',
													'css' => 'none',
												),
												'bg-8' => array(
													'icon' => TRANSERA_OPTION_IMG_URI .'/patterns/waves_pattern_preview.jpg',
													'css' => 'none',
												),
											),
											'desc'    => esc_html__( 'Select background image or try to upload new image.',
												'transera' ),
										),
										'boxed-alignment'    => array(
											'label' => esc_html__( 'Website Alignment', 'transera' ),
											'desc'  => esc_html__( 'Choose the website alignment.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
												'left' => array(
													'small' => array(
														'height' => 60,
														'src'    => TRANSERA_OPTION_IMG_URI .'/position/left-position.jpg'
													),
												),
												'center' => array(
													'small' => array(
														'height' => 60,
														'src'    => TRANSERA_OPTION_IMG_URI .'/position/center-position.jpg'
													),
												),
												'right' => array(
													'small' => array(
														'height' => 60,
														'src'    => TRANSERA_OPTION_IMG_URI. '/position/right-position.jpg'
													),
												),
											),
											'value' => 'center'
										),
		                        	)
		                        ),
		                        'show_borders' => true,
		                    ),
							'logo'	=>	array(
							    'type'  => 'upload',
							    'label' => esc_html__('Site Logo', 'transera'),
							    'desc'  => esc_html__('Upload the site logo .png or .jpg', 'transera'),
							    'images_only' => true,
							    'value' => array(
							        'url' => TRANSERA_LOGO_IMG_URI . '/logo.png'
							    )
							),
							'logo-transparent'   => array(
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
										    'type'  => 'upload',
										    'label' => esc_html__('Site Logo Transparent', 'transera'),
										    'desc'  => esc_html__('Upload the site logo .png or .jpg use for header transparent', 'transera'),
										    'images_only' => true,
										    'value' => array(
										        'url' => TRANSERA_LOGO_IMG_URI . '/logo_trans.png'
										    )
										),
									),
								),
							),
							'logo-alt'	=>	array(
								'type'  => 'text',
							    'label' => esc_html__('Logo Alt Attribute', 'transera'),
							    'desc'  => esc_html__('Appears inside the image container when the image can not be displayed. It helps search engines understand what an image is about.', 'transera'),
							),
							'logo-title'	=>	array(
								'type'  => 'text',
							    'label' => esc_html__('Logo Title Attribute', 'transera'),
							    'desc'  => esc_html__('Used to provide a title for your image. It is displayed in a popup when a user takes their mouse over to an image.', 'transera'),
							),
							'scroll-to-top-group'      => array(
								'type'    => 'group',
								'options' => array(
									'scroll-to-top-styling' => array(
										'attr'          => array(
											'data-advanced-for' => 'scroll-to-top-styling',
											'class'             => 'slz-advanced-button'
										),
										'type'          => 'popup',
										'label'         => esc_html__( 'Custom Style', 'transera' ),
										'desc'          => esc_html__( 'Change the style / typography of this shortcode', 'transera' ),
										'button'        => esc_html__( 'Styling', 'transera' ),
										'size'          => 'medium',
										'popup-options' => array(
											'icon-type'         => array(
												'type'    => 'multi-picker',
												'label'   => false,
												'desc'    => false,
												'picker'  => array(
													'icon-box-img' => array(
														'label'   => esc_html__( 'Icon', 'transera' ),
														'desc'    => esc_html__( 'Select icon type', 'transera' ),
														'attr'    => array( 'class' => 'slz-checkbox-float-left' ),
														'type'    => 'radio',
														'value'   => 'icon-class',
														'choices' => array(
															'icon-class'  => esc_html__( 'Font Awesome', 'transera' ),
															'upload-icon' => esc_html__( 'Custom Upload', 'transera' ),
														),
													),
												),
												'choices' => array(
													'icon-class'  => array(
														'icon_class' => array(
															'type'  => 'icon',
															'value' => '',
															'label' => esc_html__( '', 'transera' )
														),
													),
													'upload-icon' => array(
														'upload-custom-img' => array(
															'label' => '',
															'type'  => 'upload',
															'help'  => esc_html__('For best results upload a square image, larger then 30px x 30px.', 'transera'),
														),
													),
												)
											),
											'bg-color' => array(
												'label'   => esc_html__( 'Background Color', 'transera' ),
												'desc'    => esc_html__( 'Select the background color', 'transera' ),
												'value'   => '',
												'choices' => SLZ_Com::get_palette_color(),
												'type'    => 'color-palette'
											),
											'text-color' => array(
												'label'   => esc_html__( 'Text Color', 'transera' ),
												'desc'    => esc_html__( 'Select the text color', 'transera' ),
												'value'   => '',
												'choices' => SLZ_Com::get_palette_color(),
												'type'    => 'color-palette'
											),
										)
									),
									'enable-scroll-to' => array(
										'attr'    => array( 'class' => 'scroll-to-top-styling' ),
										'type'         => 'switch',
										'value'        => 'yes',
										'label'        => esc_html__( 'Button To Top', 'transera' ),
										'desc'         => esc_html__( 'Enable scroll to top?', 'transera' ),
										'left-choice'  => array(
											'value' => 'no',
											'label' => esc_html__( 'Disable', 'transera' ),
										),
										'right-choice' => array(
											'value' => 'yes',
											'label' => esc_html__( 'Enable', 'transera' ),
										)
									),
								)
							),
							'enable-woo-account' => array(
								'type'        => 'switch',
								'value'       => 'disable',
								'label'       => esc_html__( 'WooCommerce Account', 'transera' ),
								'desc'        => esc_html__( 'Show WooCommerce account on header top right.', 'transera' ),
								'left-choice' => array(
									'value' => 'disable',
									'label' => esc_html__( 'Disable', 'transera' ),
								),
								'right-choice' => array(
									'value' => 'enable',
									'label' => esc_html__( 'Enable', 'transera'),
								)
							),
							'map-key-api' => array(
								'type'     => 'text',
								'value'  => 'AIzaSyCZ9qvJ9lsEkaMUJcouFtRhgzkgyp2RMlM',
								'label'    => esc_html__( 'Map Google API Key', 'transera' ),
								'desc' => esc_html__( 'This key is used to run a some feature of Google Map. Please refer document to create a key', 'transera' ),
							),
						)
					),
				)
			),
			'social-tab'  => array(
				'title'   => esc_html__( 'Social Profiles', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'social-box' => array(
						'title'   => esc_html__( 'Social Settings', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'socials' => array(
								'type'          => 'addable-popup',
								'label'         => esc_html__( 'Social Links', 'transera' ),
								'desc'          => esc_html__( 'Add your social profiles', 'transera' ),
								'template'      => '{{=social_name}}',
								'popup-options' => array(
									'social_name' => array(
										'label' => esc_html__( 'Name', 'transera' ),
										'desc'  => esc_html__( 'Enter a name (it is for internal use and will not appear on the front end)', 'transera' ),
										'type'  => 'text',
									),
									'social_type' => array(
										'type'    => 'multi-picker',
										'label'   => false,
										'desc'    => false,
										'picker'  => array(
											'social-type' => array(
												'label'   => esc_html__( 'Icon', 'transera' ),
												'desc'    => esc_html__( 'Select social icon type', 'transera' ),
												'attr'    => array( 'class' => 'slz-checkbox-float-left' ),
												'type'    => 'radio',
												'value'   => 'icon-social',
												'choices' => array(
													'icon-social' => esc_html__( 'Font Awesome', 'transera' ),
													'upload-icon' => esc_html__( 'Custom Upload', 'transera' ),
												),
											),
										),
										'choices' => array(
											'icon-social' => array(
												'icon_class' => array(
													'type'  => 'icon',
													'value' => 'fa fa-adn',
													'label' => '',
												),
											),
											'upload-icon' => array(
												'upload-social-icon' => array(
													'label' => '',
													'type'  => 'upload',
												)
											),
										)
									),
									'social-link' => array(
										'label' => esc_html__( 'Link', 'transera' ),
										'desc'  => esc_html__( 'Enter your social URL link', 'transera' ),
										'type'  => 'text',
									)
								),
							),
						)
					),
				)
			),
			'customize-icon-tab'  => array(
				'title'   => esc_html__( 'Customize Icon', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'customize-icon-box' => array(
						'title'   => esc_html__( 'Customize Icon', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'customize-icon' => array(
								'type'          => 'addable-popup',
								'label'         => esc_html__( 'Customize Icon', 'transera' ),
								'desc'          => esc_html__( 'Add your customizable icon', 'transera' ),
								'template'      => '{{=icon_name}}',
								'popup-options' => array(
									'icon_name' => array(
										'label' => esc_html__( 'Name', 'transera' ),
										'desc'  => esc_html__( 'Enter a name (it will show in front end)', 'transera' ),
										'type'  => 'text',
									),
									'icon_type' => array(
										'type'    => 'multi-picker',
										'label'   => false,
										'desc'    => false,
										'picker'  => array(
											'icon-type' => array(
												'label'   => esc_html__( 'Icon', 'transera' ),
												'desc'    => esc_html__( 'Select customize icon type', 'transera' ),
												'attr'    => array( 'class' => 'slz-checkbox-float-left' ),
												'type'    => 'radio',
												'value'   => 'icon',
												'choices' => array(
													'icon' => esc_html__( 'Font Awesome', 'transera' ),
													'upload-icon' => esc_html__( 'Custom Upload', 'transera' ),
												),
											),
										),
										'choices' => array(
											'icon' => array(
												'icon_class' => array(
													'type'  => 'icon',
													'value' => 'fa fa-adn',
													'label' => '',
												),
											),
											'upload-icon' => array(
												'upload-icon' => array(
													'label' => '',
													'type'  => 'upload',
												)
											),
										)
									),
									'icon-link' => array(
										'label' => esc_html__( 'Link', 'transera' ),
										'desc'  => esc_html__( 'Enter your customize icon URL link', 'transera' ),
										'type'  => 'text',
									)
								),
							),
						)
					),
				)
			),
			'tracking-tab'  => array(
				'title'   => esc_html__( 'Tracking Scripts', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'tracking-box' => array(
						'title'   => esc_html__( 'Tracking Scripts', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'tracking-popup' => array(
								'type'          => 'addable-popup',
								'label'         => esc_html__( 'Tracking Scripts', 'transera' ),
								'desc'          => esc_html__( 'Add your tracking scripts (MixPanel, Google Analytics, etc)', 'transera' ),
								'template'      => '{{=tracking_name}}',
								'popup-options' => array(
									'tracking_name' => array(
										'label' => esc_html__( 'Tracking Name', 'transera' ),
										'desc'  => esc_html__( 'Enter a name (it is for internal use and will not appear on the front end)', 'transera' ),
										'type'  => 'text',
										'value'	=> ''
									),
									'tracking_script' => array(
									    'type'  => 'code-editor',
									    'mode'	=> 'html',
									    'attr'	=> array('rows' => 4),
									    'label' => esc_html__('Script', 'transera'),
									    'desc'  => esc_html__('Copy/Paste the tracking script here. Include &lt;script&gt; or &lt;style&gt; tag', 'transera'),
									)
								),
							),
						)
					),
				)
			),
		)
	)
);