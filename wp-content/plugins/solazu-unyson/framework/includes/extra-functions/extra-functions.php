<?php
add_action('wp_head', 'slz_extra_postview_set');
if( ! function_exists( 'slz_extra_postview_set' ) ) :

	function slz_extra_postview_set() {
		global $post;
		$post_types = slz()->theme->manifest->get('count_view_to_post_type');
		if( empty($post_types) ) {
			$post_types = array('post');
		}
		$count_key = slz()->theme->manifest->get('post_view_name');
		if( $post ) {
			$post_id = $post->ID;
			if( in_array(get_post_type(), $post_types) && is_single() ) {
				$count = get_post_meta( $post_id, $count_key, true );
				if( $count == '' ) {
					$count = 0;
					delete_post_meta( $post_id, $count_key );
					add_post_meta( $post_id, $count_key, '0' );
				} else {
					$count++;
					update_post_meta( $post_id, $count_key, $count );
				}
			}
		}
	}
endif;
if ( ! function_exists( 'slz_extra_get_sidebar' ) ) :
	/**
	 * Get sidebar to post ang page.
	 * 
	 * @param string $template ( ex: blog-sidebar )
	 * @param string $layout   ( ex: post-sidebar )
	 */
	function slz_extra_get_sidebar( $sidebar ) {
		if ( is_active_sidebar( $sidebar ) ) {
			dynamic_sidebar( $sidebar );
		}
	}
endif;
// Get sidebar setting in taxonomy
if ( ! function_exists( 'slz_extra_get_taxonomy_layout' ) ) :
	function slz_extra_get_taxonomy_layout( $option_id ){
		$term = $GLOBALS['wp_query']->get_queried_object();
		if( $term && !empty ( $term->term_id ) ) {
			$sidebar_layout = slz_get_db_term_option($term->term_id, $term->taxonomy, $option_id . '-layout', '');
			if( $sidebar_layout != '' && $sidebar_layout != 'default' ) {
				$sidebar = slz_get_db_term_option($term->term_id, $term->taxonomy, $option_id, '');
				return array( 'sidebar' => $sidebar, 'sidebar_layout' => $sidebar_layout );
			}
		}
		return false;
	}
endif;
/**
 * Get class to extra post layout
 */
if ( ! function_exists( 'slz_extra_get_content_layout_class' ) ) :
	function slz_extra_get_content_layout_class(){
		$class = '';
		if( is_single() ) {
			$post_type = get_post_type();
			$post_id = get_the_ID();
			if( $mapping = slz()->theme->get_config('extra_layout_mapping') ) {
				if( isset($mapping[$post_type]) && $arr_options = $mapping[$post_type] ) {
					$layout = slz_get_db_post_option( $post_id, $arr_options['key'], '' );
					if ( empty($layout) || $layout == 'default'){
						$layout = slz_get_db_settings_option($arr_options['key']);
					}
					if( !empty($layout) && isset( $arr_options['class'][$layout])) {
						$class = $arr_options['class'][$layout];
					}
				}
			}
			return $class;
		}
	}
