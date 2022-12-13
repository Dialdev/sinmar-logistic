<?php

class SLZ_Minify_System {

	var $default_exclude = array();
	var $cache_location = '';
	var $css_tags = '', $js_tags = '', $js_tags_footer = '';
	var $base = '', $remove_from_base = '';
	var $blog_path = false;
	var $url_len_limit = 2000;
	var $minify_limit = 50;

	public function __construct( ) {

		$this->cache_location = slz_get_upload_directory('/slz-cache');

		$this->start();

		if ( !is_dir( $this->cache_location ) ) {

			mkdir($this->cache_location, 0777, true);

		}

	}

	function start(){

		if ( self::_is_loadable() ) {

			if ( slz_get_db_settings_option( 'css_status', 'disable' ) == 'enable' ) {
				add_action('wp_head', array($this, 'print_header_style'), 9);
				add_action('login_head', array($this, 'print_header_style'), 9);
				add_action('wp_print_footer_scripts', array($this, 'print_footer_style'), 10);
				add_action('admin_print_styles', array($this, 'print_header_style'), 9);
			}

			if ( slz_get_db_settings_option( 'js_status', 'disable' ) == 'enable' ) {
				add_action('wp_head', array($this, 'print_header_script'), 9);
				add_action('login_head', array($this, 'print_header_script'), 9);
				add_action('wp_print_footer_scripts', array($this, 'print_footer_script'), 10);
				add_action('admin_print_scripts', array($this, 'print_header_script'), 9);
				add_action('admin_print_footer_scripts', array($this, 'print_footer_script'), 10);
			}
			
		}
					
		if (false === strpos($_SERVER['REQUEST_URI'], 'wp-login.php')
			&& false === strpos($_SERVER['REQUEST_URI'], 'wp-signup.php'))
			add_action('template_redirect', array($this, 'add_conditional_hooks'), 8);
		else
			$this->add_conditional_hooks();

	}

	function add_conditional_hooks (){

		if ( self::_is_loadable() == false )
			return;

		if ( slz_get_db_settings_option( 'css_status', 'disable' ) == 'enable' ) {
			add_filter('print_styles_array', array($this, 'add_styles'), 999);
		}

		if ( slz_get_db_settings_option( 'js_status', 'disable' ) == 'enable' ) {
			add_filter('print_scripts_array', array($this, 'add_scripts'), 999);
		}

	}

	function add_styles($todo) {
		global $wp_styles;

		//FIX ME : Add exclude style in theme setting
		$exclude_styles = slz_get_db_settings_option( 'minify_exclude_styles', array() );

		$css_locations = array();
		$css_inline = array();
		
		$not_minify = array();
		$i=0;
		foreach ($todo as $handle) {
			$array = $wp_styles->registered[$handle];

			if ( $this->_is_done_by_wp ( $handle, 'style' ) )
				continue;

			if ( !empty ( $array->src ) ) {

				if ( in_array($handle, $exclude_styles) ) {

					$not_minify[$i]['handle'] = $handle;
					$not_minify[$i]['url'] = $array->src;
					$not_minify[$i]['media'] = $array->args;
					$this->_mark_as_done($handle, 'style');
					$i++;
					continue;

				}

				if (slz_get_db_settings_option( 'external_status', 'disable' ) != 'enable' && $this->is_external($array->src)) {
					$not_minify[$i]['handle'] = $handle;
					$not_minify[$i]['url'] = $array->src;
					$not_minify[$i]['media'] = $array->args;
					$this->_mark_as_done($handle, 'style');
					$i++;
					continue;
				}

				$skip = false;
				if ($skip) continue;

				$css_locations[] = $this->get_css_location($array->src);

				$this->_mark_as_done($handle, 'style');
			}

			if ( self::has_inline( $handle ) )
				$css_inline[] = $handle;
				
		}

		if( !empty( $not_minify ) ) {
			foreach ( $not_minify as $item ) {
				if( empty( $item ) ) {
					continue;
				}
				$this->css_tags .= "<link rel='stylesheet' id='". $item['handle'] ."'  href='". $item['url'] ."' type='text/css' media='". $item['media'] ."' />";
			}
		}
		
		if (count($css_locations) > 0) {
			$minify_urls = $this->build_minify_urls($css_locations, '.css');

			foreach ($minify_urls as $minify_url) {
				$this->css_tags .= "<link rel='stylesheet' href='$minify_url' type='text/css' media='screen' />";
			}

		}

		$this->print_inline_styles( $css_inline );

		return array();
	}

