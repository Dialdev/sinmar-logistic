<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$palette_color = SLZ_Com::get_palette_color();

$regist_menu = array( 'default' => esc_html__('-- Select Menu --', 'slz') ) + SLZ_Com::get_regist_menu();

$menu_locations = get_nav_menu_locations();

$menu_align = array(
	'left'   => esc_html__('Left','slz'),
	'right'  => esc_html__('Right','slz'),
	);

$breaking_news_arr = array(
	'type'    => 'group',
	'options' => array(),
);

$contact_form = SLZ_Com::get_contact_form();

$arr_btn_donation = array();
if (function_exists('slz_get_option_donation_paypal')) {
    $arr_btn_donation = slz_get_option_donation_paypal();
}
$arr_event_topbar_option = array();
if (function_exists('slz_get_option_event_top_bar')) {
    $arr_event_topbar_option = slz_get_option_event_top_bar();
}

if ( slz_ext( 'headers' )->get_config('enable_breakingnews') ) {
	$breaking_news_arr = array(
				'type'    => 'group',
				'options' => array(
					'breaking-news-options' => array(
						'attr'          => array(
							'data-advanced-for' => 'breaking-news-options',
							'class'             => 'slz-advanced-button'
						),
						'type'          => 'popup',
						'label'         => esc_html__( 'Custom Style', 'slz' ),
						'desc'          => esc_html__( 'Change the style / typography of search box', 'slz' ),
						'button'        => esc_html__( 'Options', 'slz' ),
						'size'          => 'medium',
						'popup-options' => array(
							'style-breaking-news' => array(
								'attr'    => array( 'class' => 'breaking-news-options' ),
								'type'         => 'switch',
								'value'        => 'style-1',
								'label'        => esc_html__( 'Style', 'slz' ),
								'desc'         => esc_html__( 'Choose style to show.', 'slz' ),
								'left-choice'  => array(
									'value' => 'style-1',
									'label' => esc_html__( 'Style 1', 'slz' ),
								),
								'right-choice' => array(
									'value' => 'style-2',
									'label' => esc_html__( 'Style 2', 'slz' ),
								)
							),
							'limit_post'	=>	array(
								'type'  => 'text',
								'value' => '7',
								'label' => esc_html__('Limit Post', 'slz'),
								'desc'  => esc_html__('Input number of post to show', 'slz'),
							),
							'offset_post'	=>	array(
								'type'  => 'text',
								'label' => esc_html__('Offset Post', 'slz'),
								'desc'  => esc_html__('Input number of offset post', 'slz'),
							),
							'category_list' => array(
								'label'  => esc_html__( 'Category Filter', 'slz' ),
								'type'   => 'addable-option',
								'option' => array(
									'type' => 'select',
									'choices' => SLZ_Com::get_category2name_array(),
								),
								'value'  => array( '' ),
								'desc'   => esc_html__( 'Default no filter by category.', 'slz' ),
							),
							'tag_list' => array(
								'label'  => esc_html__( 'Tag Filter', 'slz' ),
								'type'   => 'addable-option',
								'option' => array(
									'type' => 'select',
									'choices' => SLZ_Com::get_tax_options2name( 'post_tag', array('empty' => esc_html__( '-All tags-', 'slz' )) ),
								),
								'value'  => array( '' ),
								'desc'   => esc_html__( 'Default no filter by tag.', 'slz' ),
							),
						)
					),
					'enable-breaking-news' => array(
						'attr'    => array( 'class' => 'breaking-news-options' ),
						'type'         => 'switch',
						'value'        => 'yes',
						'label'        => esc_html__( 'Breaking News', 'slz' ),
						'desc'         => esc_html__( 'Enable breaking news ?', 'slz' ),
						'left-choice'  => array(
							'value' => 'no',
							'label' => esc_html__( 'Disable', 'slz' ),
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Enable', 'slz' ),
						)
					),
				)
			);
}

$headers = slz_ext( 'headers' );
$option_content_topbar = $headers->get_config('option_content_topbar');
if ( !isset($option_content_topbar) ) {
    $option_content_topbar = array();
}

