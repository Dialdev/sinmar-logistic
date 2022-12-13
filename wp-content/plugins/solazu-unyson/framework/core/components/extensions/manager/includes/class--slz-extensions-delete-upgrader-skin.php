<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skins.php';

class _SLZ_Extensions_Delete_Upgrader_Skin extends WP_Upgrader_Skin
{
	public function after($data = array())
	{
		$update_actions = array(
			'extensions_page' => slz_html_tag(
				'a',
				array(
					'href' => slz_akg('extensions_page_link', $data, '#'),
					'title' => __('Go to extensions page', 'slz'),
					'target' => '_parent',
				),
				__('Return to Extensions page', 'slz')
			)
		);

		$this->feedback(implode(' | ', (array)$update_actions));

		if ($this->result) {
			// used for popup ajax form submit result
			$this->feedback('<span success></span>');
		}
	}
}