endif;
if( !function_exists( 'slz_extra_is_wishlist_page') ) {
	/**
	 * Check if current page is wishlist
	 *
	 * @return bool
	 */
	function slz_extra_is_wishlist_page() {
		if( ! defined( 'YITH_WCWL' ) ) {
			return false;
		}
		$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
		if ( ! $wishlist_page_id ) {
			return false;
		}
		return is_page( $wishlist_page_id );
	}
}
if ( ! function_exists( 'slz_extra_get_post_id' ) ) :
function slz_extra_get_post_id(){
	$post_id = get_the_ID();
	$is_shop_page = false;
	if( class_exists( 'WooCommerce' ) ) {
		if( is_shop() ) {
			$post_id = get_option('woocommerce_shop_page_id');
			$is_shop_page = true;
		} else if( is_cart() ) {
			$post_id = get_option('woocommerce_cart_page_id');
			$is_shop_page = true;
		} else if( is_account_page() ) {
			$post_id = get_option('woocommerce_myaccount_page_id');
			$is_shop_page = true;
		} else if( is_checkout() || is_checkout_pay_page() ) {
			$post_id = get_option('woocommerce_checkout_page_id');
			$is_shop_page = true;
		} else if( slz_extra_is_wishlist_page() ) {
			$is_shop_page = true;
		}
	}
	return array($post_id, $is_shop_page);
}
endif;
// Get css to show/hide sidebar
if ( ! function_exists( 'slz_extra_get_container_class' ) ) :
	function slz_extra_get_container_class( $template = '', &$instance = array(), $is_taxonomy = false ) {
		//default
		if( empty($instance) ) {
			$instance = array(
				'show_sidebar'          => false,
				'sidebar'               => slz()->theme->manifest->get('sidebar_name'),
				'sidebar_layout_class'  => '',
				'sidebar_class'         => '',
				'content_class'         => '',
				'sidebar_layout'        => 'left',
				'block_class'           => 'slz-column-1',
			);
		}
		extract($instance);
		$default = $sidebar;
		$key = 'main-blog-sidebar';
		$layout = 'main-blog-sidebar-layout';
		
		$posttype = get_post_type();
		list($post_id, $is_shop_page) = slz_extra_get_post_id();

		// check DB
		$page_sidebar = 'page-sidebar';
		if( $posttype == 'post' ){
			$page_sidebar = 'post-sidebar';
		}
		$page_option_layout = '';
		$term_setting = array();
		if( is_page() || is_single() || $is_shop_page || $is_taxonomy ) {
			$page_option = slz_get_db_post_option( $post_id, $page_sidebar, '' );
			$page_option_layout = slz_get_db_post_option( $post_id, $page_sidebar . '-layout', '' );
			
			if ( $page_option_layout != '' && $page_option_layout != 'default' ) {
				$sidebar_layout = $page_option_layout;
				if ( $page_option != '' && $page_option != 'default' ) {
					$sidebar = $page_option;
				}
			}
		}
		if ( !($page_option_layout != '' && $page_option_layout != 'default') ) {
			$mapping = slz()->theme->get_config('sidebar_mapping');
			if( is_single() ) {
				if( !empty($mapping[$posttype]) ) {
					$key = $mapping[$posttype];
				}
			} else if( is_page() ) {
				$key = 'page-sidebar';
			} else if( is_search() ) {
				$key = 'search-sidebar';
			} else if( is_category() ) {
				$key = 'category-sidebar';
				$term_setting = slz_extra_get_taxonomy_layout( $key );
			} else if( is_tag() ) {
				$key = 'tag-sidebar';
			} else if( is_author() ) {
				$key = 'author-sidebar';
			} else if( is_archive() ) {
				if( (is_post_type_archive() || is_tax() ) && !empty($mapping['archive_' . $posttype ]) ){
					$key = $mapping['archive_' . $posttype ];
				}else {
					$key = 'archive-sidebar';
				}
			}
			if( $key ) {
				$layout = $key . '-layout';
				$sidebar = slz_get_db_settings_option( $key, $default );
			}
			$sidebar_layout = slz_get_db_settings_option( $layout, 'left' );
			if( $term_setting ) {
				// check taxonomy option
				$sidebar = $term_setting['sidebar'];
				$sidebar_layout = $term_setting['sidebar_layout'];
			}
		}
		if ( $template && slz_get_db_settings_option($template, '') == 'article_03' ) {
			$block_class = 'slz-column-2';
		}
		if( empty($sidebar) ) {
			$sidebar = $default;
		}
		$instance = array(
			'sidebar_layout'        => $sidebar_layout,
			'sidebar'               => $sidebar,
			'block_class'           => $block_class,
		);
		// layout
		if ( $sidebar_layout != 'none' ) {
			$sidebar_layout_class = 'slz-sidebar-' . $sidebar_layout;
			$content_class = 'col-md-9 col-sm-12';
			$sidebar_class = 'col-md-3 col-sm-12';
			$show_sidebar = true;
		}else{
			$content_class = 'col-md-12 col-sm-12';
		}
		if ( empty ( $sidebar ) ) {
			$sidebar = $default;
		}
		return array(
			'show_sidebar'          => $show_sidebar,
			'sidebar_layout_class'  => $sidebar_layout_class,
			'sidebar_class'         => $sidebar_class,
			'content_class'         => $content_class,
			'sidebar_layout'        => $sidebar_layout,
			'sidebar'               => $sidebar,
			'block_class'           => $block_class,
		);
	}
endif;