$options = array(
	'general-box' => array(
	    'type' => 'box',
	    'title' => esc_html__('General Settings', 'slz'),
	    'options' => array(
	    	'header-transparent' => array(
				'label'        => esc_html__( 'Header Transparent', 'slz' ),
				'desc'         => esc_html__( 'Make header transparent', 'slz' ),
				'type'         => 'switch',
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__( 'No', 'slz' )
				),
				'right-choice'  => array(
					'value' => 'header-transparent',
					'label' => esc_html__( 'Yes', 'slz' )
				),
				'value'        => '',
			),
			'header-styling' => array(
				'type'          => 'popup',
				'attr'          => array( 'class' => 'slz-advanced-button' ),
				'label'         => esc_html__( 'Custom Style', 'slz' ),
				'desc'          => esc_html__( 'Change the style of this header', 'slz' ),
				'button'        => esc_html__( 'Styling', 'slz' ),
				'size'          => 'medium',
				'popup-options' => array(
					'header-bg-color'      => array(
						'label'   => esc_html__( 'Background Color', 'slz' ),
						'desc'    => esc_html__( 'Select header background color', 'slz' ),
						'value'   => '',
						'choices' => $palette_color,
						'type'    => 'color-palette'
					),
					'header-bg-image'	=>	array(
					    'type'  => 'upload',
					    'label' => esc_html__('Background Image', 'slz'),
					    'desc'  => esc_html__('Upload the background image .png or .jpg', 'slz'),
					    'images_only' => true,
					),
					'header-bg-attachment' =>	array(
					    'type'    => 'select',
					    'label'   => esc_html__('Background Attachment', 'slz'),
					    'choices' => SLZ_Params::get('option-bg-attachment'),
					),
					'header-bg-size' =>	array(
					    'type'    => 'select',
					    'label'   => esc_html__('Background Size', 'slz'),
					    'choices' => SLZ_Params::get('option-bg-size'),
					),
					'header-bg-position' =>	array(
					    'type'    => 'select',
					    'label'   => esc_html__('Background Position', 'slz'),
					    'choices' => SLZ_Params::get('option-bg-position'),
					),
					'header-text-color'      => array(
						'label'   => esc_html__( 'Text Color', 'slz' ),
						'desc'    => esc_html__( 'Select header text color', 'slz' ),
						'value'   => '',
						'choices' => $palette_color,
						'type'    => 'color-palette'
					),
				)
			),
			'enable-sticky-header'    => array(
				'type'         => 'switch',
				'value'        => '',
				'attr'         => array(),
				'label'        => esc_html__( 'Sticky Header', 'slz' ),
				'desc'         => esc_html__( 'Make the header stick with the scroll?', 'slz' ),
				'left-choice'  => array(
					'value' => 'no',
					'label' => esc_html__( 'No', 'slz' ),
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'slz' ),
				),
			),
			'menu-group' => array(
				'type'    => 'group',
				'options' => array(
					'show-main-menu'    => array(
						'type'         => 'switch',
						'value'        => 'show',
						'attr'         => array(),
						'label'        => esc_html__( 'Main Header?', 'slz' ),
						'right-choice'  => array(
							'value' => 'show',
							'label' => esc_html__( 'Show', 'slz' ),
						),
						'left-choice' => array(
							'value' => 'hide',
							'label' => esc_html__( 'Hide', 'slz' ),
						),
					),
					'left-menu' 	=>	array(
					    'type'  => 'select',
					    'attr'	=>	array('data-saved-value' => ( !empty ( $menu_locations['left-nav'] ) ? $menu_locations['left-nav'] : '')),
					    'label' => esc_html__('Select Left Menu', 'slz'),
					    'choices' => $regist_menu,
					    'desc'  => esc_html__('Select menu for left menu. This changes will be apply for all headers.', 'slz'),
					    'value'	=> ( !empty ( $menu_locations['left-nav'] ) ? $menu_locations['left-nav'] : '')
					),
					'right-menu' 	=>	array(
					    'type'  => 'select',
					    'attr'	=>	array('data-saved-value' => ( !empty ( $menu_locations['right-nav'] ) ? $menu_locations['right-nav'] : '')),
					    'label' => esc_html__('Select Right Menu', 'slz'),
					    'choices' => $regist_menu,
					    'desc'  => esc_html__('Select menu for right menu. This changes will be apply for all headers.', 'slz'),
					    'value'	=> ( !empty ( $menu_locations['right-nav'] ) ? $menu_locations['right-nav'] : '')
					),
					'menu-styling' => array(
						'attr'          => array(
							'data-advanced-for' => 'scroll-to-top-styling',
							'class'             => 'slz-advanced-button'
						),
						'type'          => 'popup',
						'label'         => esc_html__( 'Custom Style', 'slz' ),
						'desc'          => esc_html__( 'Change the style for menu', 'slz' ),
						'button'        => esc_html__( 'Styling', 'slz' ),
						'size'          => 'medium',
						'popup-options' => array(
							'menu-item-color' => array(
								'label'   => esc_html__( 'Item Color', 'slz' ),
								'desc'    => esc_html__( "Select color for menu item", 'slz' ),
								'value'   => '',
								'choices' => SLZ_Com::get_palette_color(),
								'type'    => 'color-palette'
							),
							'menu-item-active-color' => array(
								'label'   => esc_html__( 'Item Active Color', 'slz' ),
								'desc'    => esc_html__( "Select color for menu item active", 'slz' ),
								'value'   => '',
								'choices' => SLZ_Com::get_palette_color(),
								'type'    => 'color-palette'
							),
							'menu-border-color' => array(
								'label'   => esc_html__( 'Menu Border Color', 'slz' ),
								'desc'    => esc_html__( "Select color for border of dropdown menu and mega menu", 'slz' ),
								'value'   => '',
								'choices' => SLZ_Com::get_palette_color(),
								'type'    => 'color-palette'
							),
							'dropdown-align'  => array(
							    'type'  => 'select',
							    'label' => esc_html__('Dropdown Menu Align', 'slz'),
							    'choices' => $menu_align,
                                'value'   => 'right',
							)
						)
					),
				)
			),
			'enable-subheader'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'enable' => array(
						'label'        => esc_html__( 'Sub Header?', 'slz' ),
						'desc'         => esc_html__( 'Enable the sub header in header main?', 'slz' ),
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
					)
				),
				'choices'      => array(
					'show' => array(
						'subheader-styling' => array(
							'attr'          => array(
								'data-advanced-for' => 'scroll-to-top-styling',
								'class'             => 'slz-advanced-button'
							),
							'type'          => 'popup',
							'label'         => esc_html__( 'Custom Style', 'slz' ),
							'desc'          => esc_html__( 'Change the style for sub header', 'slz' ),
							'button'        => esc_html__( 'Styling', 'slz' ),
							'size'          => 'medium',
							'popup-options' => array(
								'menu-item-color' => array(
									'label'   => esc_html__( 'Main Color', 'slz' ),
									'desc'    => esc_html__( "Select main color for session", 'slz' ),
									'value'   => '',
									'choices' => SLZ_Com::get_palette_color(),
									'type'    => 'color-palette'
								),
							),
						),
						'submenu-tab' => array(
							'title'   => esc_html__( 'Sub Menu Settings', 'slz' ),
							'type'    => 'tab',
							'options' => array(
								'enable-submenu' => array(
									'label'        => esc_html__( 'Sub Menu?', 'slz' ),
									'desc'         => esc_html__( 'Enable the menu in header main?', 'slz' ),
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
								'menu-list' 	=>	array(
								    'type'  => 'select',
								    'attr'	=>	array('data-saved-value' => ( !empty ( $menu_locations['sub-nav'] ) ? $menu_locations['sub-nav'] : '')),
								    'label' => esc_html__('Select Sub Menu', 'slz'),
								    'desc'  => esc_html__('Select menu for sub menu. This changes will be apply for all headers.', 'slz'),
								    'choices' => $regist_menu,
								    'value'	=> ( !empty ( $menu_locations['sub-nav'] ) ? $menu_locations['sub-nav'] : '')
								),
							)
						),
						'contact_tab' => array(
							'title'   => esc_html__( 'Contact Settings', 'slz' ),
							'type'    => 'tab',
							'options' => array(
								'enable-contact' => array(
									'label'        => esc_html__( 'Button Contact?', 'slz' ),
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
								'contact-text'   => array(
								    'type'  => 'text',
								    'label' => esc_html__('Button Text', 'slz'),
								),
								'contact-form' =>	array(
								    'type'    => 'select',
								    'label'   => esc_html__('Contact Form', 'slz'),
								    'desc'  => esc_html__('Choose contact from plugin "Contact Form 7"', 'slz'),
								    'choices' => $contact_form,
								),
							)
						),
						'other_tab' => array(
							'title'   => esc_html__( 'Other Settings', 'slz' ),
							'type'    => 'tab',
							'options' => array(
								'add_shortcode'   => array(
								    'type'  => 'textarea',
								    'label' => esc_html__('Add Shortcode', 'slz'),
								    'desc'  => esc_html__('Paste any shortcode what you want to display on sub header', 'slz'),
								),
							)
						),
					),
				),
				'show_borders' => false,
			),
	    ),
	    'show_borders' => true,
	),
	'topbar-box' => array(
	    'type' => 'box',
	    'title' => esc_html__('Topbar Settings', 'slz'),
	    'options' => array(
	        'enable-header-top-bar'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'selected-value' => array(
						'label'        => esc_html__( 'Header Top Bar', 'slz' ),
						'desc'         => esc_html__( 'Enable the header top bar?', 'slz' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'slz' )
						),
						'left-choice'  => array(
							'value' => 'no',
							'label' => esc_html__( 'No', 'slz' )
						),
						'value'        => 'no',
					)
				),
				'choices'      => array(
					'yes' => array(
						'styling' => array(
							'type'          => 'popup',
							'attr'          => array( 'class' => 'slz-advanced-button' ),
							'label'         => esc_html__( 'Custom Style', 'slz' ),
							'desc'          => esc_html__( 'Change the style of topbar', 'slz' ),
							'button'        => esc_html__( 'Styling', 'slz' ),
							'size'          => 'medium',
							'popup-options' => array(
								'bg-color'     => array(
									'label'   => esc_html__( 'Background Color', 'slz' ),
									'desc'    => esc_html__( "Select the header's top bar background color", "slz" ),
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
								'border-color'     => array(
									'label'   => esc_html__( 'Border Color', 'slz' ),
									'desc'    => esc_html__( "Select the header's top bar border color", "slz" ),
									'value'   => '',
									'choices' => $palette_color,
									'type'    => 'color-palette'
								),
								'text-color'      => array(
									'label'   => esc_html__( 'Text Color', 'slz' ),
									'desc'    => esc_html__( 'Select header\'s top bar text color', 'slz' ),
									'value'   => '',
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
						'left-position'            => array(
							'label'  => esc_html__( 'Left Content', 'slz' ),
							'type'   => 'addable-option',
							'option' => array(
								'type' => 'select',
								'choices' => $option_content_topbar
							),
							'value'  => array( 'menu' ),
							'desc'   => esc_html__( 'Choose content will be show in topbar left.',
								'slz' ),
						),
						'right-position'            => array(
							'label'  => esc_html__( 'Right Content', 'slz' ),
							'type'   => 'addable-option',
							'option' => array(
								'type' => 'select',
								'choices' => $option_content_topbar
							),
							'value'  => array( 'social' ),
							'desc'   => esc_html__( 'Choose content will be show in topbar right.',
								'slz' ),
						),
						'menu' 	=>	array(
						    'type'  => 'select',
						    'attr'	=> array('data-saved-value' => ( !empty ( $menu_locations['top-nav'] ) ? $menu_locations['top-nav'] : '')),
						    'label' => esc_html__('Select Menu', 'slz'),
						    'desc'  => esc_html__('Select menu for topbar menu. This changes will be apply for all headers.', 'slz'),
						    'choices' => $regist_menu,
						    'value'	=> ( !empty ( $menu_locations['top-nav'] ) ? $menu_locations['top-nav'] : '')
						),
						'customize-icon'   => array(
							'type'         => 'multi-picker',
							'label'        => false,
							'desc'         => false,
							'picker'       => array(
								'icon-display' 	=>	array(
								    'type'  => 'select',
								    'label' => esc_html__('Customize Icon', 'slz'),
								    'desc'  => esc_html__('Select option to choose how to display the customize icon.', 'slz'),
								    'choices' => array(
								    	'icon'		=> esc_html__('Show icon only', 'slz'),
								    	'text'		=> esc_html__('Show text only', 'slz'),
								    	'both'		=> esc_html__('Show text and icon', 'slz'),
								    ),
								    'value'	=> ''
								)
							),
							'choices'      => array(
								'both' => array(
									'text-position' => array(
										'label'        => esc_html__( 'Text Position', 'slz' ),
										'desc'         => esc_html__( 'Select your prefered text position', 'slz' ),
										'type'         => 'switch',
										'right-choice' => array(
											'value' => 'right',
											'label' => esc_html__( 'Right', 'slz' )
										),
										'left-choice'  => array(
											'value' => 'left',
											'label' => esc_html__( 'Left', 'slz' )
										),
										'value'        => 'right',
									),
								),
							),
							'show_borders' => true,
						),
						'button' => array(
							'type'          => 'popup',
							'attr'          => array( 'class' => 'slz-advanced-button' ),
							'label'         => esc_html__( 'Button Style', 'slz' ),
							'desc'          => esc_html__( 'Change the style for button', 'slz' ),
							'button'        => esc_html__( 'Styling', 'slz' ),
							'size'          => 'medium',
							'popup-options' => array(
								'btn-text'     => array(
									'label'   => esc_html__( 'Button Text', 'slz' ),
									'type'    => 'text'
								),
								'btn-link'     => array(
									'label'   => esc_html__( 'Button Link', 'slz' ),
									'type'    => 'text'
								),
								'bg-color'     => array(
									'label'   => esc_html__( 'Button Background Color', 'slz' ),
									'type'    => 'rgba-color-picker'
								),
								'bg-hv-color'     => array(
									'label'   => esc_html__( 'Button Background Hover Color', 'slz' ),
									'type'    => 'rgba-color-picker'
								),
								'text-color'      => array(
									'label'   => esc_html__( 'Button Text Color', 'slz' ),
									'type'    => 'rgba-color-picker'
								),
								'text-hv-color'      => array(
									'label'   => esc_html__( 'Button Text Hover Color', 'slz' ),
									'type'    => 'rgba-color-picker'
								),
								'bd-color'     => array(
									'label'   => esc_html__( 'Border Color', 'slz' ),
									'type'    => 'rgba-color-picker'
								),
								'bd-hv-color'     => array(
									'label'   => esc_html__( 'Border Hover Color', 'slz' ),
									'type'    => 'rgba-color-picker'
								),
							),
						),
                        $arr_event_topbar_option,
                        $arr_btn_donation,
                        'show_topbarmenu_menu_mobile'=>array(
                            'type'  => 'checkbox',
                            'value' => false, // checked/unchecked
                            'label' => esc_html__('Show Top Bar In Menu Mobile', 'slz'),
                            'desc'  => esc_html__('Show top bar in menu mobile', 'slz'),
                            'text'  => esc_html__('Yes', 'slz'),
                        )
					),
				),
				'show_borders' => true,
			),
	    ),
	    'show_borders' => true,
	),
	'other-box' => array(
	    'type' => 'box',
	    'title' => esc_html__('Other Settings', 'slz'),
	    'options' => array(
	        'search-group'      => array(
				'type'    => 'group',
				'options' => array(
					'search-group-styling' => array(
						'attr'          => array(
							'data-advanced-for' => 'search-group-styling',
							'class'             => 'slz-advanced-button'
						),
						'type'          => 'popup',
						'label'         => esc_html__( 'Custom Style', 'slz' ),
						'desc'          => esc_html__( 'Change the style / typography of search box', 'slz' ),
						'button'        => esc_html__( 'Styling', 'slz' ),
						'size'          => 'medium',
						'popup-options' => array(
							'icon-class' => array(
								'type'  => 'icon',
								'value' => '',
								'label' => esc_html__( 'Search Icon', 'slz' )
							),
							'bg-color' => array(
								'label'   => esc_html__( 'Background Color', 'slz' ),
								'desc'    => esc_html__( 'Select the background color for search box', 'slz' ),
								'value'   => '',
								'choices' => SLZ_Com::get_palette_color(),
								'type'    => 'color-palette'
							),
							'text-color' => array(
								'label'   => esc_html__( 'Text Color', 'slz' ),
								'desc'    => esc_html__( 'Select the text color for search box', 'slz' ),
								'value'   => '',
								'choices' => SLZ_Com::get_palette_color(),
								'type'    => 'color-palette'
							)
						)
					),
					'enable-search' => array(
						'attr'    => array( 'class' => 'search-group-styling' ),
						'type'         => 'switch',
						'value'        => 'no',
						'label'        => esc_html__( 'Search Box', 'slz' ),
						'desc'         => esc_html__( 'Enable search box ?', 'slz' ),
						'left-choice'  => array(
							'value' => 'no',
							'label' => esc_html__( 'Disable', 'slz' ),
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Enable', 'slz' ),
						)
					),
				)
			),
	        'breaking-news-group' => $breaking_news_arr,
	    ),
	    'show_borders' => true,
	),
);