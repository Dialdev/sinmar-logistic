<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @param bool $exclude
 * @param string $option_name
 * @param bool $is_full_backup
 *
 * @return bool
 */
function _filter_slz_ext_backups_db_export_exclude_option($exclude, $option_name, $is_full_backup) {
	foreach (array(
		'_site_transient_',
		'_transient_'
	) as $option_prefix) {
		if (substr($option_name, 0, strlen($option_prefix)) === $option_prefix) {
			return true;
		}
	}

	return $exclude;
}
add_filter('slz_ext_backups_db_export_exclude_option', '_filter_slz_ext_backups_db_export_exclude_option', 10, 3);

/**
 * Other extensions options
 */
{
	function _filter_slz_ext_backups_db_export_exclude_other_extensions_options($exclude, $option_name, $is_full_backup) {
		if (!$is_full_backup) {
			if ($option_name === 'slz_ext_settings_options:mailer') {
				return true;
			}
		}

		return $exclude;
	}
	add_filter('slz_ext_backups_db_export_exclude_option',
		'_filter_slz_ext_backups_db_export_exclude_other_extensions_options', 10, 3
	);

	function _filter_slz_ext_backups_db_restore_keep_other_extensions_options($options, $is_full) {
		if (!$is_full) {
			$options[ 'slz_ext_settings_options:mailer' ] = true;
		}

		return $options;
	}
	add_filter('slz_ext_backups_db_restore_keep_options',
		'_filter_slz_ext_backups_db_restore_keep_other_extensions_options', 10, 2
	);

	// Disable Image Resize
	add_filter( 'slz:ext:backups:add-restore-task:image-sizes-restore', '_filter_slz_backups_disable_image_sizes_restore' );
	function _filter_slz_backups_disable_image_sizes_restore() {
		$enable = slz_ext( 'backups' )->get_config( 'enable_resize_image' );

		return $enable == true;
	}
	
}
