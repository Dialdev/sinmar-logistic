<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Footers_Loader
{
	/** @var SLZ_Footer[] $footers */
	private static $footers = array();

	private static $disabled_footers = array();

	private static $extension_footers = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_footers']) &&
			is_array($data['disabled_footers'])
		) {
			self::$disabled_footers = array_fill_keys($data['disabled_footers'], true);
		}

		self::load_core_footers();
		self::load_extensions_footers();
		return self::$footers;
	}

	// Core footers are those located in the footers extension
	private static function load_core_footers()
	{
		$footer_extension = slz_ext('footers');
		self::load_extension_footers($footer_extension);
	}

	private static function load_extensions_footers()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() !== 'footers') {
				self::load_extension_footers($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_footers($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/footers';
			$customizations_locations['uris'][] = $uri. '/footers';
		}

		$path = $extension->get_path('/footers');
		$uri = $extension->get_uri('/footers');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_footers(
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

	private static function load_folder_footers($ext_name, $paths, $rewrites = array())
	{

		// if no footer folder don't do any work
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

		foreach ($dirs as $footer_path) {
			$footer_dir = strtolower(basename($footer_path));
			$footer_tag = str_replace('-', '_', $footer_dir);

			if (isset(self::$disabled_footers[$footer_tag])) {
				continue;
			}

			if (isset(self::$extension_footers[$ext_name][$footer_tag])) {
				continue;
			}

			if (isset(self::$footers[$footer_tag])) {
				trigger_error(
					sprintf(
						__('footer "%s" from %s was already defined at %s', 'slz'),
						$footer_tag,
						$paths['path'] . '/' . $footer_dir,
						self::$footers[$footer_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			// footer path & uri
			$footer_data = array(
				'tag'  => $footer_tag,
				'path' => $paths['path'] . '/' . $footer_dir,
				'uri'  => $paths['uri']  . '/' . $footer_dir
			);

			// footer rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$footer_rewrite_paths = $cleared_rewrite_paths;
				$footer_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($footer_rewrite_paths as $key => $rewrite_path) {
					$footer_rewrite_paths[$key] .= '/' . $footer_dir;
					$footer_rewrite_uris[$key]  .= '/' . $footer_dir;
				}
				$footer_data['rewrite_paths'] = $footer_rewrite_paths;
				$footer_data['rewrite_uris']  = $footer_rewrite_uris;
			}

			self::$extension_footers[$ext_name][$footer_tag] = true;
			self::$footers[$footer_tag] = self::load_footer($footer_data);
		}
	}

	private static function load_footer($data)
	{
		$tag          = $data['tag'];
		$path         = $data['path'];
		$uri          = $data['uri'];
		$dir_name     = strtolower(basename($path));
		$class_file   = "$path/class-slz-footer-$dir_name.php";
		$class_name   = '';
		
		$args = array(
			'tag'           => $tag,
			'path'          => $path,
			'uri'           => $uri,
			'rewrite_paths' => !empty($data['rewrite_paths']) ? $data['rewrite_paths'] : array(),
			'rewrite_uris'  => !empty($data['rewrite_uris'])  ? $data['rewrite_uris']  : array()
		);

		$custom_class_found = false;

		// try to find a custom class for the footer
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Footer_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found for footer %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'SLZ_Footer')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Footer', 'slz'), $class_name),
					E_USER_WARNING
				);
			} else {
				$footer_instance  = new $class_name($args);
				$custom_class_found  = true;
			}
		}

		if (!$custom_class_found) {
			$footer_instance = new SLZ_Footer($args);
		}

		return $footer_instance;
	}
}
