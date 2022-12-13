<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (defined('SLZ')) {
	/**
	 * The framework is already loaded.
	 */
} else {
	define('SLZ', true);

	/**
	 * Load the framework on 'after_setup_theme' action when the theme information is available
	 * To prevent `undefined constant TEMPLATEPATH` errors when the framework is used as plugin
	 */
	add_action('after_setup_theme', '_action_init_framework');

	function _action_init_framework() {
		if (did_action('slz_init')) {
			return;
		}

		do_action('slz_before_init');

		$slz_dir = dirname(__FILE__);

		include $slz_dir .'/bootstrap-helpers.php';

		// these are required when slz() is executed below
		{
			require $slz_dir .'/helpers/class-slz-dumper.php';
			require $slz_dir .'/helpers/general.php';
			require $slz_dir .'/helpers/class-slz-cache.php';
		}

		/**
		 * Load core
		 */
		{
			require $slz_dir .'/core/Slz.php';

			slz();
		}

		/**
		 * Load helpers
		 */
		foreach (
			array(
				'meta',
				'class-slz-access-key',
				// 'class-slz-dumper', // included below
				// 'general', // included below
				'class-slz-wp-filesystem',
				// 'class-slz-cache', // included below
				'class-slz-file-cache',
				'class-slz-form',
				'class-slz-request',
				'class-slz-session',
				'class-slz-wp-option',
				'class-slz-wp-meta',
				'class-slz-db-options-model',
				'slz-storage',
				'database',
				'class-slz-flash-messages',
				'class-slz-resize',
				'class-slz-wp-list-table',
				'class-slz-image',
				'type/class-slz-type',
				'type/class-slz-type-register',
			)
			as $file
		) {
			require $slz_dir .'/helpers/'. $file .'.php';
		}

		/**
		 * Load includes
		 */
		foreach (array('hooks') as $file) {
			require $slz_dir .'/includes/'. $file .'.php';
		}

		/**
		 * Init components
		 */
		{
			$components = array(
				/**
				 * Load the theme's hooks.php first, to give users the possibility to add_action()
				 * for `extensions` and `backend` components actions that can happen while their initialization
				 */
				'theme',
				/**
				 * Load extensions before backend, to give extensions the possibility to add_action()
				 * for the `backend` component actions that can happen while its initialization
				 */
				'extensions',
				'backend'
			);

			foreach ($components as $component) {
				slz()->{$component}->_init();
			}

			foreach ($components as $component) {
				slz()->{$component}->_after_components_init();
			}
		}

		/**
		 * The framework is loaded
		 */
		do_action('slz_init');
	}
}
