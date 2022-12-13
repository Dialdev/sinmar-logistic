<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Extension_Gallery extends SLZ_Extension {
	private $post_type_name = 'slz-gallery';
	private $post_type_slug = 'gallery';
	private $taxonomy_name = 'slz-gallery-cat';
	private $taxonomy_slug = 'gallery-cat';


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

		add_filter( 'slz_post_options', array( $this, '_filter_slz_post_options' ), 10, 2 );
	}

	private function save_permalink_structure() {
		if ( ! isset( $_POST['permalink_structure'] ) && ! isset( $_POST['category_base'] ) ) {
			return;
		}

		$this->set_db_data(
			'permalinks/post',
			SLZ_Request::POST(
				'slz_ext_gallery_gallery_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_gallery_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
			)
		);
	}

	/**
	 * @internal
	 **/
	public function _action_add_permalink_in_settings() {
		add_settings_field(
			'slz_ext_gallery_gallery_slug',
			esc_html__( 'Gallery base', 'slz' ),
			array( $this, '_gallery_slug_input' ),
			'permalink',
			'optional'
		);

		add_settings_field(
			'slz_ext_gallery_taxonomy_slug',
			esc_html__( 'Gallery category base', 'slz' ),
			array( $this, '_taxonomy_slug_input' ),
			'permalink',
			'optional'
		);
	}

	/**
	 * @internal
	 */
	public function _gallery_slug_input() {
		?>
		<input type="text" name="slz_ext_gallery_gallery_slug" value="<?php echo $this->post_type_slug; ?>">
		<code>/my-gallery</code>
		<?php
	}

	/**
	 * @internal
	 */
	public function _taxonomy_slug_input() {
		?>
		<input type="text" name="slz_ext_gallery_taxonomy_slug" value="<?php echo $this->taxonomy_slug; ?>">
		<code>/my-gallery-category</code>
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
				'singular' => esc_html__( 'Gallery', 'slz' ),
				'plural'   => esc_html__( 'Gallery', 'slz' )
			) );

		register_post_type( $this->post_type_name,
			array(
				'labels'             => array(
					'name'               => esc_html__( 'Gallery', 'slz' ),
					'singular_name'      => esc_html__( 'Gallery', 'slz' ),
					'add_new'            => esc_html__( 'Add New', 'slz' ),
					'add_new_item'       => sprintf( esc_html__( 'Add New %s', 'slz' ), $post_names['singular'] ),
					'edit'               => esc_html__( 'Edit', 'slz' ),
					'edit_item'          => sprintf( esc_html__( 'Edit %s', 'slz' ), $post_names['singular'] ),
					'new_item'           => sprintf( esc_html__( 'New %s', 'slz' ), $post_names['singular'] ),
					'all_items'          => sprintf( esc_html__( 'All %s', 'slz' ), $post_names['plural'] ),
					'view'               => sprintf( esc_html__( 'View %s', 'slz' ), $post_names['singular'] ),
					'view_item'          => sprintf( esc_html__( 'View %s', 'slz' ), $post_names['singular'] ),
					'search_items'       => sprintf( esc_html__( 'Search %s', 'slz' ), $post_names['plural'] ),
					'not_found'          => sprintf( esc_html__( 'No %s Found', 'slz' ), $post_names['plural'] ),
					'not_found_in_trash' => sprintf( esc_html__( 'No %s Found In Trash', 'slz' ), $post_names['plural'] ),
					'parent_item_colon'  => '' /* text for parent types */
				),
				'description'        => esc_html__( 'Create a gallery item', 'slz' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->post_type_slug
				),
				'show_in_nav_menus'  => false,
				'menu_icon'          => 'dashicons-images-alt2',
				'hierarchical'       => false,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array(
					'title', /* Text input field to create a post title. */
					'editor',
					'thumbnail', /* Displays a box for featured image. */
				)
			) );
	}

	private function register_taxonomy() {
		$category_names = apply_filters( 'slz_ext_' . $this->get_name() . '_category_name',
			array(
				'singular' => esc_html__( 'Category', 'slz' ),
				'plural'   => esc_html__( 'Categories', 'slz' )
			) );

		register_taxonomy( $this->taxonomy_name, $this->post_type_name, array(
			'labels'            => array(
				'name'              => sprintf( esc_html_x( 'Gallery %s', 'taxonomy general name', 'slz' ),
					$category_names['plural'] ),
				'singular_name'     => sprintf( esc_html_x( 'Gallery %s', 'taxonomy singular name', 'slz' ),
					$category_names['singular'] ),
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

	}

	private function add_admin_filters() {
		add_filter(
			'manage_' . $this->get_post_type_name() . '_posts_columns',
			array( $this, '_filter_add_columns' ),
			10,
			1
		);
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
	}

	private function add_theme_actions() {
	}

	/**
	 * Modifies table structure for 'All Gallery' admin page
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function _filter_add_columns( $columns ) {

		return array_merge(
			array(
				'cb'                                => '',
				'thumbnail'                         => esc_html__( 'Thumbnail', 'slz' ),
				'title'                             => esc_html__( 'Title', 'slz' ),
				'taxonomy-' . $this->taxonomy_name 	=> esc_html__( 'Categories', 'slz' ),
				'date'     							=> esc_html__( 'Date', 'slz' ),
			), $columns );
	}

	/**
	 * Adds gallery options for it's custom post type
	 *
	 * @internal
	 *
	 * @param $post_options
	 * @param $post_type
	 *
	 * @return array
	 */
	public function _filter_slz_post_options( $post_options, $post_type ) {
		if ( $post_type !== $this->post_type_name ) {
			return $post_options;
		}

		$gallery_options = apply_filters( 'slz_ext_gallery_post_options',
			$this->_add_post_options());

		if (empty($gallery_options)) {
			return $post_options;
		}

		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['gallery_box']['options'][] = $gallery_options;
		} else {
			$post_options['gallery_box'] = array(
				'title'   => esc_html__('Gallery Options', 'slz'),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $gallery_options
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
	 * Get saved gallery location array from db
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	private function get_meta_position( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'position' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}

	/**
	 * Enquee backend styles on gallery pages
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
		$options = array(
			'general_tab' => array(
					'title'   => esc_html__( 'General', 'slz' ),
					'type'    => 'tab',
					'options' => array(
						'gallery_images' => array (
							'type'  => 'multi-upload',
							'value' => array (),
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__( 'Gallery Images', 'slz' ),
							'help'  => esc_html__( 'Choose Images to upload', 'slz' ),
							'desc'  => esc_html__( 'Add images to gallery. Images should have minimum size: 800x600. Bigger size images will be cropped automatically.', 'slz' ),
							'images_only' => true,
						),
						'options_icon_image'   => array(
							'type'         => 'multi-picker',
							'label'        => false,
							'desc'         => false,
							'picker'       => array(
								'options-choices' => array(
									'type'         => 'switch',
									'value'        => 'icon',
									'label'        => esc_html__( 'Upload Image or Choose Icon for Gallery', 'slz' ),
									'left-choice'  => array(
										'value' => 'image',
										'label' => esc_html__( 'Image', 'slz' ),
									),
									'right-choice' => array(
										'value' => 'icon',
										'label' => esc_html__( 'Icon', 'slz' ),
									)
								),
							),
							'choices'      => array(
								'image' => array(
									'image_upload' => array(
										'type'  => 'upload',
										'value' => '',
										'label' => esc_html__('Upload Image', 'slz'),
										'images_only' => true,
									),
								),
								'icon' => array(
									'icon_options' => array(
										'type'  => 'icon',
										'value' => '',
										'label' => esc_html__('Choose Icon', 'slz'),
									),
								),
							),
						),
					)
				),
			
		);
		return $options;
	}
	/* AJAX LOAD MORE isotope post */
	public function ajax_load_more_func(){
		if ( !empty( $_POST['params'][0] ) ) {
			$data = $_POST['params'][0];

			$model = new SLZ_Gallery();
			$model->init( $data );

			// Format: 1$ - image, 2$ - title, 3$ - img url, 4$ - url, 5$ excerpt or description meta , 6$ class, $7 category, $8 author, $9 date, $10 meta icon
			if( $data['post_type'] == 'slz-gallery' ) {
				$html_format = '
					<div class="grid-item %6$s %10$s">
						<div class="slz-block-gallery-01 style-1">
							<div class="block-image">
								<a href="%11$s" class="link fancybox-thumb">%1$s</a>
							</div>
						</div>
					</div>
				';
			}else{
				$html_format = '
					<div class="grid-item %6$s %10$s">
						<div class="slz-block-gallery-01 style-1">
							<div class="block-image">
								<a href="%11$s" class="link fancybox-thumb">%1$s</a>
							</div>
							<div class="block-content">
								<div class="block-content-wrapper">
									%9$s
									%7$s
									%2$s
									%8$s
									%5$s
									%4$s
									%3$s
								</div>
							</div>
						</div>
					</div>
				';
			}

			$html_render['html_format'] = $html_format;
			$view = $model->render_isotope_post( $html_render ); 
			echo $view;

			$model->attributes['paged'] = absint($model->attributes['paged']) + 1;
			$close_more ='';
			if( $model->query->max_num_pages > 1 && $model->attributes['paged'] <= $model->query->max_num_pages ) {
			    $close_more = '1,' .$model->query->max_num_pages;
			}
			$model->reset();
			echo '<div class="gallery_atts_more hide" data-pages="'.esc_attr($close_more).'" data-json="'. esc_attr( json_encode( $model->attributes ) ) .'"></div>';
			die();
		}
	}
}