// get pagenum link for ajax pagination
if( ! function_exists( 'slz_extra_get_pagenum_link' ) ) :
	function slz_extra_get_pagenum_link( $pagenum = 1, $base = null, $escape = true ) {
		global $wp_rewrite;
	
		$pagenum = (int) $pagenum;
	
		$request = $base ? remove_query_arg( 'paged', $base ) : remove_query_arg( 'paged' );
	
		$home_root = parse_url(home_url());
		$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
		$home_root = preg_quote( $home_root, '|' );
	
		$request = preg_replace('|^'. $home_root . '|i', '', $request);
		$request = preg_replace('|^/+|', '', $request);
		
		$qs_regex = '|\?.*?$|';
		preg_match( $qs_regex, $request, $qs_match );

		if ( !empty( $qs_match[0] ) ) {
			$query_string = $qs_match[0];
			$request = preg_replace( $qs_regex, '', $request );
		} else {
			$query_string = '';
		}

		$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
		$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
		$request = ltrim($request, '/');

		$base = trailingslashit( home_url() );

		if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
			$base .= $wp_rewrite->index . '/';

		if ( $pagenum > 1 ) {
			$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
		}

		$result = $base . $request . $query_string;
	
		/**
		 * Filter the page number link for the current request.
		 *
		 * @since 2.5.0
		 *
		 * @param string $result The page number link.
		 */
		$result = apply_filters( 'get_pagenum_link', $result );
	
		if ( $escape )
			return esc_url( $result );
		else
			return esc_url_raw( $result );
	}
endif;

//add submenu page
if( ! function_exists( 'slz_extra_add_menu_page' ) ) :
	function slz_extra_add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null)
	{
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
	}
endif;

if( ! function_exists( 'slz_extra_add_submenu_page' ) ) :
	function slz_extra_add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '')
	{
		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	}
endif;

if( ! function_exists( 'slz_extra_get_revolution_slider' ) ) :
	function slz_extra_get_revolution_slider()
	{
		global $wpdb;
		$revolution_sliders = array( '' => esc_html('No Slider', 'goahead') );
		if( defined( 'RS_PLUGIN_PATH' ) ) {
			$db_revslider = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'revslider_sliders %', '')  );
			if ( $db_revslider ) {
				foreach ( $db_revslider as $slider ) {
					$revolution_sliders[$slider->alias] = $slider->title;
				}
			}
		}
		return $revolution_sliders;
	}
endif;

/*show slider*/
if ( ! function_exists( 'slz_extra_show_slider' ) ) : 
	function slz_extra_show_slider( &$show_slider = false ) {
		$post_id = get_the_ID();
		if( defined( 'RS_PLUGIN_PATH' ) ) {
			if( $post_id ) {
				$slider = slz_get_db_post_option( $post_id , 'page-slider', '' );
				if ( !empty( $slider ) ){
					global $wpdb;
					$sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'revslider_sliders WHERE alias=%s', $slider);
					$db_revslider = $wpdb->get_results( $sql );
					if ( $db_revslider ) {
						$show_slider = true;
						echo do_shortcode( '[rev_slider_vc alias="'.$slider.'"]' );
					}
				}
			}
		}
	}
endif;
//get social share
if ( ! function_exists( 'slz_extra_get_social_share' ) ) :
	function slz_extra_get_social_share( $post_key = 'social-in-post', $echo = false, $args = array()) {
	
		$options = slz_get_db_settings_option($post_key, '');
		$show_social =  slz_akg( 'enable-social-share', $options, '' );

		if($show_social != 'enable'){
			return;
		}
		$social_enable  = slz_akg( 'enable/social-share-info', $options, array() );
		$share_format ='<a href="%1$s" class="link %3$s" target="_blank">%2$s</a>';
		$obj = new SLZ_Social_Sharing();
		$share_link = $obj->renders( $social_enable, false, $share_format);
		
		if( $share_link ){
			$share_text = esc_html__('Share to ','slz');
			if( isset( $args['share_text'] ) && !empty( $args['share_text'] ) ){
				$share_text = $args['share_text'];
			}
			$out = '<div class="slz-social-share">
				<span class="title">'. esc_html( $share_text ).'</span>
				<div class="social">'. wp_kses_post( $share_link ) .'</div>
			</div>';
			if( $echo ) {
				return $out;
			}
			echo $out;
		}// has share links
	}
endif;


