<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Headers_Loader
{
	/** @var SLZ_Header[] $headers */
	private static $headers = array();

	private static $disabled_headers = array();

	private static $extension_headers = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_headers']) &&
			is_array($data['disabled_headers'])
		) {
			self::$disabled_headers = array_fill_keys($data['disabled_headers'], true);
		}

		self::load_core_headers();
		self::load_extensions_headers();
		return self::$headers;
	}

	// Core headers are those located in the headers extension
	private static function load_core_headers()
	{
		$header_extension = slz_ext('headers');
		self::load_extension_headers($header_extension);
	}

	private static function load_extensions_headers()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() !== 'headers') {
				self::load_extension_headers($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_headers($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/headers';
			$customizations_locations['uris'][] = $uri. '/headers';
		}

		$path = $extension->get_path('/headers');
		$uri = $extension->get_uri('/headers');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_headers(
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

	private static function load_folder_headers($ext_name, $paths, $rewrites = array())
	{

		// if no header folder don't do any work
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

		foreach ($dirs as $header_path) {
			$header_dir = strtolower(basename($header_path));
			$header_tag = str_replace('-', '_', $header_dir);

			if (isset(self::$disabled_headers[$header_tag])) {
				continue;
			}

			if (isset(self::$extension_headers[$ext_name][$header_tag])) {
				continue;
			}

			if (isset(self::$headers[$header_tag])) {
				trigger_error(
					sprintf(
						__('header "%s" from %s was already defined at %s', 'slz'),
						$header_tag,
						$paths['path'] . '/' . $header_dir,
						self::$headers[$header_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			// header path & uri
			$header_data = array(
				'tag'  => $header_tag,
				'path' => $paths['path'] . '/' . $header_dir,
				'uri'  => $paths['uri']  . '/' . $header_dir
			);

			// header rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$header_rewrite_paths = $cleared_rewrite_paths;
				$header_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($header_rewrite_paths as $key => $rewrite_path) {
					$header_rewrite_paths[$key] .= '/' . $header_dir;
					$header_rewrite_uris[$key]  .= '/' . $header_dir;
				}
				$header_data['rewrite_paths'] = $header_rewrite_paths;
				$header_data['rewrite_uris']  = $header_rewrite_uris;
			}

			self::$extension_headers[$ext_name][$header_tag] = true;
			self::$headers[$header_tag] = self::load_header($header_data);
		}
	}

	private static function load_header($data)
	{
		$tag          = $data['tag'];
		$path         = $data['path'];
		$uri          = $data['uri'];
		$dir_name     = strtolower(basename($path));
		$class_file   = "$path/class-slz-header-$dir_name.php";
		$class_name   = '';
		
		$args = array(
			'tag'           => $tag,
			'path'          => $path,
			'uri'           => $uri,
			'rewrite_paths' => !empty($data['rewrite_paths']) ? $data['rewrite_paths'] : array(),
			'rewrite_uris'  => !empty($data['rewrite_uris'])  ? $data['rewrite_uris']  : array()
		);

		$custom_class_found = false;

		// try to find a custom class for the header
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Header_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found for header %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'SLZ_Header')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Header', 'slz'), $class_name),
					E_USER_WARNING
				);
			} else {
				$header_instance  = new $class_name($args);
				$custom_class_found  = true;
			}
		}

		if (!$custom_class_found) {
			$header_instance = new SLZ_Header($args);
		}

		return $header_instance;
	}
}
