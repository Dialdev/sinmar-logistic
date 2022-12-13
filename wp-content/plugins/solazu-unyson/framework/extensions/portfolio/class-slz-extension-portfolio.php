<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Extension_Portfolio extends SLZ_Extension {
	private $post_type_name = 'slz-portfolio';
	private $post_type_slug = 'project';
	private $taxonomy_name = 'slz-portfolio-cat';
	private $taxonomy_slug = 'portfolio-cat';
	private $taxonomy_tag_name = 'slz-portfolio-tag';
	private $taxonomy_tag_slug = 'portfolio-tag';

	private $taxonomy_status_name = 'slz-portfolio-status';
	private $taxonomy_status_slug = 'portfolio-status';


	public function slz_get_post_type_slug() {
		return $this->post_type_slug;
	}

	public function get_post_type_name() {
		return $this->post_type_name;
	}

	public function get_taxonomy_name() {
		return $this->taxonomy_name;
	}

	public function _get_link() {
		return self_admin_url( 'edit.php?post_type=' . $this->get_post_type_name() );
	}

	public function get_image_sizes() {
		return $this->get_config( 'image_sizes' );
	}

	public function get_taxonomy_link( $taxonomy ) {
		return admin_url( 'edit-tags.php?taxonomy=' . $taxonomy . '&post_type=' . $this->post_type_name );
	}
	/**
	 * @internal
	 */
	protected function _init() {
		$this->define_slugs();
		$this->register_post_type();
		$this->register_taxonomy();

		if ( is_admin() ) {
			$this->save_permalink_structure();
			$this->add_admin_filters();
			$this->add_admin_actions();
		} else {
			$this->add_theme_actions();
		}
	}

	private function save_permalink_structure() {
		if ( ! isset( $_POST['permalink_structure'] ) && ! isset( $_POST['category_base'] ) ) {
			return;
		}

		$this->set_db_data(
			'permalinks/post',
			SLZ_Request::POST(
				'slz_ext_portfolio_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_portfolios_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
			)
		);
	}

	/**
	 * @internal
	 **/
	public function _action_add_permalink_in_settings() {
		add_settings_field(
			'slz_ext_portfolio_slug',
			esc_html__( 'Portfolio base', 'slz' ),
			array( $this, '_portfolio_slug_input' ),
			'permalink',
			'optional'
		);

		add_settings_field(
			'slz_ext_portfolios_taxonomy_slug',
			esc_html__( 'Portfolio category base', 'slz' ),
			array( $this, '_taxonomy_slug_input' ),
			'permalink',
			'optional'
		);
	}

	/**
	 * @internal
	 **/
	public function _action_save_post() {
		$posts_rating = slz()->theme->get_config('posts_rating');
		if( isset( $posts_rating[$this->get_post_type_name()] ) && isset( $_POST['slz_options']) ){
			global $post;
			$post_id = $post->ID;
			$rating = get_post_meta ( $post_id, $posts_rating[$this->get_post_type_name()], true );
			if( empty( $rating ) ){
				update_post_meta ( $post_id, $posts_rating[$this->get_post_type_name()], 0 );
			}
		}
	}

	/**
	 * @internal
	 */
	public function _portfolio_slug_input() {
		?>
		<input type="text" name="slz_ext_portfolio_slug" value="<?php echo $this->post_type_slug; ?>">
		<code>/my-portfolio</code>
		<?php
	}

	/**
	 * @internal
	 */
	public function _taxonomy_slug_input() {
		?>
		<input type="text" name="slz_ext_portfolios_taxonomy_slug" value="<?php echo $this->taxonomy_slug; ?>">
		<code>/my-portfolios-category</code>
		<?php
	}

	private function define_slugs() {
		$this->post_type_slug = $this->get_db_data(
			'permalinks/post',
			apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
		);
		$this->taxonomy_slug  = $this->get_db_data(
			'permalinks/taxonomy',
			apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
		);
	}

	private function register_post_type() {
		$post_names = apply_filters( 'slz_ext_' . $this->get_name() . '_post_type_name',
			array(
				'singular' => esc_html__( 'Project', 'slz' ),
				'plural'   => esc_html__( 'Portfolio', 'slz' ),
				'plural-2' => esc_html__( 'Projects', 'slz' ),
			) );
		$supports = array('title', 'editor', 'thumbnail');
		if( $this->get_config('supports_comment')) {
			array_push($supports, 'comments');
		}
		if( $this->get_config('supports_author')) {
			array_push($supports, 'author');
		}
		register_post_type( $this->post_type_name,
			array(
				'labels'             => array(
					'name'               => $post_names['plural'],//esc_html__( 'Portfolio', 'slz' ),
					'singular_name'      => $post_names['singular'],//esc_html__( 'Portfolio', 'slz' ),
					'add_new'            => esc_html__( 'Add New', 'slz' ),
					'add_new_item'       => sprintf( esc_html__( 'Add New %s', 'slz' ), $post_names['singular'] ),
					'edit'               => esc_html__( 'Edit', 'slz' ),
					'edit_item'          => sprintf( esc_html__( 'Edit %s', 'slz' ), $post_names['singular'] ),
					'new_item'           => sprintf( esc_html__( 'New %s', 'slz' ), $post_names['singular'] ),
					'all_items'          => sprintf( esc_html__( 'All %s', 'slz' ), $post_names['plural-2'] ),
					'view'               => sprintf( esc_html__( 'View %s', 'slz' ), $post_names['singular'] ),
					'view_item'          => sprintf( esc_html__( 'View %s', 'slz' ), $post_names['singular'] ),
					'search_items'       => sprintf( esc_html__( 'Search %s', 'slz' ), $post_names['plural-2'] ),
					'not_found'          => sprintf( esc_html__( 'No %s Found', 'slz' ), $post_names['plural'] ),
					'not_found_in_trash' => sprintf( esc_html__( 'No %s Found In Trash', 'slz' ), $post_names['plural'] ),
					'parent_item_colon'  => '' /* text for parent types */
				),
				'description'        => esc_html__( 'Create a item', 'slz' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->post_type_slug
				),
				'menu_position'      => 21,
				'show_in_nav_menus'  => true,
				'menu_icon'          => 'dashicons-portfolio',
				'hierarchical'       => false,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => $supports
			) );
	}

	private function register_taxonomy() {
		$category_names = apply_filters( 'slz_ext_' . $this->get_name() . '_category_name',
				array(
				'singular' => esc_html__( 'Category', 'slz' ),
				'plural'   => esc_html__( 'Categories', 'slz' )
			) );
		$post_names = apply_filters( 'slz_ext_' . $this->get_name() . '_post_type_name',
				array(
				'singular' => esc_html__( 'Project', 'slz' ),
				'plural'   => esc_html__( 'Projects', 'slz' )
			) );

		register_taxonomy( $this->taxonomy_name, $this->post_type_name, array(
			'labels'            => array(
				'name'              => sprintf( _x( '%s %s', 'taxonomy general name', 'slz' ),
					$post_names['singular'], $category_names['plural'] ),
				'singular_name'     => sprintf( _x( '%s %s', 'taxonomy singular name', 'slz' ),
					$post_names['singular'], $category_names['singular'] ),
				'search_items'      => sprintf( esc_html__( 'Search %s', 'slz' ), $category_names['plural'] ),
				'all_items'         => sprintf( esc_html__( 'All %s', 'slz' ), $category_names['plural'] ),
				'parent_item'       => sprintf( esc_html__( 'Parent %s', 'slz' ), $category_names['singular'] ),
				'parent_item_colon' => sprintf( esc_html__( 'Parent %s:', 'slz' ), $category_names['singular'] ),
				'edit_item'         => sprintf( esc_html__( 'Edit %s', 'slz' ), $category_names['singular'] ),
				'update_item'       => sprintf( esc_html__( 'Update %s', 'slz' ), $category_names['singular'] ),
				'add_new_item'      => sprintf( esc_html__( 'Add New %s', 'slz' ), $category_names['singular'] ),
				'new_item_name'     => sprintf( esc_html__( 'New %s Name', 'slz' ), $category_names['singular'] ),
				'menu_name'         => sprintf( esc_html__( '%s', 'slz' ), $category_names['plural'] )
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'rewrite'           => array(
				'slug' => $this->taxonomy_slug
			),
		) );

		if ( $this->get_config('enable_tag') ) {
			$tag_names = apply_filters( 'slz_ext_portfolio_tag_name', array(
				'singular' => __( 'Tag', 'slz' ),
				'plural'   => __( 'Tags', 'slz' )
			) );

			register_taxonomy($this->taxonomy_tag_name, $this->post_type_name, array(
				'hierarchical' => false,
				'labels' => array(
					'name'              => sprintf( __('Project %s','slz'), $tag_names['plural']),
					'singular_name'     => sprintf( __('Project %s','slz'), $tag_names['singular']),
					'search_items'      => sprintf( __('Search %s','slz'), $tag_names['plural']),
					'popular_items'     => sprintf( __( 'Popular %s','slz' ), $tag_names['plural']),
					'all_items'         => sprintf( __('All %s','slz'), $tag_names['plural']),
					'parent_item'       => null,
					'parent_item_colon' => null,
					'edit_item'         => sprintf( __('Edit %s','slz'), $tag_names['singular'] ),
					'update_item'       => sprintf( __('Update %s','slz'), $tag_names['singular'] ),
					'add_new_item'      => sprintf( __('Add New %s','slz'), $tag_names['singular'] ),
					'new_item_name'     => sprintf( __('New %s Name','slz'), $tag_names['singular'] ),
					'separate_items_with_commas'    => sprintf( __( 'Separate %s with commas','slz' ), strtolower($tag_names['plural'])),
					'add_or_remove_items'           => sprintf( __( 'Add or remove %s','slz' ), strtolower($tag_names['plural'])),
					'choose_from_most_used'         => sprintf( __( 'Choose from the most used %s','slz' ), strtolower($tag_names['plural'])),
				),
				'public' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array(
					'slug' => $this->taxonomy_tag_slug
				),
			));
		}
		if ( $this->get_config('enable_status') ) {
			$tag_names = apply_filters( 'slz_ext_portfolio_status_name', array(
				'singular' => __( 'Status', 'slz' ),
				'plural'   => __( 'Status', 'slz' )
			) );

			register_taxonomy($this->taxonomy_status_name, $this->post_type_name, array(
				'hierarchical' => true,
				'labels' => array(
					'name'              => sprintf( __('Project %s','slz'), $tag_names['plural']),
					'singular_name'     => sprintf( __('Project %s','slz'), $tag_names['singular']),
					'search_items'      => sprintf( __('Search %s','slz'), $tag_names['plural']),
					'popular_items'     => sprintf( __( 'Popular %s','slz' ), $tag_names['plural']),
					'all_items'         => sprintf( __('All %s','slz'), $tag_names['plural']),
					'edit_item'         => sprintf( __('Edit %s','slz'), $tag_names['singular'] ),
					'update_item'       => sprintf( __('Update %s','slz'), $tag_names['singular'] ),
					'add_new_item'      => sprintf( __('Add New %s','slz'), $tag_names['singular'] ),
					'new_item_name'     => sprintf( __('New %s Name','slz'), $tag_names['singular'] ),
					'separate_items_with_commas'    => sprintf( __( 'Separate %s with commas','slz' ), strtolower($tag_names['plural'])),
					'add_or_remove_items'           => sprintf( __( 'Add or remove %s','slz' ), strtolower($tag_names['plural'])),
					'choose_from_most_used'         => sprintf( __( 'Choose from the most used %s','slz' ), strtolower($tag_names['plural'])),
				),
				'public' => false,
				'show_ui' => true,
				'show_in_menu' => false,
				'query_var' => true,
				'rewrite' => array(
					'slug' => $this->taxonomy_status_slug
				),
			));
		}

	}

	private function add_admin_filters() {
		add_filter(
			'manage_' . $this->get_post_type_name() . '_posts_columns',
			array( $this, '_filter_add_columns' ),
			10,
			1
		);
		add_filter( 'slz_post_options', array( $this, '_filter_admin_add_post_options' ), 10, 2 );
	}

	private function add_admin_actions() {
		add_action(
			'manage_' . $this->get_post_type_name() . '_posts_custom_column',
			array( $this, '_action_manage_custom_column' ),
			10,
			2
		);
		add_action( 'admin_enqueue_scripts', array( $this, '_action_enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, '_action_add_permalink_in_settings' ) );
		add_action( 'save_post', array( $this, '_action_save_post' ) );
	}

	private function add_theme_actions() {
	}

	/**
	 * Modifies table structure for 'All Portfolio' admin page
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function _filter_add_columns( $columns ) {
		unset( $columns[ 'taxonomy-' . $this->taxonomy_name ] );
		return array_merge(
			array(
				'cb'                                => '',
				'thumbnail'                         => esc_html__( 'Thumbnail', 'slz' ),
				'title'                             => esc_html__( 'Title', 'slz' ),
				'taxonomy-' . $this->taxonomy_name  => esc_html__( 'Categories', 'slz' ),
				'date'                              => esc_html__( 'Date', 'slz' )
			), $columns );
	}

	/**
	 * Adds portfolio options for it's custom post type
	 *
	 * @internal
	 *
	 * @param $post_options
	 * @param $post_type
	 *
	 * @return array
	 */
	public function _filter_admin_add_post_options( $post_options, $post_type ) {
		if ( $post_type !== $this->post_type_name ) {
			return $post_options;
		}

		$portfolio_options = apply_filters( 'slz_ext_portfolios_post_options',
			$this->_add_post_options()//$this->get_config('mbox_options')
		);

		if ( empty($portfolio_options) ) {
			return $post_options;
		}
		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['portfolio_box']['options'][] = $portfolio_options;
		} else {
			$post_options['portfolio_box'] = array(
				'title'   => $this->get_config('mbox_name'),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $portfolio_options
			);
		}

		return $post_options;
	}

	/**
	 * Fill custom column
	 *
	 * @internal
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function _action_manage_custom_column( $column, $post_id ) {
		switch ( $column ) {
			case 'thumbnail' :
				if( has_post_thumbnail( $post_id ) ){
					echo get_the_post_thumbnail( $post_id, array( 100, 100 ) );
				}
				else{
					$thumb_size = array( 'large' => 'full', 'no-image-large' => 'full' );
					echo SLZ_Util::get_no_image( $thumb_size, get_post( $post_id ) );
				}
				break;
			default :
				break;
		}
	}

	/**
	 * Enquee backend styles on portfolios pages
	 *
	 * @internal
	 */
	public function _action_enqueue_scripts() {
		$current_screen = array(
			'only' => array(
				array( 'post_type' => $this->post_type_name )
			)
		);
	}
	public function _add_post_options() {
        $album_tab = $gallery_tab = $other_tab = $history_tab = $team_tab = $donation_tab = array();
        if ( $this->get_config('has_album_tab') ) {
            $album_tab = array(
                    'album_tab' => array(
                        'title' => __('Album', 'slz'),
                        'type'  => 'tab',
                        'options' => array(
                            'album_price' => array(
                                'type'  => 'text',
                                'value' => '',
                                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                'label' => __('Price', 'slz'),
                                'desc'  => __('Price of album', 'slz'),
                            ),
                            'album_quantity' => array(
                                'type'  => 'text',
                                'value' => '',
                                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                'label' => __('Quantity', 'slz'),
                                'desc'  => __('Number of album', 'slz'),
                                'save-in-separate-meta' => true,
                            ),
                            'url' => array(
                                'type'  => 'text',
                                'value' => '',
                                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                'label' => __('Url', 'slz'),
                                'desc'  => __('Url of button buy', 'slz'),
                            ),
                            'artist' => array(
                                'type'  => 'addable-box',
                                'value' => array(
                                    array(
                                        'name'   => '',
                                        'value' => '',
                                    ),
                                ),
                                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                'label' => __('Attributes', 'slz'),
                                'desc'  => __('Add artist author', 'slz'),
                                'box-options' => array(
                                    'name'   => array( 'type' => 'text' ),
                                    'value' => array( 'type' => 'text' ),
                                ),
                                'template' => '{{- name }}: {{- value }}', // box title
                                'box-controls' => array( // buttons next to (x) remove box button
                                    'control-id' => '<small class="dashicons dashicons-smiley"></small>',
                                ),
                                'limit' => 0, // limit the number of boxes that can be added
                                'add-button-text' => __('Add', 'slz'),
                                'sortable' => true,
                            ),
                            'playlist' => array(
                                'type'  => 'addable-box',
                                'value' => array(
                                    array(
                                        'show'   => '',
                                        'file' => '',
                                    ),
                                ),
                                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                'label' => __('Playlist', 'slz'),
                                'desc'  => __('Add file music for playlist. (mp3)', 'slz'),
                                'box-options' => array(
                                    'show'   => array( 'type' => 'text' ),
                                    'file' => array(
                                        'images_only' => false,
                                        'type'  => 'upload',
                                        'value' => array(
                                        ),
                                        'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                        'desc'  => __('Music file', 'slz'),
                                        'files_ext' => array( 'mp3' ),
                                    ),
                                ),
                                'template' => '{{- show }}', // box title
                                'box-controls' => array( // buttons next to (x) remove box button
                                    'control-id' => '<small class="dashicons dashicons-smiley"></small>',
                                ),
                                'limit' => 0, // limit the number of boxes that can be added
                                'add-button-text' => __('Add', 'slz'),
                                'sortable' => true,
                            )
                        ),
                    ),
            );
        }
		$options = array(
			'general_tab' => array(
				'title'   => esc_html__( 'General', 'slz' ),
				'type'    => 'tab',
				'options' => array(
					'thumbnail' => array(
						'type'  => 'upload',
						'value' => array(),
						'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						'label' => esc_html__('Thumnail', 'slz'),
						'desc'  => esc_html__('Add thumbnail to the project.', 'slz'),
					),
					'description' => array(
						'type'  => 'textarea',
						'value' => '',
						'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						'label' => esc_html__('Short Description', 'slz'),
						'desc'  => esc_html__('Short description of project.', 'slz'),
					),
					'information' => array(
						'type'  => 'wp-editor',
						'value' => '',
						'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						'label' => esc_html__('Information', 'slz'),
						'desc'  => esc_html__('Information of project.', 'slz'),
						'reinit' => true,
					),
					'font-icon' => array(
						'type'  => 'icon',
						'value' => '',
						'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						'label' => esc_html__('Icon', 'slz'),
						'desc'  => esc_html__('Choose icon to post', 'slz'),
					),
				)
			),

		);
		if( $this->get_config( 'has_gallery' )) {
			$gallery_tab = array(
				'gallery_tab' => array(
					'title'   => esc_html__( 'Gallery', 'slz' ),
					'type'    => 'tab',
					'options' => array(
						'gallery_images' => array(
							'type'  => 'multi-upload',
							'value' => array(),
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Images Gallery', 'slz'),
							'desc'  => esc_html__('Add images to gallery. Images should have minimum size: 800x600. Bigger size images will be cropped automatically.', 'slz'),
							'images_only' 	=> true
						)
					)
				),
			);
		}
		if( $this->get_config( 'has_other_tab' )) {
			$other_tab = array(
				'other_tab' => array(
					'title'   => esc_html__( 'Others', 'slz' ),
					'type'    => 'tab',
					'options' => array(
                        'attach_ids' => array(
                            'type'  => 'multi-upload',
                            'value' => array(),
                            'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                            'label' => esc_html__('Attach Files', 'slz'),
                            'desc'  => esc_html__('Add attach files to the project.', 'slz'),
                            'images_only' => false,
                        ),
                        'links' => array(
                            'type'  => 'addable-option',
                            'attr'  => array( 'class' => '' ),
                            'label' => __('Custom Links', 'slz'),
                            'desc'  => __('Add custom link icon to portfolio meta info.', 'slz'),
                            'option' => array(
                                'type' => 'text'
                            ),
                            'add-button-text' => __('Add', 'slz'),
                            'sortable' => true,
                        ),
					)
				),
			);
		}
		if( $this->get_config( 'has_history_tab' )) {
			$taxonomy_list = array_merge( array( '' => esc_html__('-- Select Status --', 'slz') ),
					SLZ_Com::get_hierarchical_term2name( array('taxonomy' => $this->taxonomy_status_name) ) );
			$new_status_plink = '<a href="'.$this->get_taxonomy_link($this->taxonomy_status_name).'" target="_blank">'.esc_html__('Add New Project Status', 'slz').'</a>';
			$history_tab = array(
				'history_tab' => array(
					'title'   => esc_html__( 'History Status', 'slz' ),
					'type'    => 'tab',
					'options' => array(
						'history_status' => array(
							'label'        => esc_html__( 'History Status', 'slz' ),
							'type'         => 'addable-box',
							'value'        => array(),
							'desc'         => esc_html__( 'Add history status', 'slz' ),
							'box-controls' => array(
							),
							'box-options'  => array(
								'add_status'   => array(
									'label' => '',
									'type'  => 'html',
									'value' => '{some: "json"}',
									'html'  => $new_status_plink,
								),
								'status'     => array(
									'type'       => 'select',
									'label'      => esc_html__( 'Status', 'slz' ),
									'choices'    => $taxonomy_list,
									'desc'       => esc_html__( 'Setting current status to the project.', 'slz' ),
									'help'  => array(
										'html' => $new_status_plink
									),
								),
								'update_date'         => array(
									'type'            => 'datetime-picker',
									'value'           => '',
									'attr'            => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
									'label'           => esc_html__( 'Update Date', 'slz' ),
									'desc'            => esc_html__( 'Date to update the project. Format: MM-DD-YYYY.', 'slz' ),
									'datetime-picker' => array(
										'format'        => 'm-d-Y',
										'extra-formats' => array(),
										'moment-format' => 'MM-DD-YYYY',
										'scrollInput'   => false,
										'maxDate'       => false,
										'minDate'       => false,
										'timepicker'    => false,
										'datepicker'    => true,
									)
								),
								'link_target' => array(
									'type'  => 'checkbox',
									'value' => false,
									'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
									'label' => esc_html__('Open link in a new tab', 'slz'),
								),
								'link'     => array(
									'label' => esc_html__( 'URL (Link)', 'slz' ),
									'type'  => 'text',
									'value' => '',
									'desc'  => esc_html__( 'Link to download project', 'slz' ),
								),
								'app_store'     => array(
									'label' => esc_html__( 'Link To AppStore', 'slz' ),
									'type'  => 'text',
									'value' => '',
									'desc'  => esc_html__( 'Link to download project from AppStore', 'slz' ),
								),
								'google_store'     => array(
									'label' => esc_html__( 'Link To Google Play Store', 'slz' ),
									'type'  => 'text',
									'value' => '',
									'desc'  => esc_html__( 'Link to download project from Google Play Store', 'slz' ),
								),
								'windows_store'     => array(
									'label' => esc_html__( 'Link To Windows Store', 'slz' ),
									'type'  => 'text',
									'value' => '',
									'desc'  => esc_html__( 'Link to download project from Windows Store', 'slz' ),
								),
							),
							'template' => '{{- status}} / {{- update_date}}',
							'limit' => 0,
						),
					)
				),
			);
		}
		if( $this->get_config( 'has_team_tab' )) {
			$args = array('post_type'     => 'slz-team');
			$team_options = array('empty'      => esc_html__( '-Select Team-', 'slz' ) );
			$teams = SLZ_Com::get_post_id2title( $args, $team_options );
			$team_tab = array(
				'team_tab' => array(
					'title'   => esc_html__( 'Teams', 'slz' ),
					'type'    => 'tab',
					'options' => array(
                        'team' => array(
	                        'type'  => 'select',
	                        'label' => __('Team', 'slz'),
	                        'desc'  => __('Please select teams involved in this project', 'slz'),
	                        'choices' => $teams,
                            'save-in-separate-meta' => true,
                        ),
                        'show_team_box' => array(
                            'label'        => esc_html__( 'Team Box', 'slz' ),
                            'desc'         => esc_html__( 'Show portfolio team box in single pages?', 'slz' ),
                            'type'         => 'switch',
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => esc_html__( 'Yes', 'slz' )
                            ),
                            'left-choice'  => array(
                                'value' => 'no',
                                'label' => esc_html__( 'No', 'slz' )
                            ),
                            'value'        => 'yes'
                        ),
					)
				),
			);
		}

		$options = array_merge($options, $album_tab, $gallery_tab, $history_tab, $other_tab ,$team_tab);
		return $options;
	}
    /**
     *
     * method ajax playlist
     *
     */
    public function  ajax_get_content_playlist() {
        if( !empty( $_POST['params'][0] ) ) {
            $post_id = $_POST['params'][0]['post_id'];
            $id_img_hover = $_POST['params'][0]['id_img_hover'];
            $model = new SLZ_Portfolio();
            $model->init( array('post_id' => array($post_id) ) );
            $model->query->the_post();
            $model->loop_index();
            $format = $this->get_config('ajax_html_audio');
            echo sprintf($format['image-content'], $model->get_featured_image($format).wp_get_attachment_image($id_img_hover, '','', array( "class" => "img-hover" )) );
            echo sprintf($format['content'], sprintf($format['title'], $model->get_title()).$model->get_meta_album_artist('', $format['artist'], 3).$model->get_meta_album_playlist($format['playlist']));
        }
        die;
    }

	/*******BUY TICKET METHOD******/
	public function ajax_buy_album() {
		if( !empty( $_POST['params'][0] ) ) {
			$res = array();
			$res['status'] = 'fail';
			global $woocommerce;

//			$money_donate = $_POST['params'][0]['money'];
			$post_id_portfolio = $_POST['params'][0]['post_id'];
			$price_ticket = slz_get_db_post_option( $post_id_portfolio, 'album_price', '0' );

			$prefix = 'portfolio';
			$portfolio_title = get_the_title( $post_id_portfolio );
			$posts = get_post( $post_id_portfolio );
			if( $posts ) {
				$portfolio_slug = $posts->post_name;
			}else{
				$portfolio_slug = '';
			}

			$product_id = $this->get_post_name2id( $portfolio_slug , 'product');

			if (!isset($product_id) || empty($product_id)) {
				$product_cat = esc_html__( 'Portfolio', 'slz' );
				$product_id = $this->create_woocommerce_product( $prefix, $portfolio_title, $portfolio_slug, $product_cat );
			}

			$variation_args = array(
				'post_type'   => 'product_variation',
				'post_parent' => $product_id,
				'post_name'   => $portfolio_slug
			);
			$variation_obj  = get_posts($variation_args);
			if( !empty( $variation_obj ) ){
				$variation_id   = $variation_obj[0]->ID;
			}

			if (!isset($variation_id) || empty($variation_id)) {
				$variation_id = $this->create_woocommerce_product_variation( $prefix, $product_id, $portfolio_title, $portfolio_slug, $post_id_portfolio );
			}

			if ($product_id > 0 && $variation_id > 0) {
				$cart_item_key = $woocommerce->cart->add_to_cart( $product_id, 1, $variation_id, null, null);
				if (!is_user_logged_in()) {
					$woocommerce->session->set_customer_session_cookie(true);
				}
				$woocommerce->session->set( 'slz_portfolio_session_key_' . $cart_item_key,
					array(
						'type'  => 'portfolio',
						'portfolio_price_ticket' => $price_ticket,
						'post_id_portfolio' => $post_id_portfolio,
					));
			}
			$res['status'] = 'success';
			$res['url'] = esc_url( home_url().'/cart' );
			$res = json_encode( $res );
			echo ( $res );
		}
		die;
	}

	private function get_post_name2id( $name, $post_type ) {
		$args = array(
			'name'             => $name,
			'post_type'        => $post_type,
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'suppress_filters' => false,
		);
		$posts = get_posts( $args );
		if( $posts ) {
			return $posts[0]->ID;
		}
		return false;
	}

	public function create_woocommerce_product( $prefix, $product_title, $product_slug, $product_cat ) {
		$new_post = array(
			'post_title' 		=> $product_title,
			'post_content' 		=> esc_html__('This is a variable product used for booking processed with WooCommerce', 'slz'),
			'post_status' 		=> 'publish',
			'post_name' 		=> $product_slug,
			'post_type' 		=> 'product',
			'comment_status' 	=> 'closed'
		);
		$product_id 			= wp_insert_post( $new_post );
		$sku					= $this->random_sku( $prefix, 6 );
		update_post_meta( $product_id, '_sku', $sku );
		wp_set_object_terms( $product_id, 'variable', 'product_type' );
		wp_set_object_terms( $product_id, $product_cat, 'product_cat' );

		$product_attributes = array(
			$prefix   => array(
				'name'			=> $prefix,
				'value'			=> '',
				'is_visible' 	=> '1',
				'is_variation' 	=> '1',
				'is_taxonomy' 	=> '0'
			)
		);
		update_post_meta( $product_id, '_product_attributes', $product_attributes);

		return $product_id;
	}

	public function create_woocommerce_product_variation( $prefix, $product_id, $title, $slug, $id ) {
		$new_post = array(
			'post_title' 		=> $title,
			'post_content' 		=> esc_html__('This is a product variation', 'slzexploore-core'),
			'post_status' 		=> 'publish',
			'post_type' 		=> 'product_variation',
			'post_parent'		=> $product_id,
			'post_name' 		=> $slug,
			'comment_status' 	=> 'closed'
		);
		$variation_id 			= wp_insert_post($new_post);
		update_post_meta($variation_id, '_stock_status', 		'instock');
		update_post_meta($variation_id, '_sold_individually', 	'yes');
		update_post_meta($variation_id, '_virtual', 			'yes');
		update_post_meta($variation_id, '_manage_stock', 'no' );
		update_post_meta($variation_id, '_downloadable', 'no' );
		update_post_meta($variation_id, 'attribute_' . $prefix, $id);
		return $variation_id;
	}

	public function random_sku($prefix = '', $len = 6) {
		$str = '';
		for ($i = 0; $i < $len; $i++) {
			$str .= rand(0, 9);
		}
		return $prefix . $str;
	}

}
