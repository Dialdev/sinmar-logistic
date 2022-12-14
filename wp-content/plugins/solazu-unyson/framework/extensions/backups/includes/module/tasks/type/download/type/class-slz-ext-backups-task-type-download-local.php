<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Ext_Backups_Task_Type_Download_Local extends SLZ_Ext_Backups_Task_Type_Download_Type {
	public function get_type() {
		return 'local';
	}

	public function get_title(array $args = array(), array $state = array()) {
		return __('Local Download', 'slz');
	}

	/**
	 * {@inheritdoc}
	 * @param $args
	 * * destination_dir - Path to dir where the downloaded files must be placed
	 * * source - Path to dir or zip file
	 */
	public function download(array $args, array $state = array()) {
		// Note: destination_dir is already validated

		if (empty($args['source'])) {
			return new WP_Error(
				'no_source',
				__('Source not specified', 'slz')
			);
		} elseif (!file_exists($args['source'] = slz_fix_path($args['source']))) {
			return new WP_Error(
				'invalid_source',
				__('Invalid source', 'slz')
			);
		} elseif (
			!($is_dir = is_dir($args['source']))
			||
			!($is_zip = (substr($args['source'], -4, 4) !== '.zip'))
		) {
			return new WP_Error(
				'invalid_source_type',
				__('Invalid source type', 'slz')
			);
		}

		if ($is_dir) {
			return slz_ext_backups_copy_dir_recursive(
				$args['source'],
				$args['destination_dir']
			);
		} elseif ($is_zip) {
			if (!class_exists('ZipArchive')) {
				return new WP_Error(
					'zip_ext_missing', __('Zip extension missing', 'slz')
				);
			}

			$zip = new ZipArchive();

			if (true === $zip->open($args['source'])) {
				return new WP_Error(
					'zip_open_fail',
					sprintf(__('Cannot open zip: %s', 'slz'), $args['source'])
				);
			}

			$zip->extractTo($args['destination_dir']);

			$zip->close();
			unset($zip);

			return true;
		} else {
			return new WP_Error('unhandled_type', __('Unhandled type', 'slz'));
		}
	}
}
