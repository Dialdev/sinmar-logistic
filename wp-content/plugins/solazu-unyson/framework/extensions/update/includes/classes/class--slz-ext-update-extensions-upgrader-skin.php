<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skins.php';

class _SLZ_Ext_Update_Extensions_Upgrader_Skin extends WP_Upgrader_Skin
{
	public function after()
	{
		$update_actions = array(
			'updates_page' => slz_html_tag(
				'a',
				array(
					'href' => self_admin_url('update-core.php'),
					'title' => __('Go to updates page', 'slz'),
					'target' => '_parent',
				),
				__('Return to Updates page', 'slz')
			)
		);

		/**
		 * Filter the list of action links available following extensions update.
		 * @param array $update_actions Array of plugin action links.
		 */
		$update_actions = apply_filters('slz_ext_update_extensions_complete_actions', $update_actions);

		if (!empty($update_actions)) {
			$this->feedback(implode(' | ', (array)$update_actions));
		}
	}

	public function decrement_extension_update_count($extension_name)
	{
		$this->decrement_update_count('slz:extension:'. $extension_name);
	}
}
