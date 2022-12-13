<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Extension_Recruitment extends SLZ_Extension {
	private $post_type_name = 'slz-recruitment';
	private $post_type_slug = 'recruitment';
	private $taxonomy_name = 'slz-recruitment-cat';
	private $taxonomy_slug = 'recruitment-cat';

	private $taxonomy_type_name = 'slz-recruitment-type';
	private $taxonomy_type_slug = 'recruitment-type';

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
	public function get_taxonomy_link( $taxonomy ) {
		return admin_url( 'edit-tags.php?taxonomy=' . $taxonomy . '&post_type=' . $this->post_type_name );
	}
	
	/*public function get_image_sizes() {
		return $this->get_config( 'image_sizes' );
	}*/

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
				'slz_ext_recruitments_recruitment_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_post_slug', $this->post_type_slug )
			)
		);
		$this->set_db_data(
			'permalinks/taxonomy',
			SLZ_Request::POST(
				'slz_ext_recruitments_taxonomy_slug',
				apply_filters( 'slz_ext_' . $this->get_name() . '_taxonomy_slug', $this->taxonomy_slug )
			)
		);
	}

	/**
	 * @internal
	 **/
	public function _action_add_permalink_in_settings() {
		add_settings_field(
			'slz_ext_recruitments_recruitment_slug',
			esc_html__( 'Recruitment base', 'slz' ),
			array( $this, '_recruitment_slug_input' ),
			'permalink',
			'optional'
		);

		add_settings_field(
			'slz_ext_recruitments_taxonomy_slug',
			esc_html__( 'Recruitment category base', 'slz' ),
			array( $this, '_taxonomy_slug_input' ),
			'permalink',
			'optional'
		);
	}

	/**
	 * @internal
	 */
	public function _recruitment_slug_input() {
		?>
		<input type="text" name="slz_ext_recruitments_recruitment_slug" value="<?php echo $this->post_type_slug; ?>">
		<code>/my-recruitment</code>
		<?php
	}

	/**
	 * @internal
	 */
	public function _taxonomy_slug_input() {
		?>
		<input type="text" name="slz_ext_recruitments_taxonomy_slug" value="<?php echo $this->taxonomy_slug; ?>">
		<code>/my-recruitments-category</code>
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
				'singular' => esc_html__( 'Recruitment', 'slz' ),
				'plural'   => esc_html__( 'Recruitment', 'slz' )
			) );

		register_post_type( $this->post_type_name,
			array(
				'labels'             => array(
					'name'               => esc_html__( 'Recruitment', 'slz' ),
					'singular_name'      => esc_html__( 'Recruitment', 'slz' ),
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
				'description'        => esc_html__( 'Create a recruitment item', 'slz' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->post_type_slug
				),
				//'menu_position'      => 22,
				'show_in_nav_menus'  => true,
				'menu_icon'          => 'dashicons-megaphone',
				'hierarchical'       => false,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail'
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
				'name'              => sprintf( _x( 'Recruitment %s', 'taxonomy general name', 'slz' ),
					$category_names['plural'] ),
				'singular_name'     => sprintf( _x( 'Recruitment %s', 'taxonomy singular name', 'slz' ),
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

		$type_names = apply_filters( 'slz_ext_recruitment_name', array(
				'singular' => __( 'Working Type', 'slz' ),
				'plural'   => __( 'Working Types', 'slz' )
		) );

		register_taxonomy( $this->taxonomy_type_name, $this->post_type_name, array(
			'labels'            => array(
				'name'              => sprintf( _x( 'Working Types', 'taxonomy general name', 'slz' )),
				'singular_name'     => sprintf( _x( 'Working Type', 'taxonomy singular name', 'slz' )),
				'search_items'      => sprintf( esc_html__( 'Search %s', 'slz' ), $type_names['plural'] ),
				'all_items'         => sprintf( esc_html__( 'All %s', 'slz' ), $type_names['plural'] ),
				'parent_item'       => sprintf( esc_html__( 'Parent %s', 'slz' ), $type_names['singular'] ),
				'parent_item_colon' => sprintf( esc_html__( 'Parent %s:', 'slz' ), $type_names['singular'] ),
				'edit_item'         => sprintf( esc_html__( 'Edit %s', 'slz' ), $type_names['singular'] ),
				'update_item'       => sprintf( esc_html__( 'Update %s', 'slz' ), $type_names['singular'] ),
				'add_new_item'      => sprintf( esc_html__( 'Add New %s', 'slz' ), $type_names['singular'] ),
				'new_item_name'     => sprintf( esc_html__( 'New %s Name', 'slz' ), $type_names['singular'] ),
				'menu_name'         => sprintf( esc_html__( '%s', 'slz' ), $type_names['plural'] )
			),
			'public' => false,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite'           => array(
				'slug' => $this->taxonomy_type_slug
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
	 * Modifies table structure for 'All Recruitment' admin page
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function _filter_add_columns( $columns ) {
		unset( $columns[ 'taxonomy-' . $this->taxonomy_name ] );

		return array_merge( array(
				'cb'                                => '',
				'thumbnail'                         => esc_html__( 'Thumbnail', 'slz' ),
				'title'                             => esc_html__( 'Title', 'slz' ),
				'taxonomy-' . $this->taxonomy_name  => esc_html__( 'Categories', 'slz' ),
				'date'                              => esc_html__( 'Date', 'slz' )
			), $columns );
	}

	/**
	 * Adds recruitment options for it's custom post type
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

		$recruitment_options = apply_filters( 'slz_ext_recruitments_post_options',
			$this->_add_post_options() );

		if (empty($recruitment_options)) {
			return $post_options;
		}

		if ( isset( $post_options['man'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['recruitment_box']['options'][] = $recruitment_options;
		} else {
			$post_options['recruitment_box'] = array(
				'title'   => esc_html__('Recruitment Options', 'slz'),
				'desc'    => 'false',
				'type'    => 'box',
				'options' => $recruitment_options
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
	 * Enqueue backend scripts on recruitments pages
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

		$types = array_merge( array( '' => esc_html__('-- Select Working Type --', 'slz') ),
					SLZ_Com::get_hierarchical_term2name( array('taxonomy' => $this->taxonomy_type_name) ) );

		$new_type_plink = '<a href="'.$this->get_taxonomy_link($this->taxonomy_type_name).'" target="_blank">'.esc_html__('Add New Working Type', 'slz').'</a>';

		$options = array(
			'general_tab' => array(
				'title'   => esc_html__( 'General', 'slz' ),
				'type'    => 'tab',
				'options' => array(
					'img' => array(
						'type'  => 'upload',
						'value' => '',
						'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
						'label' => esc_html__('Thumbnail', 'slz'),
						'help'  => esc_html__('Choose a thumbnail for recruitment(use for some shortcode). Images should have minimum size: 350x350. Bigger size images will be cropped automatically.', 'slz'),
						'images_only' => true,
					),
					'recruit_type' => array(
						'type'  => 'select',
						'value' => '',
						'label' => esc_html__('Working Type', 'slz'),
						'help'  => esc_html__('Choose working type.', 'slz'),
						'choices' => $types,
						'desc'  => $new_type_plink
					),
					'salary' => array(
						'type'  => 'text',
						'value' => '',
						'label' => esc_html__( 'Salary', 'slz'),
						'help'  => esc_html__( 'Salary for the recruitment.', 'slz'),
 						'desc'   => esc_html__('Example: 500$ - 1000$.', 'slz')
					),
					'location' => array(
						'type'  => 'text',
						'value' => '',
						'label' => esc_html__('Location', 'slz'),
						'help'  => esc_html__('Enter the working location of the recruitment.', 'slz'),
 						'desc'   => esc_html__('Example: NewYork.', 'slz')
					),
					'expired_date'         => array(
						'type'            => 'datetime-picker',
						'value'           => '',
						'label'           => esc_html__( 'Expired Date', 'slz' ),
						'help'            => esc_html__( 'Expired date of the recruitment.', 'slz'),
						'desc'            => esc_html__( 'Format: MM-DD-YYYY.', 'slz' ),
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
					'more_info' => array(
						'type'		  => 'addable-popup',
						'label'		 => esc_html__( 'Add Information', 'seogrow' ),
						'template'	  => '{{=info_name}}',
						'help'            => esc_html__( 'add more information recruitment.', 'slz'),
						'popup-options' => array(
							'info_name' => array(
								'label' => esc_html__( 'Label', 'seogrow' ),
								'desc'  => esc_html__( 'Enter a label for this information', 'seogrow' ),
								'type'  => 'text',
							),
							'info_value' => array(
								'label' => esc_html__( 'Information', 'seogrow' ),
								'desc'  => esc_html__( 'Enter information', 'seogrow' ),
								'type'  => 'text',
							)
						),
					),
				)
			),
			
		);
		return $options;
	}

	/* Ajax load recruitment list content */
	public function ajax_load_recruitment_list_content(){
		$data = $_POST['params'];
		$model = new SLZ_Recruitment();
		$model->init( $data );
		$uniq_id = $model->attributes['uniq_id'];
		$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
		if( ! $model->query->have_posts() ) {
		    die();
		}
		$count = 0;
		
		$html_render['recruit_type_format'] ='<li class="time"><i class="fa fa-hourglass"></i>%1$s</li>';
		$html_options = $model->set_default_options($html_render);
		
        while ( $model->query->have_posts() ) {
        	$model->html_format = $model->set_default_options( $html_options );
            $model->query->the_post();
            $model->loop_index();
            $count++;
            if($count == 1){
            	continue;
            }

            $tab_id = 'tab-recruitment-'.get_the_ID();
    	?>
            <div id="<?php echo esc_attr($tab_id); ?>" role="tabpanel" class="tab-pane fade">
                <div class="slz-block-item-01 style-1">
                    <?php
                        if ( $model->has_thumbnail ){
                            echo ($model->get_featured_image($html_options));
                        }
                    ?>
                    <div class="block-content">
                        <div class="block-content-wrapper">
                            <?php $model->get_title( $html_options, true ); ?>
                            <ul class="block-info-cv">
                            	<?php echo $model->get_recruit_type();?>
                                <?php echo $model->get_expired_date();?>
                                <?php echo $model->get_salary();?>
                                <?php echo $model->get_location();?>
                            </ul>
                            <div class="block-text">
                                <?php echo ($model->get_description()); ?>
                            </div>
                            <?php echo ($model->get_apply_button()); ?>
                        </div>
                    </div>
                </div>
            </div>
    	<?php
        }//end while
        $model->reset();
		die();
	}

	/* Ajax load recruitment tab content */
	public function ajax_load_recruitment_tab_content(){
		$atts = $_POST['params']['atts'];
		$cats =  $_POST['params']['cats'];
		$output_grid = '';
		$html_format = '<div class="slz-template-01">
                    <div class="slz-recent-post">
                        <div class="media">
                            <div class="media-left">
                                %1$s
                                %3$s
                            </div>
                            <div class="media-right">
                                %2$s 
                                <ul class="block-info">
                                    %4$s
                                    %5$s
                                    %8$s
                                </ul>
                                <div class="description">%6$s</div>
                                %7$s
                            </div>
                        </div>
                    </div>    
                </div>';

		$html_render['image_format'] = '<a href="%2$s" class="wrapper-image">%1$s</a>';
		$html_render['html_format'] = $html_format;
		
		foreach ($cats as $cat) {
			$atts['category_slug'] = $cat['cat'];
			$model = new SLZ_Recruitment();
			$model->init( $atts );
			$html_options = $model->set_default_options($html_render);
			$grid = $model->render_recruiment_tab( '',$html_options );
			$output_grid .= sprintf('<div id="tab-%2$s" class="tab-pane fade" role="tabpanel"><div class=" cv-content">%1$s</div></div>',
					$grid,
					$cat['id']
			);
		}
		print_r($output_grid);
		die();
	}
}
