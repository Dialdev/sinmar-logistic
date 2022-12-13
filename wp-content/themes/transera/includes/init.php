<?php if ( ! defined( 'ABSPATH' ) ) die( 'Direct access forbidden.' );

class Transera_Includes
{
	private static $rel_path = null;

	private static $include_isolated_callable;

	private static $initialized = false;
	

	public static function init()
	{

		if (self::$initialized) {

			return;

		} else {

			self::$initialized = true;

		}

		self::$include_isolated_callable = create_function('$path', 'include $path;');

		{
			self::include_child_first('/helpers.php');
			self::include_child_first('/hooks.php');
			self::include_all_child_first('/includes');
			add_action('init', array(__CLASS__, '_action_init'));
		}

		if ( ! is_admin() ) {

			add_action( 'wp_enqueue_scripts', array( __CLASS__, '_action_enqueue_scripts' ),
				20
			);

			add_action(	'wp_head', array( __CLASS__, '_action_wp_head' ) );

		} else {

			add_action( 'admin_enqueue_scripts', array( __CLASS__, '_action_enqueue_admin_scripts' ),
				20
			);

		}

	}

	private static function get_rel_path($append = '')
	{

		if (self::$rel_path === null) {

			self::$rel_path = '/includes';

		}

		return self::$rel_path . $append;

	}

	private static function include_all_child_first($dir_rel_path)
	{

		$paths = array();

		if (is_child_theme()) {

			$paths[] = self::get_child_path($dir_rel_path);

		}

		$paths[] = self::get_parent_path($dir_rel_path);

		foreach ($paths as $path) {

			if ($files = glob($path .'/*.php')) {

				foreach ($files as $file) {

					self::include_isolated($file);

				}
			}
		}
	}

	private static function dirname_to_classname($dirname) {

		$class_name = explode('-', $dirname);

		$class_name = array_map('ucfirst', $class_name);

		$class_name = implode('_', $class_name);

		return $class_name;

	}

	public static function get_parent_path($rel_path)
	{

		return get_template_directory() . self::get_rel_path($rel_path);

	}

	public static function get_child_path($rel_path)
	{

		if (!is_child_theme()) {

			return null;

		}

		return get_stylesheet_directory() . self::get_rel_path($rel_path);

	}

	public static function include_isolated($path)
	{

		call_user_func(self::$include_isolated_callable, $path);

	}

	public static function include_child_first($rel_path)
	{

		if (is_child_theme()) {

			$path = self::get_child_path($rel_path);

			if (file_exists($path)) {

				self::include_isolated($path);

			}

		}

		{

			$path = self::get_parent_path($rel_path);

			if (file_exists($path)) {

				self::include_isolated($path);

			}

		}

	}

	public static function include_parent_first($rel_path)
	{

		{

			$path = self::get_parent_path($rel_path);

			if (file_exists($path)) {

				self::include_isolated($path);

			}

		}

		if (is_child_theme()) {

			$path = self::get_child_path($rel_path);

			if (file_exists($path)) {

				self::include_isolated($path);

			}

		}

	}

	public static function _action_enqueue_scripts()
	{

		self::include_parent_first('/static.php');

	}

	public static function _action_wp_head()
	{

		if  ( defined( 'SLZ' ) ) {

			self::include_parent_first('/styling.php');
			
		}

	}

	public static function _action_enqueue_admin_scripts()
	{

		self::include_child_first( '/backend-static.php' );

	}

	public static function _action_init()
	{

		self::include_child_first('/menus.php');

		self::include_child_first( '/posts.php' );

	}

}

Transera_Includes::init();