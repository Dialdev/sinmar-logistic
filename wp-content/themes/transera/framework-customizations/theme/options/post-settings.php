<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$post_ext = slz_ext('posts');

if ( empty( $post_ext ) ) 
	return;

$regist_sidebars = array_merge( array( '' => esc_html__('-- Select widget area --', 'transera') ), SLZ_Com::get_regist_sidebars() );

$options = array(
	'posts'          => array(
		'title'   => esc_html__( 'Post Settings', 'transera' ),
		'type'    => 'tab',
		'options' => array(
			'posts-tab'          => array(
				'title'   => esc_html__( 'Post Settings', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'posts-box'        => array(
						'title'   => esc_html__( 'Posts', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'blog-layout'	=> array(
								'type'    => 'image-picker',
								'label'   => esc_html__( 'Blog Style', 'transera' ),
								'desc'    => esc_html__( 'Select the blog display style', 'transera' ),
								'choices' => $post_ext->get_post_choices(),
								'value'   => SLZ_Com::get_first( $post_ext->get_post_choices() ),
							),
							'blog-sidebar-layout'    => array(
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
							'blog-sidebar'	=>	array(
								'type'  => 'select',
								'label' => esc_html__('Post Sidebar', 'transera'),
								'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
								'choices' => $regist_sidebars,
							),
						)
					),
					'related-box'        => array(
						'title'   => esc_html__( 'Related Articles', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'blog-article'   => array(
								'type'         => 'multi-picker',
								'label'        => false,
								'desc'         => false,
								'picker'       => array(
									'status' => array(
										'label'        => esc_html__( 'Show Related Articles', 'transera' ),
										'desc'         => esc_html__( 'Show related articles ?', 'transera' ),
										'type'         => 'switch',
										'right-choice' => array(
											'value' => 'show',
											'label' => esc_html__( 'Show', 'transera' )
										),
										'left-choice'  => array(
											'value' => 'hide',
											'label' => esc_html__( 'Hide', 'transera' )
										),
										'value'        => 'hide',
									)
								),
								'choices'      => array(
									'show' => array(
										'filter-by' => array(
											'label'        => esc_html__( 'Filter By', 'transera' ),
											'desc'         => esc_html__( 'Filter related articles by ?', 'transera' ),
											'type'         => 'switch',
											'right-choice' => array(
												'value' => 'category',
												'label' => esc_html__( 'By Category', 'transera' )
											),
											'left-choice'  => array(
												'value' => 'tag',
												'label' => esc_html__( 'By Tag', 'transera' )
											),
											'value'        => 'category',
										),
										'limit'           => array(
											'type'  => 'short-text',
											'label' => esc_html__( 'Article Post Limit', 'transera' ),
											'desc'  => esc_html__( 'Total post of related article will be show. Ex: 6, 12', 'transera' ),
											'value' => '6',
										),
										'order_by'	=>	array(
											'type'  => 'select',
											'label' => esc_html__('Article Order By', 'transera'),
											'desc'  => esc_html__('Order the post in related article by ?', 'transera'),
											'choices' => array(
												'id' => esc_html__('ID', 'transera'),
												'title' => esc_html__('Title', 'transera'),
												'date' => esc_html__('Date', 'transera'),
												'author' => esc_html__('Author', 'transera'),
												'random' => esc_html__('Random', 'transera')
											),
										),
										'order'	=>	array(
											'type'  => 'select',
											'label' => esc_html__('Article Order', 'transera'),
											'desc'  => esc_html__('Order the post in related article with ascending or descending mode ?', 'transera'),
											'choices' => array(
												'desc' 	=> esc_html__('Desc', 'transera'),
												'asc' 	=> esc_html__('Asc', 'transera')
											),
										)
									),
								),
								'show_borders' => true,
							),
						)
					),
					'post-content-box'	=> array(
						'title'   => esc_html__( 'Other Settings', 'transera' ),
						'type'    => 'box',
						'options' => array(
							'blog-post-tags'         => array(
								'label'        => esc_html__( 'Post Tags', 'transera' ),
								'desc'         => esc_html__( 'Show post tags?', 'transera' ),
								'type'         => 'switch',
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__( 'Yes', 'transera' )
								),
								'left-choice'  => array(
									'value' => 'no',
									'label' => esc_html__( 'No', 'transera' )
								),
								'value'        => 'yes',
							),
							'blog-post-author-box'         => array(
								'label'        => esc_html__( 'Author Box', 'transera' ),
								'desc'         => esc_html__( 'Show author box?', 'transera' ),
								'type'         => 'switch',
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__( 'Yes', 'transera' )
								),
								'left-choice'  => array(
									'value' => 'no',
									'label' => esc_html__( 'No', 'transera' )
								),
								'value'        => 'yes',
							),
                            'social-in-post'   => array(
                                'type'         => 'multi-picker',
                                'label'        => false,
                                'desc'         => false,
                                'picker'       => array(
                                    'enable-social-share' => array(
                                        'type'         => 'switch',
                                        'value'        => 'yes',
                                        'label'        => esc_html__( 'Social Share', 'transera' ),
										'desc'         => esc_html__( 'Enable share social icon in single pages ?', 'transera' ),
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
                                        'social-share-info' => array(
                                            'label'  => esc_html__( 'Add Social', 'transera' ),
                                            'type'   => 'addable-option',
                                            'option' => array(
                                                'type'  => 'select',
                                                'choices'	=>	array(
                                                    'facebook' 	  => esc_html__('Facebook', 'transera'),
                                                    'twitter'     => esc_html__('Twitter', 'transera'),
                                                    'google-plus' => esc_html__('Google Plus', 'transera'),
                                                    'pinterest'   => esc_html__('Pinterest', 'transera'),
                                                    'linkedin' 	  => esc_html__('Linkedint', 'transera')
                                                )
                                            )
                                        ),
										'social-share-count' => array(
											'type'   => 'multi-picker',
											'label'  => false,
											'desc'   => false,
											'picker' => array(
												'enable-social-share-count' => array(
													'type'        => 'switch',
													'value'       => 'disable',
													'label'       => esc_html__( 'Share Count', 'transera' ),
													'desc'        => esc_html__( 'Enable share count in post info ?', 'transera' ),
													'left-choice' => array(
														'value' => 'disable',
														'label' => esc_html__( 'Disable', 'transera' )
													),
													'right-choice' => array(
														'value' => 'enable',
														'label' => esc_html__( 'Enable', 'transera' )
													)
												)
											),
											'choices'    => array(
												'enable' => array(
													'social-share-facebook-appid' => array(
														'type'  => 'text',
														'label' => esc_html__('Facebook App ID', 'transera'),
														'desc'  => esc_html__( 'Enter App ID to get the share count of Facebook.', 'transera' )
													),
													'social-share-facebook-secret-key' => array(
														'type'  => 'text',
														'label' => esc_html__('Facebook Secret Key', 'transera'),
														'desc'  => esc_html__( 'Enter Secret Key to get the share count of Facebook.', 'transera' )
													)
												)
											)
										)
                                    )
                                )
                            )
						)
					)

				)
			),
			'post-info-tab'          => array(
				'title'   => esc_html__( 'Post Info', 'transera' ),
				'type'    => 'tab',
				'options' => array(
					'post-info'            => array(
						'label'  => esc_html__( 'Select Post Info', 'transera' ),
						'type'   => 'addable-option',
						'option' => array(
							'type'  => 'select',
							'choices'	=>	array(
								'author'		=>	esc_html__('Author', 'transera'),
								'category' 		=>	esc_html__('Category', 'transera'),
								'tag' 			=>	esc_html__('Tag', 'transera'),
								'comment' 		=>	esc_html__('Comment Count', 'transera'),
								'view' 			=>	esc_html__('View Count', 'transera'),
							)
						),
						'value'  => array( 'category', 'author' ),
						'desc'   => esc_html__( 'Select post info to show in post detail and block detail.',
							'transera' ),
					),
				)
			),

		)
	),
);