if(  !function_exists('slz_extra_get_count_social_share') ) {
	function slz_extra_get_count_social_share() {
		$post_key = 'social-in-post';
		$options = slz_get_db_settings_option($post_key, '');
		$show_social =  slz_akg( 'enable-social-share', $options, '' );
		if($show_social != 'enable'){
			return;
		}

		$show_count = slz_akg( 'enable/social-share-count/enable-social-share-count', $options, '' );
		if( $show_count != 'enable' ) {
			return;
		}

		$social_enable  = slz_akg( 'enable/social-share-info', $options, array() );
		if( empty( $social_enable ) ) {
			return;
		}

		$total = 0;
		$url = get_permalink();		
		$obj = new SLZ_Social_Sharing();

		if( in_array( 'facebook', $social_enable ) ){
			$fb_appid     = slz_akg( 'enable/social-share-count/enable/social-share-facebook-appid',
									$options, '' );
			$fb_secet_key = slz_akg( 'enable/social-share-count/enable/social-share-facebook-secret-key',
									$options, '' );
			$total += $obj->get_facebook_share_count( $url, $fb_appid, $fb_secet_key );

		}
		if( in_array( 'twitter', $social_enable ) ){
			$total += $obj->get_tweets_share_count($url);
		}
		if( in_array( 'google-plus', $social_enable ) ){
			$total += $obj->get_googleplus_share_count($url);
		}
		if( in_array( 'pinterest', $social_enable ) ){
			$total += $obj->get_pinterest_share_count($url);
		}
		if( in_array( 'linkedin', $social_enable ) ){
			$total += $obj->get_linkedin_share_count($url);
		}
		
		echo '<div class="post-detail-share-count">'. esc_html( $total ) .'</div>';
	}
}

if( !function_exists('slz_is_theme_share_on') ) {
	function slz_is_theme_share_on() {
		$options = slz_get_db_settings_option('social-in-post', '');
		$show_social = slz_akg( 'enable-social-share', $options, '' );
		if($show_social == 'enable'){
			$show_count  = slz_akg( 'enable/social-share-count/enable-social-share-count', $options, '' );
			if( $show_count == 'enable' ) {
				return true;
			}
		}
		return false;
	}
}


if ( !function_exists('slz_is_maintenance_on')) {

	function slz_is_maintenance_on(){

		if (function_exists('mt_get_plugin_options') && !is_user_logged_in())
		{
			$mt_options = mt_get_plugin_options(true);

			if ($mt_options['state'])
			{
				if (!empty($mt_options['expiry_date_start'])
						&& !empty($mt_options['expiry_date_end'])
						) {
							$current_time = strtotime(current_time('mysql', 1));
							$start        = strtotime($mt_options['expiry_date_start']);
							$end          = strtotime($mt_options['expiry_date_end']);

							if ($current_time < $start
									|| ($current_time >= $end && !empty($mt_options['is_down']))
									) {
										return false;
									}
						}

						return true;
			}

			return true;
		}
	}

}

if( !function_exists( 'slz_get_currency_format_options' ) ) :
	function slz_get_currency_format_options( $money ) {
		$out = '';
		$currency = slz_get_db_settings_option( 'currency-money-format', '$' );
		$position = slz_get_db_settings_option( 'currency-position', 'left' );
		switch ($position) {
			case 'left':
				$out .= $currency. number_format( $money );
			break;
			
			case 'right':
				$out .= number_format( $money ) .$currency;
			break;

			case 'left-with-space':
				$out .= $currency. ' ' .number_format( $money );
			break;
			
			case 'right-with-space':
				$out .= number_format( $money ). ' ' .$currency;
			break;
			
			default:
				$out .= $currency.number_format( $money );
			break;
		}
		return $out;
	}
endif;

if( !function_exists('slz_get_live_setting') ) :
	function slz_get_live_setting( $delete_option = false ) {
		$config_path =  WP_CONTENT_DIR . '/uploads/slz-live-setting/config.php';
		if( $delete_option ) {
			delete_option('slz_cfg_live_setting');
		}else{
			if( file_exists( $config_path ) ) {
				
				$cfg = array();
				
				if( $cfg =  get_option( 'slz_cfg_live_setting', '' ) ) {
				}else{
					require_once( $config_path );
					update_option( 'slz_cfg_live_setting', $cfg);
				}
				
				$obj = new SLZ_Live_Setting( $cfg );
				$obj->get_view();
			}else{
				delete_option('slz_cfg_live_setting');
			}
		}
	}
endif;