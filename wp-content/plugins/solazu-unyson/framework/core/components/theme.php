<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Theme Component
 * Works with framework customizations / theme directory
 */
final class _SLZ_Component_Theme
{
	private static $cache_key = 'slz_theme';

	/**
	 * @var SLZ_Theme_Manifest
	 */
	public $manifest;

	public function __construct()
	{
		{
			$manifest = array();

			@include slz_get_template_customizations_directory('/theme/manifest.php');

			$this->manifest = new SLZ_Theme_Manifest($manifest);
		}
	}

	/**
	 * @internal
	 */
	public function _init()
	{
		add_action('admin_notices', array($this, '_action_admin_notices'));
	}

	/**
	 * @internal
	 */
	public function _after_components_init()
	{
	}

	/**
	 * Search relative path in: child theme -> parent "theme" directory and return full path
	 * @param string $rel_path
	 * @return false|string
	 */
	public function locate_path($rel_path)
	{
		try {
			return SLZ_File_Cache::get($cache_key = 'core:theme:path:'. $rel_path);
		} catch (SLZ_File_Cache_Not_Found_Exception $e) {
			if (is_child_theme() && file_exists(slz_get_stylesheet_customizations_directory('/theme'. $rel_path))) {
				$path = slz_get_stylesheet_customizations_directory('/theme'. $rel_path);
			} elseif (file_exists(slz_get_template_customizations_directory('/theme'. $rel_path))) {
				$path = slz_get_template_customizations_directory('/theme'. $rel_path);
			} else {
				$path = false;
			}

			SLZ_File_Cache::set($cache_key, $path);

			return $path;
		}
	}

	/**
	 * Return array with options from specified name/path
	 * @param string $name '{theme}/framework-customizations/theme/options/{$name}.php'
	 * @param array $variables These will be available in options file (like variables for view)
	 * @return array
	 */
	public function get_options($name, array $variables = array())
	{
		$path = $this->locate_path('/options/'. $name .'.php');

		if (!$path) {
			return array();
		}

		$variables = slz_get_variables_from_file($path, array('options' => array()), $variables);

		return $variables['options'];
	}

	public function get_settings_options()
	{
		$cache_key = self::$cache_key .'/options/settings';

		try {
			return SLZ_Cache::get($cache_key);
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			$options = apply_filters('slz_settings_options', $this->get_options('settings'));

			SLZ_Cache::set($cache_key, $options);

			return $options;
		}
	}

	public function get_customizer_options()
	{
		$cache_key = self::$cache_key .'/options/customizer';

		try {
			return SLZ_Cache::get($cache_key);
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			$options = apply_filters('slz_customizer_options', $this->get_options('customizer'));

			SLZ_Cache::set($cache_key, $options);

			return $options;
		}
	}

	public function get_post_options($post_type)
	{
		$cache_key = self::$cache_key .'/options/posts/'. $post_type;

		try {
			return SLZ_Cache::get($cache_key);
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			$options = apply_filters('slz_post_options', $this->get_options('posts/'. $post_type), $post_type);

			SLZ_Cache::set($cache_key, $options);

			return $options;
		}
	}

	public function get_taxonomy_options($taxonomy)
	{
		$cache_key = self::$cache_key .'/options/taxonomies/'. $taxonomy;

		try {
			return SLZ_Cache::get($cache_key);
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			$options = apply_filters('slz_taxonomy_options',
				$this->get_options('taxonomies/'. $taxonomy),
				$taxonomy
			);

			SLZ_Cache::set($cache_key, $options);

			return $options;
		}
	}

	/**
	 * Return config key value, or entire config array
	 * Config array is merged from child configs
	 * @param string|null $key Multi key format accepted: 'a/b/c'
	 * @param mixed $default_value
	 * @return mixed|null
	 */
	final public function get_config($key = null, $default_value = null)
	{
		$cache_key = self::$cache_key .'/config';

		try {
			$config = SLZ_Cache::get($cache_key);
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			// default values
			$config = array(
				/** Toggle Theme Settings form ajax submit */
				'settings_form_ajax_submit' => true,
				/** Toggle Theme Settings side tabs */
				'settings_form_side_tabs' => false,
				/** Toggle Tabs rendered all at once, or initialized only on open/display */
				'lazy_tabs' => true,
			);

			if (file_exists(slz_get_template_customizations_directory('/theme/config.php'))) {
				$variables = slz_get_variables_from_file(slz_get_template_customizations_directory('/theme/config.php'), array('cfg' => null));

				if (!empty($variables['cfg'])) {
					$config = array_merge($config, $variables['cfg']);
					unset($variables);
				}
			}

			if (is_child_theme() && file_exists(slz_get_stylesheet_customizations_directory('/theme/config.php'))) {
				$variables = slz_get_variables_from_file(slz_get_stylesheet_customizations_directory('/theme/config.php'), array('cfg' => null));

				if (!empty($variables['cfg'])) {
					$config = array_merge($config, $variables['cfg']);
					unset($variables);
				}
			}

			unset($path);

			SLZ_Cache::set($cache_key, $config);
		}

		return $key === null ? $config : slz_akg($key, $config, $default_value);
	}

	/**
	 * @internal
	 */
	public function _action_admin_notices()
	{
		if ( is_admin() && !slz()->theme->manifest->check_requirements() && current_user_can('manage_options') ) {
			echo '<div class="notice notice-warning"><p>';
			echo __('Theme requirements not met:', 'slz') .' '. slz()->theme->manifest->get_not_met_requirement_text();
			echo '</p></div>';
		}
	}
}
