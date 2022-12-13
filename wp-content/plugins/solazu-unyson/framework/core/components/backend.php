<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Backend functionality
 */
final class _SLZ_Component_Backend {

	/** @var callable */
	private $print_meta_box_content_callback;

	/** @var SLZ_Form */
	private $settings_form;

	private $available_render_designs = array( 'default', 'taxonomy', 'customizer' );

	private $default_render_design = 'default';

	/**
	 * Store option types for registration, until they will be required
	 * @var array|false
	 *      array Can have some pending option types in it
	 *      false Option types already requested and was registered, so do not use pending anymore
	 */
	private $option_types_pending_registration = array();

	/**
	 * Contains all option types
	 * @var SLZ_Option_Type[]
	 */
	private $option_types = array();

	/**
	 * @var SLZ_Option_Type_Undefined
	 */
	private $undefined_option_type;

	/**
	 * Store container types for registration, until they will be required
	 * @var array|false
	 *      array Can have some pending container types in it
	 *      false Container types already requested and was registered, so do not use pending anymore
	 */
	private $container_types_pending_registration = array();

	/**
	 * Contains all container types
	 * @var SLZ_Container_Type[]
	 */
	private $container_types = array();

	/**
	 * @var SLZ_Container_Type_Undefined
	 */
	private $undefined_container_type;

	private $static_registered = false;

	/**
	 * @var SLZ_Access_Key
	 */
	private $access_key;

	/**
	 * @internal
	 */
	public function _get_settings_page_slug() {
		return 'slz-settings';
	}

	/**
	 * @return string
	 * @since 2.6.3
	 */
	public function get_options_name_attr_prefix() {
		return 'slz_options';
	}

	/**
	 * @return string
	 * @since 2.6.3
	 */
	public function get_options_id_attr_prefix() {
		return 'slz-option-';
	}

	private function get_current_edit_taxonomy() {
		static $cache_current_taxonomy_data = null;

		if ( $cache_current_taxonomy_data !== null ) {
			return $cache_current_taxonomy_data;
		}

		$result = array(
			'taxonomy' => null,
			'term_id'  => 0,
		);

		do {
			if ( ! is_admin() ) {
				break;
			}

			// code from /wp-admin/admin.php line 110
			{
				if ( isset( $_REQUEST['taxonomy'] ) && taxonomy_exists( $_REQUEST['taxonomy'] ) ) {
					$taxnow = $_REQUEST['taxonomy'];
				} else {
					$taxnow = '';
				}
			}

			if ( empty( $taxnow ) ) {
				break;
			}

			$result['taxonomy'] = $taxnow;

			if ( empty( $_REQUEST['tag_ID'] ) ) {
				return $result;
			}

			// code from /wp-admin/edit-tags.php
			{
				$tag_ID = (int) $_REQUEST['tag_ID'];
			}

			$result['term_id'] = $tag_ID;
		} while ( false );

		$cache_current_taxonomy_data = $result;

		return $cache_current_taxonomy_data;
	}

	public function __construct() {
		$this->print_meta_box_content_callback = create_function( '$post,$args', 'echo $args["args"];' );
	}

