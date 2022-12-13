<?php
if ( file_exists( TRANSERA_INCLUDE_DIR . '/class-breadcrumb.php' ) ) :
	require_once TRANSERA_INCLUDE_DIR . '/class-breadcrumb.php';
endif;
add_action( 'after_setup_theme', '_transera_action_theme_setup' );
add_action( 'widgets_init', '_transera_action_widgets_init' );
if ( ! function_exists( '_transera_action_theme_setup' ) ) :
	function _transera_action_theme_setup() {
		load_theme_textdomain( 'transera', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote' ) );
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(1200, 650, true);
		add_theme_support( 'title-tag' );
		if ( defined('SLZ') ) {
			$image_sizes = slz()->theme->manifest->get('register_image_sizes');
			foreach($image_sizes as $key => $sizes ) {
				$crop = true;
				if( isset( $sizes['crop'] ) ) {
					$crop = $sizes['crop'];
				}
				add_image_size( $key, $sizes['width'], $sizes['height'], $crop );
			}
		}
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
		add_editor_style( '/static/css/custom-editor.css' );
	}
endif;
if ( ! function_exists( '_transera_action_widgets_init' ) ) :
	function _transera_action_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Custom Widget Area', 'transera' ),
			'id'            => 'transera-custom-sidebar',
			'description'   => esc_html__( 'Appears on sidebar of posts and pages', 'transera'),
			'before_widget' => '<div id="%1$s" class="box %2$s slz-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="title-widget">',
			'after_title'   => '</div>'
		) );
	}
