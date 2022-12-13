<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Filters and Actions
 */

/**
 * Option types
 */
{
	/**
	 * @internal
	 */
	function _action_slz_init_option_types() {
		require_once dirname(__FILE__) .'/option-types/init.php';
	}
	add_action('slz_option_types_init', '_action_slz_init_option_types');

	/**
	 * Some option-types have add_action('wp_ajax_...')
	 * so init all option-types if current request is ajax
	 * @since 2.6.1
	 */
	if (defined('DOING_AJAX') && DOING_AJAX) {
		function _action_slz_init_option_types_on_ajax() {
			slz()->backend->option_type('text');
		}
		add_action('slz_init', '_action_slz_init_option_types_on_ajax');
	}

	require_once dirname(__FILE__) . '/extra-functions/class-slz-params.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-com.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-util.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-block.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-block-module.php';
	require_once dirname(__FILE__) . '/extra-functions/model/class-slz-custom-posttype-model.php';
	require_once dirname(__FILE__) . '/extra-functions/model/class-slz-pagination.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-ajax.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-post-feature-video.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-social-sharing.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-template-module.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-hash-tag-compiler.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-review.php';
	require_once dirname(__FILE__) . '/extra-functions/extra-functions.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-minify-system.php';
 	require_once dirname(__FILE__) . '/extra-functions/class-slz-browser-cache.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-page-cache.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-vc-params.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-icon.php';
	require_once dirname(__FILE__) . '/extra-functions/class-slz-live-setting.php';
	
	
	/**
	 * @internal
	 */
		function _action_slz_slz_init_ajax() {
			$new_ajax = new SLZ_Ajax_Loader();
			$new_ajax->init();
		}
		add_action('init', '_action_slz_slz_init_ajax', 0);
		
		function _action_slz_feature_video_init() {
			$video = new SLZ_Post_Feature_Video();
			$video->init();
		}
		add_action( 'init', '_action_slz_feature_video_init' );

		function _action_slz_review_ratings() {
			$ratings = new SLZ_Review();
			$ratings->init();
		}
		add_action( 'init', '_action_slz_review_ratings' );

		{
			/**
			 *  Change image, logo and title for login screen
			 *  
			 **/
			if ( ! function_exists( '_action_slz_login_style' ) ) {
				function _action_slz_login_style() {
					$logo = slz_get_db_settings_option('logo', '');
					if( isset( $logo['url'] ) ) {
						$custom_css = '.login h1 a { 
											background : url('.esc_url($logo['url']).') center no-repeat; 
											width: 100%;
											background-size: contain;
										}';
						wp_enqueue_style( 'slz-login-style', slz_get_framework_directory_uri( '/static/css/slz-backend.css' ) );
						wp_add_inline_style( 'slz-login-style', $custom_css );
					}
				}
			}
			add_action( 'login_enqueue_scripts', '_action_slz_login_style' );
	
			// Change title for login screen
			if ( ! function_exists( '_filter_slz_login_headertitle' ) ) {
				function _filter_slz_login_headertitle() {
					return esc_attr(get_bloginfo('description'));
				}
			}
			add_filter('login_headertitle', '_filter_slz_login_headertitle');
			
			// Change url for login screen
			if ( ! function_exists( '_filter_slz_login_headerurl' ) ) {
				function _filter_slz_login_headerurl() {
					return esc_url(home_url('/'));
				}
			}
			add_filter( 'login_headerurl', '_filter_slz_login_headerurl' );
		}

	/**
	 * Prevent Fatal Error if someone is registering option-types in old way (right away)
	 * not in 'slz_option_types_init' action
	 * @param string $class
	 */
	function _slz_autoload_option_types($class) {
		if ('SLZ_Option_Type' === $class) {
			require_once dirname(__FILE__) .'/../core/extends/class-slz-option-type.php';

			if (is_admin() && defined('WP_DEBUG') && WP_DEBUG) {
				SLZ_Flash_Messages::add(
					'option-type-register-wrong',
					__("Please register option-types on 'slz_option_types_init' action", 'slz'),
					'warning'
				);
			}
		} elseif ('SLZ_Container_Type' === $class) {
			require_once dirname(__FILE__) .'/../core/extends/class-slz-container-type.php';

			if (is_admin() && defined('WP_DEBUG') && WP_DEBUG) {
				SLZ_Flash_Messages::add(
					'container-type-register-wrong',
					__("Please register container-types on 'slz_container_types_init' action", 'slz'),
					'warning'
				);
			}
		}
	}
	spl_autoload_register('_slz_autoload_option_types');
}
/**
 * Add item for user profile
 * To get contact items of user :
 * get_user_meta ( int $user_id, string $key = '', bool $single = false )
 */
{
	function _filter_slz_add_item_user_profile($items) {

		// Add new item
		$links = SLZ_Params::params_social();
		foreach($links as $k=>$v){
			$items[$k] = $v;
		}
		return $items;
	}
	add_filter('user_contactmethods', '_filter_slz_add_item_user_profile');
}
/**
 * Container types
 */
{
	/**
	 * @internal
	 */
	function _action_slz_init_container_types() {
		require_once dirname(__FILE__) .'/container-types/init.php';
	}
	add_action('slz_container_types_init', '_action_slz_init_container_types');
}

