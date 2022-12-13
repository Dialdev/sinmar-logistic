<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Shortcode
{
	private $tag;
	private $path;
	private $uri;
	private $rewrite_paths;
	private $rewrite_uris;
	private $options;
	private $config;

	final public function __construct($args)
	{
		$this->tag           = $args['tag'];
		$this->path          = $args['path'];
		$this->uri           = $args['uri'];
		$this->rewrite_paths = $args['rewrite_paths'];
		$this->rewrite_uris  = $args['rewrite_uris'];

		$this->_init();
	}

	protected function _init()
	{
	}

	/**
	 * Gets the shortcodes' tag (id)
	 * @return string
	 */
	final public function get_tag()
	{
		return $this->tag;
	}

	/**
	 * Gets the path at which the shortcode is located
	 * @param string $rel_path A string to append to the path like '/views/view.php'
	 * @return string
	 */
	final public function get_declared_path($rel_path = '')
	{
		return $this->path . $rel_path;
	}

	/**
	 * Gets the uri at which the shortcode is located
	 * @param string $rel_path A string to append to the uri like '/views/view.php'
	 * @return string
	 */
	final public function get_declared_URI($rel_path = '')
	{
		return $this->uri . $rel_path;
	}

	/**
	 * Searches the path first in child_theme (if activated), parent_theme and framework
	 *
	 * This allows to find overridden files like the view and static files
	 *
	 * @param $rel_path string A string to append to the path like '/views/view.php'
	 * @return string|bool The path if it was found or false otherwise
	 */
	final public function locate_path($rel_path = '')
	{
		if (class_exists('SLZ_File_Cache')) {
			try {
				return SLZ_File_Cache::get($cache_key = 'ext:shcd:'. $this->tag .':path:'. $rel_path);
			} catch (SLZ_File_Cache_Not_Found_Exception $e) {
				$result = false;
				foreach (array_merge($this->rewrite_paths, array($this->path)) as $path) {
					$actual_path = $path . $rel_path;
					if (file_exists($actual_path)) {
						$result = $actual_path;
						break;
					}
				}

				SLZ_File_Cache::set($cache_key, $result);

				return $result;
			}
		} else {
			foreach (array_merge($this->rewrite_paths, array($this->path)) as $path) {
				$actual_path = $path . $rel_path;
				if (file_exists($actual_path)) {
					return $actual_path;
				}
			}

			return false;
		}
	}

	/**
	 * @param string $append
	 * @return string
	 * @since 1.3.5
	 */
	public function get_uri($append = '') {
		return $this->uri . $append;
	}

	/**
	 * Searches the uri first in child_theme (if activated), parent_theme and framework
	 *
	 * This allows to find uris to overridden files like the view and static files
	 *
	 * @param $rel_path string A string to append to the path like '/views/view.php'
	 * @return string|bool The path if it was found or false otherwise
	 */
	final public function locate_URI($rel_path = '')
	{
		if (class_exists('SLZ_File_Cache')) {
			try {
				return SLZ_File_Cache::get( $cache_key = 'ext:shcd:' . $this->tag . ':uri:' . $rel_path );
			} catch ( SLZ_File_Cache_Not_Found_Exception $e ) {
				$result = false;
				$paths  = array_merge( $this->rewrite_paths, array( $this->path ) );
				$uris   = array_merge( $this->rewrite_uris, array( $this->uri ) );
				foreach ( $paths as $key => $path ) {
					$actual_path = $path . $rel_path;
					if ( file_exists( $actual_path ) ) {
						$result = $uris[ $key ] . $rel_path;
						break;
					}
				}

				SLZ_File_Cache::set( $cache_key, $result );

				return $result;
			}
		} else {
			$paths  = array_merge( $this->rewrite_paths, array( $this->path ) );
			$uris   = array_merge( $this->rewrite_uris, array( $this->uri ) );
			foreach ( $paths as $key => $path ) {
				$actual_path = $path . $rel_path;
				if ( file_exists( $actual_path ) ) {
					return $uris[ $key ] . $rel_path;
				}
			}

			return false;
		}
	}

	public function get_config($key = null)
	{
		if (!$this->config) {
			$theme_vars = $vars = array('cfg' => array());
			$config_path = $this->locate_path('/config.php');

			if ($config_path) {
				$vars = slz_get_variables_from_file($config_path, array('cfg' => null));
			}

			$theme_config_path = $this->locate_path('/theme-config.php');
			if ( $theme_config_path ) {
				$theme_vars = slz_get_variables_from_file($theme_config_path, array('cfg' => null));
			}

			$this->config = array_merge( $vars['cfg'], $theme_vars['cfg'] );
		}

		if (!is_array($this->config)) {
			return null;
		} else {
			return $key === null ? $this->config : slz_akg($key, $this->config);
		}
	}

	public function get_styles(){
		$styles = $this->get_config('styles');

		if ( !empty ( $styles ) ) {

			$disabled_style = apply_filters('slz_ext_shortcodes_' . $this->tag . '_disable_style', array());

			$disabled_style = array_fill_keys($disabled_style, true);

			foreach ($styles as $style_key => $style_value) {
				if ( isset ( $disabled_style[$style_value] ) )
					unset ( $styles [$style_key] );
			}

			return array_flip( $styles );

		}

		return array();
	}

	public function get_layouts(){
		$styles = $this->get_config('layouts');

		if ( !empty ( $styles ) ) {

			$disabled_style = apply_filters('slz_ext_shortcodes_' . $this->tag . '_disable_layout', array());

			$disabled_style = array_fill_keys($disabled_style, true);

			foreach ($styles as $style_key => $style_value) {
				if ( isset ( $disabled_style[$style_value] ) )
					unset ( $styles [$style_key] );
			}

			return array_flip( $styles );

		}

		return array();
	}

	public function get_style_options(){

		$styles = $this->get_styles();

		$results = array();

		foreach ($styles as $style_key => $style_value) {
			
			$options_path = $this->locate_path('/options/' . $style_value . '.php');

			if ( file_exists( $options_path ) ) {

				$vars = slz_get_variables_from_file($options_path, array('vc_options' => null));

				if ( !empty ( $vars['vc_options']) && is_array( $vars['vc_options'] ) ) {

					foreach ($vars['vc_options'] as $option_key => $option_value) {
						
						if ( !isset( $vars['vc_options'][$option_key]['dependency'] ) ) {
							$vars['vc_options'][$option_key]['dependency'] = array(
								'element' => 'style',
								'value'   => array( $style_value ),
							);
						}

					}

					$results = array_merge( $results, $vars['vc_options'] );
				}

			}
		}

		return $results;
	}

	public function get_layout_options(){
	
		$styles = $this->get_layouts();
	
		$results = array();
	
		foreach ($styles as $style_key => $style_value) {
				
			$options_path = $this->locate_path('/options/' . $style_value . '.php');
	
			if ( file_exists( $options_path ) ) {
	
				$vars = slz_get_variables_from_file($options_path, array('vc_options' => null));
	
				if ( !empty ( $vars['vc_options']) && is_array( $vars['vc_options'] ) ) {
					$vc_options['vc_options'] = array();
					foreach ($vars['vc_options'] as $option_key => $option_value) {
						$is_dependency = true;
						foreach($results as $key => $item) {
							// check param_name exists
							if($item['param_name'] == $vars['vc_options'][$option_key]['param_name']){
								if( !isset( $vars['vc_options'][$option_key]['dependency'] ) ) {
									$results[$key]['dependency']['value'][] = $style_value;
								}
								$is_dependency = false;
								break;
							}
						}
						if( $is_dependency ) {
							if ( !isset( $vars['vc_options'][$option_key]['dependency'] ) ) {
								// dependency not exists
								if( $is_dependency ){
									$vars['vc_options'][$option_key]['dependency'] = array(
										'element' => 'layout',
										'value'   => array( $style_value),
									);
									$vc_options['vc_options'][] = $vars['vc_options'][$option_key];
								}
							} else {
								//dependency exists
								$vc_options['vc_options'][] = $vars['vc_options'][$option_key];
							}
						}
					}
					$results = array_merge( $results, $vc_options['vc_options'] );
				}
			}
		}
		return $results;
	}

	public function get_options()
	{
		if (!$this->options) {
			$options_path = $this->locate_path('/options.php');
			if ($options_path) {
				$vars = slz_get_variables_from_file($options_path, array('options' => null));
				$this->options = $vars['options'];
			}
		}
		return apply_filters('slz_shortcode_get_options', $this->options, $this->tag);
	}

	/**
	 * Used as an public alias method of enqueue_static
	 */
	public function _enqueue_static() {
		$this->enqueue_static();
	}

	/**
	 * @param $atts
	 * @param null $content
	 * @param string $tag deprecated
	 * @return string
	 */
	final public function render($atts, $content = null, $tag = '', $ajax = false)
	{
		if (empty($atts)) {
			$atts = array();
		} else {
			if (version_compare(slz_ext('shortcodes')->manifest->get_version(), '1.3.0', '>=')) {
				/**
				 * @var WP_Post $post
				 */
				global $post;

				$atts = slz_ext_shortcodes_decode_attr($atts, $this->tag,
					/**
					 * This was required, but sometimes the shortcode is rendered manually from code and
					 * very often is used PageBuilder encoder which doesn't require/need post id
					 */
					$post ? $post->ID : 0
				);

				if (is_wp_error($atts)) {
					return '<p>Shortcode attributes decode error: ' . $atts->get_error_message() . '</p>';
				}
			} else {
				/**
				 * @deprecated Since Shortcodes 1.3.0
				 */
				$atts = apply_filters('slz_shortcode_atts', $atts, $content, $this->tag);
			}
		}

		return $this->_render($atts, $content, '', $ajax);
	}

	/**
	 * @param $atts
	 * @param null $content
	 * @param string $tag deprecated
	 * @return string
	 */
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
		$view_file = $this->locate_path('/views/view.php');
		if (!$view_file) {
			trigger_error(
				sprintf(__('No default view (views/view.php) found for shortcode: %s', 'slz'), $this->tag),
				E_USER_ERROR
			);
		}

		$this->enqueue_static();

		$view_extra = apply_filters('slz_shortcode_render_view', array(
			'before' => '',
			'after' => '',
		), $atts, $this->tag);

		return
			$view_extra['before'] .
			slz_render_view($view_file, array(
				'atts'    => apply_filters('slz_shortcode_render_view:atts', $atts, $this->tag),
				'content' => $content,
				'tag'     => $this->tag
			)) .
			$view_extra['after'];
	}

	protected function enqueue_static()
	{
		$static_file = $this->locate_path('/static.php');
		if ($static_file) {
			slz_include_file_isolated($static_file);
		}
		$theme_static_file = $this->locate_path('/theme-static.php');
		if ($theme_static_file) {
			slz_include_file_isolated($theme_static_file);
		}
	}

	public function get_data( $args ){
		if( ! $args ) {
			$args = array();
		}

		$defaults = $this->get_config('default_value');

		$args = shortcode_atts( $defaults, $args );
		
		//get image size
		$image_size = $this->get_config('image_size');
		
		if( isset($args['layout']) && !empty($image_size[$args['layout']])) {
			$image_size = $image_size[$args['layout']];
		} else if( !empty($image_size['default'])) {
			$image_size = $image_size['default'];
		}
		$args['thumb-size'] = SLZ_Util::get_thumb_size( $image_size, $args );

		$args['title_length'] = $this->get_config('title_length');

		if( !isset( $args['excerpt_length'] ) && empty( $args['excerpt_length'] ) ) {
			$args['excerpt_length'] = $this->get_config('excerpt_length');
		}else{
			if( $args['excerpt_length'] == 'full' ) {
				$args['excerpt_length'] = '';
			}
		}

		return $args;
	}

	public function get_icon_library_options( $dependency = array(), $group = '', $suffix_name = '' ,$args = array()){
		$results = array();
		$icon_library = SLZ_Params::font_icon_library();
		if( empty( $icon_library ) ){
			return $results;
		}
		if( empty($args['label']) ){
			$args['label'] = esc_html__( 'Icon library', 'slz' );
		}
		$library_options = array(
			'type'        => 'dropdown',
			'heading'     => $args['label'],
			'value'       => $icon_library,
			'admin_label' => true,
			'param_name'  => 'icon_library' . $suffix_name,
			'description' => esc_html__( 'Select icon library.', 'slz' )
		);
		if( !empty( $dependency ) ){
			$library_options['dependency'] = $dependency;
		}
		if( !empty( $group ) ){
			$library_options['group'] = $group;
		}
		$results[] = $library_options;

		foreach ($icon_library as $key => $value) {
			$type = $value;
			if( $value == 'vs' ){
				$type = 'fontawesome';
			}
			$result = array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'slz' ),
				'param_name'  => 'icon_' . $value . $suffix_name,
				'settings'    => array(
					'type'         => $type,
					'iconsPerPage' => 4000
				),
				'dependency'  => array(
					'element' => 'icon_library' . $suffix_name,
					'value'   => $value
				),
				'description' => esc_html__( 'Select icon from library.', 'slz' )
			);
			if( !empty( $group ) ){
				$result = array_merge( $result, array( 'group' => $group ) );
			}
			$results[] = $result;
		}
		
		return $results;
	}

	public function get_icon_library_views( $item = array(), $format = '', $suffix_name = '' ){
		$out = '';
		if( empty( $item ) ){
			return $out;
		}
		if( empty( $format ) ){
			$format = '<i class="%1$s"></i>';
		}
		$icon = 'vs';
		if( isset( $item['icon_library'.$suffix_name] ) && !empty( $item['icon_library'.$suffix_name] ) ){
			$icon = $item['icon_library'.$suffix_name].$suffix_name;
		}
		if ( isset( $item['icon_'.$icon] ) && !empty( $item['icon_'.$icon] ) ) {
			SLZ_Util::slz_icon_fonts_enqueue($item['icon_library'.$suffix_name] );
			$out = sprintf( $format, esc_attr( $item['icon_'.$icon] ) );
		}
		return $out;
	}
	
}
