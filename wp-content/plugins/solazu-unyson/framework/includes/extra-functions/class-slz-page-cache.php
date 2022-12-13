<?php

class SLZ_Page_Cache {

	var $wp_cache_link;
	var $wp_config_link;
	var $option;
	var $path;

	public function __construct( ) {

		$this->wp_cache_link = WP_CONTENT_DIR . '/advanced-cache.php';
		$this->wp_config_link = WP_CONTENT_DIR . '/cache-config.php';
		$this->option = get_option('slz_theme_settings_options:'. slz()->theme->manifest->get_id());
		$this->path = WP_CONTENT_DIR . '/uploads/slz-page-cache/';

		add_action( 'slz_settings_form_saved', array( &$this, 'settings_form_saved' ) );

		if ( slz_akg( 'cache_refresh_update_post', $this->option, array()) != array() ){
			add_action('wp_trash_post', array( &$this, 'when_update_post' ), 0);
			add_action('publish_post', array( &$this, 'when_update_post' ), 0);
			add_action('edit_post', array( &$this, 'when_update_post' ), 0);
			add_action('delete_post', array( &$this, 'when_update_post' ), 0);
			add_action('publish_phone', array( &$this, 'when_update_post' ), 0);
		}

		if ( slz_akg( 'cache_refresh_post_comment', $this->option, '') == true ) {
			add_action('trackback_post', array( &$this, 'when_comment' ), 99);
			add_action('pingback_post', array( &$this, 'when_comment' ), 99);
			add_action('comment_post', array( &$this, 'when_comment' ), 99);
			add_action('edit_comment', array( &$this, 'when_comment' ), 99);
			add_action('wp_set_comment_status', array( &$this, 'when_comment' ), 99, 2);
		}

		if ( slz_akg( 'cache_refresh_switch_theme', $this->option, false) != false ){
			add_action('switch_theme', array( &$this, 'clear_all_cache' ), 99); 
		}

		if ( slz_akg( 'cache_refresh_user_profile', $this->option, array()) != array() ){
			add_action('personal_options_update', array( &$this, 'clear_profile_cache' ), 99); 
			add_action('edit_user_profile_update', array( &$this, 'clear_profile_cache' ), 99); 
		}

		if ( slz_akg( 'cache_refresh_update_nav_menu', $this->option, false) != false ){
			add_action( 'wp_update_nav_menu', array( &$this, 'clear_all_cache' ) );
		}

		if ( get_option('slz-cache-admin-notices') )
			add_action( 'admin_notices', array( &$this, 'admin_notices' ) );

		if ( slz_akg( 'cache_flush_status/enable-page-cache-preload', $this->option, '') == 'enable' ) {

			add_action('wp_cache_gc', array( &$this, 'garbage_collection' ));

			$cache_scheduled_time = slz_akg( 'cache_flush_status/enable/cache_scheduler_time', $this->option, '');

			if ( empty ( $cache_scheduled_time ) ) {

				$cache_scheduled_time = '00:00';

			}

			wp_schedule_event( strtotime( $cache_scheduled_time ), slz_akg( 'cache_flush_status/enable/cache_scheduler_interval', $this->option, 'weekly'), 'wp_cache_gc' );
		}

		add_action( 'set_logged_in_cookie', array( &$this, 'check_login_action' ), 0, 5 );

		add_action( 'clear_auth_cookie', array( &$this, 'check_login_action' ), 0, 5 );
	}

	function garbage_collection(){
		$this->clear_all_cache();
	}

	function clear_profile_cache( $user_id ){

		$profile_option = slz_akg( 'cache_refresh_user_profile', $this->option, array() );

		$user = get_userdata( $user_id );

		if ( $profile_option != array() && is_object( $user ) ){

			if ( !empty ( $profile_option['author'] ) ) {

				$this->remove_cache ( get_author_posts_url($user_id, $user->data->user_nicename) );

			}
			
			if ( !empty ( $profile_option['post'] ) ) {
				
				$args = array(
					'author'        =>  $user_id,
					'orderby'       =>  'post_date',
					'order'         =>  'ASC',
					'posts_per_page' => 10000
					);

				$current_user_posts = get_posts( $args );

				foreach ($current_user_posts as $post) {
					$this->remove_cache ( get_permalink ( $post->ID ));
				}
			}
		}
	}