/**
 * Custom Github API service
 * Provides the same responses but is "unlimited"
 * To prevent error: Github API rate limit exceeded 60 requests per hour
 * https://github.com/ThemeFuse/Unyson/issues/138
 * @internal
 */
function _slz_filter_github_api_url($url) {
	return 'http://github-api-cache.unyson.io';
}
add_filter('slz_github_api_url', '_slz_filter_github_api_url');

/**
 * Javascript events related to tinymce init
 * @since 2.6.0
 */
{
	add_action('wp_tiny_mce_init', '_slz_action_tiny_mce_init');
	function _slz_action_tiny_mce_init($mce_settings) {
?>
<script type="text/javascript">
	if (typeof slzEvents != 'undefined') { slzEvents.trigger('slz:tinymce:init:before'); }
</script>
<?php
	}

	add_action('after_wp_tiny_mce', '_slz_action_after_wp_tiny_mce');
	function _slz_action_after_wp_tiny_mce($mce_settings) {
?>
<script type="text/javascript">
	if (typeof slzEvents != 'undefined') { slzEvents.trigger('slz:tinymce:init:after'); }
</script>
<?php
	}
}


/*
 * Tracking code
 */
add_action('wp_head','_action_show_tracking_array');
 if ( !function_exists ( '_action_show_tracking_array' ) ) {
	function _action_show_tracking_array() {
		$tracking_array = slz_get_db_settings_option ( 'tracking-popup', '' );
		
		$tracking = array ();
		
		if (! empty ( $tracking_array )) {
			
			foreach ( $tracking_array as $tracking_arr ) {
				
				$tracking [] = $tracking_arr ['tracking_script'];
			}
		}
		if ($tracking) {
			
			echo implode ( '', $tracking );
		}
		
		echo '';
	}
}

if ( ! function_exists( '_action_slz_javascript_detection' ) ) :

	function _action_slz_javascript_detection() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}

	add_action( 'wp_head', '_action_slz_javascript_detection', 0 );

endif;

function _action_add_post_format_scripts( $hook ) {
 
	global $post;
 
	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		if ( 'post' === $post->post_type ) {
			wp_enqueue_script(  'slz-post-format-custom', slz_get_framework_directory_uri( '/static/js/slz-post-format.js' ) );
		}
	}
}
add_action( 'admin_enqueue_scripts', '_action_add_post_format_scripts', 10, 1 );

add_action( 'admin_enqueue_scripts', '_action_slz_deregister_woocommerce_setting', 99 );
function _action_slz_deregister_woocommerce_setting(){
	if( is_admin() ){
		$screen = get_current_screen();
		$arr_posttype = '';
		$arr_posttype = slz()->theme->get_config('woo_posttype_deregister');
		if( $screen->base == slz()->theme->manifest->get('prefix') . '_page_slz-settings' ) {
			wp_deregister_script( 'woocommerce_settings' );
		}else{
			if( !empty( $arr_posttype ) ) {
					
				foreach ( $arr_posttype as $item ) {
					if( $screen->post_type == $item ) {
						wp_deregister_script( 'woocommerce_settings' );
					}
				}
			}
		}
	}
}
//WPML Hooks
//Fixed https://github.com/ThemeFuse/Unyson/issues/326
{
	if ( is_admin() ) {
		add_action( 'icl_save_term_translation', '_slz_action_wpml_duplicate_term_options', 20, 2 );
		function _slz_action_wpml_duplicate_term_options( $original, $translated ) {
			$original_options = slz_get_db_term_option(
					slz_akg( 'term_id', $original ),
					slz_akg( 'taxonomy', $original )
			);
			if ( $original_options !== null ) {
				slz_set_db_term_option(
						slz_akg( 'term_id', $translated ),
						slz_akg( 'taxonomy', $original ),
						null,
						$original_options
				);
			}
		}
	}
}