<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Helper functions used while loading the framework
 */

/**
 * Convert to Unix style directory separators
 */
function slz_fix_path($path) {
	$fixed_path = untrailingslashit( str_replace(array('//', '\\'), array('/', '/'), $path) );

	if (empty($fixed_path) && !empty($path)) {
		$fixed_path = '/';
	}

	return $fixed_path;
}

/**
 * Relative path of the framework customizations directory
 * @param string $append
 * @return string
 */
function slz_get_framework_customizations_dir_rel_path($append = '') {
	try {
		$dir = SLZ_Cache::get($cache_key = 'slz_customizations_dir_rel_path');
	} catch (SLZ_Cache_Not_Found_Exception $e) {
		SLZ_Cache::set(
			$cache_key,
			$dir = apply_filters('slz_framework_customizations_dir_rel_path', '/framework-customizations')
		);
	}

	return $dir . $append;
}

/** Child theme related functions */
{
	/**
	 * Full path to the child-theme framework customizations directory
	 * @param string $rel_path
	 * @return null|string
	 */
	function slz_get_stylesheet_customizations_directory($rel_path = '') {
		if (is_child_theme()) {
			return get_stylesheet_directory() . slz_get_framework_customizations_dir_rel_path($rel_path);
		} else {
			// check is_child_theme() before using this function
			return null;
		}
	}

	/**
	 * URI to the child-theme framework customizations directory
	 * @param string $rel_path
	 * @return null|string
	 */
	function slz_get_stylesheet_customizations_directory_uri($rel_path = '') {
		if (is_child_theme()) {
			return get_stylesheet_directory_uri() . slz_get_framework_customizations_dir_rel_path($rel_path);
		} else {
			// check is_child_theme() before using this function
			return null;
		}
	}
}

/** Parent theme related functions */
{
	/**
	 * Full path to the parent-theme framework customizations directory
	 * @param string $rel_path
	 * @return string
	 */
	function slz_get_template_customizations_directory($rel_path = '') {
		try {
			$dir = SLZ_Cache::get($cache_key = 'slz_template_customizations_dir');
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			SLZ_Cache::set(
				$cache_key,
				$dir = get_template_directory() . slz_get_framework_customizations_dir_rel_path()
			);
		}

		return $dir . $rel_path;
	}

	/**
	 * URI to the parent-theme framework customizations directory
	 * @param string $rel_path
	 * @return string
	 */
	function slz_get_template_customizations_directory_uri($rel_path = '') {
		try {
			$dir = SLZ_Cache::get($cache_key = 'slz_template_customizations_dir_uri');
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			SLZ_Cache::set(
				$cache_key,
				$dir = get_template_directory_uri() . slz_get_framework_customizations_dir_rel_path()
			);
		}

		return $dir . $rel_path;
	}
}

/** Framework related functions */
{
	/**
	 * Full path to the parent-theme/framework directory
	 * @param string $rel_path
	 * @return string
	 */
	function slz_get_framework_directory($rel_path = '') {
		try {
			$dir = SLZ_Cache::get($cache_key = 'slz_framework_dir');
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			SLZ_Cache::set(
				$cache_key,
				$dir = apply_filters('slz_framework_directory', dirname(__FILE__))
			);
		}

		return $dir . $rel_path;
	}

	/**
	 * URI to the parent-theme/framework directory
	 * @param string $rel_path
	 * @return string
	 */
	function slz_get_framework_directory_uri($rel_path = '') {
		try {
			$dir = SLZ_Cache::get($cache_key = 'slz_framework_dir_uri');
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			SLZ_Cache::set(
				$cache_key,
				$dir = apply_filters('slz_framework_directory_uri', get_template_directory_uri() . '/framework')
			);
		}

		return $dir . $rel_path;
	}
}
/** Uploads related functions */
{
	/**
	 * Full path to the uploads
	 * @param string $rel_path
	 * @return string
	 */
	function slz_get_upload_directory($rel_path = '') {
		try {
			$dir = SLZ_Cache::get($cache_key = 'slz_upload_dir');
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			$uploads = wp_upload_dir();
			SLZ_Cache::set(
					$cache_key,
					$dir = apply_filters('slz_upload_directory', $uploads['basedir'])
			);
		}

		return $dir . $rel_path;
	}
	/**
	 * URI to the uploads
	 * @param string $rel_path
	 * @return string
	 */
	function slz_get_upload_directory_uri($rel_path = '') {
		try {
			$dir = SLZ_Cache::get($cache_key = 'slz_upload_dir_uri');
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			$uploads = wp_upload_dir();
			SLZ_Cache::set(
					$cache_key,
					$dir = apply_filters('slz_upload_directory_uri',$uploads['baseurl'])
			);
		}
	
		return $dir . $rel_path;
	}
}