	function add_scripts($todo) {
		global $wp_scripts;

		$script_locations = $script_location_footer = $minify_urls_footer = array();

		$exclude_scripts = slz_get_db_settings_option( 'minify_exclude_scripts', array() );
		
		$not_minify = array();
		$extra_data = array();
		$i = 0;
		foreach ($todo as $handle) {
			$array = $wp_scripts->registered[$handle];

			if ( $this->_is_done_by_wp ( $handle, 'script' ) )
				continue;

			if( isset( $array->extra['data'] ) && !empty( $array->extra['data'] ) ){
				$extra_data[] = $array->extra['data'];
			}

			if ( !empty ( $array->src ) ) {

				if ( in_array($handle, $exclude_scripts) ) {
					$not_minify[$i]['src'] = $array->src;
					$this->_mark_as_done($handle, 'script');
					$i++;
					continue;

				}

				if (slz_get_db_settings_option( 'external_status', 'disable' ) != 'enable' && $this->is_external($array->src)) {
					$not_minify[$i]['src']  = $array->src;
					$this->_mark_as_done($handle, 'script');
					$i++;
					continue;
				}

				$skip = false;
				if ($skip) continue;

				if ( slz_get_db_settings_option( 'js_placement', 'header-footer' ) == 'header-footer' )  {
					if ( !empty ( $array->extra['group'] ) && $array->extra['group'] == 1 )
						$script_location_footer[$handle] = $this->get_js_location($array->src);
					else
						$script_locations[$handle] = $this->get_js_location($array->src);
				}
				else{
					$script_locations[$handle] = $this->get_js_location($array->src);
				}

				$this->_mark_as_done($handle, 'script');
			}
		}

		$minify_urls = $this->build_minify_urls($script_locations, '.js');

		if ($script_location_footer != array()) {
			$minify_urls_footer = $this->build_minify_urls($script_location_footer, '.js');
		}

		if( !empty( $extra_data ) ){
			foreach ($extra_data as $data) {
				$this->js_tags .= "<script type='text/javascript'> 
									// <![CDATA[
									$data
									// ]]>
									</script>". "\n";
			}
		}

		foreach ($minify_urls as $minify_url) {
			$this->js_tags .= "<script type=\"text/javascript\" src=\"$minify_url\"". (slz_get_db_settings_option('js_async_tag', 'disable') === 'enable' && slz_get_db_settings_option( 'js_placement', 'header-footer' ) !== 'footer' ? ' async' : '') ."></script>". "\n";
		}

		foreach ($minify_urls_footer as $minify_url) {
			$this->js_tags_footer .= "<script type='text/javascript' src='$minify_url'></script>". "\n";
		}

		if( !empty( $not_minify ) ) {
			foreach ( $not_minify as $item ) {
				if( empty( $item ) ) {
					continue;
				}
				$this->js_tags .= "<script type='text/javascript' src='".$item['src']."'></script>". "\n";
			}
		}

		return array();
		
	}

	private function _mark_as_done($handle, $type)
	{
		global $wp_scripts, $wp_styles;

		$media = 'script' == $type ? $wp_scripts : $wp_styles;

		$media->done[] = $handle;
	}

	private function _is_done_by_wp($handle, $type)
	{
		global $wp_scripts, $wp_styles;

		$media = 'script' == $type ? $wp_scripts : $wp_styles;

		if (in_array($handle, $media->done))
			return true;

		return false;
	}

	function print_inline_styles($handles)
	{
		global $wp_styles;

		foreach ($handles as $handle)
			$wp_styles->print_inline_style($handle);
	}

	private static function has_inline($handle)
	{
		global $wp_styles;

		if (isset($wp_styles->registered[$handle]->extra['after']))
			return true;

		return false;
	}

	private static function _is_loadable()
	{
		$allowed_in_admin = false;

		if (is_admin() && !$allowed_in_admin)
			return false;

		if (!did_action('template_redirect'))
			return true;

		if (!empty($_GET['geo_mashup_content'])
			&& 'render-map' == $_GET['geo_mashup_content'])
			return false;

		if (!empty($_GET['aec_page']))
			return false;

		if (defined('SPVERSION') && function_exists('sp_get_option'))
		{
			$sp_page = sp_get_option('sfpage');
			if (is_page($sp_page))
				return false;
		}

		if (slz_is_maintenance_on())
		{
			return false;
		}

		return true;

	}

	function print_header_style(){
		echo $this->css_tags . "\n";
		$this->css_tags = '';
	}

	function print_footer_style(){
		echo $this->css_tags . "\n";
		$this->css_tags = '';
	}


	function print_header_script(){
		echo $this->js_tags . "\n";
		$this->js_tags = '';
	}

	function print_footer_script(){
		echo $this->js_tags_footer . "\n";
		$this->js_tags_footer = '';
	}

	function get_css_location($src) {
		$css_path = $this->local_version($src);
		if ($this->is_external($css_path, false)) {
			$this->fetch_content($src, '.css');
			$location = $this->cache_location . '/' . md5($src) . '.css';
		} else {
			$location = $css_path;
		}

		return $location;
	}

	function local_version($url) {
		$site_url = trailingslashit(get_option('siteurl'));
		$url = str_replace($site_url, '', $url);
		$url = preg_replace('/\?.*/i', '', $url);
		return $url;
	}

	function is_external($url, $localize=true) {
		if ($localize) {
			$url = $this->local_version($url);
		}

		if (substr($url, 0, 4) != 'http' && substr($url, 0, 2) != '//'
			&& (substr($url, -3, 3) == '.js' || substr($url, -4, 4) == '.css')) {
			return false;
		} else {
			return true;
		}
	}

