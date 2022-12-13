<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
$regist_sidebars = array_merge( array( 'default' => esc_html__('-- Default --', 'transera') ), SLZ_Com::get_regist_sidebars() );

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

$page_header = slz()->theme->get_options( 'page-options' );

$options = array(
	'post-settings' => array(
		'type'    => 'box',
		'title'   => esc_html__(' Post Options','transera' ),
		'options' => array(
			'post-general-settings' => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'General Settings', 'transera' ),
				'options' => array(
					'post-template' => array(
						'label'   => esc_html__( 'Post Template', 'transera' ),
						'type'    => 'image-picker',
						'attr'    => array('class' => 'slz-image-picker-max-width' ),
						'choices' => array_merge( $default, slz_ext('posts')->get_post_choices() ),
						'value'   => 'default'
					),
					'post-sidebar-layout' => array(
						'label' => esc_html__( 'Sidebar Layout', 'transera' ),
						'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
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
									'src'	=> TRANSERA_OPTION_IMG_URI . '/sidebar/right.png'
								)
							),
							'none' => array(
								'small' => array(
									'height' => 50,
									'src'	=> TRANSERA_OPTION_IMG_URI . '/sidebar/full.png'
								)
							),
						) ),
						'value' => 'default'
					),
					'post-sidebar'  =>  array(
						'type'    => 'select',
						'label'   => esc_html__('Choose Sidebar', 'transera'),
						'desc'    => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
						'choices' => $regist_sidebars,
						'value'   => 'default'
					),
				)
			),
			$page_header,
			'feature-video' => array(
				'title'   => esc_html__( 'Feature Video', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'feature-video-settings' => array(
						'type'    => 'tab',
						'options' => array(
							'thumbnail' => array(
								'type'  => 'checkbox',
								'value' => false,
								'label' => esc_html__('Video Thumbnail', 'transera'),
								'text'  => esc_html__('Create thumbnail from video and using it as featured image?.', 'transera'),
							),
							'video_type'   => array(
								'type'   => 'multi-picker',
								'label'  => false,
								'desc'   => false,
								'picker' => array(
									'video_options' => array(
										'type'  => 'switch',
										'value' => 'yes',
										'label' => esc_html__( 'Type of Video', 'transera' ),
										'left-choice' => array(
											'value' => 'youtube',
											'label' => esc_html__( 'Youtube', 'transera' ),
										),
										'right-choice' => array(
											'value' => 'vimeo',
											'label' => esc_html__( 'Vimeo', 'transera' ),
										)
									),
								),
								'choices' => array(
									'vimeo' => array(
										'vimeo_link' => array(
											'type'  => 'text',
											'value' => '',
											'label' => esc_html__('Vimeo ID', 'transera'),
											'desc'  => esc_html__('Example the Video ID for http://vimeo.com/86323053 is 86323053', 'transera'),
										),
									),
									'youtube' => array(
										'youtube_link' => array(
											'type'  => 'text',
											'value' => '',
											'label' => esc_html__('Youtube ID', 'transera'),
											'desc'  => esc_html__('Example the Video ID for http://www.youtube.com/v/8OBfr46Y0cQ is 8OBfr46Y0cQ', 'transera'),
										),
									),
								),
							),
						)
					)
				),
			),
			'feature-audio' => array(
				'title'   => esc_html__( 'Feature Audio', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'feature-audio-settings' => array(
						'type'    => 'tab',
						'options' => array(
							'feature-audio-link' => array(
								'type'  => 'text',
								'value' => '',
								'label' => esc_html__('Audio Link', 'transera'),
								'desc'  => esc_html__('Input full link of audio.', 'transera'),
							),
						)
					)
				),
			),
			'feature-gallery' => array(
				'title'   => esc_html__( 'Feature Gallery', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'feature-gallery-settings' => array(
						'type'    => 'tab',
						'options' => array(
							'feature-gallery-images' => array (
								'type'  => 'multi-upload',
								'value' => array (),
								'label' => esc_html__( 'Gallery Images', 'transera' ),
								'help'  => esc_html__( 'Choose Images to upload', 'transera' ),
								'images_only' => true,
							),
						)
					)
				),
			),
			'feature-quote' => array(
				'title'   => esc_html__( 'Feature Quote', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'feature-quote-settings' => array(
						'type'    => 'tab',
						'options' => array(
							'feature-quote-info' => array (
								'type'  => 'textarea',
								'value' => '',
								'label' => esc_html__('Quote Text', 'transera'),
								'help'  => esc_html__('Input quote text info', 'transera'),
							),
						)
					)
				),
			),
		),
	)
);