endif;
/*------------------------- TGM Plugin ---------------------------*/
if ( file_exists( TRANSERA_INCLUDE_DIR . '/class-tgm-plugin-activation.php' ) ) :
	require_once TRANSERA_INCLUDE_DIR . '/class-tgm-plugin-activation.php';
	add_action( 'tgmpa_register', '_transera_register_required_plugins' );
	add_action( 'admin_init', '_transera_call_tgm_plugin_action' );
	if ( ! function_exists( '_transera_call_tgm_plugin_action' ) ) :
		function _transera_call_tgm_plugin_action(){
			if( isset( $_GET['slz-deactivate'] ) && $_GET['slz-deactivate'] == 'deactivate-plugin' ) {
				check_admin_referer( 'slz-deactivate', 'slz-nonce' );
		
				$plugins = TGM_Plugin_Activation::$instance->plugins;
		
				foreach( $plugins as $plugin ) {
					if( $plugin['slug'] == $_GET['plugin'] ) {
						deactivate_plugins( $plugin['file_path'] );
					}
				}
			} if( isset( $_GET['slz-activate'] ) && $_GET['slz-activate'] == 'activate-plugin' ) {
				check_admin_referer( 'slz-activate', 'slz-nonce' );
		
				$plugins = TGM_Plugin_Activation::$instance->plugins;
		
				foreach( $plugins as $plugin ) {
					if( $plugin['slug'] == $_GET['plugin'] ) {
						activate_plugin( $plugin['file_path'] );
					}
				}
			}
		}
	endif;
	function _transera_register_required_plugins () {
		$plugins = array(
			array(
				'name'					=> esc_html__('Solazu Unyson', 'transera'),
				'slug'					=> 'solazu-unyson',
				'source'				=> TRANSERA_PLUGIN_DIR . '/solazu-unyson.zip',
				'required'				=> true,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/solazu-unyson.png',
			),
			array(
				'name'					=> esc_html__('WPBakery Visual Composer', 'transera'),
				'slug'					=> 'js_composer',
				'source'				=> TRANSERA_PLUGIN_DIR . '/js_composer.zip',
				'required'				=> true,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/js_composer.jpg',
			),
			// Include Revolution plugin.
			array(
					'name'                    => esc_html__('Revolution Slider', 'transera'),
					'slug'                    => 'revslider',
					'source'                => TRANSERA_PLUGIN_DIR . '/revslider.zip',
					'required'                => true,
					'force_activation'        => false,
					'force_deactivation'    => false,
					'image_url'                => TRANSERA_PLUGIN_IMG_URI . '/revslider.jpg',
			),	
			// Include Contact Form 7 plugin.
			array(
					'name'					=> esc_html__('Contact Form 7', 'transera'),
					'slug'					=> 'contact-form-7',
					'required'				=> true,
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/contact_form_7.jpg',
			),				
			// Include Newsletter plugin.
			array(
				'name'					=> esc_html__('Newsletter', 'transera'),
				'slug'					=> 'newsletter',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/newsletter.png',
			),
			// Include EWWW Image Optimizer
			array(
				'name'					=> esc_html__('EWWW Image Optimizer', 'transera'),
				'slug'					=> 'ewww-image-optimizer',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/ewww_image_optimizer.jpg',
			),
			// Include WooCommerce plugin.
			array(
				'name'					=> esc_html__('WooCommerce', 'transera'),
				'slug'					=> 'woocommerce',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/woocommerce.png',
			),
			// Include YITH WooCommerce Zoom Magnifier plugin
			array(
				'name'					=> esc_html__('YITH WooCommerce Zoom Magnifier', 'transera'),
				'slug'					=> 'yith-woocommerce-zoom-magnifier',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/yith_magnifier.jpg',
			),
			// Include YITH WooCommerce Wishlist plugin
			array(
				'name'					=> esc_html__('YITH WooCommerce Wishlist', 'transera'),
				'slug'					=> 'yith-woocommerce-wishlist',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> TRANSERA_PLUGIN_IMG_URI . '/yith_woo_wishlist.jpg',
			),
		);
		$config = array(
			'id'               => 'tgmpa',
			'domain'           => 'transera',
			'default_path'     => '',
			'parent_slug'      => 'themes.php',
			'menu'             => 'tgmpa-install-plugins',
			'has_notices'      => true,
			'is_automatic'     => true,
			'message'          => '',
			'strings'          => array(
				'page_title'                       => esc_html__('Install Required Plugins', 'transera'),
				'menu_title'                       => esc_html__('Install Plugins', 'transera'),
				'installing'                       => esc_html__('Installing Plugin: %s', 'transera'),
				'oops'                             => esc_html__('Something went wrong with the plugin API.', 'transera'),
				'notice_can_install_required'      => _n_noop('This theme requires the following plugin installed or update: %1$s.', 'This theme requires the following plugins installed or updated: %1$s.', 'transera' ),
				'notice_can_install_recommended'   => _n_noop('This theme recommends the following plugin installed or updated: %1$s.', 'This theme recommends the following plugins installed or updated: %1$s.', 'transera' ),
				'notice_cannot_install'            => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'transera' ),
				'notice_can_activate_required'     => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'transera' ),
				'notice_can_activate_recommended'  => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'transera' ),
				'notice_cannot_activate'           => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'transera' ),
				'notice_ask_to_update'             => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'transera' ),
				'notice_cannot_update'             => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'transera' ),
				'install_link'                     => _n_noop('Begin installing plugin', 'Begin installing plugins', 'transera' ),
				'activate_link'                    => _n_noop('Activate installed plugin', 'Activate installed plugins', 'transera' ),
				'return'                           => esc_html__('Return to Required Plugins Installer', 'transera'),
				'plugin_activated'                 => esc_html__('Plugin activated successfully.', 'transera'),
				'complete'                         => esc_html__('All plugins installed and activated successfully. %s', 'transera'),
				'nag_type'                         => 'updated'
			)
		);
		tgmpa($plugins, $config);
	}
