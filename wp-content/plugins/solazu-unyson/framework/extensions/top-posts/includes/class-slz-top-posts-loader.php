<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Top_Posts_Loader
{
	/** @var SLZ_Top_Post[] $top_posts */
	private static $top_posts = array();

	private static $disabled_top_posts = array();

	private static $extension_top_posts = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_top_posts']) &&
			is_array($data['disabled_top_posts'])
		) {
			self::$disabled_top_posts = array_fill_keys($data['disabled_top_posts'], true);
		}

		self::load_core_top_posts();
		self::load_extensions_top_posts();
		return self::$top_posts;
	}

	// Coretop posts are those located in thetop posts extension
	private static function load_core_top_posts()
	{
		$top_post_extension = slz_ext('top-posts');
		//self::load_extension_top_posts($top_post_extension);
	}

	private static function load_extensions_top_posts()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() == 'top-posts') {
				self::load_extension_top_posts($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_top_posts($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/top-posts';
			$customizations_locations['uris'][] = $uri. '/top-posts';
		}

		$path = $extension->get_path('/top-posts');
		$uri = $extension->get_uri('/top-posts');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_top_posts(
				$ext_name,
				array(
					'path' => $path,
					'uri' => $uri,
				),
				$customizations_locations
			);

			if ($customizations_locations) {
				$path = array_pop($customizations_locations['paths']);
				$uri = array_pop($customizations_locations['uris']);
			}
		} while($customizations_locations);
	}

	private static function load_folder_top_posts($ext_name, $paths, $rewrites = array())
	{

		// if notop post folder don't do any work
		if (!file_exists($paths['path'])) {
			return;
		}

		if (class_exists('SLZ_File_Cache')) {
			try {
				$dirs = SLZ_File_Cache::get($cache_key = 'ext:shcd:ld:'. $ext_name .':'. $paths['path']);
			} catch (SLZ_File_Cache_Not_Found_Exception $e) {
				$dirs = glob($paths['path'] .'/*', GLOB_ONLYDIR);

				SLZ_File_Cache::set($cache_key, $dirs);
			}
		} else {
			$dirs = glob($paths['path'] .'/*', GLOB_ONLYDIR);
		}

		if (empty($dirs)) {
			return;
		}

		// clean rewrite paths because it may contain nulls
		if (isset($rewrites['paths'])) {
			$cleared_rewrite_paths = array();
			$cleared_rewrite_uris  = array();
			foreach ($rewrites['paths'] as $key => $rewrite_path) {
				if ($rewrite_path && file_exists($rewrite_path)) {
					$cleared_rewrite_paths[] = $rewrites['paths'][$key];
					$cleared_rewrite_uris[]  = $rewrites['uris'][$key];
				}
			}
		}

		foreach ($dirs as $top_post_path) {
			$top_post_dir = strtolower(basename($top_post_path));
			$top_post_tag = str_replace('-', '_', $top_post_dir);

			if (isset(self::$disabled_top_posts[$top_post_tag])) {
				continue;
			}

			if (isset(self::$extension_top_posts[$ext_name][$top_post_tag])) {
				continue;
			}

			if (isset(self::$top_posts[$top_post_tag])) {
				trigger_error(
					sprintf(
						__('article "%s" from %s was already defined at %s', 'slz'),
						$top_post_tag,
						$paths['path'] . '/' . $top_post_dir,
						self::$top_posts[$top_post_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			//top post path & uri
			$top_post_data = array(
				'tag'  => $top_post_tag,
				'path' => $paths['path'] . '/' . $top_post_dir,
				'uri'  => $paths['uri']  . '/' . $top_post_dir
			);

			//top post rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$top_post_rewrite_paths = $cleared_rewrite_paths;
				$top_post_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($top_post_rewrite_paths as $key => $rewrite_path) {
					$top_post_rewrite_paths[$key] .= '/' . $top_post_dir;
					$top_post_rewrite_uris[$key]  .= '/' . $top_post_dir;
				}
				$top_post_data['rewrite_paths'] = $top_post_rewrite_paths;
				$top_post_data['rewrite_uris']  = $top_post_rewrite_uris;
			}

			self::$extension_top_posts[$ext_name][$top_post_tag] = true;
			self::$top_posts[$top_post_tag] = self::load_top_post($top_post_data);
		}
	}

	private static function load_top_post($data)
	{
		$tag          = $data['tag'];
		$path         = $data['path'];
		$uri          = $data['uri'];
		$dir_name     = strtolower(basename($path));
		$class_file   = "$path/class-slz-article-$dir_name.php";
		$class_name   = '';
		
		$args = array(
			'tag'           => $tag,
			'path'          => $path,
			'uri'           => $uri,
			'rewrite_paths' => !empty($data['rewrite_paths']) ? $data['rewrite_paths'] : array(),
			'rewrite_uris'  => !empty($data['rewrite_uris'])  ? $data['rewrite_uris']  : array()
		);

		$custom_class_found = false;

		// try to find a custom class for thetop post
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Top_Post_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found fortop post %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'SLZ_Top_Post')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Top_Post', 'slz'), $class_name),
					E_USER_WARNING
				);
			} else {
				$top_post_instance  = new $class_name($args);
				$custom_class_found  = true;
			}
		}

		if (!$custom_class_found) {
			$top_post_instance = new SLZ_Top_Post($args);
		}

		$top_post_instance = new SLZ_Top_Post($args);

		return $top_post_instance;
	}
}
