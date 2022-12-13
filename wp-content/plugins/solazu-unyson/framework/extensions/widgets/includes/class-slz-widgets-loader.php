<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Widgets_Loader
{
	/** @var SLZ_Widget[] $widgets */
	private static $widgets = array();

	private static $disabled_widgets = array();

	private static $extension_widgets = array();

	public static function load($data)
	{
		if (
			isset($data['disabled_widgets']) &&
			is_array($data['disabled_widgets'])
		) {
			self::$disabled_widgets = array_fill_keys($data['disabled_widgets'], true);
		}

		self::load_core_widgets();
		self::load_extensions_widgets();
		return self::$widgets;
	}

	// Core widgets are those located in the widgets extension
	private static function load_core_widgets()
	{
		$widget_extension = slz_ext('widgets');
		self::load_extension_widgets($widget_extension);
	}

	private static function load_extensions_widgets()
	{
		foreach (slz()->extensions->get_all() as $extension) {
			if ($extension->get_name() !== 'widgets') {
				self::load_extension_widgets($extension);
			}
		}
	}

	/**
	 * @param SLZ_Extension $extension
	 */
	private static function load_extension_widgets($extension)
	{
		$ext_name = $extension->get_name();

		$customizations_locations = array(
			'paths' => array(),
			'uris' => array(),
		);

		foreach ($extension->get_customizations_locations() as $path => $uri) {
			$customizations_locations['paths'][] = $path. '/widgets';
			$customizations_locations['uris'][] = $uri. '/widgets';
		}

		$path = $extension->get_path('/widgets');
		$uri = $extension->get_uri('/widgets');

		do {
			if (empty($customizations_locations['paths'])) {
				$customizations_locations = array();
			}

			self::load_folder_widgets(
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

	private static function load_folder_widgets($ext_name, $paths, $rewrites = array())
	{

		// if no widget folder don't do any work
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

		foreach ($dirs as $widget_path) {
			$widget_dir = strtolower(basename($widget_path));
			$widget_tag = str_replace('-', '_', $widget_dir);

			if (isset(self::$disabled_widgets[$widget_tag])) {
				continue;
			}

			$class_file   = "$widget_path/class-slz-widget-$widget_dir.php";

			$class_name = '';

			if (file_exists($class_file)) {
				require_once $class_file;

				$class_name = explode('_', $widget_tag);
				$class_name = array_map('ucfirst', $class_name);
				$class_name = 'SLZ_Widget_' . implode('_', $class_name);

			}

			if (isset(self::$extension_widgets[$ext_name][$widget_tag])) {
				continue;
			}

			if (isset(self::$widgets[$widget_tag])) {
				trigger_error(
					sprintf(
						__('widget "%s" from %s was already defined at %s', 'slz'),
						$widget_tag,
						$paths['path'] . '/' . $widget_dir,
						self::$widgets[$widget_tag]->get_declared_path()
					),
					E_USER_WARNING
				);
				continue;
			}

			// widget path & uri
			$widget_data = array(
				'tag'  => $widget_tag,
				'path' => $paths['path'] . '/' . $widget_dir,
				'uri'  => $paths['uri']  . '/' . $widget_dir,
				'class'=> $class_name
			);

			// widget rewrite paths
			if (isset($cleared_rewrite_paths)) {
				$widget_rewrite_paths = $cleared_rewrite_paths;
				$widget_rewrite_uris  = $cleared_rewrite_uris;
				foreach ($widget_rewrite_paths as $key => $rewrite_path) {
					$widget_rewrite_paths[$key] .= '/' . $widget_dir;
					$widget_rewrite_uris[$key]  .= '/' . $widget_dir;
				}
				$widget_data['rewrite_paths'] = $widget_rewrite_paths;
				$widget_data['rewrite_uris']  = $widget_rewrite_uris;
			}

			self::$extension_widgets[$ext_name][$class_name] = true;
			self::$widgets[$class_name] = self::load_widget($widget_data);
		}
	}

	private static function load_widget($data)
	{
		$tag          = $data['tag'];
		$path         = $data['path'];
		$uri          = $data['uri'];
		$dir_name     = strtolower(basename($path));
		$class_file   = "$path/class-slz-widget-$dir_name.php";
		$class_name   = '';

		// try to find a custom class for the widget
		if (file_exists($class_file)) {
			require_once $class_file;

			$class_name = explode('_', $tag);
			$class_name = array_map('ucfirst', $class_name);
			$class_name = 'SLZ_Widget_' . implode('_', $class_name);

			if (!class_exists($class_name)) {
				trigger_error(
					sprintf(__('Class file found for widget %s but no class %s found', 'slz'), $tag, $class_name),
					E_USER_WARNING
				);
			} elseif (!is_subclass_of($class_name, 'WP_Widget')) {
				trigger_error(
					sprintf(__('The class %s must extend from WP_Widget', 'slz'), $class_name),
					E_USER_WARNING
				);
			}
		}

		$args = array(
			'tag'           => $tag,
			'path'          => $path,
			'uri'           => $uri,
			'rewrite_paths' => !empty($data['rewrite_paths']) ? $data['rewrite_paths'] : array(),
			'rewrite_uris'  => !empty($data['rewrite_uris'])  ? $data['rewrite_uris']  : array(),
			'class'			=> $class_name
		);

		$widget_instance = new SLZ_Widget($args);

		return $widget_instance;
	}
}
