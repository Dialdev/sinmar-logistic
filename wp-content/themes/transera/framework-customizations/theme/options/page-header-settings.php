<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
$align = array(
	'left'   => esc_html__('Left','transera'),
	'right'  => esc_html__('Right','transera'),
	'center' => esc_html__('Center','transera')
	);

$general_box = array(
	'general-content-box' => array(
		'title'   => esc_html__( 'Area Setting', 'transera' ),
		'type'    => 'box',
		'options' => array(
			'bg-color'    => array(
				'label'   => esc_html__( 'Background Color', 'transera' ),
				'desc'    => esc_html__( "Select the page header background color", 'transera' ),
				'value'   => '',
				'choices' => SLZ_Com::get_palette_color(),
				'type'    => 'color-palette'
			),
			'bg-image'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'bg-image-type' => array(
						'type'  => 'radio',
						'value' => 'upload-image',
						'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						'label' => esc_html__('Background Image', 'transera'),
						'choices' => array(
							'upload-image'  => esc_html__('Upload Image', 'transera'),
							'feature-image' => esc_html__('Featured Image', 'transera'),
						),
						'inline' => true,
					),
				),
				'choices'      => array(
					'upload-image' => array(
						'background-image' => array(
							'label'   => esc_html__( 'Image', 'transera' ),
							'type'    => 'background-image',
							'value'   => 'none',
							'desc'    => esc_html__( 'Upload an image to make background image', 'transera' ),
						),
					)
				),
			),
			'bg-attachment' => array(
				'type'    => 'select',
				'label'   => esc_html__('Background Attachment', 'transera'),
				'choices' => SLZ_Params::get('option-bg-attachment'),
			),
			'bg-size' => array(
				'type'    => 'select',
				'label'   => esc_html__('Background Size', 'transera'),
				'choices' => SLZ_Params::get('option-bg-size'),
			),
			'bg-position' => array(
				'type'    => 'select',
				'label'   => esc_html__('Background Position', 'transera'),
				'choices' => SLZ_Params::get('option-bg-position'),
			),
			'text-align'  => array(
				'type'    => 'select',
				'label'   => esc_html__('Page Header Align', 'transera'),
				'choices' => $align,
			),
			'height'    => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Page Header Height', 'transera' ),
				'desc'  => esc_html__( 'Enter heigth in pixels. Ex:30 ', 'transera' ),
				'value' => '30',
			),
		),
	),
);
$general_title_box = array(
	'title-content-box' => array(
		'title'   => esc_html__( 'Title Setting', 'transera' ),
		'type'    => 'box',
		'options' => array(
			'general-pagetitle-title'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
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
				),
				'choices'      => array(
					'enable' => array(
						'type-of-title' => array(
							'type'         => 'multi-picker',
							'label'        => false,
							'desc'         => false,
							'picker'       => array(
								'title-type' => array(
									'type'  => 'radio',
									'value' => 'title',
									'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
									'label' => esc_html__('Choose Title', 'transera'),
									'choices' => array(
										'title'      => esc_html__('Page Title','transera'),
										'custom'     => esc_html__('Custom','transera'),
									),
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
						'title-typography' => array(
							'type'         => 'typography',
							'label'        => esc_html__( 'Styling', 'transera' ),
							'value' => array(
								'size'   => 45,
						        'color'  => '#18364a'
							),
							'components' => array(
								'family' => false,
							),
						),
					),
				),
			),
		),
	),
);
$post_title_box = array(
	'title-content-box' => array(
		'title'   => esc_html__( 'Title Setting', 'transera' ),
		'type'    => 'box',
		'options' => array(
			'general-pagetitle-title'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
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
				),
				'choices'      => array(
					'enable' => array(
						'type-of-title' => array(
							'type'         => 'multi-picker',
							'label'        => false,
							'desc'         => false,
							'picker'       => array(
								'title-type' => array(
									'type'  => 'radio',
									'value' => 'level',
									'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
									'label' => esc_html__('Choose Title', 'transera'),
									'choices' => array(
										'title'      => esc_html__( 'Post Title','transera' ),
										'level'      => esc_html__( 'Category','transera' ),
										'custom'     => esc_html__( 'Custom','transera' ),
									),
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
						'title-typography' => array(
							'type'         => 'typography',
							'label'        => esc_html__( 'Styling', 'transera' ),
							'value' => array(
								'size'   => 45,
								'color'  => '#18364a'
							),
							'components' => array(
								'family' => false,
							),
						),
					),
				),
			),
		),
	),
);
$breadcrumb_box = array(
	'breadcrumb-content-box'	=> array(
		'title'   => esc_html__( 'Breadcrumb Setting', 'transera' ),
		'type'    => 'box',
		'options' => array(
			'general-pagetitle-bc'   => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
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
				'choices'      => array(
					'enable' => array(
						'breadcrumb' => array(
							'type'         => 'typography',
							'label'        => esc_html__( 'Breadcrumb Styling', 'transera' ),
							'value' => array(
								'size'   => 14,
								'color'  => '#666c72'
							),
							'components' => array(
								'family' => false,
							),
						),
						'breadcrumb-active' => array(
							'type'         => 'typography',
							'label'        => esc_html__( 'Breadcrumb Active Styling', 'transera' ),
							'value' => array(
								'size'   => 14,
								'color'  => '#db0f31'
							),
							'components' => array(
								'family' => false,
							),
						),
					),
				),
			),
		),
	)
);

$woo_option = array();
if( TRANSERA_WC_ACTIVE ) {
	$woo_option = array(
		'product-tab' => array(
			'title'   => esc_html__( 'Product', 'transera' ),
			'type'    => 'tab',
			'options' => array(
				'product-pagetitle' => array(
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
							),
						),
					),
					'choices'      => array(
						'enable' => array(
							$general_box,
							$post_title_box,
							$breadcrumb_box
						),
					),
				),
			),
		),
	);
}

$options = array(
	'page-title' => array(
		'title'   => esc_html__( 'Page Header', 'transera' ),
		'type'    => 'tab',
		'options' => array(
			'general-tab' => array(
				'title'   => esc_html__( 'General', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'general-pagetitle'   => array(
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
								$general_box,
								$general_title_box,
								$breadcrumb_box
							),
						),
					),
				),
			),
			'post-tab' => array(
				'title'   => esc_html__( 'Posts', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'post-pagetitle'   => array(
						'type'         => 'multi-picker',
						'label'        => false,
						'desc'         => false,
						'picker'       => array(
							'enable-page-title' => array(
								'type'         => 'switch',
								'value'        => 'enable',
								'label'        => esc_html__( 'Page Header', 'transera' ),
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
								$general_box,
								$post_title_box,
								$breadcrumb_box
							),
						),
					),
				),
			),
			'service-tab' => array(
				'title'   => esc_html__( 'Service', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'slz-service-pagetitle'   => array(
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
								$general_box,
								$post_title_box,
								$breadcrumb_box
							),
						),
					),
				),
			),
			'team-tab' => array(
				'title'   => esc_html__( 'Team', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'slz-team-pagetitle'   => array(
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
								$general_box,
								$post_title_box,
								$breadcrumb_box
							),
						),
					),
				),
			),
			$woo_option
		)
	)
);

