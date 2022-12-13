<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Posts_Loader
{
	/** @var SLZ_Post[] $posts */
	private static $posts = array();

	private static $disabled_posts = array();

	private static $extension_posts = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_posts']) &&
			is_array($data['disabled_posts'])
		) {
			self::$disabled_posts = array_fill_keys($data['disabled_posts'], true);
		}

		self::load_core_posts();
		self::load_extensions_posts();
		return self::$posts;
	}

	// Core posts are those located in the posts extension
	private static function load_core_posts()
	{
		$post_extension = slz_ext('posts');
		self::load_extension_posts($post_extension);
	}

	private static function load_extensions_posts()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() !== 'posts') {
				self::load_extension_posts($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_posts($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/posts';
			$customizations_locations['uris'][] = $uri. '/posts';
		}

		$path = $extension->get_path('/posts');
		$uri = $extension->get_uri('/posts');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_posts(
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

	private static function load_folder_posts($ext_name, $paths, $rewrites = array())
	{

		// if no post folder don't do any work
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

		foreach ($dirs as $post_path) {
			$post_dir = strtolower(basename($post_path));
			$post_tag = str_replace('-', '_', $post_dir);

			if (isset(self::$disabled_posts[$post_tag])) {
				continue;
			}

			if (isset(self::$extension_posts[$ext_name][$post_tag])) {
				continue;
			}

			if (isset(self::$posts[$post_tag])) {
				trigger_error(
					sprintf(
						__('post "%s" from %s was already defined at %s', 'slz'),
						$post_tag,
						$paths['path'] . '/' . $post_dir,
						self::$posts[$post_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			// post path & uri
			$post_data = array(
				'tag'  => $post_tag,
				'path' => $paths['path'] . '/' . $post_dir,
				'uri'  => $paths['uri']  . '/' . $post_dir
			);

			// post rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$post_rewrite_paths = $cleared_rewrite_paths;
				$post_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($post_rewrite_paths as $key => $rewrite_path) {
					$post_rewrite_paths[$key] .= '/' . $post_dir;
					$post_rewrite_uris[$key]  .= '/' . $post_dir;
				}
				$post_data['rewrite_paths'] = $post_rewrite_paths;
				$post_data['rewrite_uris']  = $post_rewrite_uris;
			}

			self::$extension_posts[$ext_name][$post_tag] = true;
			self::$posts[$post_tag] = self::load_post($post_data);
		}
	}

	private static function load_post($data)
	{
		$tag          = $data['tag'];
		$path         = $data['path'];
		$uri          = $data['uri'];
		$dir_name     = strtolower(basename($path));
		$class_file   = "$path/class-slz-post-$dir_name.php";
		$class_name   = '';
		
		$args = array(
			'tag'           => $tag,
			'path'          => $path,
			'uri'           => $uri,
			'rewrite_paths' => !empty($data['rewrite_paths']) ? $data['rewrite_paths'] : array(),
			'rewrite_uris'  => !empty($data['rewrite_uris'])  ? $data['rewrite_uris']  : array()
		);

		$custom_class_found = false;

		// try to find a custom class for the post
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Post_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found for post %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'SLZ_Post')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Post', 'slz'), $class_name),
					E_USER_WARNING
				);
			} else {
				$post_instance  = new $class_name($args);
				$custom_class_found  = true;
			}
		}

		if (!$custom_class_found) {
			$post_instance = new SLZ_Post($args);
		}

		return $post_instance;
	}
}
