<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( '_action_slz_register_ext_download_sources' ) ) {
	function _action_slz_register_ext_download_sources(_SLZ_Ext_Download_Source_Register $download_sources) {
		$dir = dirname(__FILE__);

		require_once $dir . '/class-slz-download-source-github.php';
		$download_sources->register(new SLZ_Ext_Download_Source_Github());
	}
}

add_action(
	'slz_register_ext_download_sources',
	'_action_slz_register_ext_download_sources'
);