	function clear_all_cache( ) {

		$files = glob($this->path . '*');

		foreach($files as $file){

			if(is_file($file))

				unlink($file);

		}

	}

	function when_comment( $comment_id, $status = 'NA' ){
		$comment = get_comment($comment_id, ARRAY_A);

		$postid = $comment['comment_post_ID'];

		if ($postid > 0)  {

			$permalink = get_permalink( $postid );

			$this->remove_cache ( $permalink );

			return $postid;

		}
	}

	function when_update_post($post_id){

		$option = $this->option['cache_refresh_update_post'];

		if ( empty( $post_id ) )
			return;

		if ( !empty ( $option['post'] ) ) {

			$permalink = get_permalink( $post_id );

			$this->remove_cache( $permalink );

		}

		if ( !empty ( $option['front'] ) ) {
			$this->remove_cache ( get_home_url('/') );
			$this->remove_cache ( get_permalink( get_option( 'page_for_posts' ) ) );
		}

		if ( !empty ( $option['category'] ) ) {
			$post_categories = wp_get_post_categories( $post_id );

			foreach($post_categories as $c){
				$this->remove_cache ( get_category_link ( $c ) );
			}
		}
			
	}

	function remove_cache( $link ) {

		if ( empty ( $link ) )
			return;

		$link = str_replace(array('http://', 'https://'), array('', ''), $link);

		if ( file_exists( $this->path . md5( $link ) . '.php' ) ) {

			unlink( $this->path . md5( $link ) . '.php' );

		}

	}

	function admin_notices(){

		echo get_option('slz-cache-admin-notices');

		delete_option('slz-cache-admin-notices');

	}

	function settings_form_saved($old_value){
		$this->option = get_option('slz_theme_settings_options:'. slz()->theme->manifest->get_id());

		if ( ( slz_akg( 'page_cache_status', $old_value, 'disable' ) == 'disable' || slz_akg( 'page_cache_status', $old_value, 'disable' ) == '' ) && slz_akg( 'page_cache_status', $this->option, 'disable' ) == 'enable' ){
			$this->modify_wordpress_config_file();
			
		}

		if ( slz_akg( 'page_cache_status', $old_value, '' ) == 'enable' && slz_akg( 'page_cache_status', $this->option, '' ) == 'disable' ){
			$this->disable_cache();
		}

		if ( !$this->should_exit() )
			$this->modify_wordpress_config_file();
	}

	function disable_cache(){

		if ( file_exists( ABSPATH . 'wp-config.php') )

			$global_config_file = ABSPATH . 'wp-config.php';

		else

			$global_config_file = dirname(ABSPATH) . '/wp-config.php';

		$line = 'define(\'WP_CACHE\', true);';

		if ( strpos( file_get_contents( $global_config_file ), $line ) && ( !$this->is_writeable( $global_config_file ) || !$this->replace_line( 'define *\( *\'WP_CACHE\'', '//' . $line, $global_config_file ) ) ){

			update_option('slz-cache-admin-notices', "<div id=\"message\" class=\"updated fade\"><h3>" . __("Could not remove WP_CACHE define from $global_config_file. Please edit that file and remove the line containing the text 'WP_CACHE'. Then refresh this page.", 'slz') . "</h3></div>" );

		}

		if ( file_exists( $this->wp_cache_link ) )
			unlink($this->wp_cache_link);

		if ( file_exists( $this->wp_config_link ) )
			unlink($this->wp_config_link);
		
		$this->clear_all_cache();
	}

