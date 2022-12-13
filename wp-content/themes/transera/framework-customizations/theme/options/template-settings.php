<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$article_ext = slz_ext('articles');

if ( $article_ext != null )
{
	$regist_sidebars = array_merge( array( '' => esc_html__('-- Select widget area --', 'transera') ), SLZ_Com::get_regist_sidebars() );

	$options = array(
		'article_tab' => array(
			'title'   => esc_html__( 'Template Settings', 'transera' ),
			'type'    => 'tab',
			'options' => array(
				'template-settings-tab' => array(
					'title'   => esc_html__( 'Template Settings', 'transera' ),
					'type'    => 'tab',
					'options' => array(
						'category-template-box' => array(
							'title'   => esc_html__( 'Category Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'category-article-style' => array(
									'label' => esc_html__( 'Article Style', 'transera' ),
									'type'    => 'image-picker',
									'choices' => $article_ext->get_article_choices(),
									'value'   => SLZ_Com::get_first( $article_ext->get_article_choices() ),
								),
								'category-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'category-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'archive-template-box' => array(
							'title'   => esc_html__( 'Archive Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'archive-article-style' => array(
									'label' => esc_html__( 'Article Style', 'transera' ),
									'type'    => 'image-picker',
									'choices' => $article_ext->get_article_choices(),
									'value'   => SLZ_Com::get_first( $article_ext->get_article_choices() ),
								),
								'archive-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'archive-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'page-template-box' => array(
							'title'   => esc_html__( 'Page Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'page-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'page-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'main-blog-template-box' => array(
							'title'   => esc_html__( 'Blog Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'main-blog-article-style' => array(
									'label' => esc_html__( 'Article Style', 'transera' ),
									'type'    => 'image-picker',
									'choices' => $article_ext->get_article_choices(),
									'value'   => SLZ_Com::get_first( $article_ext->get_article_choices() ),
								),
								'main-blog-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'main-blog-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'author-template-box' => array(
							'title'   => esc_html__( 'Author Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'author-article-style' => array(
									'label' => esc_html__( 'Article Style', 'transera' ),
									'type'    => 'image-picker',
									'choices' => $article_ext->get_article_choices(),
									'value'   => SLZ_Com::get_first( $article_ext->get_article_choices() ),
								),
								'author-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'author-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'search-template-box' => array(
							'title'   => esc_html__( 'Search Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'search-article-style' => array(
									'label' => esc_html__( 'Article Style', 'transera' ),
									'type'    => 'image-picker',
									'choices' => $article_ext->get_article_choices(),
									'value'   => SLZ_Com::get_first( $article_ext->get_article_choices() ),
								),
								'search-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'search-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'tag-template-box' => array(
							'title'   => esc_html__( 'Tag Settings', 'transera' ),
							'type'    => 'box',
							'options' => array(
								'tag-article-style' => array(
									'label' => esc_html__( 'Article Style', 'transera' ),
									'type'    => 'image-picker',
									'choices' => $article_ext->get_article_choices(),
									'value'   => SLZ_Com::get_first( $article_ext->get_article_choices() ),
								),
								'tag-sidebar-layout'    => array(
									'label' => esc_html__( 'Sidebar Layout', 'transera' ),
									'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
									'type'  => 'image-picker',
									'choices' => array(
										'left' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/left.png'
											)
										),
										'right' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/right.png'
											)
										),
										'none' => array(
											'small' => array(
												'height' => 50,
												'src'    => TRANSERA_OPTION_IMG_URI .'/sidebar/full.png'
											)
										),
									),
									'value' => 'left'
								),
								'tag-sidebar'  =>  array(
									'type'  => 'select',
									'label' => esc_html__('Choose Sidebar', 'transera'),
									'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
									'choices' => $regist_sidebars,
								),
							)
						),
						'team-tab'=>array(
							'type'=>'box',
							'title'   => esc_html__( 'Team Settings', 'transera' ),
							'options'=> array(
								'team-template-box' => array(
									'title'   => esc_html__( 'Team Single', 'transera' ),
									'type'    => 'tab',
									'options' => array(
										'team-sidebar-layout' => array(
											'label' => esc_html__( 'Sidebar Layout', 'transera' ),
											'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
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
											),
											'value' => 'left'
										),
										'team-sidebar'  =>  array(
											'type'  => 'select',
											'label' => esc_html__('Choose Sidebar', 'transera'),
											'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
											'choices' => $regist_sidebars,
										),
									)
								),
								'team-template-ac-box' => array(
									'title'   => esc_html__( 'Team Archive', 'transera' ),
									'type'    => 'tab',
									'options' => array(
										'team-ac-sidebar-layout'    => array(
											'label' => esc_html__( 'Sidebar Layout', 'transera' ),
											'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
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
											),
											'value' => 'left'
										),
										'team-ac-sidebar'  =>  array(
											'type'  => 'select',
											'label' => esc_html__('Choose Sidebar', 'transera'),
											'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
											'choices' => $regist_sidebars,
										),
									)
								),
							)
						),
						'recruitment-tab'=>array(
							'type'=>'box',
							'title'   => esc_html__( 'Recruitment Settings', 'transera' ),
							'options'=> array(
								'recruitment-template-box' => array(
									'title'   => esc_html__( 'Recruitment Single', 'transera' ),
									'type'    => 'tab',
									'options' => array(
										'recruitment-sidebar-layout' => array(
											'label' => esc_html__( 'Sidebar Layout', 'transera' ),
											'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
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
											),
											'value' => 'left'
										),
										'recruitment-sidebar'  =>  array(
											'type'  => 'select',
											'label' => esc_html__('Choose Sidebar', 'transera'),
											'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
											'choices' => $regist_sidebars,
										),
									)
								),
								'recruitment-template-ac-box' => array(
									'title'   => esc_html__( 'Recruitment Archive', 'transera' ),
									'type'    => 'tab',
									'options' => array(
										'recruitment-ac-sidebar-layout'    => array(
											'label' => esc_html__( 'Sidebar Layout', 'transera' ),
											'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
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
											),
											'value' => 'left'
										),
										'recruitment-ac-sidebar'  =>  array(
											'type'  => 'select',
											'label' => esc_html__('Choose Sidebar', 'transera'),
											'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
											'choices' => $regist_sidebars,
										),
									)
								),
							)
						),
						'service-tab'=>array(
							'type'=>'box',
							'title'   => esc_html__( 'Service Settings', 'transera' ),
							'options'=> array(
								'service-template-box' => array(
									'title'   => esc_html__( 'Service Single', 'transera' ),
									'type'    => 'tab',
									'options' => array(
										'service-sidebar-layout' => array(
											'label' => esc_html__( 'Sidebar Layout', 'transera' ),
											'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
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
											),
											'value' => 'left'
										),
										'service-sidebar'  =>  array(
											'type'  => 'select',
											'label' => esc_html__('Choose Sidebar', 'transera'),
											'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
											'choices' => $regist_sidebars,
										),
									)
								),
								'service-template-ac-box' => array(
									'title'   => esc_html__( 'Team Archive', 'transera' ),
									'type'    => 'tab',
									'options' => array(
										'service-ac-sidebar-layout'    => array(
											'label' => esc_html__( 'Sidebar Layout', 'transera' ),
											'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
											'type'  => 'image-picker',
											'choices' => array(
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
											),
											'value' => 'left'
										),
										'service-ac-sidebar'  =>  array(
											'type'  => 'select',
											'label' => esc_html__('Choose Sidebar', 'transera'),
											'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
											'choices' => $regist_sidebars,
										),
									)
								),
							)
						),
					)
				),
			)
		)
	);
}
