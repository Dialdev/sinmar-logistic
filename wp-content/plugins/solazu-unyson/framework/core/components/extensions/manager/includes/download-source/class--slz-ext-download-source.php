<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * User to specify multiple download sources for an extension.
 * @since 2.5.12
 */
abstract class SLZ_Ext_Download_Source extends SLZ_Type
{
	/**
	 * Perform the actual download.
	 * It should download, by convention, a zip file which absolute path
	 * is $path.
	 *
	 * @param array $opts {extension_name: '...', extension_title: '...', ...}
	 * @param string $zip_path Absolute file of the future ZIP file
	 * @return null|WP_Error
	 */
	abstract public function download(array $opts, $zip_path);
}