	function modify_wordpress_config_file() {

		$ret = true;

		if ( file_exists( ABSPATH . 'wp-config.php') )

			$global_config_file = ABSPATH . 'wp-config.php';

		else

			$global_config_file = dirname(ABSPATH) . '/wp-config.php';

		if ( !$this->is_writeable($this->wp_config_link) ) {
				
			update_option('slz-cache-admin-notices', "<div id=\"message\" class=\"updated fade\"><h3>" . __( 'Warning', 'slz' ) . "! <em>" . sprintf( __( 'Could not create and update config file. Please chmod wp-content as 777 permission.', 'slz' ) ) . "</em></h3></div>" );

			return false;
		}

		slz_aks ( 'cache_change_status', 'done', $this->option );

		$content = '<?php' . "\n" . '$slz_cache_option = ' . var_export( $this->option, true ) . '; ?>';

		$fp = @fopen( $this->wp_config_link, 'w' );
		if( $fp ) {
			fputs( $fp, $content );
			fclose( $fp );
		} else {
			$ret = false;
		}

		$line = 'define(\'WP_CACHE\', true);';

		if (!$this->is_writeable($global_config_file) || !$this->replace_line('define *\( *\'WP_CACHE\'', $line, $global_config_file) ) {
			if ( defined( 'WP_CACHE' ) && constant( 'WP_CACHE' ) == false ) {
				
				update_option('slz-cache-admin-notices', "<div id=\"message\" class=\"updated fade\">" . __( "<h3>WP_CACHE constant set to false</h3><p>Please edit your wp-config.php and add or edit the following line above the final require_once command:<br /><br /><code>define('WP_CACHE', true);</code></p>", 'slz' ) . "</div>" );

			} else {

				update_option('slz-cache-admin-notices', "<div id=\"message\" class=\"updated fade\">" . __( "<h3>Warning</h3><p>" . __( "<strong>Error: WP_CACHE is not enabled</strong> in your <code>wp-config.php</code> file and I couldn&#8217;t modify it.<p>" . sprintf( __( "Edit <code>%s</code> and add the following line:<br /> <code>define('WP_CACHE', true);</code><br />Otherwise, <strong>WP-Cache will not be executed</strong> by WordPress core. ", 'slz' ), $global_config_file ) . "</p>", 'slz' ) . "</p>", 'slz' ) . "</div>" );

			}
			return false;
		}

		$line = 'define( \'SLZ_Page_Cache_Home\', \'' . dirname( __FILE__ ) . '\' );';

		if ( !$this->is_writeable($global_config_file) || !$this->replace_line('define *\( *\'SLZ_Page_Cache_Home\'', $line, $global_config_file ) ) {
				
				update_option('slz-cache-admin-notices', "<div id=\"message\" class=\"updated fade\"><h3>" . __( 'Warning', 'slz' ) . "! <em>" . sprintf( __( 'Could not update %s!</em> SLZ_Page_Cache_Home must be set in config file.', 'slz' ), $global_config_file ) . "</h3></div>" );

				return false;
		}

		$file = $this->cache_content();

		$fp = @fopen( $this->wp_cache_link, 'w' );
		if( $fp ) {
			fputs( $fp, $file );
			fclose( $fp );
		} else {
			$ret = false;
		}

		if ( $ret == true ){
			update_option('slz-page-cache-status', 'complete');
			update_option('slz_theme_settings_options:'. slz()->theme->manifest->get_id(), $this->option);
		}

		return $ret;
	}

	function replace_line($old, $new, $my_file) {

		if ( @is_file( $my_file ) == false ) {
			return false;
		}
		if (!$this->is_writeable($my_file)) {
			echo "Error: file $my_file is not writable.\n";
			return false;
		}

		$found = false;
		$lines = file($my_file);
		foreach( (array)$lines as $line ) {
			if ( preg_match("/$old/", $line)) {
				$found = true;
				break;
			}
		}
		if ($found) {
			$fd = fopen($my_file, 'w');
			foreach( (array)$lines as $line ) {
				if ( !preg_match("/$old/", $line))
					fputs($fd, $line);
				else {
					fputs($fd, "$new //Added by Solazu Unyson Plugin\n");
				}
			}
			fclose($fd);
			return true;
		}
		$fd = fopen($my_file, 'w');
		$done = false;
		foreach( (array)$lines as $line ) {
			if ( $done || !preg_match('/^(if\ \(\ \!\ )?define|\$|\?>/', $line) ) {
				fputs($fd, $line);
			} else {
				fputs($fd, "$new //Added by Solazu Unyson Plugin\n");
				fputs($fd, $line);
				$done = true;
			}
		}
		fclose($fd);
		return true;
	}

