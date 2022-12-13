<?php 

class SLZ_Page_Buffer{

	private static $cache_path;
	var $options;

	public function __construct( $options ) {

		$this->options = $options;

		add_action('init', array($this, 'pre_content'), 9999999);
		add_action('wp_footer', array($this, 'post_content'), 999999);

	}

	static function get_path(){

		if (is_null(self::$cache_path)) {

			self::$cache_path = WP_CONTENT_DIR . '/uploads/slz-page-cache/';

			if ( !is_dir(self::$cache_path) ){

				@mkdir( self::$cache_path );

			}
		}

		return self::$cache_path;
	}

	static function get_file(){

		$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		return self::get_path() . md5( $current_url ) . '.php';
	}

	function pre_content(){
		ob_start();
	}

	function post_content(){

		$execute = true;

		if ( $this->is_accept_query_string() ){
			$execute = true;
		}
		else{

			$reject_page_type = slz_array_get('reject_page_type', $this->options, array());

			foreach ($reject_page_type as $key => $value) {
				$function = 'is_' . $key;

				if ( function_exists( $function ) ) {
					if( call_user_func_array( $function, array() ) ) {
						$execute = false;
						break;
					}
				}
				
			}

			$reject_woo_page = slz_array_get('reject_woo_page', $this->options, array());
			$woo_page_ids = array(
				'account'  => get_option('woocommerce_myaccount_page_id'),
				'cart'     => get_option('woocommerce_cart_page_id'),
				'checkout' => get_option('woocommerce_checkout_page_id'),
				'shop'     => get_option('woocommerce_shop_page_id')
			);

			if( !empty( $reject_woo_page ) ){
				foreach( $reject_woo_page as $key => $val ){
					$page_id = intval( $woo_page_ids[$key] );
					if( ( $key == 'shop' && is_shop() ) || get_the_ID() == $page_id ){
						$execute = false;
						break;
					}
				}
			}

			if ( is_single( ) || is_page() ) {

				$reject_post_ids = slz_array_get('reject_post_ids', $this->options, '');

				if ( !empty ( $reject_post_ids ) ) {

					$post_ids = explode(',', $reject_post_ids);

					if ( in_array(get_the_ID(), $post_ids)){
						$execute = false;
					}

				}
			}
			
		}
		if ( $execute ) {

			if ( !file_exists( self::get_file() ) ) {

				$fp = fopen( self::get_file(), 'w' );

				$content = ob_get_contents();
				$content .= '</body></html>';

				if ( slz_array_get('cache_compress_content', $this->options, '') == true ) {
					if (!class_exists('Minify_HTML')) {
						if ( function_exists( 'slz_get_framework_directory' ) && file_exists( slz_get_framework_directory('/minify/lib/Minify/HTML.php') ) ){
							require_once(slz_get_framework_directory('/minify/lib/Minify/HTML.php'));
						}
					}

					if (class_exists('Minify_HTML')) {

						$content = Minify_HTML::minify($content);

					}
				}

				fwrite( $fp, $content );

				fclose( $fp );
				
			}

		}

		ob_end_flush( );
	}

	function is_accept_query_string(){
		$accept_qs = slz_array_get('accept_query_string', $this->options, array());
		foreach ( $_GET as $key => $value ) {
			if ( in_array( strtolower( $key ), $accept_qs ) )
				return true;
		}
		return false;
	}

}

class SLZ_Cache_Check{

	var $options;

	function __construct( $options ){
		$this->options = $options;
	}

	function is_logged_in() {
		foreach ( array_keys( $_COOKIE ) as $cookie_name ) {
			if ( strpos( $cookie_name, 'wordpress_logged_in' ) !== false )
				return true;
		}

		return false;
	}

	function is_logged_in_role_allowed() {

		$roles = slz_array_get('reject_author_roles', $this->options, array());

		if ( empty( $roles ) )
			return true;

		foreach ( array_keys( $_COOKIE ) as $cookie_name ) {
			foreach ( $roles as $role => $role_value ) {
				if( $role_value == true ) {
					if ( strstr( $cookie_name, md5( NONCE_KEY . $role ) ) ){
						return false;
					}
				}
			}
		}

		return true;
	}

