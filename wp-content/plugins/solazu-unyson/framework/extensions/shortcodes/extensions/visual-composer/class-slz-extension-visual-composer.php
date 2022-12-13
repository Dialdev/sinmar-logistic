<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Visual_Composer extends SLZ_Extension {

	protected function _init() {

		if ( !is_admin() )
			return;

		if ( function_exists ('vc_map')){

			add_action('slz_extensions_init', array($this, '_action_slz_extensions_init'), 200);

		}

	}

	function _action_slz_extensions_init(){

		if (
			!isset( $_GET['page'] )
				||
			$_GET['page'] != slz()->backend->_get_settings_page_slug()
		) {

			if ( isset( $_POST ) && isset( $_POST['slzf'] ) && $_POST['slzf'] == str_replace('-', '_', slz()->backend->_get_settings_page_slug() ) )
				return;

			$shortcodes = slz()->extensions->get('shortcodes')->get_shortcodes();

			foreach ($shortcodes as $tag => $shortcode) {

				$vc_options_path = $shortcode->locate_path('/vc_options.php');

				if ($vc_options_path) {

					$vars = slz_get_variables_from_file($vc_options_path, array('vc_options' => null));

					$vc_option = $vars['vc_options'];

				}

				$config = $shortcode->get_config('page_builder');

				if ( $vc_option != null && $config != null ) {

					vc_map(array(
						'name'        => !empty( $config['title'] ) ? $config['title'] : '',
						'base'        => !empty( $config['tag'] ) ? $config['tag'] : '',
						'icon'        => !empty( $config['icon'] ) ? $config['icon'] : '',
						'category'    => !empty( $config['tab'] ) ? $config['tab'] : '',
						'description' => !empty( $config['description'] ) ? $config['description'] : '',
						'allowed_container_element' => !empty( $config['allowed_container_element'] ) ? $config['allowed_container_element'] : '',
						'is_container' => !empty( $config['is_container'] ) ? $config['is_container'] : '',
						'show_settings_on_create' => !empty( $config['show_settings_on_create'] ) ? $config['show_settings_on_create'] : '',
						'as_child' => !empty( $config['as_child'] ) ? $config['as_child'] : '',
						'as_parent' => !empty( $config['as_parent'] ) ? $config['as_parent'] : '',
						'js_view' => !empty( $config['js_view'] ) ? $config['js_view'] : '',
						'class' => !empty( $config['class'] ) ? $config['class'] : '',
						'custom_markup' => !empty( $config['custom_markup'] ) ? $config['custom_markup'] : '',
						'default_content' => !empty( $config['default_content'] ) ? $config['default_content'] : '',
						'admin_enqueue_js' => !empty( $config['admin_enqueue_js'] ) ? $config['admin_enqueue_js'] : '',
						'params'      => $vc_option
					));

				}

			}
		}
		
	}

}

