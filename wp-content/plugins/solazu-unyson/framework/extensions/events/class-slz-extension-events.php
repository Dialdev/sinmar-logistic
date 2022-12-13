<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Extension_Events extends SLZ_Extension {
	private $post_type_name = 'slz-event';
	private $post_type_slug = 'event';
    private $taxonomy_name = 'slz-event-cat';
    private $taxonomy_status_name = 'slz-event-status';
	private $taxonomy_status_slug = 'event-status';
    private $taxonomy_slug = 'event-cat';

	private $post_type_ed_name = 'slz-event-donation';
	private $post_type_ed_slug = 'event-donation';

	public function slz_get_post_type_slug() {
		return $this->post_type_slug;
	}

	public function get_post_type_name() {
		return $this->post_type_name;
	}

	public function get_taxonomy_name() {
		return $this->taxonomy_name;
	}

    public function get_taxonomy_status_name() {
        return $this->taxonomy_status_name;
    }

	public function _get_link() {
		return self_admin_url( 'edit.php?post_type=' . $this->get_post_type_name() );
	}

	public function get_image_sizes() {
		return $this->get_config( 'image_sizes' );
	}

	public function get_post_type_ed_name() {
		return $this->post_type_ed_name;
	}

	/**
	 * @internal
	 */
	protected function _init() {
		$this->define_slugs();
		$this->register_post_type();
		$this->register_taxonomy();
		$this->register_status_taxonomy();

		if ( is_admin() ) {
			$this->save_permalink_structure();
			$this->add_admin_filters();
			$this->add_admin_actions();
		} else {
			$this->add_theme_actions();
		}

		add_filter( 'slz_post_options', array( $this, '_filter_slz_post_options' ), 10, 2 );
		add_filter( 'slz_post_options', array( $this, '_filter_slz_ed_post_options' ), 10, 2 );
	}

	private function save_permalink_structure() {
		if ( ! isset( $_POST['permalink_structure'] ) && ! isset( $_POST['category_base'] ) ) {
			return;
		}

		$this->set_db_data(
			'permalinks/post',
			SLZ_Request::POST(
				'slz_ext_events_event_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_events_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
			)
		);
	}

	/**
	 * @internal
	 **/
	public function _action_add_permalink_in_settings() {
		add_settings_field(
			'slz_ext_events_event_slug',
			esc_html__( 'Event base', 'slz' ),
			array( $this, '_event_slug_input' ),
			'permalink',
			'optional'
		);

		add_settings_field(
			'slz_ext_events_taxonomy_slug',
			esc_html__( 'Events category base', 'slz' ),
			array( $this, '_taxonomy_slug_input' ),
			'permalink',
			'optional'
		);
	}

	/**
	 * @internal
	 */
	public function _event_slug_input() {
		?>
		<input type="text" name="slz_ext_events_event_slug" value="<?php echo $this->post_type_slug; ?>">
		<code>/my-event</code>
		<?php
	}

	/**
	 * @internal
	 */
	public function _taxonomy_slug_input() {
		?>
		<input type="text" name="slz_ext_events_taxonomy_slug" value="<?php echo $this->taxonomy_slug; ?>">
		<code>/my-events-category</code>
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
				'singular' => esc_html__( 'Event', 'slz' ),
				'plural'   => esc_html__( 'Events', 'slz' )
			) );

		register_post_type( $this->post_type_name,
			array(
				'labels'             => array(
				'name'               => esc_html__( 'Events', 'slz' ),
				'singular_name'      => esc_html__( 'Event', 'slz' ),
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
				'description'        => esc_html__( 'Create a event item', 'slz' ),
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
				'menu_icon'          => 'dashicons-calendar-alt',
				'hierarchical'       => false,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array(
					'title', /* Text input field to create a post title. */
					'editor',
					'thumbnail', /* Displays a box for featured image. */
				)
			) );

		// Events Donation
		$ed_post_names = apply_filters( 'slz_ext_' . $this->get_name() . '_post_type_name',
			array(
				'singular' => esc_html__( 'Event Donation', 'slz' ),
				'plural'   => esc_html__( 'Events Donation', 'slz' )
			) );

		register_post_type( $this->post_type_ed_name,
			array(
				'labels'         => array(
					'name'          => esc_html__( 'Events Donation', 'slz' ),
					'singular_name' => esc_html__( 'Event Donation', 'slz' ),
					'add_new'       => esc_html__( 'Add New', 'slz' ),
					'add_new_item'  => sprintf( esc_html__( 'Add New %s','slz'),$ed_post_names['singular'] ),
					'edit'          => esc_html__( 'Edit', 'slz' ),
					'edit_item'     => sprintf( esc_html__( 'Edit %s', 'slz' ), $ed_post_names['singular'] ),
					'new_item'      => sprintf( esc_html__( 'New %s', 'slz' ), $ed_post_names['singular'] ),
					'all_items'     => sprintf( esc_html__( 'All %s', 'slz' ), $ed_post_names['plural'] ),
					'view'          => sprintf( esc_html__( 'View %s', 'slz' ), $ed_post_names['singular'] ),
					'view_item'     => sprintf( esc_html__( 'View %s', 'slz' ), $ed_post_names['singular'] ),
					'search_items'  => sprintf( esc_html__( 'Search %s', 'slz' ), $ed_post_names['plural'] ),
					'not_found'     => sprintf( esc_html__( 'No %s Found','slz'), $ed_post_names['plural'] ),
					'not_found_in_trash' => sprintf( esc_html__( 'No %s Found In Trash', 'slz' ), $ed_post_names['plural'] ),
					'parent_item_colon'  => ''
				),
				'description'        => esc_html__( 'Create a event donation item', 'slz' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => false,
				'publicly_queryable' => true,
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->post_type_ed_slug
				),
				'show_in_nav_menus'  => false,
				'menu_icon'          => 'dashicons-groups',
				'hierarchical'       => false,
				'query_var'          => true,
				'supports'           => array('')
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
				'name'              => sprintf( esc_html_x( 'Event %s', 'taxonomy general name', 'slz' ),
					$category_names['plural'] ),
				'singular_name'     => sprintf( esc_html_x( 'Event %s', 'taxonomy singular name', 'slz' ),
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

    private function register_status_taxonomy() {
        $category_names = apply_filters( 'slz_ext_' . $this->get_name() . '_status_name',
            array(
                'singular' => esc_html__( 'Status', 'slz' ),
                'plural'   => esc_html__( 'Status', 'slz' )
            ) );

        register_taxonomy( $this->taxonomy_status_name, $this->post_type_name, array(
            'labels'            => array(
                'name'              => sprintf( esc_html_x( 'Event %s', 'taxonomy general name', 'slz' ),
                    $category_names['plural'] ),
                'singular_name'     => sprintf( esc_html_x( 'Event %s', 'taxonomy singular name', 'slz' ),
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
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => false,
            'query_var'         => true,
            'show_in_nav_menus' => false,
            'show_in_menu'      => false,
            'show_tagcloud'     => false,
            'meta_box_cb'       => false,
            'rewrite'           => array(
                'slug' => $this->taxonomy_status_slug
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
			'manage_' . $this->get_post_type_ed_name() . '_posts_columns',
			array( $this, '_filter_add_ed_columns' ),
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
			'manage_' . $this->get_post_type_ed_name() . '_posts_custom_column',
			array( $this, '_action_manage_ed_custom_column' ),
			10,
			2
		);
		add_action( 'admin_enqueue_scripts', array( $this, '_action_enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, '_action_add_permalink_in_settings' ) );
	}

	private function add_theme_actions() {
	}

	/**
	 * Modifies table structure for 'All Events' admin page
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function _filter_add_columns( $columns ) {
		unset( $columns['date'], $columns['cb'], $columns['title'], $columns[ 'taxonomy-' . $this->taxonomy_name ] );
		return array_merge(
            array(
                'cb'                                         => esc_html__( 'Checkbox', 'slz' ),
                'thumbnail'                                => esc_html__( 'Thumbnail', 'slz' ),
                'title'                                      => esc_html__( 'Title', 'slz' ),
                'taxonomy-' . $this->taxonomy_name           => esc_html__( 'Categorys', 'slz' ),
            ),
            $columns,
			array(
                'event_location'     => esc_html__( 'Location', 'slz' ),
				'event_date_range'   => esc_html__( 'Event Range', 'slz' ),
                'date'               => esc_html__( 'Date', 'slz' ),
			)
		);
	}

	/**
	 * Modifies table structure for 'All Donation' in "Events" admin page
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function _filter_add_ed_columns( $columns ) {
		unset( $columns['title'] );
		unset( $columns['date'] );

		return array_merge( $columns, array(
				'dornor_name'           => esc_html__( 'Name', 'slz' ),
				'email'                 => esc_html__( 'Email', 'slz' ),
				'event'                 => esc_html__( 'Event', 'slz' ),
				'amount'                => esc_html__( 'Money', 'slz' ),
				'status'                => esc_html__( 'Status', 'slz' ),
				'action_btn'            => esc_html__( 'Action', 'slz' )
			) );
	}

	/**
	 * Adds event options for it's custom post type
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

        $album_tab = $gallery_tab = $other_tab = $history_tab = $team_tab = $donation_tab = array();
		$has_artist_band   = $this->get_config( 'has_artist_band' );
		$is_multiple_price = $this->get_config( 'is_multiple_price' );
        $has_gallery       = $this->get_config( 'has_gallery' );
        $has_banner_ticket_bg       = $this->get_config( 'has_banner_ticket_bg' );

        $taxonomy_status_option = array();
        $events = slz_ext('events');
        $enable_status_taxonomy = $events->get_config('has_status_taxonomy');
        if ($enable_status_taxonomy) {
            $args = array
            (
                'get' => 'all',
            );
            $event_status_option = array(
                'empty'   => esc_html__( '-Empty Event Status-', 'slz' )
            );
            $terms = get_terms( 'slz-event-status', $args);
            foreach ($terms as $term) {
                $event_status_option[$term->term_id] = $term->name;
            }

            $taxonomy_status_option = array(
                'status' => array(
                    'type'    => 'slz-select-link',
                    'value'   => '',
                    'label'   => esc_html__('Status', 'slz'),
                    'choices' => $event_status_option,
                    'save-in-separate-meta' => true,
                    'link'    => 'edit-tags.php?taxonomy=slz-event-status&post_type=slz-event',
                    'link_image' => 'https://cdn1.iconfinder.com/data/icons/material-core/20/add-circle-outline-128.png'
                )
            );
        }


        if ($has_gallery) {
        	$gallery_tab = array(
                'gallery_tab' => array(
                    'title'       => esc_html__( 'Gallery', 'slz' ),
                    'type'        => 'tab',
                    'options'     => array(
                        'gallery_tab' => array(
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
                    )
                )
            );
        }

        if( $this->get_config( 'has_other_tab' )) {
			$other_tab = array(
                'other_tab'   => array(
                    'title'       => esc_html__( 'Others', 'slz' ),
                    'type'        => 'tab',
                    'options'     =>    array(
                        'other_tab' => array(
                            'type'      => 'tab',
                            'options'   => array(
                                'event_goal_donation' => array(
                                    'label' => esc_html__('Goal Donation', 'slz'),
                                    'type'  => 'text',
                                    'desc'  => esc_html__('Input Goal Donation for Event', 'slz'),
                                ),
                                'address' => array(
                                    'type'  => 'map',
                                    'value' => array(
                                        'coordinates' => array(
                                            'lat'   => -34,
                                            'lng'   => 150,
                                        )
                                    ),
                                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                    'label' => esc_html__('Address', 'slz'),
                                    'desc'  => esc_html__('Input Address for Event', 'slz'),
                                ),
                                'event_attributes'    => array(
                                    'type'            => 'addable-box',
                                    'value'           => array(
                                        array(
                                            'name'            => '',
                                            'value'           => '',
                                        ),
                                    ),
                                    'attr'            => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                                    'label'           => esc_html__('Attributes', 'slz'),
                                    'desc'            => esc_html__('Add event attributes', 'slz'),
                                    'box-options'     => array(
                                        'name'            => array( 'type' => 'text' ),
                                        'value'           => array( 'type' => 'text' ),
                                    ),
                                    'template'        => '{{- name }}: {{- value }}', // box title
                                    'box-controls'    => array( // buttons next to (x) remove box button
                                        'control-id'      => '<small class="dashicons dashicons-smiley"></small>',
                                    ),
                                    'limit'           => 0, // limit the number of boxes that can be added
                                    'add-button-text' => esc_html__('Add', 'slz'),
                                    'sortable'        => true,
                                )
                            )
                        ),
                    )
                )
            );
		}

        if( $is_multiple_price ) {
            $general_tab = array(
                $taxonomy_status_option,
                'event_date_range' => array(
                    'type'  => 'datetime-range',
                    'label' => esc_html__( 'Start And End Of Event', 'slz' ),
                    'desc'  => esc_html__( 'Set start and end events datetime', 'slz' ),
                    'datetime-pickers' => apply_filters( 'slz_option_type_event_datetime_pickers', array(
                        'from' => array(
                            'fixed'         => true,
                            'timepicker'    => true,
                            'datepicker'    => true,
                            'defaultTime'   => '08:00'
                        ),
                        'to'   => array(
                            'fixed'         => true,
                            'timepicker'    => true,
                            'datepicker'    => true,
                            'defaultTime'   => '18:00'
                        )
                    ) ),
                    'value' => array(
                        'from' => '',
                        'to'   => ''
                    ),
                    'save-in-separate-meta' => true
                ),
                'description' => array(
                    'type'  => 'textarea',
                    'value' => '',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => esc_html__('Description', 'slz'),
                ),
                'event_location' => array(
                    'label' => esc_html__('Event Location', 'slz'),
                    'type'  => 'text',
                    'desc'  => esc_html__('Where does the event take place?', 'slz'),
                ),
                'hide_event_expired' => array(
                    'type'  => 'checkbox',
                    'value' => false,
                    'label' => esc_html__('Hide Event When Expired', 'slz'),
                    'text'  => esc_html__('Yes', 'slz'),
                )
            );
        } else {
            $general_tab = array(
                $taxonomy_status_option,
                'event_ticket_price' => array(
                    'label' => esc_html__('Ticket Price', 'slz'),
                    'type'  => 'text',
                    'value' => '0',
                    'desc'  => esc_html__('Price to sale the ticket of the event', 'slz'),
                    'save-in-separate-meta' => true
                ),
                'event_ticket_number' => array(
                    'label' => esc_html__('Number Ticket', 'slz'),
                    'type'  => 'text',
                    'value' => '',
                    'desc'  => esc_html__('Number of the ticket of the event', 'slz'),
                    'save-in-separate-meta' => true
                ),
                'event_date_range' => array(
                    'type'  => 'datetime-range',
                    'label' => esc_html__( 'Start And End Of Event', 'slz' ),
                    'desc'  => esc_html__( 'Set start and end events datetime', 'slz' ),
                    'datetime-pickers' => apply_filters( 'slz_option_type_event_datetime_pickers', array(
                        'from' => array(
                            'fixed'         => true,
                            'timepicker'    => true,
                            'datepicker'    => true,
                            'defaultTime'   => '08:00'
                        ),
                        'to'   => array(
                            'fixed'         => true,
                            'timepicker'    => true,
                            'datepicker'    => true,
                            'defaultTime'   => '18:00'
                        )
                    ) ),
                    'value' => array(
                        'from' => '',
                        'to'   => ''
                    ),
                    'save-in-separate-meta' => true
                ),
                'description' => array(
                    'type'  => 'textarea',
                    'value' => '',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => esc_html__('Description', 'slz'),
                ),
                'event_show_button' => array(
                    'type'  => 'checkboxes',
				    'value' => array(
				        'donation' => true,
				        'ticket'   => true
				    ),
				    'label' => esc_html__('Show Button', 'slz'),
				    'desc'  => esc_html__('Choose button that display in single page.', 'slz'),
				    'choices' => array(
				        'donation' => esc_html__('Donation', 'slz'),
				        'ticket'   => esc_html__('Buy Ticket', 'slz'),
				    ),
				    'inline' => true
                ),
                'event_ticket_text' => array(
                    'label' => esc_html__('Button Buy Ticket Text', 'slz'),
                    'type'  => 'text',
                    'desc'  => esc_html__('Input text for Buy Ticket button', 'slz'),
                ),
                'event_ticket_url' => array(
                    'label' => esc_html__('Button Buy Ticket URL', 'slz'),
                    'type'  => 'text',
                    'desc'  => esc_html__('Input URL for payment method on button Buy Ticket', 'slz')
                ),
                'event_donation_text' => array(
                    'label' => esc_html__('Button Donation Text', 'slz'),
                    'type'  => 'text',
                    'desc'  => esc_html__('Input text for Donation button.', 'slz')
                ),
                'event_donation_url' => array(
                    'label' => esc_html__('Button Donation URL', 'slz'),
                    'type'  => 'text',
                    'desc'  => esc_html__('Input URL for Donation button when payment method is set custom link in theme settings.', 'slz')
                ),
                'event_location' => array(
                    'label' => esc_html__('Event Location', 'slz'),
                    'type'  => 'text',
                    'desc'  => esc_html__('Where does the event take place?', 'slz'),
                    'save-in-separate-meta' => true
                ),
                'hide_event_expired' => array(
                    'type'  => 'checkbox',
                    'value' => false,
                    'label' => esc_html__('Hide Event When Expired', 'slz'),
                    'text'  => esc_html__('Yes', 'slz'),
                )
            );
        }

        if( $has_banner_ticket_bg ) {
            $general_tab['banner_image'] = array(
                'type'  => 'upload',
                'label' => esc_html__('Banner Ticket Background Image', 'slz'),
                'desc'  => esc_html__('Upload image .png or .jpg', 'slz'),
                'images_only' => true,
                'value' => '',
            );
        }


		if( $has_artist_band ) {
		    $artist_band = array(
				'artist_band'               => array(
					'label'                 => esc_html__('Artists & Band', 'slz'),
					'type'                  => 'text',
					'value'                 => '',
					'desc'                  => esc_html__('Artists & Band.', 'slz'),
					'save-in-separate-meta' => true
                ),
            );

            $general_tab = array_merge( $general_tab, $artist_band );
        }
// Define @tab
        $param_options = array(
				'general_tab' => array(
				'title'       => esc_html__( 'General', 'slz' ),
				'type'        => 'tab',
				'options'     => $general_tab,
				),
				$gallery_tab,
				$other_tab
        );

        if( $is_multiple_price ) {
            $multi_price = array(
                'ticket_price_tab'   => array(
                    'title'   => esc_html__( 'Order', 'slz' ),
                    'type'    => 'tab',
                    'options' => array(
                        'price_box' => array(
                            'type'  => 'addable-box',
                            'value' => array(),
                            'attr' => array( 'class' => '' ),
                            'desc' => 'Add multiple price.',
                            'box-options' => array(
                                'ticket_name' => array(
                                    'type'  => 'text',
                                    'value' => '',
                                    'attr'  => array( 'class' => '' ),
                                    'label' => esc_html__( 'Ticket Name', 'slz' ),
                                    'desc'  => 'Name of Ticket.',
                                ),
                                'ticket_price' => array(
                                    'type'  => 'text',
                                    'value' => '',
                                    'attr'  => array( 'class' => '' ),
                                    'label' => esc_html__( 'Ticket Price', 'slz' ),
                                    'desc'  => 'Price of ticket.',
                                ),
                                'ticket_number' => array(
                                    'type' => 'text',
                                    'value' => '',
                                    'attr'  => array( 'class' => '' ),
                                    'label' => esc_html__( 'Number of Ticket', 'slz' ),
                                    'desc'  => 'Number of Ticket.',
                                ),
                                'items' => array(
                                    'type'  => 'addable-box',
                                    'value' => array(),
                                    'attr'  => array( 'class' => '' ),
                                    'label' => esc_html__('Items', 'slz'),
                                    'desc'  => esc_html__('Items of ticket.', 'slz'),
                                    'box-options' => array(
                                        'item' => array(
                                            'type' => 'text',
                                            'value' => '',
                                            'attr'  => array( 'class' => '' ),
                                            'label' => esc_html__( 'Item', 'slz' ),
                                            'desc'  => 'Ticket item.',
                                        ),
                                    ),
                                    'template' => '{{- item }}',
                                    'add-button-text' => esc_html__('Add', 'slz'),
                                    'sortable' => true,
                                ),
                                'ticket_url' => array(
                                    'label' => esc_html__('Button Buy Ticket URL', 'slz'),
                                    'type'  => 'text',
                                    'desc'  => esc_html__('Input URL for payment method on button Buy Ticket', 'slz'),
                                ),
                            ),
                            'template' => '{{- ticket_name }}: {{- ticket_price }}',
                            'add-button-text' => esc_html__( 'Add', 'slz' ),
                            'sortable' => true,
                        ),
                    ),
                ),
            );

            $param_options = array_merge( $param_options, $multi_price , $gallery_tab, $other_tab);
        }

		$event_options = apply_filters( 'slz_ext_events_post_options', $param_options);

		if (empty($event_options)) {
			return $post_options;
		}

		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['event_box']['options'][] = $event_options;
		} else {
			$post_options['event_box'] = array(
				'title'   => esc_html__('Event Options', 'slz' ),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $event_options
			);
		}

		return $post_options;
	}
	
	/**
	 * Adds events donation options for it's custom post type
	 * Use for donation
	 *
	 * @internal
	 *
	 * @param $post_options
	 * @param $post_type
	 *
	 * @return array
	 */
	public function _filter_slz_ed_post_options( $post_options, $post_type ) {
		if ( $post_type !== $this->post_type_ed_name ) {
			return $post_options;
		}

		$args = array( 'post_type' => $this->post_type_name );
		$event_list = SLZ_Com::get_post_id2title( $args, array(), false );


		$donation_options = apply_filters( 'slz_ext_' . $this->get_name() . '_post_options',
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
						        'pending' => esc_html__('Pending', 'slz')
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
						'event' => array(
						    'type'    => 'select',
						    'value'   => '',
						    'label'   => esc_html__('Event', 'slz'),
						    'choices' => $event_list,
							'save-in-separate-meta' => true
						),
						'first_name' => array(
							'type'   => 'text',
							'value'  => '',
							'label'  => esc_html__('First Name', 'slz'),
							'help'   => esc_html__('First name of persional information.', 'slz')
						),
						'last_name'  => array(
							'type'   => 'text',
							'value'  => '',
							'label'  => esc_html__('Last Name', 'slz'),
							'help'   => esc_html__('Last name of persional information.', 'slz')
						),
						'email' => array(
							'type'   => 'text',
							'value'  => '',
							'label'  => esc_html__('Email Name', 'slz'),
							'help'   => esc_html__('Email of persional information.', 'slz')
						),
						'phone' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Phone', 'slz'),
							'help'  => esc_html__('Phone of persional information.', 'slz')
						),
						'address' => array(
							'type'  => 'text',
							'value' => '',
							'label' => esc_html__('Address', 'slz'),
							'help'  => esc_html__('Address of persional information.', 'slz')
						)
					)
				)
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
	 * Fill custom column
	 *
	 * @internal
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function _action_manage_custom_column( $column, $post_id ) {
		switch ( $column ) {
			case 'event_location' :
				echo $this->get_event_location( $post_id );
				break;
			case 'event_date_range' :
				echo $this->get_event_date_range( $post_id );
				break;
			case 'description' :
				echo $this->get_event_description( $post_id );
				break;
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

	public function _action_manage_ed_custom_column( $column, $post_id ) {
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
			case 'event' :
				echo $this->get_meta_event( $post_id );
				break;
			case 'amount' :
				echo $this->get_meta_amount($post_id);
				break;
			case 'status' :
				echo $this->get_meta_status( $post_id );
				break;
			case 'action_btn' :
				echo $this->get_action_button( $post_id );
				break;
			default :
				break;
		}
	}

	/**
	 * Get saved donation data array from db
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

	private function get_meta_email( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'email' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}

	private function get_meta_event( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'event' );
		$url = get_edit_post_link( $meta );
		$out = '<a href="'. esc_url( $url ) .'" target="_blank" >'. esc_html( get_the_title( $meta ) ) .'</a>';
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $out : '&#8212;' );
	}

	private function get_meta_amount( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'amount' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? slz_get_currency_format_options( $meta ) : '&#8212;' );
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

	private function get_action_button( $post_id ){
		$out = '';
		$meta = slz_get_db_post_option( $post_id, 'status' );
		
		if( $meta == 'approve' ) {
			$out = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-ed-cancel-btn" value="&#x21b6;" title="'. esc_html__('Unapprove', 'slz') .'" >';
		}else{
			$out = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-ed-approve-btn" value="&#8901;&#8901;&#8901;" title="'. esc_html__( 'Approve', 'slz' ) .'" >';
		}
		return $out;
	}

	/**
	 * Get saved event location array from db
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	private function get_event_location( $post_id ) {
		$meta = slz_get_db_post_option( $post_id);
		return ( ( isset( $meta['event_location'] ) and false === empty( $meta['event_location'] ) ) ? $meta['event_location'] : '&#8212;' );
	}

	private function get_event_address( $post_id ) {
		$meta = slz_get_db_post_option( $post_id);
		return ( ( isset( $meta['address'] ) and false === empty( $meta['address'] ) ) ? $meta['address'] : '&#8212;' );
	}	

	private function get_event_description( $post_id ) {
		$meta = slz_get_db_post_option( $post_id);
		return ( ( isset( $meta['description'] ) and false === empty( $meta['description'] ) ) ? $meta['description'] : '&#8212;' );
	}

	private function get_event_date_range( $post_id ) {
		$meta = slz_get_db_post_option( $post_id);
		if ( isset( $meta['event_date_range'] ) and false === empty( $meta['event_date_range'] ) ) {
			$from = $meta['event_date_range']['from'];
			$to = $meta['event_date_range']['to'];
			$range = $from." - ".$to;
			return $range;
		}
		return '&#8212;';
	}

	private function get_meta_position( $post_id ) {
		$meta = slz_get_db_post_option( $post_id, 'position' );
		return ( ( isset( $meta ) and false === empty( $meta ) ) ? $meta : '&#8212;' );
	}

	/**
	 * Enquee backend styles on events pages
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

	public function ajax_search_event(){
        global $wpdb;

	    $params = $_POST['params'][0];

	    if( empty( $params ) )
	        die;

        $res = array();

	    $concert_name = $params['concert_name'];
        $from = $params['from'];
        $to = $params['to'];
        $artists_bands = $params['artists_bands'];
        $atts = json_decode( base64_decode( $params['atts'] ), true );
        $atts['thumb-size']['is_ajax'] = true;

        $atts['limit_post'] = -1;

        $meta_query = array();

        if( ! empty( $from ) ) {
            $meta_query[] = array(
                'key'     => 'slz_option:from_date',
                'value'   => date( "Y/m/d" , strtotime( $from ) ),
                'compare' => '>=',
            );
        }

        if( ! empty( $to ) ) {
            $meta_query[] = array(
                'key'     => 'slz_option:from_date',
                'value'   => date( "Y/m/d" , strtotime( $to ) ),
                'compare' => '<=',
            );
        }

        if( ! empty( $artists_bands ) ) {
            $meta_query[] = array(
                'key'     => 'slz_option:artist_band',
                'value'   => $artists_bands,
                'compare' => 'LIKE',
            );
        }

        $_postId = $wpdb->get_col("select ID from $wpdb->posts where post_title LIKE '%".$concert_name."%' ");

        $args = array(
            'post__in'=> $_postId,
            'post_type'        => $this->post_type_name,
            'posts_per_page'   => 5,
//            's'                => $concert_name,
            'meta_query'       => $meta_query,
            'post_status'      => 'publish',
        );

        $html_format = '
            <div class="item">
                <div class="slz-event-01">
                    <div class="event-wrapper">
                        %1$s
                        <div class="event-info info">
                            <div class="info-wrapper">
                                %2$s
                                <div class="info-content">
                                    %3$s
                                    %5$s
                                </div>
                            </div>
                        </div>
                        %9$s
                        <div class="event-info price">
                            <div class="unit">ticket</div>
                            <div class="number">%10$s</div>
                        </div>
                        <div class="event-info button">
                            <a href="%8$s" class="slz-btn"> <span class="btn-text">'. esc_html__( 'book now', 'slz' ) .'</span><span class="btn-icon fa fa-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $html_render['html_format'] = $html_format;
            $html_render['event_date'] = '
            <div class="event-info time">
                <div class="date">%1$s</div>
                <div class="month">%2$s</div>
                <div class="year">%3$s</div>
            </div>
        ';

        $html_render['title_format'] = '
            <div class="title-wrapper"><a href="%2$s" class="title">%1$s</a></div>
        ';

        $html_render['thumb_class'] = 'thumb-img';

        $html_render['event_description_format'] = '
            <div class="description">%1$s</div>
        ';

        $html_render['image_format'] = '
            <div class="info-img">%1$s</div>
        ';

        $html_render['event_location'] = '
            <div class="event-info location">
                <div class="specific">%1$s</div>
            </div>
        ';

        $model = new SLZ_Event();
        $model->init( $atts, $args );

        $inc = 0;
        $res['content'] = '';
        if ( $model->query->have_posts() ) {
            $res['count'] = $model->query->found_posts;
            while ( $model->query->have_posts() ) {
                $model->query->the_post();
                $model->loop_index();
                $res['content'] .= sprintf( $html_render['html_format'],
                    $model->get_event_date( $html_render ),
                    $model->get_image( $html_render ),
                    $model->get_title( $html_render ),
                    $model->get_event_block_info( $html_render ),
                    $model->get_event_description( $html_render  ),
                    $inc++,
                    $model->post_meta['event_date_range']['from'],
                    $model->permalink,
                    $model->get_event_location( $html_render ),
                    $model->get_meta_price( $html_render )
                );
            }
            $model->reset();
        } else {
            $res['count'] = 0;
            $res['content'] = esc_html__( 'Not found!', 'slz' );
        }

        echo json_encode( $res );
        die;
    }

    public function ajax_btn_more_event(){

        $params = $_POST['params'][0];

        if( empty( $params ) )
            die;

        $res = array();
        $html_render = json_decode( base64_decode( $params['html_render'] ), true );
        $atts = json_decode( base64_decode( $params['atts'] ), true );
        $atts['offset_post'] = $params['offset_post'];
        $model = new SLZ_Event();
        $model->init( $atts );
        $res = $model->render_event_ajax($html_render);

        echo ( $res );
        die;
    }
	
	/*******BUY TICKET METHOD******/
	public function ajax_buy_ticket() {
		if( !empty( $_POST['params'][0] ) ) {
			$res = array();
			$res['status'] = 'fail';
			global $woocommerce;
			
//			$money_donate = $_POST['params'][0]['money'];
			$post_id_event = $_POST['params'][0]['post_id'];

			if( ! $this->get_config( 'is_multiple_price' ) ) {
                $price_ticket = slz_get_db_post_option( $post_id_event, 'event_ticket_price', '0' );

                $prefix = 'event';
                $event_title = get_the_title( $post_id_event );
                $posts = get_post( $post_id_event );
                if( $posts ) {
                    $event_slug = $posts->post_name;
                }else{
                    $event_slug = '';
                }

                $product_id = $this->get_post_name2id( $event_slug , 'product');

                if (!isset($product_id) || empty($product_id)) {
                    $product_cat = esc_html__( 'Events', 'slz' );
                    $product_id = $this->create_woocommerce_product( $prefix, $event_title, $event_slug, $product_cat );
                }

                $variation_args = array(
                    'post_type'   => 'product_variation',
                    'post_parent' => $product_id,
                    'post_name'   => $event_slug
                );
                $variation_obj  = get_posts($variation_args);
                if( !empty( $variation_obj ) ){
                    $variation_id   = $variation_obj[0]->ID;
                }

                if (!isset($variation_id) || empty($variation_id)) {
                    $variation_id = $this->create_woocommerce_product_variation( $prefix, $product_id, $event_title, $event_slug, $post_id_event );
                }

                if ($product_id > 0 && $variation_id > 0) {
                    $cart_item_key = $woocommerce->cart->add_to_cart( $product_id, 1, $variation_id, null, null);
                    if (!is_user_logged_in()) {
                        $woocommerce->session->set_customer_session_cookie(true);
                    }
                    $woocommerce->session->set( 'slz_events_session_key_' . $cart_item_key,
                        array(
                            'type'  => 'events',
                            'event_price_ticket' => $price_ticket,
                            'post_id_event' => $post_id_event,
                        ));
                }
                $res['status'] = 'success';
                $res['url'] = esc_url( home_url().'/cart' );
                $res = json_encode( $res );
                echo ( $res );
			} else {
                $pricing_column = $_POST['params'][0]['pricing_column'];

			    if( ! isset( $pricing_column ) ) {
                    die;
                }

                $price_box = slz_get_db_post_option( $post_id_event, 'price_box', array() );

			    foreach ( $price_box as $idx => $box ) {
			        $price_box[ md5( $box['ticket_name'].$box['ticket_price'] ) ] = $box;
                }

                if( ! empty( $price_box[$pricing_column] ) ) {
                    $price_ticket = $price_box[$pricing_column]['ticket_price'];
                } else {
                    die;
                }

                $prefix = 'event';
                $event_title = get_the_title( $post_id_event );
                $posts = get_post( $post_id_event );
                if( $posts ) {
                    $event_slug = $posts->post_name;
                }else{
                    $event_slug = '';
                }

                $product_id = $this->get_post_name2id( $event_slug , 'product');

                if (!isset($product_id) || empty($product_id)) {
                    $product_cat = esc_html__( 'Events', 'slz' );
                    $product_id = $this->create_woocommerce_product( $prefix, $event_title, $event_slug, $product_cat );
                }

                $variation_args = array(
                    'post_type'   => 'product_variation',
                    'post_parent' => $product_id,
                    'post_name'   => $event_slug
                );
                $variation_obj  = get_posts($variation_args);
                if( !empty( $variation_obj ) ){
                    $variation_id   = $variation_obj[0]->ID;
                }

                if (!isset($variation_id) || empty($variation_id)) {
                    $variation_id = $this->create_woocommerce_product_variation( $prefix, $product_id, $event_title, $event_slug, $post_id_event );
                }

                if ($product_id > 0 && $variation_id > 0) {
                    $cart_item_key = $woocommerce->cart->add_to_cart( $product_id, 1, $variation_id, null, null);
                    if (!is_user_logged_in()) {
                        $woocommerce->session->set_customer_session_cookie(true);
                    }
                    $woocommerce->session->set( 'slz_events_session_key_' . $cart_item_key,
                        array(
                            'type'  => 'events',
                            'event_price_ticket' => $price_ticket,
                            'post_id_event'      => $post_id_event,
                            'pricing_column'     => $pricing_column,
                        ));
                }
                $res['status'] = 'success';
                $res['url'] = esc_url( home_url().'/cart' );
                $res = json_encode( $res );
                echo ( $res );
            }
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

	/***** Event Donation button action *****/
	public function ajax_ed_approve_btn_admin() {
		if( !empty( $_POST['params'][0] ) ) {
			$approve = 'approve';
			$post_id = $_POST['params'][0]['post_id'];
			slz_set_db_post_option( $post_id, 'status', $approve );
			
			$raised = 0;
			$count_dornors = 0;
			$event_id = slz_get_db_post_option( $post_id, 'event', '' );
			$posts = $this->get_approved_event_donation($event_id);
			if( !empty( $posts->posts ) ) {
				foreach ( $posts->posts as $post ) {
					$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
					$raised += intval( $donate );
				}
				$count_dornors = count( $posts->posts );
			}
			
			update_post_meta($event_id, 'slz-donation-raised-money', $raised);
			update_post_meta($event_id, 'slz-donation-dornors-number', $count_dornors);
			
			$res = array();
			$res['status'] = '<div class="donate-approve-status">'. esc_html__('Approve', 'slz') .'</div>';
			$res['btn'] = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-ed-cancel-btn" value="&#x21b6;" title="'. esc_html__('Unapprove', 'slz') .'" >';
			$res = json_encode( $res );
			echo ( $res );
		}
		die;
	}
	
	public function ajax_ed_cancel_btn_admin() {
		if( !empty( $_POST['params'][0] ) ) {
			$cancel = 'pending';
			$post_id = $_POST['params'][0]['post_id'];
			slz_set_db_post_option( $post_id, 'status', $cancel );
			
			$raised = 0;
			$count_dornors = 0;
			$event_id = slz_get_db_post_option( $post_id, 'event', '' );
			$posts = $this->get_approved_event_donation($event_id);
			if( !empty( $posts->posts ) ) {
				foreach ( $posts->posts as $post ) {
					$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
					$raised += intval( $donate );
				}
				$count_dornors = count( $posts->posts );
			}
			
			update_post_meta($event_id, 'slz-donation-raised-money', $raised);
			update_post_meta($event_id, 'slz-donation-dornors-number', $count_dornors);
			
			$res = array();
			$res['status'] = '<div class="donate-pending-status">'. esc_html__('Pending', 'slz') .'</div>';
			$res['btn'] = '<input type="button" data-post-id="'. esc_attr( $post_id ) .'" class="slz-btn-donation-admin slz-ed-approve-btn" value="&#8901;&#8901;&#8901;" title="'. esc_html__( 'Approve', 'slz' ) .'" >';
			$res = json_encode( $res );
			echo ( $res );
		}
		die;
	}

	public function get_approved_event_donation( $event_id ) {
		$args = array(
			'post_type'       => $this->post_type_ed_name,
			'posts_per_page'  => -1,
			'meta_query' => array(
				array(
					'key'     => 'slz_option:event',
					'value'   => $event_id
				),
				array(
					'key'     => 'slz_option:status',
					'value'   => 'approve'
				)
			)
		);
		$posts = new WP_Query( $args );
		
		return $posts;
	}

	public function get_event_donation( $event_id ) {
        $args = array(
            'post_type'       => $this->post_type_ed_name,
            'posts_per_page'  => -1,
            'meta_query' => array(
                array(
                    'key'     => 'slz_option:event',
                    'value'   => $event_id
                )
            )
        );
        $posts = new WP_Query( $args );

        return $posts;
    }

    public function get_event_donation_trashed( $event_id ) {
        $args = array(
            'post_type'       => $this->post_type_ed_name,
            'posts_per_page'  => -1,
            'post_status' => 'trash',
            'meta_query' => array(
                array(
                    'key'     => 'slz_option:event',
                    'value'   => $event_id
                )
            )
        );
        $posts = new WP_Query( $args );

        return $posts;
    }

    public function update_event_donation_meta( $event_id ) {
		$raised = 0;
		$count_dornors = 0;
        $posts = $this->get_approved_event_donation($event_id);

		if( !empty( $posts->posts ) ) {
			foreach ( $posts->posts as $post ) {
				$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
				$raised += intval( $donate );
			}
			$count_dornors = count( $posts->posts );
		}
		
		update_post_meta($event_id, 'slz-donation-raised-money', $raised);
		update_post_meta($event_id, 'slz-donation-dornors-number', $count_dornors);
    }

	// ajax donate event in single event
	public function ajax_donate_event() {
		if( !empty( $_POST['params'][0] ) ) {
			$res = array();
			$res['status'] = 'fail';
			global $woocommerce;
			
			$money_donate = $_POST['params'][0]['money'];
			$post_id = $_POST['params'][0]['post_id'];

			$prefix = 'event';
			$event_slug = '';
			$event_title = get_the_title( $post_id ) . esc_html__( ' ( Donation )', 'slz' );
			$posts = get_post( $post_id );
			if( $posts ) {
				$event_slug = $posts->post_name . '-donation';
			}

			$product_id = $this->get_post_name2id( $event_slug , 'product');

			if (!isset($product_id) || empty($product_id)) {
				$product_cat = esc_html__( 'Events', 'slz' );
				$product_id = $this->create_woocommerce_product( $prefix, $event_title, $event_slug, $product_cat );
			}

			$variation_args = array(
				'post_type'   => 'product_variation',
				'post_parent' => $product_id,
				'post_name'   => $event_slug
			);
			$variation_obj  = get_posts($variation_args);
			if( !empty( $variation_obj ) ){
				$variation_id   = $variation_obj[0]->ID;
			}

			if (!isset($variation_id) || empty($variation_id)) {
				$variation_id = $this->create_woocommerce_product_variation( $prefix, $product_id, $event_title, $event_slug, $post_id );
			}

			if ($product_id > 0 && $variation_id > 0) {
				$cart_item_key = $woocommerce->cart->add_to_cart( $product_id, 1, $variation_id, null, null);
				if (!is_user_logged_in()) {
					$woocommerce->session->set_customer_session_cookie(true);
				}
				$woocommerce->session->set( 'slz_events_session_key_' . $cart_item_key,
											array(
												'type'  => 'event_donate',
												'donate_money' => $money_donate,
												'post_id' => $post_id,
											));
				// set products is donation
				update_post_meta( $product_id, 'slz-is-donation-product', true );
			}
			$res['status'] = 'success';
			$res['url'] = esc_url( home_url().'/cart' );
			$res = json_encode( $res );
			echo ( $res );
		}
		die;
	}

	// ajax search in archive event
	public function ajax_archive_search(){
	    if( empty( $_POST['params'] ) ) {
	        die;
        }
        $path = $this->locate_view_path( 'ajax-event-list' );
        if ( ! empty( $path ) ) {
            $params = $_POST['params'];
            echo slz_render_view( $path, compact('params') );
        }
	}
}
