<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Articles_Loader
{
	/** @var SLZ_Article[] $articles */
	private static $articles = array();

	private static $disabled_articles = array();

	private static $extension_articles = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_articles']) &&
			is_array($data['disabled_articles'])
		) {
			self::$disabled_articles = array_fill_keys($data['disabled_articles'], true);
		}

		self::load_core_articles();
		self::load_extensions_articles();
		return self::$articles;
	}

	// Core articles are those located in the articles extension
	private static function load_core_articles()
	{
		$article_extension = slz_ext('articles');
		self::load_extension_articles($article_extension);
	}

	private static function load_extensions_articles()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() !== 'articles') {
				self::load_extension_articles($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_articles($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/articles';
			$customizations_locations['uris'][] = $uri. '/articles';
		}

		$path = $extension->get_path('/articles');
		$uri = $extension->get_uri('/articles');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_articles(
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

	private static function load_folder_articles($ext_name, $paths, $rewrites = array())
	{

		// if no article folder don't do any work
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

		foreach ($dirs as $article_path) {
			$article_dir = strtolower(basename($article_path));
			$article_tag = str_replace('-', '_', $article_dir);

			if (isset(self::$disabled_articles[$article_tag])) {
				continue;
			}

			if (isset(self::$extension_articles[$ext_name][$article_tag])) {
				continue;
			}

			if (isset(self::$articles[$article_tag])) {
				trigger_error(
					sprintf(
						__('article "%s" from %s was already defined at %s', 'slz'),
						$article_tag,
						$paths['path'] . '/' . $article_dir,
						self::$articles[$article_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			// article path & uri
			$article_data = array(
				'tag'  => $article_tag,
				'path' => $paths['path'] . '/' . $article_dir,
				'uri'  => $paths['uri']  . '/' . $article_dir
			);

			// article rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$article_rewrite_paths = $cleared_rewrite_paths;
				$article_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($article_rewrite_paths as $key => $rewrite_path) {
					$article_rewrite_paths[$key] .= '/' . $article_dir;
					$article_rewrite_uris[$key]  .= '/' . $article_dir;
				}
				$article_data['rewrite_paths'] = $article_rewrite_paths;
				$article_data['rewrite_uris']  = $article_rewrite_uris;
			}

			self::$extension_articles[$ext_name][$article_tag] = true;
			self::$articles[$article_tag] = self::load_article($article_data);
		}
	}

	private static function load_article($data)
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

		// try to find a custom class for the article
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Article_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found for article %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'SLZ_Article')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Article', 'slz'), $class_name),
					E_USER_WARNING
				);
			} else {
				$article_instance  = new $class_name($args);
				$custom_class_found  = true;
			}
		}

		if (!$custom_class_found) {
			$article_instance = new SLZ_Article($args);
		}

		return $article_instance;
	}
}