	/**
	 * @internal
	 */
	public function _init() {
		if ( is_admin() ) {
			$this->settings_form = new SLZ_Form('slz_settings', array(
				'render' => array($this, '_settings_form_render'),
				'validate' => array($this, '_settings_form_validate'),
				'save' => array($this, '_settings_form_save'),
			));
		}

		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * @internal
	 */
	public function _after_components_init() {}

	private function get_access_key()
	{
		if (!$this->access_key) {
			$this->access_key = new SLZ_Access_Key('slz_backend');
		}

		return $this->access_key;
	}

	private function add_actions() {
		if ( is_admin() ) {
			add_action('admin_menu', array($this, '_action_admin_menu'));
			add_action('add_meta_boxes', array($this, '_action_create_post_meta_boxes'), 10, 2);
			add_action('init', array($this, '_action_init'), 20);
			add_action('admin_enqueue_scripts', array($this, '_action_admin_register_scripts'),
				/**
				 * Usually when someone register/enqueue a script/style to be used in other places
				 * in 'admin_enqueue_scripts' actions with default (not set) priority 10, they use priority 9.
				 * Use here priority 8, in case those scripts/styles used in actions with priority 9
				 * are using scripts/styles registered here
				 */
				8
			);
			add_action('admin_enqueue_scripts', array($this, '_action_admin_enqueue_scripts'),
				/**
				 * In case some custom defined option types are using script/styles registered
				 * in actions with default priority 10 (make sure the enqueue is executed after register)
				 */
				11
			);

			// render and submit options from javascript
			{
				add_action('wp_ajax_slz_backend_options_render', array($this, '_action_ajax_options_render'));
				add_action('wp_ajax_slz_backend_options_get_values', array($this, '_action_ajax_options_get_values'));
			}
		}

		add_action('save_post', array($this, '_action_save_post'), 7, 3);
		add_action('wp_restore_post_revision', array($this, '_action_restore_post_revision'), 10, 2);
		add_action('_wp_put_post_revision', array($this, '_action__wp_put_post_revision'));

		add_action('customize_register', array($this, '_action_customize_register'), 7);

		add_action('slz_add_inline_style', array($this, '_action_add_inline_style'));

		add_action( 'wp_enqueue_scripts', array($this, '_action_enqueue_scripts') );

		add_action( 'init', array( $this, '_action_add_new_image_size' ) );

		add_action( 'slz_init_theme_option_data', array( $this, '_action_init_theme_option_data' ) );

	}

	public function _action_add_inline_style( $custom_css )
	{
		wp_enqueue_style('slz-custom-css', slz_get_framework_directory_uri( '/static/css/custom.css' ));
		wp_add_inline_style( 'slz-custom-css', $custom_css );
	}

	public function _action_add_new_image_size(){

		$image_sizes = slz()->manifest->get('register_image_sizes');

		if ( !empty( $image_sizes ) ) {

			foreach($image_sizes as $key => $sizes ) {
				$crop = true;
				if( isset( $sizes['crop'] ) ) {
					$crop = $sizes['crop'];
				}
				add_image_size( $key, $sizes['width'], $sizes['height'], $crop );
			}

		}
		
	}

	public function _action_init_theme_option_data(){

		$current_option = SLZ_WP_Option::get( 'slz_theme_settings_options:'. slz()->theme->manifest->get_id() );

		if ( $current_option == '' || $current_option == array() ) {

			slz_set_db_settings_option(null, slz_get_db_settings_option());

		}

		if ( file_exists( slz_get_template_customizations_directory( '/theme/views/article.php' ) ) ) {

			// $content = slz_get_variables_from_file(slz_get_template_customizations_directory( '/theme/views/article.php' ), array( 'content' => null ) );

			// if ( !empty ( $content['content'] ) ){

			// 	slz_set_db_settings_option('article-layout', $content['content']);

			// 	$hashtag_system = new SLZ_Hash_Tag_Compiler();

			// 	$hashtag_system->compiler(slz_get_db_settings_option('article-layout', ''));
			// }
			
		}

	}

	private function add_filters() {
		if ( is_admin() ) {
			add_filter('admin_footer_text', array($this, '_filter_admin_footer_text'), 11);
			add_filter('update_footer', array($this, '_filter_footer_version'), 11);
		}
	}

	/**
	 * @param string|SLZ_Option_Type $option_type_class
	 *
	 * @internal
	 */
	private function register_option_type( $option_type_class ) {
		if ( is_array( $this->option_types_pending_registration ) ) {
			// Option types never requested. Continue adding to pending
			$this->option_types_pending_registration[] = $option_type_class;
		} else {
			if ( is_string( $option_type_class ) ) {
				$option_type_class = new $option_type_class;
			}

			if ( ! is_subclass_of( $option_type_class, 'SLZ_Option_Type' ) ) {
				trigger_error( 'Invalid option type class ' . get_class( $option_type_class ), E_USER_WARNING );
				return;
			}

			/**
			 * @var SLZ_Option_Type $option_type_class
			 */

			$type = $option_type_class->get_type();

			if ( isset( $this->option_types[ $type ] ) ) {
				trigger_error( 'Option type "' . $type . '" already registered', E_USER_WARNING );
				return;
			}

			$this->option_types[ $type ] = $option_type_class;

			$this->option_types[ $type ]->_call_init($this->get_access_key());
		}
	}

	/**
	 * @param string|SLZ_Container_Type $container_type_class
	 *
	 * @internal
	 */
	private function register_container_type( $container_type_class ) {
		if ( is_array( $this->container_types_pending_registration ) ) {
			// Container types never requested. Continue adding to pending
			$this->container_types_pending_registration[] = $container_type_class;
		} else {
			if ( is_string( $container_type_class ) ) {
				$container_type_class = new $container_type_class;
			}

			if ( ! is_subclass_of( $container_type_class, 'SLZ_Container_Type' ) ) {
				trigger_error( 'Invalid container type class ' . get_class( $container_type_class ), E_USER_WARNING );
				return;
			}

			/**
			 * @var SLZ_Container_Type $container_type_class
			 */

			$type = $container_type_class->get_type();

			if ( isset( $this->container_types[ $type ] ) ) {
				trigger_error( 'Container type "' . $type . '" already registered', E_USER_WARNING );
				return;
			}

			$this->container_types[ $type ] = $container_type_class;

			$this->container_types[ $type ]->_call_init($this->get_access_key());
		}
	}

	private function register_static() {
		if (
			!doing_action('admin_enqueue_scripts')
			&&
			!did_action('admin_enqueue_scripts')
		) {
			/**
			 * Do not wp_enqueue/register_...() because at this point not all handles has been registered
			 * and maybe they are used in dependencies in handles that are going to be enqueued.
			 * So as a result some handles will not be equeued because of not registered dependecies.
			 */
			return;
		}

		if ( $this->static_registered ) {
			return;
		}

		/**
		 * Register styles/scripts only in admin area, on frontend it's not allowed to use styles/scripts from framework backend core
		 * because they are meant to be used only in backend and can be changed in the future.
		 * If you want to use a style/script from framework backend core, copy it to your theme and enqueue as a theme style/script.
		 */
		if ( ! is_admin() ) {
			$this->static_registered = true;

			return;
		}
		wp_enqueue_style('slz-slz-backend', slz_get_framework_directory_uri( '/static/css/slz-backend.css' ));

		wp_register_script(
			'slz-events',
			slz_get_framework_directory_uri( '/static/js/slz-events.js' ),
			array( 'backbone' ),
			slz()->manifest->get_version(),
			true
		);
		wp_register_script(
			'slz-ie-fixes',
			slz_get_framework_directory_uri( '/static/js/ie-fixes.js' ),
			array(),
			slz()->manifest->get_version(),
			true
		);

		{
			wp_register_style(
				'qtip',
				slz_get_framework_directory_uri( '/static/libs/qtip/css/jquery.qtip.min.css' ),
				array(),
				slz()->manifest->get_version()
			);
			wp_register_script(
				'qtip',
				slz_get_framework_directory_uri( '/static/libs/qtip/jquery.qtip.min.js' ),
				array( 'jquery' ),
				slz()->manifest->get_version()
			);
		}

		/**
		 * Important!
		 * Call wp_enqueue_media() before wp_enqueue_script('slz') (or using 'slz' in your script dependencies)
		 * otherwise slz.OptionsModal won't work
		 */
		{
			wp_register_style(
				'slz',
				slz_get_framework_directory_uri( '/static/css/slz.css' ),
				array( 'qtip' ),
				slz()->manifest->get_version()
			);

			wp_register_script(
				'slz',
				slz_get_framework_directory_uri( '/static/js/slz.js' ),
				array( 'jquery', 'slz-events', 'backbone', 'qtip' ),
				slz()->manifest->get_version(),
				true // false fixes https://github.com/ThemeFuse/Unyson/issues/1625#issuecomment-224219454
			);

			wp_localize_script( 'slz', '_slz_localized', array(
				'SLZ_URI'     => slz_get_framework_directory_uri(),
				'SITE_URI'   => site_url(),
				'LOADER_URI' => apply_filters( 'slz_loader_image', slz_get_framework_directory_uri() . '/static/img/logo.svg' ),
				'l10n'       => array(
					'done'     => __( 'Done', 'slz' ),
					'ah_sorry' => __( 'Ah, Sorry', 'slz' ),
					'save'     => __( 'Save', 'slz' ),
					'reset'    => __( 'Reset', 'slz' ),
					'apply'    => __( 'Apply', 'slz' ),
					'cancel'   => __( 'Cancel', 'slz' ),
					'ok'       => __( 'Ok', 'slz' )
				),
			) );
		}

		{
			wp_register_style(
				'slz-backend-options',
				slz_get_framework_directory_uri( '/static/css/backend-options.css' ),
				array( 'slz' ),
				slz()->manifest->get_version()
			);

			wp_register_script(
				'slz-backend-options',
				slz_get_framework_directory_uri( '/static/js/backend-options.js' ),
				array( 'slz', 'slz-events', 'postbox', 'jquery-ui-tabs' ),
				slz()->manifest->get_version(),
				true
			);
			
			wp_localize_script( 'slz', '_slz_backend_options_localized', array(
				'lazy_tabs' => slz()->theme->get_config('lazy_tabs')
			) );
		}

		{

			wp_enqueue_style(
				'slz-datetimepicker',
				slz_get_framework_directory_uri('/static/libs/datetimepicker/jquery.datetimepicker.css'),
				array(),
				slz()->manifest->get_version()
			);

			wp_enqueue_script(
				'slz-datetimepicker',
				slz_get_framework_directory_uri( '/static/libs/datetimepicker/jquery.datetimepicker.min.js' ),
				array(),
				slz()->manifest->get_version(),
				true
			);

		}

		{
			wp_register_style(
				'slz-selectize',
				slz_get_framework_directory_uri( '/static/libs/selectize/selectize.css' ),
				array(),
				slz()->manifest->get_version()
			);
			wp_register_script(
				'slz-selectize',
				slz_get_framework_directory_uri( '/static/libs/selectize/selectize.min.js' ),
				array( 'jquery', 'slz-ie-fixes' ),
				slz()->manifest->get_version(),
				true
			);
		}

		{
			wp_register_script(
				'slz-mousewheel',
				slz_get_framework_directory_uri( '/static/libs/mousewheel/jquery.mousewheel.min.js' ),
				array( 'jquery' ),
				slz()->manifest->get_version(),
				true
			);
		}

		{
			wp_register_style(
				'slz-jscrollpane',
				slz_get_framework_directory_uri( '/static/libs/jscrollpane/jquery.jscrollpane.css' ),
				array(),
				slz()->manifest->get_version()
			);
			wp_register_script( 'slz-jscrollpane',
				slz_get_framework_directory_uri( '/static/libs/jscrollpane/jquery.jscrollpane.min.js' ),
				array( 'jquery', 'slz-mousewheel' ),
				slz()->manifest->get_version(),
				true
			);
		}

		wp_register_style(
			'slz-font-awesome',
			slz_get_framework_directory_uri( '/static/libs/font-awesome/css/font-awesome.min.css' ),
			array(),
			slz()->manifest->get_version()
		);

		wp_register_script(
			'backbone-relational',
			slz_get_framework_directory_uri( '/static/libs/backbone-relational/backbone-relational.js' ),
			array( 'backbone' ),
			slz()->manifest->get_version(),
			true
		);

		wp_register_script(
			'slz-uri',
			slz_get_framework_directory_uri( '/static/libs/uri/URI.js' ),
			array(),
			slz()->manifest->get_version(),
			true
		);

		wp_register_script(
			'slz-moment',
			/**
			 * IMPORTANT: At the end of the script is added this line:
			 * moment.locale(document.documentElement.lang.slice(0, 2)); // fixes https://github.com/ThemeFuse/Unyson/issues/1767
			 */
			slz_get_framework_directory_uri( '/static/libs/moment/moment-with-locales.min.js' ),
			array(),
			slz()->manifest->get_version(),
			true
		);

		wp_register_script(
			'slz-form-helpers',
			slz_get_framework_directory_uri( '/static/js/slz-form-helpers.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
		);

		wp_register_style(
			'slz-unycon',
			slz_get_framework_directory_uri( '/static/libs/unycon/unycon.css' ),
			array(),
			slz()->manifest->get_version()
		);

		$this->static_registered = true;
	}

	/**
	 * @internal
	 */
	public function _action_admin_menu() {
		$data = array(
			'capability'       => 'manage_options',
			'slug'             => $this->_get_settings_page_slug(),
			'content_callback' => array( $this, '_print_settings_page' ),
		);

		if ( ! current_user_can( $data['capability'] ) ) {
			return;
		}

		if ( ! slz()->theme->locate_path('/options/settings.php') ) {
			return;
		}

		/**
		 * Collect $hookname that contains $data['slug'] before the action
		 * and skip them in verification after action
		 */
		{
			global $_registered_pages;

			$found_hooknames = array();

			if ( ! empty( $_registered_pages ) ) {
				foreach ( $_registered_pages as $hookname => $b ) {
					if ( strpos( $hookname, $data['slug'] ) !== false ) {
						$found_hooknames[ $hookname ] = true;
					}
				}
			}
		}

		/**
		 * Use this action if you what to add the settings page in a custom place in menu
		 * Usage example http://pastebin.com/gvAjGRm1
		 */
		do_action( 'slz_backend_add_custom_settings_menu', $data );

		/**
		 * Check if settings menu was added in the action above
		 */
		{
			$menu_exists = false;

			if ( ! empty( $_registered_pages ) ) {
				foreach ( $_registered_pages as $hookname => $b ) {
					if ( isset( $found_hooknames[ $hookname ] ) ) {
						continue;
					}

					if ( strpos( $hookname, $data['slug'] ) !== false ) {
						$menu_exists = true;
						break;
					}
				}
			}
		}

		if ( $menu_exists ) {
			return;
		}

		add_submenu_page(
			slz()->theme->manifest->get('id'),
			__( 'Theme Settings', 'slz' ),
			__( 'Theme Settings', 'slz' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

		add_action( 'admin_menu', array( $this, '_action_admin_change_theme_settings_order' ), 9999 );
	}

	public function _filter_admin_footer_text( $html ) {
		if (
			(
				current_user_can( 'update_themes' )
				||
				current_user_can( 'update_plugins' )
			)
			&&
			slz_current_screen_match(array(
				'only' => array(
					array('parent_base' => slz()->extensions->manager->get_page_slug()) // Unyson Extensions page
				)
			))
		) {
			return ( empty( $html ) ? '' : $html . '<br/>' )
			. '<em>'
			. str_replace(
				array(
					'{wp_review_link}',
					'{facebook_share_link}',
					'{twitter_share_link}',
				),
				array(
					slz_html_tag('a', array(
						'target' => '_blank',
						'href'   => 'https://themeforest.net/user/swlabs',
					), __('leave a review', 'slz')),
					slz_html_tag('a', array(
						'target' => '_blank',
						'href'   => 'https://www.facebook.com/sharer/sharer.php?'. http_build_query(array(
							'u' => 'https://themeforest.net/user/swlabs',
						)),
						'onclick' => 'return !window.open(this.href, \'Facebook\', \'width=640,height=300\')',
					), __('Facebook', 'slz')),
					slz_html_tag('a', array(
						'target' => '_blank',
						'href'   => 'https://twitter.com/home?'. http_build_query(array(
							'status' => __('Unyson WordPress Framework is the fastest and easiest way to develop a premium theme. I highly recommend it', 'slz')
								.' https://themeforest.net/user/swlabs #SolazuUnysonWP',
						)),
						'onclick' => 'return !window.open(this.href, \'Twitter\', \'width=640,height=430\')',
					), __('Twitter', 'slz')),
				),
				__('If you like Solazu Unyson, {wp_review_link}, share on {facebook_share_link} or {twitter_share_link}.', 'slz')
			)
			. '</em>';
		} else {
			return $html;
		}
	}

	/**
	 * Print framework version in the admin footer
	 *
	 * @param string $html
	 *
	 * @return string
	 * @internal
	 */
	public function _filter_footer_version( $html ) {
		if ( current_user_can( 'update_themes' ) || current_user_can( 'update_plugins' ) ) {
			return ( empty( $html ) ? '' : $html . ' | ' ) . slz()->manifest->get_name() . ' ' . slz()->manifest->get_version();
		} else {
			return $html;
		}
	}

	public function _action_admin_change_theme_settings_order() {
		global $submenu;

		if ( ! isset( $submenu['themes.php'] ) ) {
			// probably current user doesn't have this item in menu
			return;
		}

		$id    = $this->_get_settings_page_slug();
		$index = null;

		foreach ( $submenu['themes.php'] as $key => $sm ) {
			if ( $sm[2] == $id ) {
				$index = $key;
				break;
			}
		}

		if ( ! empty( $index ) ) {
			$item = $submenu['themes.php'][ $index ];
			unset( $submenu['themes.php'][ $index ] );
			array_unshift( $submenu['themes.php'], $item );
		}
	}

	public function _print_settings_page() {
		echo '<div class="wrap">';

		if ( slz()->theme->get_config( 'settings_form_side_tabs' ) ) {
			// this is needed for flash messages (admin notices) to be displayed properly
			echo '<h2 class="slz-hidden"></h2>';
		} else {
			$title = __( 'Theme Settings', 'slz' );

			// Extract page title from menu title
			do {
				global $menu, $submenu;

				foreach ($menu as $_menu) {
					if ($_menu[2] === $this->_get_settings_page_slug()) {
						$title = $_menu[0];
						break 2;
					}
				}

				foreach ($submenu as $_menu) {
					foreach ($_menu as $_submenu) {
						if ($_submenu[2] === $this->_get_settings_page_slug()) {
							$title = $_submenu[0];
							break 3;
						}
					}
				}
			} while(false);

			echo '<h2>' . esc_html($title) . '</h2><br/>';
		}

		$this->settings_form->render();

		echo '</div>';
	}

	/**
	 * @param string $post_type
	 * @param WP_Post $post
	 */
	public function _action_create_post_meta_boxes( $post_type, $post ) {
		$options = slz()->theme->get_post_options( $post_type );

		if ( empty( $options ) ) {
			return;
		}

		$collected = array();

		slz_collect_options( $collected, $options, array(
			'limit_option_types' => false,
			'limit_container_types' => false,
			'limit_level' => 1,
		) );

		if (empty($collected)) {
			return;
		}

		$values = slz_get_db_post_option( $post->ID );

		foreach ( $collected as $id => &$option ) {
			if (
				isset($option['options']) // container
				&&
				$option['type'] === 'box'
			) { // this is a box, add it as a metabox
				$context  = isset( $option['context'] )
					? $option['context']
					: 'normal';
				$priority = isset( $option['priority'] )
					? $option['priority']
					: 'default';

				add_meta_box(
					'slz-options-box-' . $id,
					empty( $option['title'] ) ? ' ' : $option['title'],
					$this->print_meta_box_content_callback,
					$post_type,
					$context,
					$priority,
					$this->render_options( $option['options'], $values )
				);
			} else { // this is not a box, wrap it in auto-generated box
				add_meta_box(
					'slz-options-box:auto-generated:'. time() .':'. slz_unique_increment(),
					' ',
					$this->print_meta_box_content_callback,
					$post_type,
					'normal',
					'default',
					$this->render_options( array($id => $option), $values )
				);
			}
		}
	}

	/**
	 * @param object $term
	 */
	public function _action_create_taxonomy_options( $term ) {
		$options = slz()->theme->get_taxonomy_options( $term->taxonomy );

		if ( empty( $options ) ) {
			return;
		}

		$collected = array();

		slz_collect_options( $collected, $options, array(
			'limit_option_types' => false,
			'limit_container_types' => false,
			'limit_level' => 1,
		) );

		if ( empty( $collected ) ) {
			return;
		}

		$values = slz_get_db_term_option( $term->term_id, $term->taxonomy );

		// fixes word_press style: .form-field input { width: 95% }
		echo '<style type="text/css">.slz-option-type-radio input, .slz-option-type-checkbox input { width: auto; }</style>';

		echo $this->render_options( $collected, $values, array(), 'taxonomy' );
	}

	/**
	 * @param string $taxonomy
	 */
	public function _action_create_add_taxonomy_options( $taxonomy ) {
		$options = slz()->theme->get_taxonomy_options( $taxonomy );
		if ( empty( $options ) ) {
			return;
		}

		$collected = array();

		slz_collect_options( $collected, $options, array(
			'limit_option_types'    => false,
			'limit_container_types' => false,
			'limit_level'           => 1,
		) );

		if ( empty( $collected ) ) {
			return;
		}

		// fixes word_press style: .form-field input { width: 95% }
		echo '<style type="text/css">.slz-option-type-radio input, .slz-option-type-checkbox input { width: auto; }</style>';

		echo '<div class="slz-force-xs">';
		echo $this->render_options( $collected, array(), array(), 'taxonomy' );
		echo '</div>';

		echo '<script type="text/javascript">'
			.'jQuery(function($){'
			.'    $("#submit").on("click", function(){'
			.'        $("html, body").animate({ scrollTop: $("#col-left").offset().top });'
			.'    });'
			.'});'
			.'</script>';
	}

	public function _action_init() {
		$current_edit_taxonomy = $this->get_current_edit_taxonomy();

		if ( $current_edit_taxonomy['taxonomy'] ) {
			add_action(
				$current_edit_taxonomy['taxonomy'] . '_edit_form',
				array( $this, '_action_create_taxonomy_options' )
			);
			add_action(
				$current_edit_taxonomy['taxonomy'] . '_add_form_fields',
				array( $this, '_action_create_add_taxonomy_options' )
			);
		}

		if ( ! empty( $_POST ) ) {
			// is form submit
			add_action( 'edited_term', array( $this, '_action_term_edit' ), 10, 3 );

			if ($current_edit_taxonomy['taxonomy']) {
				add_action(
					'create_' . $current_edit_taxonomy['taxonomy'],
					array($this, '_action_save_taxonomy_fields')
				);
			}
		}
	}

	/**
	 * Save meta from $_POST to slz options (post meta)
	 * @param int $post_id
	 * @param WP_Post $post
	 * @param bool $update
	 */
	public function _action_save_post( $post_id, $post, $update ) {
		if (
			isset($_POST['post_ID'])
			&&
			intval($_POST['post_ID']) === intval($post_id)
			&&
			!empty($_POST[ $this->get_options_name_attr_prefix() ]) // this happens on Quick Edit
		) {
			/**
			 * This happens on regular post form submit
			 * All data from $_POST belongs this $post
			 * so we save them in its post meta
			 */

			static $post_options_save_happened = false;
			if ($post_options_save_happened) {
				/**
				 * Prevent multiple options save for same post
				 * It can happen from a recursion or wp_update_post() for same post id
				 */
				return;
			} else {
				$post_options_save_happened = true;
			}

			$old_values = (array)slz_get_db_post_option($post_id);

			slz_set_db_post_option(
				$post_id,
				null,
				slz_get_options_values_from_input(
					slz()->theme->get_post_options($post->post_type)
				)
			);

			/**
			 * @deprecated
			 * Use the 'slz_post_options_update' action
			 */
			do_action( 'slz_save_post_options', $post_id, $post, $old_values );
		} elseif ($original_post_id = wp_is_post_autosave( $post_id )) {
			do {
				$parent = get_post($post->post_parent);

				if ( ! $parent instanceof WP_Post ) {
					break;
				}

				if (
					isset($_POST['post_ID'])
					&&
					intval($_POST['post_ID']) === intval($parent->ID)
				) {} else {
					break;
				}

				if (empty($_POST[ $this->get_options_name_attr_prefix() ])) {
					// this happens on Quick Edit
					break;
				}

				slz_set_db_post_option(
					$post->ID,
					null,
					slz_get_options_values_from_input(
						slz()->theme->get_post_options($parent->post_type)
					)
				);
			} while(false);
		} elseif ($original_post_id = wp_is_post_revision( $post_id )) {
			/**
			 * Do nothing, the
			 * - '_wp_put_post_revision'
			 * - 'wp_restore_post_revision'
			 * actions will handle this
			 */
		}  else {
			/**
			 * This happens on:
			 * - post add (auto-draft): do nothing
			 * - revision restore: do nothing, that is handled by the 'wp_restore_post_revision' action
			 */
		}
	}

	/**
	 * @param $post_id
	 * @param $revision_id
	 */
	public function _action_restore_post_revision($post_id, $revision_id)
	{
		/**
		 * Copy options meta from revision to post
		 */
		slz_set_db_post_option(
			$post_id,
			null,
			(array)slz_get_db_post_option($revision_id, null, array())
		);
	}

	/**
	 * @param $revision_id
	 */
	public function _action__wp_put_post_revision($revision_id)
	{
		/**
		 * Copy options meta from post to revision
		 */
		slz_set_db_post_option(
			$revision_id,
			null,
			(array)slz_get_db_post_option(
				wp_is_post_revision($revision_id),
				null,
				array()
			)
		);
	}

	/**
	 * Update all post meta `slz_option:<option-id>` with values from post options that has the 'save-in-separate-meta' parameter
	 *
	 * @param int $post_id
	 *
	 * @return bool
	 * @deprecated since 2.5.0
	 */
	public function _sync_post_separate_meta( $post_id ) {
		$post_type = get_post_type( $post_id );

		if ( ! $post_type ) {
			return false;
		}

		$meta_prefix = 'slz_option:';

		/**
		 * Collect all options that needs to be saved in separate meta
		 */
		{
			$options_values = slz_get_db_post_option( $post_id );

			$separate_meta_options = array();

			foreach (
				slz_extract_only_options( slz()->theme->get_post_options( $post_type ) )
				as $option_id => $option
			) {
				if (
					isset( $option['save-in-separate-meta'] )
					&&
					$option['save-in-separate-meta']
					&&
					array_key_exists( $option_id, $options_values )
				) {
					$separate_meta_options[ $meta_prefix . $option_id ] = $options_values[ $option_id ];
				}
			}

			unset( $options_values );
		}

		/**
		 * Delete meta that starts with $meta_prefix
		 */
		{
			/** @var wpdb $wpdb */
			global $wpdb;

			foreach (
				$wpdb->get_results(
					$wpdb->prepare(
						"SELECT meta_key " .
						"FROM {$wpdb->postmeta} " .
						"WHERE meta_key LIKE %s AND post_id = %d",
						$wpdb->esc_like( $meta_prefix ) . '%',
						$post_id
					)
				)
				as $row
			) {
				if ( array_key_exists( $row->meta_key, $separate_meta_options ) ) {
					/**
					 * This meta exists and will be updated below.
					 * Do not delete for performance reasons, instead of delete->insert will be performed only update
					 */
					continue;
				} else {
					// this option does not exist anymore
					delete_post_meta( $post_id, $row->meta_key );
				}
			}
		}

		foreach ( $separate_meta_options as $meta_key => $option_value ) {
			slz_update_post_meta($post_id, $meta_key, $option_value );
		}

		return true;
	}

	/**
	 * @param int $term_id
	 */
	public function _action_save_taxonomy_fields( $term_id ) {
		if (
			isset( $_POST['action'] )
			&&
			'add-tag' === $_POST['action']
			&&
			isset( $_POST['taxonomy'] )
			&&
			($taxonomy = get_taxonomy( $_POST['taxonomy'] ))
			&&
			current_user_can($taxonomy->cap->edit_terms)
		) { /* ok */ } else { return; }

		$options = slz()->theme->get_taxonomy_options( $taxonomy->name );
		if ( empty( $options ) ) {
			return;
		}

		slz_set_db_term_option(
			$term_id,
			$taxonomy->name,
			null,
			slz_get_options_values_from_input($options)
		);

		do_action( 'slz_save_term_options', $term_id, $taxonomy->name, array() );
	}

	public function _action_term_edit( $term_id, $tt_id, $taxonomy ) {
		if (
			isset( $_POST['action'] )
			&&
			'editedtag' === $_POST['action']
			&&
			isset( $_POST['taxonomy'] )
			&&
			($taxonomy = get_taxonomy( $_POST['taxonomy'] ))
			&&
			current_user_can($taxonomy->cap->edit_terms)
		) { /* ok */ } else { return; }

		if (intval(SLZ_Request::POST('tag_ID')) != $term_id) {
			// the $_POST values belongs to another term, do not save them into this one
			return;
		}

		$options = slz()->theme->get_taxonomy_options( $taxonomy->name );
		if ( empty( $options ) ) {
			return;
		}

		$old_values = (array) slz_get_db_term_option( $term_id, $taxonomy->name );

		slz_set_db_term_option(
			$term_id,
			$taxonomy->name,
			null,
			slz_get_options_values_from_input($options)
		);

		do_action( 'slz_save_term_options', $term_id, $taxonomy->name, $old_values );
	}

	public function _action_admin_register_scripts() {
		$this->register_static();
	}

	public function _action_enqueue_scripts() {
		do_action( 'slz_front_enqueue_scripts:settings' );
	}

	public function _action_admin_enqueue_scripts() {
		global $current_screen, $plugin_page, $post;

		/**
		 * Enqueue settings options static in <head>
		 */
		{
			if ( $this->_get_settings_page_slug() === $plugin_page ) {
				slz()->backend->enqueue_options_static(
					slz()->theme->get_settings_options()
				);

				do_action( 'slz_admin_enqueue_scripts:settings' );
			}
		}

		/**
		 * Enqueue post options static in <head>
		 */
		{
			if ( 'post' === $current_screen->base && $post ) {
				slz()->backend->enqueue_options_static(
					slz()->theme->get_post_options( $post->post_type )
				);

				do_action( 'slz_admin_enqueue_scripts:post', $post );
			}
		}

		/**
		 * Enqueue term options static in <head>
		 */
		{
			if (
				'edit-tags' === $current_screen->base
				&&
				$current_screen->taxonomy
			) {
				slz()->backend->enqueue_options_static(
					slz()->theme->get_taxonomy_options( $current_screen->taxonomy )
				);

				do_action( 'slz_admin_enqueue_scripts:term', $current_screen->taxonomy );
			}
		}
	}

	/**
	 * Render options html from input json
	 *
	 * POST vars:
	 * - options: '[{option_id: {...}}, {option_id: {...}}, ...]'                  // Required // String JSON
	 * - values:  {option_id: value, option_id: {...}, ...}                        // Optional // Object
	 * - data:    {id_prefix: 'slz_options-a-b-', name_prefix: 'slz_options[a][b]'}  // Optional // Object
	 */
	public function _action_ajax_options_render() {
		// options
		{
			if ( ! isset( $_POST['options'] ) ) {
				wp_send_json_error( array(
					'message' => 'No options'
				) );
			}

			$options = json_decode( SLZ_Request::POST( 'options' ), true );

			if ( ! $options ) {
				wp_send_json_error( array(
					'message' => 'Wrong options'
				) );
			}
		}

		// values
		{
			if ( isset( $_POST['values'] ) ) {
				$values = SLZ_Request::POST( 'values' );

				if (is_string($values)) {
					$values = json_decode($values, true);
				}
			} else {
				$values = array();
			}

			$values = array_intersect_key($values, slz_extract_only_options($options));
		}

		// data
		{
			if ( isset( $_POST['data'] ) ) {
				$data = SLZ_Request::POST( 'data' );
			} else {
				$data = array();
			}
		}

		wp_send_json_success( array(
			'html' => slz()->backend->render_options( $options, $values, $data ),
			/** @since 2.6.1 */
			'default_values' => slz_get_options_values_from_input($options, array()),
		) );
	}

	/**
	 * Get options values from html generated with 'slz_backend_options_render' ajax action
	 *
	 * POST vars:
	 * - options: '[{option_id: {...}}, {option_id: {...}}, ...]' // Required // String JSON
	 * - slz_options... // Use a jQuery "ajax form submit" to emulate real form submit
	 *
	 * Tip: Inside form html, add: <input type="hidden" name="options" value="[...json...]">
	 */
	public function _action_ajax_options_get_values() {
		// options
		{
			if ( ! isset( $_POST['options'] ) ) {
				wp_send_json_error( array(
					'message' => 'No options'
				) );
			}

			$options = json_decode( SLZ_Request::POST( 'options' ), true );

			if ( ! $options ) {
				wp_send_json_error( array(
					'message' => 'Wrong options'
				) );
			}
		}

		// name_prefix
		{
			if ( isset( $_POST['name_prefix'] ) ) {
				$name_prefix = SLZ_Request::POST( 'name_prefix' );
			} else {
				$name_prefix = $this->get_options_name_attr_prefix();
			}
		}

		wp_send_json_success( array(
			'values' => slz_get_options_values_from_input(
				$options,
				SLZ_Request::POST( slz_html_attr_name_to_array_multi_key( $name_prefix ), array() )
			)
		) );
	}

	public function _settings_form_render( $data ) {
		{
			$this->enqueue_options_static( array() );

			wp_enqueue_script( 'slz-form-helpers' );
		}

		$options = slz()->theme->get_settings_options();

		if ( empty( $options ) ) {
			return $data;
		}

		if ( $values = SLZ_Request::POST( $this->get_options_name_attr_prefix() ) ) {
			// This is form submit, extract correct values from $_POST values
			$values = slz_get_options_values_from_input( $options, $values );
		} else {
			// Extract previously saved correct values
			$values = slz_get_db_settings_option();
		}

		$ajax_submit = slz()->theme->get_config( 'settings_form_ajax_submit' );
		$side_tabs   = slz()->theme->get_config( 'settings_form_side_tabs' );

		$data['attr']['class'] = 'slz-settings-form';

		if ( $side_tabs ) {
			$data['attr']['class'] .= ' slz-backend-side-tabs';
		}

		$data['submit']['html'] = '<!-- -->'; // is generated in view

		do_action( 'slz_settings_form_render', array(
			'ajax_submit' => $ajax_submit,
			'side_tabs'   => $side_tabs,
		) );

		slz_render_view( slz_get_framework_directory( '/views/backend-settings-form.php' ), array(
			'options'              => $options,
			'values'               => $values,
			'reset_input_name'     => '_slz_reset_options',
			'ajax_submit'          => $ajax_submit,
			'side_tabs'            => $side_tabs,
		), false );

		return $data;
	}

	public function _settings_form_validate( $errors ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			$errors['_no_permission'] = __( 'You have no permissions to change settings options', 'slz' );
		}

		return $errors;
	}

	public function _settings_form_save( $data ) {
		$flash_id   = 'slz_settings_form_save';
		$old_values = (array) slz_get_db_settings_option();

		if ( ! empty( $_POST['_slz_reset_options'] ) ) { // The "Reset" button was pressed
			slz_set_db_settings_option(
				null,
				/**
				 * Some values that don't relate to design, like API credentials, are useful to not be wiped out.
				 *
				 * Usage:
				 *
				 * add_filter('slz_settings_form_reset:values', '_filter_add_persisted_option', 10, 2);
				 * function _filter_add_persisted_option ($current_persisted, $old_values) {
				 *   $value_to_persist = slz_akg('my/multi/key', $old_values);
				 *   slz_aks('my/multi/key', $value_to_persist, $current_persisted);
				 *
				 *   return $current_persisted;
				 * }
				 */
				apply_filters('slz_settings_form_reset:values', array(), $old_values)
			);

			SLZ_Flash_Messages::add( $flash_id, __( 'The options were successfully reset', 'slz' ), 'success' );

			do_action('slz_init_theme_option_data');

			do_action( 'slz_settings_form_reset', $old_values );
		} else { // The "Save" button was pressed
			slz_set_db_settings_option(
				null,
				slz_get_options_values_from_input(
					slz()->theme->get_settings_options()
				)
			);

			SLZ_Flash_Messages::add( $flash_id, __( 'The options were successfully saved', 'slz' ), 'success' );

			do_action( 'slz_settings_form_saved', $old_values );
		}

		$redirect_url = slz_current_url();

		$data['redirect'] = $redirect_url;

		return $data;
	}

	/**
	 * Render options array and return the generated HTML
	 *
	 * @param array $options
	 * @param array $values Correct values returned by slz_get_options_values_from_input()
	 * @param array $options_data {id_prefix => ..., name_prefix => ...}
	 * @param string $design
	 *
	 * @return string HTML
	 */
	public function render_options( $options, $values = array(), $options_data = array(), $design = null ) {
		if (empty($design)) {
			$design = $this->default_render_design;
		}

		if (
			!doing_action('admin_enqueue_scripts')
			&&
			!did_action('admin_enqueue_scripts')
		) {
			/**
			 * Do not wp_enqueue/register_...() because at this point not all handles has been registered
			 * and maybe they are used in dependencies in handles that are going to be enqueued.
			 * So as a result some handles will not be equeued because of not registered dependecies.
			 */
		} else {
			/**
			 * register scripts and styles
			 * in case if this method is called before enqueue_scripts action
			 * and option types has some of these in their dependencies
			 */
			$this->register_static();

			wp_enqueue_media();
			wp_enqueue_style( 'slz-backend-options' );
			wp_enqueue_script( 'slz-backend-options' );
		}

		$collected = array();

		slz_collect_options( $collected, $options, array(
			'limit_option_types' => false,
			'limit_container_types' => false,
			'limit_level' => 1,
			'info_wrapper' => true,
		) );

		if ( empty( $collected ) ) {
			return false;
		}

		$html = '';

		$option = reset( $collected );

		$collected_type = array(
			'group' => $option['group'],
			'type'  => $option['option']['type'],
		);
		$collected_type_options = array(
			$option['id'] => &$option['option']
		);

		while ( $collected_type_options ) {
			$option = next( $collected );

			if ( $option ) {
				if (
					$option['group'] === $collected_type['group']
					&&
					$option['option']['type'] === $collected_type['type']
				) {
					$collected_type_options[ $option['id'] ] = &$option['option'];
					continue;
				}
			}

			switch ( $collected_type['group'] ) {
				case 'container':
					if ($design === 'taxonomy') {
						$html .= slz_render_view(
							slz_get_framework_directory('/views/backend-container-design-'. $design .'.php'),
							array(
								'type' => $collected_type['type'],
								'html' => $this->container_type($collected_type['type'])->render(
									$collected_type_options, $values, $options_data
								),
							)
						);
					} else {
						$html .= $this->container_type($collected_type['type'])->render(
							$collected_type_options, $values, $options_data
						);
					}
					break;
				case 'option':
					foreach ( $collected_type_options as $id => &$_option ) {
						$data = $options_data; // do not change directly to not affect next loops

						$data['value'] = isset( $values[ $id ] ) ? $values[ $id ] : null;

						$html .= $this->render_option(
							$id,
							$_option,
							$data,
							$design
						);
					}
					unset($_option);
					break;
				default:
					$html .= '<p><em>' . __( 'Unknown collected group', 'slz' ) . ': ' . $collected_type['group'] . '</em></p>';
			}

			unset( $collected_type, $collected_type_options );

			if ( $option ) {
				$collected_type = array(
					'group' => $option['group'],
					'type'  => $option['option']['type'],
				);
				$collected_type_options = array(
					$option['id'] => &$option['option']
				);
			} else {
				$collected_type_options = array();
			}
		}

		return $html;
	}

	/**
	 * Enqueue options static
	 *
	 * Useful when you have dynamic options html on the page (for e.g. options modal)
	 * and in order to initialize that html properly, the option types scripts styles must be enqueued on the page
	 *
	 * @param array $options
	 */
	public function enqueue_options_static( $options ) {
		static $static_enqueue = true;
		
		if (
			!doing_action('admin_enqueue_scripts')
			&&
			!did_action('admin_enqueue_scripts')
		) {
			/**
			 * Do not wp_enqueue/register_...() because at this point not all handles has been registered
			 * and maybe they are used in dependencies in handles that are going to be enqueued.
			 * So as a result some handles will not be equeued because of not registered dependecies.
			 */
			return;
		} else {
			/**
			 * register scripts and styles
			 * in case if this method is called before enqueue_scripts action
			 * and option types has some of these in their dependencies
			 */
			if ($static_enqueue) {
				$this->register_static();
	
				wp_enqueue_media();
				wp_enqueue_style( 'slz-backend-options' );
				wp_enqueue_script( 'slz-backend-options' );
				
				$static_enqueue = false;
			}
		}

		$collected = array();

		slz_collect_options( $collected, $options, array(
			'limit_option_types' => false,
			'limit_container_types' => false,
			'limit_level' => 0,
			'callback' => array(__CLASS__, '_callback_slz_collect_options_enqueue_static'),
		) );

		unset($collected);
	}

	/**
	 * @internal
	 * @param array $data
	 */
	public static function _callback_slz_collect_options_enqueue_static($data) {
		if ($data['group'] === 'option') {
			slz()->backend->option_type($data['option']['type'])->enqueue_static($data['id'], $data['option']);
		} elseif ($data['group'] === 'container') {
			slz()->backend->container_type($data['option']['type'])->enqueue_static($data['id'], $data['option']);
		}
	}

	/**
	 * Render option enclosed in backend design
	 *
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 * @param string $design default or taxonomy
	 *
	 * @return string
	 */
	public function render_option( $id, $option, $data = array(), $design = null ) {
		if (empty($design)) {
			$design = $this->default_render_design;
		}

		if (
			!doing_action('admin_enqueue_scripts')
			&&
			!did_action('admin_enqueue_scripts')
		) {
			/**
			 * Do not wp_enqueue/register_...() because at this point not all handles has been registered
			 * and maybe they are used in dependencies in handles that are going to be enqueued.
			 * So as a result some handles will not be equeued because of not registered dependecies.
			 */
		} else {
			$this->register_static();
		}


		if ( ! in_array( $design, $this->available_render_designs ) ) {
			trigger_error( 'Invalid render design specified: ' . $design, E_USER_WARNING );
			$design = 'post';
		}

		if ( ! isset( $data['id_prefix'] ) ) {
			$data['id_prefix'] = $this->get_options_id_attr_prefix();
		}

		$data = apply_filters(
			'slz:backend:option-render:data',
			$data
		);

		return slz_render_view(slz_get_framework_directory('/views/backend-option-design-'. $design .'.php'), array(
			'id'     => $id,
			'option' => $option,
			'data'   => $data,
		) );
	}

	/**
	 * Render a meta box
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $content HTML
	 * @param array $other Optional elements
	 *
	 * @return string Generated meta box html
	 */
	public function render_box( $id, $title, $content, $other = array() ) {
		if ( ! function_exists( 'add_meta_box' ) ) {
			trigger_error( 'Try call this method later (\'admin_init\' action), add_meta_box() function does not exists yet.',
				E_USER_WARNING );

			return '';
		}

		$other = array_merge( array(
			'html_before_title' => false,
			'html_after_title'  => false,
			'attr'              => array(),
		), $other );

		{
			$placeholders = array(
				'id'      => '{{meta_box_id}}',
				'title'   => '{{meta_box_title}}',
				'content' => '{{meta_box_content}}',
			);

			// other placeholders
			{
				$placeholders['html_before_title'] = '{{meta_box_html_before_title}}';
				$placeholders['html_after_title']  = '{{meta_box_html_after_title}}';
				$placeholders['attr']              = '{{meta_box_attr}}';
				$placeholders['attr_class']        = '{{meta_box_attr_class}}';
			}
		}

		$cache_key = 'slz_meta_box_template';

		try {
			$meta_box_template = SLZ_Cache::get( $cache_key );
		} catch ( SLZ_Cache_Not_Found_Exception $e ) {
			$temp_screen_id = 'slz-temp-meta-box-screen-id-' . slz_unique_increment();
			$context        = 'normal';

			add_meta_box(
				$placeholders['id'],
				$placeholders['title'],
				$this->print_meta_box_content_callback,
				$temp_screen_id,
				$context,
				'default',
				$placeholders['content']
			);

			ob_start();

			do_meta_boxes( $temp_screen_id, $context, null );

			$meta_box_template = ob_get_clean();

			remove_meta_box( $id, $temp_screen_id, $context );

			// remove wrapper div, leave only meta box div
			{
				// <div ...>
				{
					$meta_box_template = str_replace(
						'<div id="' . $context . '-sortables" class="meta-box-sortables">',
						'',
						$meta_box_template
					);
				}

				// </div>
				{
					$meta_box_template = explode( '</div>', $meta_box_template );
					array_pop( $meta_box_template );
					$meta_box_template = implode( '</div>', $meta_box_template );
				}
			}

			// add 'slz-postbox' class and some attr related placeholders
			$meta_box_template = str_replace(
				'class="postbox',
				$placeholders['attr'] . ' class="postbox slz-postbox' . $placeholders['attr_class'],
				$meta_box_template
			);

			// add html_before|after_title placeholders
			{
				$meta_box_template = str_replace(
					'<span>' . $placeholders['title'] . '</span>',

					/**
					 * used <small> not <span> because there is a lot of css and js
					 * that thinks inside <h2 class="hndle"> there is only one <span>
					 * so do not brake their logic
					 */
					'<small class="slz-html-before-title">' . $placeholders['html_before_title'] . '</small>' .
					'<span>' . $placeholders['title'] . '</span>' .
					'<small class="slz-html-after-title">' . $placeholders['html_after_title'] . '</small>',

					$meta_box_template
				);
			}

			SLZ_Cache::set( $cache_key, $meta_box_template );
		}

		// prepare attributes
		{
			$attr_class = '';
			if ( isset( $other['attr']['class'] ) ) {
				$attr_class = ' ' . $other['attr']['class'];

				unset( $other['attr']['class'] );
			}

			unset( $other['attr']['id'] );
		}

		// replace placeholders with data/content
		return str_replace(
			array(
				$placeholders['id'],
				$placeholders['title'],
				$placeholders['content'],
				$placeholders['html_before_title'],
				$placeholders['html_after_title'],
				$placeholders['attr'],
				$placeholders['attr_class'],
			),
			array(
				esc_attr( $id ),
				$title,
				$content,
				$other['html_before_title'],
				$other['html_after_title'],
				slz_attr_to_html( $other['attr'] ),
				esc_attr( $attr_class )
			),
			$meta_box_template
		);
	}

	/**
	 * @param SLZ_Access_Key $access_key
	 * @param string|SLZ_Option_Type $option_type_class
	 *
	 * @internal
	 */
	public function _register_option_type( SLZ_Access_Key $access_key, $option_type_class ) {
		if ( $access_key->get_key() !== 'slz_option_type' ) {
			trigger_error( 'Call denied', E_USER_ERROR );
		}

		$this->register_option_type( $option_type_class );
	}

	/**
	 * @return Param
	 */
	public function get_param( $key = null, $default_value = null ) {

		$cache_key = 'slz_backend';
		
		$cache_key = $cache_key .'/global_param';

		$core_param = $theme_param = $global_param = array();

		try {

			$global_param = SLZ_File_Cache::get($cache_key);

		} catch (SLZ_File_Cache_Not_Found_Exception $e) {
			
			// core param
			if ( file_exists( slz_get_framework_directory( '/bootstrap-param.php' ) ) ) {
				$param = slz_get_variables_from_file(slz_get_framework_directory( '/bootstrap-param.php' ), array( 'params' => null ) );

				if ( !empty( $param['params'] ) ) {
					$core_param = $param['params'];
				}
				unset ( $param );
			}

			// theme param
			if ( file_exists( slz_get_template_customizations_directory( '/theme/param.php' ) ) ) {
				$param = slz_get_variables_from_file(slz_get_template_customizations_directory( '/theme/param.php' ), array( 'params' => null ) );

				if ( !empty( $param['params'] ) ) {
					$theme_param = $param['params'];
				}
				unset( $param );
			}

			if( isset( $core_param['block_image_sizes'] ) && isset( $theme_param['block_image_sizes'] ) ){
				$core_param['block_image_sizes'] = array_merge( $core_param['block_image_sizes'], $theme_param['block_image_sizes'] );
				unset ( $theme_param['block_image_sizes'] );
			}

			if( isset( $core_param['register_image_sizes'] ) && isset( $theme_param['register_image_sizes'] ) ){
				$core_param['register_image_sizes'] = array_merge( $core_param['register_image_sizes'], $theme_param['register_image_sizes'] );
				unset ( $theme_param['register_image_sizes'] );
			}

			$global_param = array_merge($core_param, $theme_param);

			SLZ_File_Cache::set($cache_key, $global_param);
		}

		return $key === null ? $global_param : slz_akg($key, $global_param, $default_value);
	}

	/**
	 * @param SLZ_Access_Key $access_key
	 * @param string|SLZ_Container_Type $container_type_class
	 *
	 * @internal
	 */
	public function _register_container_type( SLZ_Access_Key $access_key, $container_type_class ) {
		if ( $access_key->get_key() !== 'slz_container_type' ) {
			trigger_error( 'Call denied', E_USER_ERROR );
		}

		$this->register_container_type( $container_type_class );
	}

	/**
	 * @param string $option_type
	 *
	 * @return SLZ_Option_Type|SLZ_Option_Type_Undefined
	 */
	public function option_type( $option_type ) {
		if ( is_array( $this->option_types_pending_registration ) ) { // This method is called for the first time
			require_once dirname(__FILE__) .'/../extends/class-slz-option-type.php';

			do_action('slz_option_types_init');

			// Register pending option types
			{
				$pending_option_types = $this->option_types_pending_registration;

				// clear this property, so register_option_type() will not add option types to pending anymore
				$this->option_types_pending_registration = false;

				foreach ( $pending_option_types as $option_type_class ) {
					$this->register_option_type( $option_type_class );
				}

				unset( $pending_option_types );
			}
		}

		if ( isset( $this->option_types[ $option_type ] ) ) {
			return $this->option_types[ $option_type ];
		} else {
			if ( is_admin() ) {
				SLZ_Flash_Messages::add(
					'slz-get-option-type-undefined-' . $option_type,
					sprintf( __( 'Undefined option type: %s', 'slz' ), $option_type ),
					'warning'
				);
			}

			if (!$this->undefined_option_type) {
				require_once slz_get_framework_directory('/includes/option-types/class-slz-option-type-undefined.php');

				$this->undefined_option_type = new SLZ_Option_Type_Undefined();
			}

			return $this->undefined_option_type;
		}
	}

	/**
	 * @param string $container_type
	 *
	 * @return SLZ_Container_Type|SLZ_Container_Type_Undefined
	 */
	public function container_type( $container_type ) {
		if ( is_array( $this->container_types_pending_registration ) ) { // This method is called for the first time
			require_once dirname(__FILE__) .'/../extends/class-slz-container-type.php';

			do_action('slz_container_types_init');

			// Register pending container types
			{
				$pending_container_types = $this->container_types_pending_registration;

				// clear this property, so register_container_type() will not add container types to pending anymore
				$this->container_types_pending_registration = false;

				foreach ( $pending_container_types as $container_type_class ) {
					$this->register_container_type( $container_type_class );
				}

				unset( $pending_container_types );
			}
		}

		if ( isset( $this->container_types[ $container_type ] ) ) {
			return $this->container_types[ $container_type ];
		} else {
			if ( is_admin() ) {
				SLZ_Flash_Messages::add(
					'slz-get-container-type-undefined-' . $container_type,
					sprintf( __( 'Undefined container type: %s', 'slz' ), $container_type ),
					'warning'
				);
			}

			if (!$this->undefined_container_type) {
				require_once slz_get_framework_directory('/includes/container-types/class-slz-container-type-undefined.php');

				$this->undefined_container_type = new SLZ_Container_Type_Undefined();
			}

			return $this->undefined_container_type;
		}
	}

	/**
	 * @param WP_Customize_Manager $wp_customize
	 * @internal
	 */
	public function _action_customize_register($wp_customize) {
		if (is_admin()) {
			add_action('admin_enqueue_scripts', array($this, '_action_enqueue_customizer_static'));
		}

		$this->customizer_register_options(
			$wp_customize,
			slz()->theme->get_customizer_options()
		);
	}

	/**
	 * @internal
	 */
	public function _action_enqueue_customizer_static()
	{
		{
			$options_for_enqueue = array();
			$customizer_options = slz()->theme->get_customizer_options();

			/**
			 * In customizer options is allowed to have container with unspecified (or not existing) 'type'
			 * slz()->backend->enqueue_options_static() tries to enqueue both options and container static
			 * not existing container types will throw notices.
			 * To prevent that, extract and send it only options (without containers)
			 */
			slz_collect_options($options_for_enqueue, $customizer_options, array(
				'callback' => array(__CLASS__, '_callback_slz_collect_options_enqueue_static'),
			));

			unset($options_for_enqueue, $customizer_options);
		}

		wp_enqueue_script(
			'slz-backend-customizer',
			slz_get_framework_directory_uri( '/static/js/backend-customizer.js' ),
			array( 'jquery', 'slz-events', 'backbone', 'slz-backend-options' ),
			slz()->manifest->get_version(),
			true
		);
		wp_localize_script(
			'slz-backend-customizer',
			'_slz_backend_customizer_localized',
			array(
				'change_timeout' => apply_filters('slz_customizer_option_change_timeout', 333),
			)
		);

		do_action('slz_admin_enqueue_scripts:customizer');
	}

	/**
	 * @param WP_Customize_Manager $wp_customize
	 * @param array $options
	 * @param array $parent_data {'type':'...','id':'...'}
	 */
	private function customizer_register_options($wp_customize, $options, $parent_data = array()) {
		$collected = array();

		slz_collect_options( $collected, $options, array(
			'limit_option_types' => false,
			'limit_container_types' => false,
			'limit_level' => 1,
			'info_wrapper' => true,
		) );

		if ( empty( $collected ) ) {
			return;
		}

		foreach ($collected as &$opt) {
			switch ($opt['group']) {
				case 'container':
					// Check if has container options
					{
						$_collected = array();

						slz_collect_options( $_collected, $opt['option']['options'], array(
							'limit_option_types' => array(),
							'limit_container_types' => false,
							'limit_level' => 1,
							'limit' => 1,
							'info_wrapper' => false,
						) );

						$has_containers = !empty($_collected);

						unset($_collected);
					}

					$children_data = array(
						'group' => 'container',
						'id' => $opt['id']
					);

					$args = array(
						'title' => empty($opt['option']['title'])
							? slz_id_to_title($opt['id'])
							: $opt['option']['title'],
						'description' => empty($opt['option']['desc'])
							? ''
							: $opt['option']['desc'],
					);

					if (isset($opt['option']['wp-customizer-args']) && is_array($opt['option']['wp-customizer-args'])) {
						$args = array_merge($opt['option']['wp-customizer-args'], $args);
					}

					if ($has_containers) {
						if ($parent_data) {
							trigger_error($opt['id'] .' panel can\'t have a parent ('. $parent_data['id'] .')', E_USER_WARNING);
							break;
						}

						$wp_customize->add_panel($opt['id'], $args);

						$children_data['customizer_type'] = 'panel';
					} else {
						if ($parent_data) {
							if ($parent_data['customizer_type'] === 'panel') {
								$args['panel'] = $parent_data['id'];
							} else {
								trigger_error($opt['id'] .' section can have only panel parent ('. $parent_data['id'] .')', E_USER_WARNING);
								break;
							}
						}

						$wp_customize->add_section($opt['id'], $args);

						$children_data['customizer_type'] = 'section';
					}

					$this->customizer_register_options(
						$wp_customize,
						$opt['option']['options'],
						$children_data
					);

					unset($children_data);
					break;
				case 'option':
					$setting_id = $this->get_options_name_attr_prefix() .'['. $opt['id'] .']';

					{
						$args_control = array(
							'label' => empty($opt['option']['label'])
								? slz_id_to_title($opt['id'])
								: $opt['option']['label'],
							'description' => empty($opt['option']['desc'])
								? ''
								: $opt['option']['desc'],
							'settings' => $setting_id,
						);

						if (isset($opt['option']['wp-customizer-args']) && is_array($opt['option']['wp-customizer-args'])) {
							$args_control = array_merge($opt['option']['wp-customizer-args'], $args_control);
						}

						if ($parent_data) {
							if ($parent_data['customizer_type'] === 'section') {
								$args_control['section'] = $parent_data['id'];
							} else {
								trigger_error('Invalid control parent: '. $parent_data['customizer_type'], E_USER_WARNING);
								break;
							}
						} else { // the option is not placed in a section, create a section automatically
							$args_control['section'] = 'slz_option_auto_section_'. $opt['id'];

							$wp_customize->add_section($args_control['section'], array(
								'title' => empty($opt['option']['label'])
									? slz_id_to_title($opt['id'])
									: $opt['option']['label'],
							));
						}
					}

					if (!class_exists('_SLZ_Customizer_Setting_Option')) {
						require_once slz_get_framework_directory('/includes/customizer/class--slz-customizer-setting-option.php');
					}

					if (!class_exists('_SLZ_Customizer_Control_Option_Wrapper')) {
						require_once slz_get_framework_directory('/includes/customizer/class--slz-customizer-control-option-wrapper.php');
					}

					{
						$args_setting = array(
							'default' => slz()->backend->option_type($opt['option']['type'])->get_value_from_input($opt['option'], null),
							'slz_option' => $opt['option'],
						);

						if (isset($opt['option']['wp-customizer-setting-args']) && is_array($opt['option']['wp-customizer-setting-args'])) {
							$args_setting = array_merge($opt['option']['wp-customizer-setting-args'], $args_setting);
						}

						$wp_customize->add_setting(
							new _SLZ_Customizer_Setting_Option(
								$wp_customize,
								$setting_id,
								$args_setting
							)
						);

						unset($args_setting);
					}

					// control must be registered after setting
					$wp_customize->add_control(
						new _SLZ_Customizer_Control_Option_Wrapper(
							$wp_customize,
							$opt['id'],
							$args_control
						)
					);
					break;
				default:
					trigger_error('Unknown group: '. $opt['group'], E_USER_WARNING);
			}
		}
	}

	/**
	 * For e.g. an option-type was rendered using 'customizer' design,
	 * but inside it uses render_options() but it doesn't know the current render design
	 * and the options will be rendered with 'default' design.
	 * This method allows to specify the default design that will be used if not specified on render_options()
	 * @param null|string $design
	 * @internal
	 */
	public function _set_default_render_design($design = null)
	{
		if (empty($design) || !in_array($design, $this->available_render_designs)) {
			$this->default_render_design = 'default';
		} else {
			$this->default_render_design = $design;
		}
	}
}
