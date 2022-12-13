<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Article
{
	private $tag;
	private $path;
	private $uri;
	private $rewrite_paths;
	private $rewrite_uris;
	private $config;
	private $options;

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
	 * Gets the articles' tag (id)
	 * @return string
	 */
	final public function get_tag()
	{
		return $this->tag;
	}

	/**
	 * Gets the path at which the article is located
	 * @param string $rel_path A string to append to the path like '/views/view.php'
	 * @return string
	 */
	final public function get_declared_path($rel_path = '')
	{
		return $this->path . $rel_path;
	}

	/**
	 * Gets the uri at which the article is located
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
				return SLZ_File_Cache::get($cache_key = 'ext:shcd:article-' . $this->tag .':path:'. $rel_path);
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
				return SLZ_File_Cache::get( $cache_key = 'ext:shcd:article-' . $this->tag . ':uri:' . $rel_path );
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
			$config_path = $this->locate_path('/config.php');
			if ($config_path) {
				$vars = slz_get_variables_from_file($config_path, array('cfg' => null));
				$this->config = $vars['cfg'];
			}
		}

		if (!is_array($this->config)) {
			return null;
		} else {
			return $key === null ? $this->config : slz_akg($key, $this->config);
		}
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
		return apply_filters('slz_article_get_options', $this->options, $this->tag);
	}

	/**
	 * Used as an public alias method of enqueue_static
	 */
	public function _enqueue_static() {
		$this->enqueue_static();
	}

	protected function enqueue_static()
	{
		$static_file = $this->locate_path('/static.php');
		if ($static_file) {
			slz_include_file_isolated($static_file);
		}
	}

	/**
	 * @return string
	 */
	final public function render( $post, $echo = true )
	{
		$view_file = $this->locate_path('/views/view.php');
		if (!$view_file) {
			trigger_error(
				sprintf(__('No default view (views/view.php) found for article: %s', 'slz'), $this->tag),
				E_USER_ERROR
			);
		}

		$this->enqueue_static();

		$view_extra = apply_filters('slz_article_render_view', array(
			'before' => '',
			'after' => '',
		), array(), $this->tag);

		$module = new SLZ_Block_Module( $post, $this->get_data() );

		$result = $view_extra['before'] .
				slz_render_view($view_file, compact( 'module' )) .
				$view_extra['after'];
		if( $echo ) {
			echo $result;
		} else {
			return $result;
		}
	}

	public function get_data( $args = null ){
		if( ! $args ) {
			$args = array();
		}

		$args['thumb-size'] = SLZ_Util::get_thumb_size( $this->get_config('image_size') );

		$args['title_length'] = $this->get_config('title_length');

		$args['excerpt_length'] = $this->get_config('excerpt_length');

		return $args;
	}
}