	function get_js_location($src) {

		$script_path = $this->local_version($src);
		if ($this->is_external($script_path, false)) {
			$this->fetch_content($src, '.js');
			$location = $this->cache_location . '/' . md5($src) . '.js';
		} else {
			$location = $script_path;
		}

		return $location;
	}

	function fetch_content($url, $type = '') {
		$cache_file = slz_get_upload_directory('/slz-cache/'.md5($url).$type);
		$content = '';
		if (file_exists($cache_file)) {
			$this->refetch_cache_if_expired($url, $cache_file);

			$fh = fopen($cache_file, 'r');
			if ($fh && filesize($cache_file) > 0) {
				$content = fread($fh, filesize($cache_file));
				fclose($fh);
			}
			else {
				$content = $this->fetch_and_cache($url, $cache_file);
			}
		}
		else {
			$content = $this->fetch_and_cache($url, $cache_file);
		}
		return $content;
	}

	function refetch_cache_if_expired($url, $cache_file) {
		$cache_file_mtime = filemtime($cache_file);
		if ((time() - $cache_file_mtime) > slz_get_db_settings_option('minify_cache_time', 3600)) {
			$this->fetch_and_cache($url, $cache_file);
		}
	}

	function fetch_and_cache($url, $cache_file) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_USERAGENT, 'Solazu Unyson Useragent');
		$content = curl_exec($ch);
		curl_close($ch);
		if ($content) {
			if (is_array($content)) {
				$content = implode($content);
			}

			$fh = fopen($cache_file, 'w');
			if ($fh) {
				fwrite($fh, $content);
				fclose($fh);
			}
			else {
			}

			return $content;
		}
		else {
			return '';
		}
	}

	function build_minify_urls($locations, $type) {
		$minify_url = slz_get_framework_directory_uri('/minify/?f=');
		$minify_url .= implode(',', $locations);
		$latest_modified = $this->get_latest_modified_time($locations);
		$minify_urls = $this->check_and_split_url($minify_url, $latest_modified);

		return $this->get_cached_minify_urls($minify_urls, $type);
	}

	function get_cached_minify_urls($urls, $type) {
		$cached_urls = array();
		foreach ($urls as $url) {
			$cache_file = slz_get_upload_directory('/slz-cache/'.md5($url).$type);
			if (file_exists($cache_file)) {
				$this->refetch_cache_if_expired($url, $cache_file);
	
				$fh = fopen($cache_file, 'r');
				if ($fh && filesize($cache_file) > 0) {
					$content = fread($fh, filesize($cache_file));
					fclose($fh);
				} else {
					$this->fetch_and_cache($url, $cache_file);
				}
			} else {
				$this->fetch_and_cache($url, $cache_file);
			}

			if (file_exists($cache_file)) {
				$cache_url = slz_get_upload_directory_uri() . '/slz-cache/'.md5($url).$type.'?m='.filemtime($cache_file);
				$cached_urls[] = $cache_url;
			}
			
		}
		return $cached_urls;
	}

	function check_and_split_url($url, $latest_modified = 0) {
		$url_chunk = explode('?f=', $url);
		$base_url = array_shift($url_chunk);
		$files = explode(',', array_shift($url_chunk));
		$num_files = sizeof($files);

		if ($this->url_needs_splitting($url, $files)) {
			$first_half = $this->check_and_split_url($base_url . '?f=' . implode(',', array_slice($files, 0, $num_files/2)), $latest_modified);
			$second_half = $this->check_and_split_url($base_url . '?f=' . implode(',', array_slice($files, $num_files/2)), $latest_modified);
			return array_merge( $first_half, $second_half );
		}
		else {
			$debug_string = '';

			$base = $this->get_base();
			if ($base != '') {
				$base_string = '&b='.$base;
			} else {
				$base_string = '';
			}

			$extra_string = '';

			$latest_modified_string = '&m='.$latest_modified;

			return array($base_url . '?f=' . implode(',', $files) . $debug_string . $base_string . $extra_string . $latest_modified_string);
		}
		
	}

	function get_latest_modified_time($locations = array()) {
		$latest_modified = 0;
		if (!empty($locations)) {
			$base_path = trailingslashit($_SERVER['DOCUMENT_ROOT']);
			$base_path .= trailingslashit($this->get_base());

			foreach ($locations as $location) {
				$path = $base_path.$location;
				if ( file_exists( $path ) ) {
					$mtime = filemtime($path);
					if ($latest_modified < $mtime) {
						$latest_modified = $mtime;
					}
				}
				
			}
		}
		return $latest_modified;
	}

	function get_base_from_siteurl() {
		$site_url = trailingslashit(get_option('siteurl'));
		return rtrim(preg_replace('/^https?:\/\/.*?\//', '', $site_url), '\\/');
	}

	function get_base() {
		return $this->get_base_from_siteurl();
	}

	function url_needs_splitting($url, $locations) {
		if ($url > $this->url_len_limit || count($locations) > $this->minify_limit) {
			return true;
		} else {
			return false;
		}
	}
}

$minify_system = new SLZ_Minify_System();