	function is_writeable($path) {

		if ( $path{strlen( $path )-1}=='/' )

			return $this->is_writeable( $path.uniqid( mt_rand( ) ).'.tmp' );

		else if ( is_dir( $path ) )

			return $this->is_writeable( $path.'/'.uniqid( mt_rand( ) ).'.tmp' );

		$rm = file_exists( $path );

		$f = @fopen( $path, 'a' );

		if ( $f===false )

			return false;

		fclose( $f );

		if ( !$rm )

			unlink( $path );

		return true;
	}

	function should_exit(){

		if ( empty ( $this->option ) )
			return true;

		if ( slz_akg( 'page_cache_status', $this->option, 'disable' ) == 'disable' )
			return true;

		if ( slz_akg ( 'cache_change_status', $this->option, 'change' ) == 'change' )
			return false;

		if ( get_option('slz-page-cache-status') != 'complete'
			||
				!defined( 'WP_CACHE' ) 
			||
				WP_CACHE == false
			||
				!defined( 'SLZ_Page_Cache_Home' ) 
			||
				SLZ_Page_Cache_Home != dirname( __FILE__ )
			||
				!file_exists( $this->wp_cache_link )
			)
			return false;

		return true;
	}

	function check_login_action( $logged_in_cookie = false, $expire = ' ', $expiration = 0, $user_id = 0, $action = 'logged_out' ) {
		global $current_user;
		if ( isset( $current_user->ID ) && !$current_user->ID )
			$user_id = new WP_User( $user_id );
		else
			$user_id = $current_user;

		if ( is_string( $user_id->roles ) ) {
			$roles = array( $user_id->roles );
		} elseif ( !is_array( $user_id->roles ) || count( $user_id->roles ) <= 0 ) {
			return;
		} else {
			$roles = $user_id->roles;
		}

		$rejected_roles = slz_akg( 'reject_author_roles', $this->option, array() ) ;

		if ( 'logged_out' == $action ) {
			foreach ( $rejected_roles as $role => $role_value ) {
				if ( $role_value == true ) {
					$role_hash = md5( NONCE_KEY . $role );
					setcookie( 'slz_logged_' . $role_hash, $expire,
						time() - 31536000, COOKIEPATH, COOKIE_DOMAIN );
				}
			}
			return;
		}

		if ( 'logged_in' != $action )
			return;

		foreach ( $roles as $role ) {
			if ( isset( $rejected_roles[$role] ) && $rejected_roles[$role] == true ) {
				$role_hash = md5( NONCE_KEY . $role );
				setcookie( 'slz_logged_' . $role_hash, true, $expire,
					COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
			}
		}
	}

	function cache_content(){
		return base64_decode('PD9waHAgCmlmKCBkZWZpbmVkICggJ1dQX0NBQ0hFJyApICYmIFdQX0NBQ0hFID09IHRydWUgJiYgZGVmaW5lZCAoICdTTFpfUGFnZV9DYWNoZV9Ib21lJyApICYmIGZpbGVfZXhpc3RzKCBXUF9DT05URU5UX0RJUiAuICcvY2FjaGUtY29uZmlnLnBocCcgKSApewoJaW5jbHVkZV9vbmNlKCBXUF9DT05URU5UX0RJUiAuICcvY2FjaGUtY29uZmlnLnBocCcgKTsKCWluY2x1ZGVfb25jZSggU0xaX1BhZ2VfQ2FjaGVfSG9tZSAuICcvY2xhc3Mtc2x6LXBhZ2UtYnVmZmVyLnBocCcgKTsgCn0gCg==');
	}

}

new SLZ_Page_Cache();