	function is_rejected_cookies(){

		$cookies = slz_array_get('reject_user_cookies', $this->options, array());

		foreach ($cookies as $cookie) {
			if ( in_array($cookie, array_keys( $_COOKIE )))
				return true;
		}

		return false;

	}

	function user_agent_is_rejected() {

		$cache_rejected_user_agent = slz_array_get('reject_user_agents', $this->options, array());

		if (!function_exists('apache_request_headers')) 
			return false;

		$headers = apache_request_headers();

		if (!isset($headers["User-Agent"]))
			return false;

		if ( false == is_array( $cache_rejected_user_agent ) )
			return false;

		foreach ($cache_rejected_user_agent as $expr) {
			if (strlen($expr) > 0 && stristr($headers["User-Agent"], $expr))
				return true;
		}

		return false;
	}

	function is_accept_query_string(){
		$accept_qs = slz_array_get('accept_query_string', $this->options, array());
		foreach ( $_GET as $key => $value ) {
			if ( in_array( strtolower( $key ), $accept_qs ) )
				return true;
		}
		return false;
	}

}

if ( !function_exists('slz_array_get') ):
	function slz_array_get($keys, &$array_or_object, $default_value = null, $keys_delimiter = '/') {
		if (!is_array($keys)) {
			$keys = explode( $keys_delimiter, (string) $keys );
		}

		$key_or_property = array_shift($keys);
		if ($key_or_property === null) {
			return $default_value;
		}

		$is_object = is_object($array_or_object);

		if ($is_object) {
			if (!property_exists($array_or_object, $key_or_property)) {
				return $default_value;
			}
		} else {
			if (!is_array($array_or_object) || !array_key_exists($key_or_property, $array_or_object)) {
				return $default_value;
			}
		}

		if (isset($keys[0])) { // not used count() for performance reasons
			if ($is_object) {
				return slz_array_get($keys, $array_or_object->{$key_or_property}, $default_value);
			} else {
				return slz_array_get($keys, $array_or_object[$key_or_property], $default_value);
			}
		} else {
			if ($is_object) {
				return $array_or_object->{$key_or_property};
			} else {
				return $array_or_object[$key_or_property];
			}
		}
	}
endif;

if ( !function_exists('slz_set_cache') ):
	function slz_set_cache(){
		
		global $slz_cache_option;
		
		if ( empty ( $slz_cache_option ) )
			return;

		if ( slz_array_get( 'page_cache_status', $slz_cache_option, 'disable' ) == 'disable' )
			return;

		$check = new SLZ_Cache_Check( $slz_cache_option );

		if ( $check->is_logged_in( ) )
			return;

		if ( $check->user_agent_is_rejected() )
			return;

		if ( $check->is_rejected_cookies() ){
			return;
		}

		new SLZ_Page_Buffer($slz_cache_option);

	}
endif;

if ( !function_exists('slz_get_cache') ):
	function slz_get_cache(){
		
		global $slz_cache_option;
		
		if ( empty ( $slz_cache_option ) )
			return;

		if ( slz_array_get( 'page_cache_status', $slz_cache_option, 'disable' ) == 'disable' )
			return;

		$check = new SLZ_Cache_Check( $slz_cache_option );

		if ( !$check->is_logged_in_role_allowed( ) )
			return;

		if ( $check->user_agent_is_rejected() )
			return;

		$slz_cache_file = SLZ_Page_Buffer::get_file();

		if ( file_exists( $slz_cache_file ) ) {

			$cache_file_mtime = filemtime( $slz_cache_file );

			$is_time_out = false;

			$cache_time_out = slz_array_get( 'cache_flush_status/enable/page_cache_time', $slz_cache_option, 3600 );

			if (slz_array_get( 'cache_flush_status/enable-page-cache-preload', $slz_cache_option, '') == 'enable' && $cache_time_out != 0){

				if ( (time() - $cache_file_mtime ) > $cache_time_out ) {

					$is_time_out = true;

				}

			}

			if ( $is_time_out ) {
				
				@unlink( $slz_cache_file );

				slz_set_cache();

			}
			else {

				include ( $slz_cache_file );

				exit;

			}

		}
		else
			slz_set_cache();

	}
endif;

slz_get_cache();
?>