endif;
/*--------------------------- Framework Functions ----------------------*/
if( defined( 'SLZ' ) ) {
	if ( file_exists( TRANSERA_FW_CUSTOMIZE_DIR. '/theme/class-welcome.php' ) ) :
		require_once TRANSERA_FW_CUSTOMIZE_DIR . '/theme/class-welcome.php';
	endif;
	add_action( 'slz_settings_form_saved', '_transera_settings_form_saved' );
	add_filter( 'slz:ext:backups-demo:demos', '_transera_slz_ext_backups_demos');
	add_filter('slz_ext_manager_disable_extension', '_transera_filter_disable_extensions');
	// disable extensions
	if( !function_exists( '_transera_filter_disable_extensions' ) ) {
		function _transera_filter_disable_extensions($to_disable)
		{
			$to_disable = array(
				'megamenu',
				'breadcrumbs',
				'events',
				'feedback',
				'social',
				'analytics',
				'slider',
				'seo',
				'social-counter',
				'instagram',
				'new-tweet',
				'portfolio',
				'donation',
					
			);
			return $to_disable;
		}
	}
	
	if ( !function_exists( '_transera_settings_form_saved' ) ) :
	
		function _transera_settings_form_saved($old_value){
	
			if ( slz_get_db_settings_option('article-layout', '') != '' ) {
	
				$hashtag_system = new SLZ_Hash_Tag_Compiler();
	
				$hashtag_system->compiler(slz_get_db_settings_option('article-layout', ''));
	
			}
	
			$option = slz_get_db_settings_option('slz-header-style-group', array());
	
			$selected_header = slz_akg('slz-header-style', $option);
	
			$location_data = get_theme_mod( 'nav_menu_locations' );
	
			if ( $selected_header != '' ){
	
				$header_enable = slz_akg( $selected_header . '/enable-header-top-bar/selected-value', $option, '');
	
				if ( $header_enable == 'yes' ){
	
					$menu_data = slz_akg( $selected_header . '/enable-header-top-bar/yes/menu', $option, $location_data['top-nav']);
	
					if ( $menu_data == 'default' ) 
						$menu_data = '';
	
					$location_data['top-nav'] = $menu_data;
	
				}
	
				$main_menu = slz_akg( $selected_header . '/main-menu', $option, $location_data['main-nav']);
	
				if ( $main_menu == 'default' ) 
					$main_menu = '';
	
				$location_data['main-nav'] = $main_menu;
	
			}
	
			$option = slz_get_db_settings_option('slz-footer-style-group', array());
	
			$selected_footer = slz_akg('slz-footer-style', $option);
	
			if ( $selected_footer != '' ){
	
				$footer_enable = slz_akg( $selected_footer . '/footer-top/status', $option, '');
	
				if ( $footer_enable == 'enable' ){
	
					$menu_enable = slz_akg( $selected_footer . '/footer-top/enable/enable-menu/selected_value', $option, '');
	
					if ( $menu_enable == 'yes' ) {
	
						$menu_data = slz_akg( $selected_footer . '/footer-top/enable/enable-menu/yes/menu', $option, $location_data['bottom-nav']);
	
						if ( $menu_data == 'default' ) 
							$menu_data = '';
	
						$location_data['bottom-nav'] = $menu_data;
	
					}
	
				}
	
			}
	
			set_theme_mod( 'nav_menu_locations', $location_data);
	
		}
	
	endif;
	
	if ( !function_exists( '_transera_slz_ext_backups_demos' ) ) :
	
		function _transera_slz_ext_backups_demos($demos) {
			$demos_array = array(
				'transera_demo' => array(
					'title' => esc_html__('Transera Demo', 'transera'),
					'screenshot'   => TRANSERA_IMG_URI . '/demo-images/default.png',
					'preview_link' => 'http://wp.swlabs.co/transera',
					'version'	=> '1.2'
				),
			);
	
			$download_url = 'http://wp.swlabs.co/demo-content/index.php';
	
			foreach ($demos_array as $id => $data) {
				$demo = new SLZ_Ext_Backups_Demo($id, 'piecemeal', array(
					'url' => $download_url,
					'file_id' => $id
				));
	
				$demo->set_title($data['title']);
				$demo->set_screenshot($data['screenshot']);
				$demo->set_preview_link($data['preview_link']);
				if ( !empty ( $data['version'] ) )
					$demo->set_version($data['version']);
	
				$demos[ $demo->get_id() ] = $demo;
	
				unset($demo);
			}
	
			return $demos;
		}
	
	endif;
}// end Framework Functions


function transera_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
  
    return $title;
}
 
add_filter( 'get_the_archive_title', 'transera_archive_title' );