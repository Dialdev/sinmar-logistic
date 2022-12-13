<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Templates_Loader
{
	/** @var SLZ_Template[] $templates */
	private static $templates = array();

	private static $disabled_templates = array();

	private static $extension_templates = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_templates']) &&
			is_array($data['disabled_templates'])
		) {
			self::$disabled_templates = array_fill_keys($data['disabled_templates'], true);
		}

		self::load_core_templates();
		self::load_extensions_templates();
		return self::$templates;
	}

	// Core templates are those located in the templates extension
	private static function load_core_templates()
	{
		$template_extension = slz_ext('templates');
		self::load_extension_templates($template_extension);
	}

	private static function load_extensions_templates()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() !== 'templates') {
				self::load_extension_templates($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_templates($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/templates';
			$customizations_locations['uris'][] = $uri. '/templates';
		}

		$path = $extension->get_path('/templates');
		$uri = $extension->get_uri('/templates');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_templates(
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

	private static function load_folder_templates($ext_name, $paths, $rewrites = array())
	{

		// if no template folder don't do any work
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

		foreach ($dirs as $template_path) {
			$template_dir = strtolower(basename($template_path));
			$template_tag = str_replace('-', '_', $template_dir);

			if (isset(self::$disabled_templates[$template_tag])) {
				continue;
			}

			if (isset(self::$extension_templates[$ext_name][$template_tag])) {
				continue;
			}

			if (isset(self::$templates[$template_tag])) {
				trigger_error(
					sprintf(
						__('template "%s" from %s was already defined at %s', 'slz'),
						$template_tag,
						$paths['path'] . '/' . $template_dir,
						self::$templates[$template_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			// template path & uri
			$template_data = array(
				'tag'  => $template_tag,
				'path' => $paths['path'] . '/' . $template_dir,
				'uri'  => $paths['uri']  . '/' . $template_dir
			);

			// template rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$template_rewrite_paths = $cleared_rewrite_paths;
				$template_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($template_rewrite_paths as $key => $rewrite_path) {
					$template_rewrite_paths[$key] .= '/' . $template_dir;
					$template_rewrite_uris[$key]  .= '/' . $template_dir;
				}
				$template_data['rewrite_paths'] = $template_rewrite_paths;
				$template_data['rewrite_uris']  = $template_rewrite_uris;
			}

			self::$extension_templates[$ext_name][$template_tag] = true;
			self::$templates[$template_tag] = self::load_template($template_data);
		}
	}

	private static function load_template($data)
	{
		$tag          = $data['tag'];
		$path         = $data['path'];
		$uri          = $data['uri'];
		$dir_name     = strtolower(basename($path));
		$class_file   = "$path/class-slz-template-$dir_name.php";
		$class_name   = '';
		
		$args = array(
			'tag'           => $tag,
			'path'          => $path,
			'uri'           => $uri,
			'rewrite_paths' => !empty($data['rewrite_paths']) ? $data['rewrite_paths'] : array(),
			'rewrite_uris'  => !empty($data['rewrite_uris'])  ? $data['rewrite_uris']  : array()
		);

		$custom_class_found = false;

		// try to find a custom class for the template
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Template_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found for template %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'SLZ_Template')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Template', 'slz'), $class_name),
					E_USER_WARNING
				);
			} else {
				$template_instance  = new $class_name($args);
				$custom_class_found  = true;
			}
		}

		if (!$custom_class_found) {
			$template_instance = new SLZ_Template($args);
		}

		return $template_instance;
	}
}
