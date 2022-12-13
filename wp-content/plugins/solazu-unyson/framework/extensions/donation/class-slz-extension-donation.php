<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Extension_Donation extends SLZ_Extension {
	private $post_type_name = 'slz-donation';
	private $post_type_slug = 'donation';
	private $taxonomy_name = 'slz-donation-cat';
	private $taxonomy_slug = 'donation-cat';

	private $post_type_name_causes = 'slz-causes';
	private $post_type_slug_causes = 'causes';
	private $taxonomy_name_causes = 'slz-causes-cat';
	private $taxonomy_slug_causes = 'causes-cat';

	/* donation */
	public function slz_get_post_type_slug() {
		return $this->post_type_slug;
	}

	/* donation */
	public function get_post_type_name() {
		return $this->post_type_name;
	}

	/* donation */
	public function get_taxonomy_name() {
		return $this->taxonomy_name;
	}
	
	/* causes */
	public function slz_get_post_type_slug_causes() {
		return $this->post_type_slug_causes;
	}

	/* causes */
	public function get_post_type_name_causes() {
		return $this->post_type_name_causes;
	}

	/* causes */
	public function get_taxonomy_name_causes() {
		return $this->taxonomy_name_causes;
	}

	/* donation */
	public function _get_link() {
		return self_admin_url( 'edit.php?post_type=' . $this->get_post_type_name() );
	}
	
	/* causes */
	public function _get_link_causes() {
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
		$this->register_post_type_causes();
		$this->register_taxonomy_causes();
		

		if ( is_admin() ) {
			$this->save_permalink_structure();
			$this->add_admin_filters();
			$this->add_admin_actions();
		} else {
			$this->add_theme_actions();
		}

		add_filter( 'slz_post_options', array( $this, '_filter_slz_post_options' ), 10, 2 );
		add_filter( 'slz_post_options', array( $this, '_filter_slz_post_options_causes' ), 10, 2 );
	}

	private function save_permalink_structure() {
		if ( ! isset( $_POST['permalink_structure'] ) && ! isset( $_POST['category_base'] ) ) {
			return;
		}
		
		/* donation */
		$this->set_db_data(
			'permalinks/post',
			SLZ_Request::POST(
				'slz_ext_donation_donation_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_donation_donation_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
			)
		);
		
		/* causes */
		$this->set_db_data(
			'permalinks/post',
			SLZ_Request::POST(
				'slz_ext_donation_causes_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug_causes )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_donation_causes_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug_causes )
			)
		);
	}

	/**
	 * @internal
	 **/
	public function _action_add_permalink_in_settings() {
		/* causes */
		add_settings_field(
			'slz_ext_donation_causes_slug',
			esc_html__( 'Causes base', 'slz' ),
			array( $this, '_donation_slug_input_causes' ),
			'permalink',
			'optional'
		);
		add_settings_field(
			'slz_ext_donation_causes_taxonomy_slug',
			esc_html__( 'Causes category base', 'slz' ),
			array( $this, '_taxonomy_slug_input_causes' ),
			'permalink',
			'optional'
		);
	}

	/**
	 * @internal
	 * use for donation
	 */
	public function _donation_slug_input() {
		?>
		<input type="text" name="slz_ext_donation_donation_slug" value="<?php echo $this->post_type_slug; ?>">
		<code>/my-donation</code>
		<?php
	}

	/**
	 * @internal
	 * use for donation
	 */
	public function _taxonomy_slug_input() {
		?>
		<input type="text" name="slz_ext_donation_donation_taxonomy_slug" value="<?php echo $this->taxonomy_slug; ?>">
		<code>/my-donation-category</code>
		<?php
	}
	
	/**
	 * @internal
	 * use for causes
	 */
	public function _donation_slug_input_causes() {
		?>
		<input type="text" name="slz_ext_donation_causes_slug" value="<?php echo $this->post_type_slug_causes; ?>">
		<code>/my-cause</code>
		<?php
	}

	/**
	 * @internal
	 * use for causes
	 */
	public function _taxonomy_slug_input_causes() {
		?>
		<input type="text" name="slz_ext_donation_causes_taxonomy_slug" value="<?php echo $this->taxonomy_slug_causes; ?>">
		<code>/my-cause-category</code>
		<?php
	}

	private function define_slugs() {
		/* donation */
		$this->post_type_slug = $this->get_db_data(
			'permalinks/post',
			apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
		);
		$this->taxonomy_slug  = $this->get_db_data(
			'permalinks/taxonomy',
			apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
		);
		
		/* causes */
		$this->post_type_slug_causes = $this->get_db_data(
			'permalinks/post',
			apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug_causes )
		);
		$this->taxonomy_slug_causes  = $this->get_db_data(
			'permalinks/taxonomy',
			apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug_causes )
		);
	}

	/*
	 * Use for Donation
	 */
	private function register_post_type() {
		$post_names = apply_filters( 'slz_ext_' . $this->get_name() . '_post_type_name',
			array(
				'singular' => esc_html__( 'Donation', 'slz' ),
				'plural'   => esc_html__( 'Donation', 'slz' )
			) );

		register_post_type( $this->post_type_name,
			array(
				'labels'             => array(
					'name'               => esc_html__( 'Donation', 'slz' ),
					'singular_name'      => esc_html__( 'Donation', 'slz' ),
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
				'description'        => esc_html__( 'Create a donation item', 'slz' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->post_type_slug
				),
				'menu_position'      => 23,
				'show_in_nav_menus'  => true,
				'menu_icon'          => 'dashicons-heart',
				'hierarchical'       => false,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array('')
			) );
	}

	/*
	 * Use for Causes
	 */
	private function register_post_type_causes() {
		$post_names = apply_filters( 'slz_ext_' . $this->get_name() . '_post_type_name',
			array(
				'singular' => esc_html__( 'Causes', 'slz' ),
				'plural'   => esc_html__( 'Causes', 'slz' )
			) );

		register_post_type( $this->post_type_name_causes,
			array(
				'labels'             => array(
					'name'               => esc_html__( 'Causes', 'slz' ),
					'singular_name'      => esc_html__( 'Causes', 'slz' ),
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
				'description'        => esc_html__( 'Create a cause item', 'slz' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => false,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->post_type_slug_causes
				),
				'menu_position'      => 23,
				'show_in_nav_menus'  => true,
				'menu_icon'          => 'dashicons-groups',
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

	private function register_taxonomy_causes() {
		$category_names = apply_filters( 'slz_ext_' . $this->get_name() . '_category_name',
			array(
				'singular' => esc_html__( 'Category', 'slz' ),
				'plural'   => esc_html__( 'Categories', 'slz' )
			) );

		register_taxonomy( $this->taxonomy_name_causes, $this->post_type_name_causes, array(
			'labels'            => array(
				'name'              => sprintf( esc_html_x( 'Cause %s', 'taxonomy general name', 'slz' ),
					$category_names['plural'] ),
				'singular_name'     => sprintf( esc_html_x( 'Cause %s', 'taxonomy singular name', 'slz' ),
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
				'slug' => $this->taxonomy_slug_causes
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
		add_filter(
			'manage_' . $this->get_post_type_name_causes() . '_posts_columns',
			array( $this, '_filter_add_columns_causes' ),
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
		add_action(
			'manage_' . $this->get_post_type_name_causes() . '_posts_custom_column',
			array( $this, '_action_manage_custom_column_causes' ),
			10,
			2
		);
		add_action( 'admin_enqueue_scripts', array( $this, '_action_enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, '_action_add_permalink_in_settings' ) );
	}

	private function add_theme_actions() {
	}

	/**
	 * Modifies table structure for 'All Donation' admin page
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function _filter_add_columns( $columns ) {
		unset( $columns[ 'taxonomy-' . $this->taxonomy_name ] );
		unset( $columns['title'] );
		unset( $columns['date'] );

		return array_merge( $columns, array(
				'dornor_name'            => esc_html__( 'Name( Last, First )', 'slz' ),
				'email'                 => esc_html__( 'Email', 'slz' ),
				'cause'                 => esc_html__( 'Cause', 'slz' ),
				'amount'                => esc_html__( 'Money', 'slz' ),
				'status'                => esc_html__( 'Status', 'slz' ),
				'action_btn'            => esc_html__( 'Action', 'slz' ),
			) );
	}

	public function _filter_add_columns_causes( $columns ) {
		return array_merge( array(
				'cb'           => '',
				'title'        => esc_html__( 'Title', 'slz' ),
				'goal'         => esc_html__( 'Goal', 'slz' ),
				'raised'       => esc_html__( 'Raised', 'slz' ),
				'location'     => esc_html__( 'Location', 'slz' ),
				'time'         => esc_html__( 'Time', 'slz' ),
				'taxonomy-'. $this->taxonomy_name_causes => esc_html__( 'Category', 'slz' ),
		) );
	}
	
	/**
	 * Adds donation options for it's custom post type
	 * Use for donation
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
		
		$args = array(
			'post_type'  => 'slz-causes',
			'posts_per_page' => -1,
		);
		$posts = get_posts( $args );
		
		$arr = array();
		if( !empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$arr[ $post->ID ] = $post->post_title;
			}
		}
		
		$donation_options = apply_filters( 'slz_ext_donation_post_options',
			array(
				'general_tab' => array(
					'title'   => esc_html__( 'General', 'slz' ),
					'type'    => 'tab',
					'options' => array(
						'status' => array(
							'type'  => 'radio',
						    'value' => 'pending',
						    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						    'label' => esc_html__('Status', 'slz'),
						    'help'  => esc_html__('Status', 'slz'),
						    'choices' => array( // Note: Avoid bool or int keys http://bit.ly/1cQgVzk
						        'approve' => esc_html__('Approve', 'slz'),
						        'pending' => esc_html__('Pending', 'slz'),
						    ),
						    // Display choices inline instead of list
						    'inline' => true,
						    'save-in-separate-meta' => true
						),
						'amount' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Amount Of Donation', 'slz'),
							'help'  => esc_html__('Amount of this donation. ( example: $50 -> input 50 ).', 'slz'),
							'save-in-separate-meta' => true
						),
						'payment' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Payment Method', 'slz'),
							'save-in-separate-meta' => true
						),
						'cause' => array(
						    'type'  => 'select',
						    'value' => '',
						    'label' => esc_html__('Cause', 'slz'),
						    'choices' => $arr,
							'save-in-separate-meta' => true
						),
						'first_name' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('First Name', 'slz'),
							'help'  => esc_html__('First name of persional information.', 'slz'),
						),
						'last_name' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Last Name', 'slz'),
							'help'  => esc_html__('Last name of persional information.', 'slz'),
						),
						'email' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Email Name', 'slz'),
							'help'  => esc_html__('Email of persional information.', 'slz'),
						),
						'phone' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Phone', 'slz'),
							'help'  => esc_html__('Phone of persional information.', 'slz'),
						),
						'address' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Address', 'slz'),
							'help'  => esc_html__('Address of persional information.', 'slz'),
						),
					)
				),
			) );

		if (empty($donation_options)) {
			return $post_options;
		}

		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['donation_box']['options'][] = $donation_options;
		} else {
			$post_options['donation_box'] = array(
				'title'   => esc_html__('Donation Options', 'slz'),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $donation_options
			);
		}

		return $post_options;
	}

	/**
	 * Adds donation options for it's custom post type
	 * Use for causes
	 *
	 * @internal
	 *
	 * @param $post_options
	 * @param $post_type
	 *
	 * @return array
	 */
	public function _filter_slz_post_options_causes( $post_options, $post_type ) {
		if ( $post_type !== $this->post_type_name_causes ) {
			return $post_options;
		}
		
		$causes_options = apply_filters( 'slz_ext_donation_post_options',
			array(
				'general_tab' => array(
					'title'   => esc_html__( 'General', 'slz' ),
					'type'    => 'tab',
					'options' => array(
						'urgent' => array(
						    'type'  => 'switch',
						    'value' => 'no',
						    'label' => __('Urgent', 'slz'),
						    'left-choice' => array(
						        'value' => 'yes',
						        'label' => __('Yes', 'slz'),
						    ),
						    'right-choice' => array(
						        'value' => 'no',
						        'label' => __('No', 'slz'),
						    ),
						    'save-in-separate-meta' => true
						),
						'goal' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Goal', 'slz'),
							'help'  => esc_html__('Goal number of this cause. ( example: $50 -> input 50 ).', 'slz'),
							'save-in-separate-meta' => true
						),
						'location' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Location', 'slz'),
							'help'  => esc_html__('Cause location address.', 'slz'),
							'save-in-separate-meta' => true
						),
						'people_benefits' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('People benefits', 'slz'),
							'help'  => esc_html__('People benefits number of this cause.', 'slz'),
							'save-in-separate-meta' => true
						),
						'time' => array(
						    'type'  => 'datetime-range',
						    'label' => __('Time', 'slz'),
						    'datetime-pickers' => array(
						    'from' => array(
						        'format'  => 'Y/m/d H:i',
						        'timepicker'  => true,
						        'datepicker'  => true,
						        ),
						    'to' => array(
						        'format'  => 'Y/m/d H:i',
						        'timepicker'  => true,
						        'datepicker'  => true,
						        )
						    ),
						    'value' => array(
						        'from' => '',
						        'to' => ''
						    ),
						    'save-in-separate-meta' => true
						),
						'donation_url' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Donation URL', 'slz'),
							'help'  => esc_html__('Input donation URL for buton donate method.', 'slz'),
						),
						'description' => array(
							'type' => 'textarea',
							'label' => __('Description', 'slz'),
							'value' => '',
							'desc'  => __('Description of this cause.', 'slz')
						),
					)
				),
			) );

		if (empty($causes_options)) {
			return $post_options;
		}

		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['donation_box']['options'][] = $causes_options;
		} else {
			$post_options['donation_box'] = array(
				'title'   => esc_html__('Donation Options', 'slz'),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $causes_options
			);
		}

		return $post_options;
	}

	/**
	 * Fill custom column
	 * Use for donation
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
			case 'dornor_name' :
				echo $this->get_dornor_name( $post_id );
				break;
			case 'email' :
				echo $this->get_meta_email( $post_id );
				break;
			case 'cause' :
				echo $this->get_meta_cause( $post_id );
				break;
			case 'status' :
				echo $this->get_meta_status( $post_id );
				break;
			case 'action_btn' :
				echo $this->get_action_button( $post_id );
				break;
			case 'amount' :
				echo $this->get_meta_amount($post_id);
				break;
			default :
				break;
		}
	}

	/**
	 * Fill custom column
	 * Use for causes
	 *
	 * @internal
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function _action_manage_custom_column_causes( $column, $post_id ) {
		switch ( $column ) {
			case 'goal':
				echo $this->get_meta_goal( $post_id );
				break;
			case 'location':
				echo $this->get_meta_location( $post_id );
				break;
			case 'time':
				echo $this->get_meta_time( $post_id );
				break;
			case 'raised':
				echo $this->get_raised_money($post_id);
			default :
				break;
		}
	}
	
	/**
	 * Get saved donation location array from db
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	private function get_dornor_name( $post_id ) {
		$first_name = slz_get_db_post_option( $post_id, 'first_name', '' );
		$last_name = slz_get_db_post_option( $post_id, 'last_name', '' );
		if( !empty( $first_name ) && !empty( $last_name ) ) {
			$dornor_name = $last_name . ' ' . $first_name;
		}elseif( empty( $first_name ) && empty( $last_name ) ) {	
			$dornor_name = '&#8212;';
		}elseif( empty( $first_name ) ) {
			$dornor_name = $last_name;
		}elseif ( empty( $last_name ) ) {
			$dornor_name = $first_name;
		}
		return $dornor_name;
	}
	private function get_meta_firstname( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'first_name' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}
	private function get_meta_lastname( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'last_name' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}
	private function get_meta_email( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'email' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}
	private function get_meta_location( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'location' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}
	private function get_meta_status( $post_id ) {
		$out = '';
		$meta = slz_get_db_post_option( $post_id, 'status' );
		if( isset( $meta ) and false === empty( $meta ) ) {
			$meta_arr = array(
				'pending'  => 'donate-pending-status',
				'approve'  => 'donate-approve-status',
			);
			$out = '<div class="'. esc_attr( $meta_arr[$meta] ) .' slz-btn-donation-admin">'. esc_html( $meta ) .'</div>';
		}else{
			$out .= '&#8212;';
		}
		return $out;
	}
	private function get_meta_goal( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'goal' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? slz_get_currency_format_options($meta) : '&#8212;' );
	}
	private function get_meta_time( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'time' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ?  $meta['from'].' - '.$meta['to'] : '&#8212;' );
	}
	private function get_meta_cause( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'cause' );
		$url = get_edit_post_link( $meta );
		$out = '<a href="'. esc_url( $url ) .'" target="_blank" >'. esc_html( get_the_title( $meta ) ) .'</a>';
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $out : '&#8212;' );
	}
	private function get_meta_amount( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'amount' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? slz_get_currency_format_options( $meta ) : '&#8212;' );
	}
	private function get_action_button( $post_id ){
		$out = '';
		$meta = slz_get_db_post_option( $post_id, 'status' );
		
		if( $meta == 'approve' ) {
			$out = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-cancel-btn" value="&#x21b6;" title="'. esc_html__('Unapprove', 'slz') .'" >';
		}else{
			$out = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-approve-btn" value="&#8901;&#8901;&#8901;" title="'. esc_html__( 'Approve', 'slz' ) .'" >';
		}
		return $out;
	}
	private function get_raised_money( $post_id ) {
		$out = '';
		$raised = get_post_meta( $post_id, 'slz-donation-raised-money', true );
		if( empty( $raised ) ) {
			$raised = 0;
		}
		$raised = intval( $raised );
		$out .= slz_get_currency_format_options( $raised );
		return $out;
	}

	/**
	 * Enquee backend styles on donation pages
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
	
	public function get_query_approved_donation( $causes_id ) {
		$args = array(
			'post_type'       => 'slz-donation',
			'posts_per_page'  => -1,
			'meta_query' => array(
				array(
					'key'     => 'slz_option:cause',
					'value'   => $causes_id,
				),
				array(
					'key'     => 'slz_option:status',
					'value'   => 'approve',
				),
			),
		);
		$posts = new WP_Query( $args );
		
		return $posts;
	}

    public function get_query_all_donation( $causes_id ) {
        $args = array(
            'post_type'       => 'slz-donation',
            'posts_per_page'  => -1,
            'meta_query' => array(
                array(
                    'key'     => 'slz_option:cause',
                    'value'   => $causes_id,
                )
            ),
        );
        $posts = new WP_Query( $args );

        return $posts;
    }

    public function get_query_all_donation_strash( $causes_id ) {
        $args = array(
            'post_type'       => 'slz-donation',
            'posts_per_page'  => -1,
            'meta_query' => array(
                array(
                    'key'     => 'slz_option:cause',
                    'value'   => $causes_id,
                )
            ),
            'post_status' => 'trash'
        );
        $posts = new WP_Query( $args );

        return $posts;
    }

	/* ****Donate Method**** */
	public function ajax_approve_btn_admin() {
		if( !empty( $_POST['params'][0] ) ) {
			$approve = 'approve';
			$post_id = $_POST['params'][0]['post_id'];
			slz_set_db_post_option( $post_id, 'status', $approve );
			
			$donate = 0;
			$raised = 0;
			$count_dornors = 0;
			$causes_id = slz_get_db_post_option( $post_id, 'cause', '' );
			$posts = $this->get_query_approved_donation($causes_id);
			if( !empty( $posts->posts ) ) {
				foreach ( $posts->posts as $post ) {
					$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
					$raised += intval( $donate );
				}
				$count_dornors = count( $posts->posts );
			}
			
			update_post_meta($causes_id, 'slz-donation-raised-money', $raised);
			update_post_meta($causes_id, 'slz-donation-dornors-number', $count_dornors);
			
			$res = array();
			$res['status'] = '<div class="donate-approve-status">'. esc_html( $approve ) .'</div>';
			$res['btn'] = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-cancel-btn" value="&#x21b6;" title="'. esc_html__('Unapprove', 'slz') .'" >';
			$res = json_encode( $res );
			echo ( $res );
		}
		die;
	}
	
	public function ajax_cancel_btn_admin() {
		if( !empty( $_POST['params'][0] ) ) {
			$cancel = 'pending';
			$post_id = $_POST['params'][0]['post_id'];
			slz_set_db_post_option( $post_id, 'status', $cancel );
			
			$donate = 0;
			$raised = 0;
			$causes_id = slz_get_db_post_option( $post_id, 'cause', '' );
			$posts = $this->get_query_approved_donation($causes_id);
			if( !empty( $posts->posts ) ) {
				foreach ( $posts->posts as $post ) {
					$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
					$raised += intval( $donate );
				}
				$count_dornors = count( $posts->posts );
			}
			
			update_post_meta($causes_id, 'slz-donation-raised-money', $raised);
			update_post_meta($causes_id, 'slz-donation-dornors-number', $count_dornors);
			
			$res = array();
			$res['status'] = '<div class="donate-pending-status">'. esc_html( $cancel ) .'</div>';
			$res['btn'] = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-approve-btn" value="&#8901;&#8901;&#8901;" title="'. esc_html__( 'Approve', 'slz' ) .'" >';
			$res = json_encode( $res );
			echo ( $res );
		}
		die;
	}
	
	public function ajax_add_donate() {
		if( !empty( $_POST['params'][0] ) ) {
			$res = array();
			$res['status'] = 'fail';
			global $woocommerce;
			
			$money_donate = $_POST['params'][0]['money'];
			$post_id_cause = $_POST['params'][0]['post_id'];

			$prefix = 'cause';
			$cause_title = get_the_title( $post_id_cause );
			$posts = get_post( $post_id_cause );
			if( $posts ) {
				$causes_slug = $posts->post_name;
			}else{
				$causes_slug = '';
			}

			$product_id = $this->get_post_name2id( $causes_slug , 'product');

			if (!isset($product_id) || empty($product_id)) {
				$product_cat = esc_html__( 'Causes', 'slz' );
				$product_id = $this->create_woocommerce_product( $prefix, $cause_title, $causes_slug, $product_cat );
			}

			$variation_args = array(
				'post_type'   => 'product_variation',
				'post_parent' => $product_id,
				'post_name'   => $causes_slug
			);
			$variation_obj  = get_posts($variation_args);
			if( !empty( $variation_obj ) ){
				$variation_id   = $variation_obj[0]->ID;
			}

			if (!isset($variation_id) || empty($variation_id)) {
				$variation_id = $this->create_woocommerce_product_variation( $prefix, $product_id, $cause_title, $causes_slug, $post_id_cause );
			}

			if ($product_id > 0 && $variation_id > 0) {
				$cart_item_key = $woocommerce->cart->add_to_cart( $product_id, 1, $variation_id, null, null);
				if (!is_user_logged_in()) {
					$woocommerce->session->set_customer_session_cookie(true);
				}
				$woocommerce->session->set( 'slz_donation_session_key_' . $cart_item_key,
											array(
												'type'  => 'causes',
												'donate_money' => $money_donate,
												'post_id_cause' => $post_id_cause,
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