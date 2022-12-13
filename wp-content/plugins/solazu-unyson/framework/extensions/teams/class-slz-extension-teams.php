<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Extension_Teams extends SLZ_Extension {
	private $post_type_name = 'slz-team';
	private $post_type_slug = 'team';
	private $taxonomy_name = 'slz-team-cat';
	private $taxonomy_slug = 'team-cat';


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
				'slz_ext_teams_team_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_teams_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
			)
		);
	}

	/**
	 * @internal
	 **/
	public function _action_add_permalink_in_settings() {
		add_settings_field(
			'slz_ext_teams_team_slug',
			esc_html__( 'Team base', 'slz' ),
			array( $this, '_team_slug_input' ),
			'permalink',
			'optional'
		);

		add_settings_field(
			'slz_ext_teams_taxonomy_slug',
			esc_html__( 'Teams category base', 'slz' ),
			array( $this, '_taxonomy_slug_input' ),
			'permalink',
			'optional'
		);
	}

	/**
	 * @internal
	 */
	public function _team_slug_input() {
		?>
		<input type="text" name="slz_ext_teams_team_slug" value="<?php echo $this->post_type_slug; ?>">
		<code>/my-team</code>
		<?php
	}

	/**
	 * @internal
	 */
	public function _taxonomy_slug_input() {
		?>
		<input type="text" name="slz_ext_teams_taxonomy_slug" value="<?php echo $this->taxonomy_slug; ?>">
		<code>/my-teams-category</code>
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
				'singular' => esc_html__( 'Team', 'slz' ),
				'plural'   => esc_html__( 'Teams', 'slz' )
			) );

		register_post_type( $this->post_type_name,
			array(
				'labels'             => array(
					'name'               => esc_html__( 'Teams', 'slz' ),
					'singular_name'      => esc_html__( 'Team', 'slz' ),
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
				'description'        => esc_html__( 'Create a team item', 'slz' ),
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

	private function register_taxonomy() {
		$category_names = apply_filters( 'slz_ext_' . $this->get_name() . '_category_name',
			array(
				'singular' => esc_html__( 'Category', 'slz' ),
				'plural'   => esc_html__( 'Categories', 'slz' )
			) );

		register_taxonomy( $this->taxonomy_name, $this->post_type_name, array(
			'labels'            => array(
				'name'              => sprintf( esc_html_x( 'Team %s', 'taxonomy general name', 'slz' ),
					$category_names['plural'] ),
				'singular_name'     => sprintf( esc_html_x( 'Team %s', 'taxonomy singular name', 'slz' ),
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
	 * Modifies table structure for 'All Teams' admin page
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
				'position'                          => esc_html__( 'Position', 'slz' ),
				'taxonomy-' . $this->taxonomy_name 	=> esc_html__( 'Categories', 'slz' ),
				'date'     							=> esc_html__( 'Date', 'slz' ),
			), $columns );
	}

	/**
	 * Adds team options for it's custom post type
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

        $icon_tab = array();
        if ( $this->get_config('has_icon_tab') ) {
            $icon_tab = array(
                'icon_tab' => array(
                    'title' => __('Other', 'slz'),
                    'type'  => 'tab',
                    'options' => array(
                        'arr_icon' => array(
                            'type'  => 'addable-box',
                            'value' => array(
                                array(
                                    'name'   => '',
                                    'value' => '',
                                ),
                            ),
                            'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                            'label' => __('Attributes', 'slz'),
                            'desc'  => __('Add icon for team', 'slz'),
                            'box-options' => array(
                                'name'   => array( 'type' => 'text' ),
                                'value' => array( 'type' => 'text' ),
                                'icon' => array( 'type' => 'icon-v2' ),
                            ),
                            'template' => '{{- name }}: {{- value }}', // box title
                            'box-controls' => array( // buttons next to (x) remove box button
                                'control-id' => '<small class="dashicons dashicons-smiley"></small>',
                            ),
                            'limit' => 0, // limit the number of boxes that can be added
                            'add-button-text' => __('Add', 'slz'),
                            'sortable' => true,
                        ),
                        'list_image' =>array(
                            'type'  => 'multi-upload',
                            'value' => array(),
                            'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                            'label' => __('Album Images', 'slz'),
                            'images_only' => true,
                        )
                    )
                )
            );
        }

		$social_meta = array();
		$social_arr = SLZ_Params::get( 'params_social');
		foreach ($social_arr as $key => $value) {
			$social_meta[$key] = array(
				'type'  => 'text',
				'value' => '',
				'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
				'label' => $value,
				'help'  => $value . esc_html__(' of social.', 'slz'),
			);
		}


		$team_options = apply_filters( 'slz_ext_teams_post_options',
			array(
				'general_tab' => array(
					'title'   => esc_html__( 'General', 'slz' ),
					'type'    => 'tab',
					'options' => array(
						'position' => array(
							'type'  => 'text',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Position', 'slz'),
							'help'  => esc_html__('Postition of team.', 'slz'),
							'save-in-separate-meta' => true
						),
						'phone' => array(
							'type'  => 'text',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Phone', 'slz'),
							'help'  => esc_html__('Phone of team.', 'slz'),
						),
						'email' => array(
							'type'  => 'text',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Email', 'slz'),
							'help'  => esc_html__('Email of team.', 'slz'),
						),
						'skype' => array(
							'type'  => 'text',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Skype', 'slz'),
							'help'  => esc_html__('Skype of team.', 'slz'),
						),
						'short_des' => array(
							'type'  => 'textarea',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Short description', 'slz'),
							'help'  => esc_html__('Short description of team. Display on Team List shortcode', 'slz'),
						),
						'description' => array(
							'type'  => 'textarea',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Description', 'slz'),
							'help'  => esc_html__('Description of team. Only display on Team List shortcode - Layout Carousel.', 'slz'),
						),
						'quote' => array(
							'type'  => 'textarea',
							'value' => '',
							'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
							'label' => esc_html__('Quote', 'slz'),
							'help'  => esc_html__('Quote of team.', 'slz'),
						),
					)
				),
				'social_tab' => array(
					'title'   => esc_html__( 'Social', 'slz' ),
					'type'    => 'tab',
					'options' => $social_meta
				)
			) );
        $team_options = array_merge($team_options, $icon_tab);
		if (empty($team_options)) {
			return $post_options;
		}

		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['team_box']['options'][] = $team_options;
		} else {
			$post_options['team_box'] = array(
				'title'   => esc_html__('Team Options', 'slz'),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $team_options
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
			case 'position' :
				echo $this->get_meta_position( $post_id );
				break;
			default :
				break;
		}
	}

	/**
	 * Get saved team location array from db
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
	 * Enquee backend styles on teams pages
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

}
