<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Theme Settings Options
class SLZ_Db_Options_Model_Settings extends SLZ_Db_Options_Model {
	protected function get_id() {
		return 'settings';
	}

	protected function get_options($item_id, array $extra_data = array()) {
		return slz()->theme->get_settings_options();
	}

	protected function get_values($item_id, array $extra_data = array()) {
		return SLZ_WP_Option::get('slz_theme_settings_options:'. slz()->theme->manifest->get_id(), null, array());
	}

	protected function set_values($item_id, $values, array $extra_data = array()) {
		SLZ_WP_Option::set('slz_theme_settings_options:' . slz()->theme->manifest->get_id(), null, $values);
	}

	protected function get_slz_storage_params($item_id, array $extra_data = array()) {
		return array(
			'settings' => true
		);
	}

	protected function _after_set($item_id, $option_id, $sub_keys, $old_value, array $extra_data = array()) {
		/**
		 * @since 2.6.0
		 */
		do_action('slz_settings_options_update', array(
			/**
			 * Option id
			 * First level multi-key
			 * For e.g. if $option_id is 'hello/world/7' this will be 'hello'
			 */
			'option_id' => $option_id,
			/**
			 * The remaining sub-keys
			 * For e.g.
			 * if $option_id is 'hello/world/7' this will be array('world', '7')
			 * if $option_id is 'hello' this will be array()
			 */
			'sub_keys' => explode('/', $sub_keys),
			/**
			 * Old option(s) value
			 */
			'old_value' => $old_value
		));
	}

	protected function _init() {
		/**
		 * Get a theme settings option value from the database
		 *
		 * @param string|null $option_id Specific option id (accepts multikey). null - all options
		 * @param null|mixed $default_value If no option found in the database, this value will be returned
		 * @param null|bool $get_original_value REMOVED https://github.com/ThemeFuse/Unyson/issues/1676
		 *
		 * @return mixed|null
		 */
		function slz_get_db_settings_option( $option_id = null, $default_value = null, $get_original_value = null ) {
			return SLZ_Db_Options_Model_Settings::_get_instance('settings')->get(null, $option_id, $default_value);
		}

		/**
		 * Set a theme settings option value in database
		 *
		 * @param null $option_id Specific option id (accepts multikey). null - all options
		 * @param mixed $value
		 */
		function slz_set_db_settings_option( $option_id = null, $value ) {
			SLZ_Db_Options_Model_Settings::_get_instance('settings')->set(null, $option_id, $value);
		}
	}
}
new SLZ_Db_Options_Model_Settings();

// Post Options
class SLZ_Db_Options_Model_Post extends SLZ_Db_Options_Model {
	protected function get_id() {
		return 'post';
	}

	private function get_cache_key($key, $item_id = null, array $extra_data = array()) {
		return 'slz-options-model:'. $this->get_id() .'/'. $key;
	}

	private function get_post_id($post_id) {
		$post_id = intval($post_id);

		try {
			// Prevent too often execution of wp_get_post_autosave() because it does WP Query
			return SLZ_Cache::get($cache_key = $this->get_cache_key('id/'. $post_id));
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			if ( ! $post_id ) {
				/** @var WP_Post $post */
				global $post;

				if ( ! $post ) {
					return null;
				} else {
					$post_id = $post->ID;
				}

				/**
				 * Check if is Preview and use the preview post_id instead of real/current post id
				 *
				 * Note: WordPress changes the global $post content on preview:
				 * 1. https://github.com/WordPress/WordPress/blob/2096b451c704715db3c4faf699a1184260deade9/wp-includes/query.php#L3573-L3583
				 * 2. https://github.com/WordPress/WordPress/blob/4a31dd6fe8b774d56f901a29e72dcf9523e9ce85/wp-includes/revision.php#L485-L528
				 */
				if ( is_preview() && is_object($preview = wp_get_post_autosave($post->ID)) ) {
					$post_id = $preview->ID;
				}
			}

			SLZ_Cache::set($cache_key, $post_id);

			return $post_id;
		}
	}

	private function get_post_type($post_id) {
		$post_id = $this->get_post_id($post_id);

		try {
			return SLZ_Cache::get($cache_key = $this->get_cache_key('type/'. $post_id));
		} catch (SLZ_Cache_Not_Found_Exception $e) {
			SLZ_Cache::set(
				$cache_key,
				$post_type = get_post_type(
					($post_revision_id = wp_is_post_revision($post_id)) ? $post_revision_id : $post_id
				)
			);

			return $post_type;
		}
	}

	protected function get_options($item_id, array $extra_data = array()) {
		$post_type = $this->get_post_type($item_id);

		if (apply_filters('slz_get_db_post_option:slz-storage-enabled',
			/**
			 * Slider extension has too many slz_get_db_post_option()
			 * inside post options altering filter and it creates recursive mess.
			 * add_filter() was added in Slider extension
			 * but this hardcode can be replaced with `true`
			 * only after all users will install new version 1.1.15.
			 */
			$post_type !== 'slz-slider',
			$post_type
		)) {
			return slz()->theme->get_post_options( $post_type );
		} else {
			return array();
		}
	}

	protected function get_values($item_id, array $extra_data = array()) {
		return SLZ_WP_Meta::get( 'post', $this->get_post_id($item_id), 'slz_options', array() );
	}

	protected function set_values($item_id, $values, array $extra_data = array()) {
		SLZ_WP_Meta::set( 'post', $this->get_post_id($item_id), 'slz_options', $values );
	}

	protected function get_slz_storage_params($item_id, array $extra_data = array()) {
		return array( 'post-id' => $this->get_post_id($item_id) );
	}

	protected function _get_cache_key($key, $item_id, array $extra_data = array()) {
		if ($key === 'options') {
			return $this->get_post_type($item_id); // Cache options grouped by post-type, not by post id
		} else {
			return $this->get_post_id($item_id);
		}
	}

	protected function _after_set($post_id, $option_id, $sub_keys, $old_value, array $extra_data = array()) {
		/**
		 * @deprecated
		 */
		slz()->backend->_sync_post_separate_meta($post_id);

		/**
		 * @since 2.2.8
		 */
		do_action('slz_post_options_update',
			$post_id,
			/**
			 * Option id
			 * First level multi-key
			 * For e.g. if $option_id is 'hello/world/7' this will be 'hello'
			 */
			$option_id,
			/**
			 * The remaining sub-keys
			 * For e.g.
			 * if $option_id is 'hello/world/7' this will be array('world', '7')
			 * if $option_id is 'hello' this will be array()
			 */
			explode('/', $sub_keys),
			/**
			 * Old post option(s) value
			 * @since 2.3.3
			 */
			$old_value
		);
	}

	protected function _init() {
		/**
		 * Get post option value from the database
		 *
		 * @param null|int $post_id
		 * @param string|null $option_id Specific option id (accepts multikey). null - all options
		 * @param null|mixed $default_value If no option found in the database, this value will be returned
		 * @param null|bool $get_original_value REMOVED https://github.com/ThemeFuse/Unyson/issues/1676
		 *
		 * @return mixed|null
		 */
		function slz_get_db_post_option($post_id = null, $option_id = null, $default_value = null, $get_original_value = null) {
			return SLZ_Db_Options_Model::_get_instance('post')->get(intval($post_id), $option_id, $default_value);
		}

		/**
		 * Set post option value in database
		 *
		 * @param null|int $post_id
		 * @param string|null $option_id Specific option id (accepts multikey). null - all options
		 * @param $value
		 */
		function slz_set_db_post_option( $post_id = null, $option_id = null, $value ) {
			SLZ_Db_Options_Model::_get_instance('post')->set(intval($post_id), $option_id, $value);
		}

		// todo: add_action() to clear the SLZ_Cache
	}
}
new SLZ_Db_Options_Model_Post();

// Term Options
class SLZ_Db_Options_Model_Term extends SLZ_Db_Options_Model {
	protected function get_id() {
		return 'term';
	}

	protected function get_values($item_id, array $extra_data = array()) {
		self::migrate($item_id);

		return (array)get_term_meta( $item_id, 'slz_options', true);
	}

	protected function set_values($item_id, $values, array $extra_data = array()) {
		self::migrate($item_id);

		update_term_meta($item_id, 'slz_options', $values);
	}

	protected function get_options($item_id, array $extra_data = array()) {
		return slz()->theme->get_taxonomy_options($extra_data['taxonomy']);
	}

	protected function get_slz_storage_params($item_id, array $extra_data = array()) {
		return array(
			'term-id' => $item_id,
			'taxonomy' => $extra_data['taxonomy'],
		);
	}

	protected function _get_cache_key($key, $item_id, array $extra_data = array()) {
		if ($key === 'options') {
			return $extra_data['taxonomy']; // Cache options grouped by taxonomy, not by term id
		} else {
			return $item_id;
		}
	}

	/**
	 * Cache termmeta table name if exists
	 * @var string|false
	 */
	private static $old_table_name;

	/**
	 * @return string|false
	 */
	private static function get_old_table_name() {
		if (is_null(self::$old_table_name)) {
			/** @var WPDB $wpdb */
			global $wpdb;

			$table_name = $wpdb->get_results( "show tables like '{$wpdb->prefix}slz_termmeta'", ARRAY_A );
			$table_name = $table_name ? array_pop($table_name[0]) : false;

			if ( $table_name && ! $wpdb->get_results( "SELECT 1 FROM `{$table_name}` LIMIT 1" ) ) {
				// The table is empty, delete it
				$wpdb->query( "DROP TABLE `{$table_name}`" );
				$table_name = false;
			}

			self::$old_table_name = $table_name;
		}

		return self::$old_table_name;
	}

	/**
	 * @internal
	 */
	public static function _action_switch_blog() {
		self::$old_table_name = null; // reset
	}

	/**
	 * When a term is deleted, delete its meta from old slz_termmeta table
	 *
	 * @param mixed $term_id
	 *
	 * @return void
	 * @internal
	 */
	public static function _action_slz_delete_term( $term_id ) {
		if ( ! ( $table_name = self::get_old_table_name() ) ) {
			return;
		}

		$term_id = (int) $term_id;

		if ( ! $term_id ) {
			return;
		}

		/** @var WPDB $wpdb */
		global $wpdb;

		$wpdb->delete( $table_name, array( 'slz_term_id' => $term_id ), array( '%d' ) );
	}

	/**
	 * In WP 4.4 was introduced native term meta https://codex.wordpress.org/Version_4.4#For_Developers
	 * All data from old table must be migrated to native term meta
	 * @param int $term_id
	 * @return bool
	 */
	private static function migrate($term_id) {
		global $wpdb; /** @var wpdb $wpdb */

		if (
			( $old_table_name = self::get_old_table_name() )
			&&
			( $value = $wpdb->get_col( $wpdb->prepare(
				"SELECT meta_value FROM `{$old_table_name}` WHERE slz_term_id = %d AND meta_key = 'slz_options' LIMIT 1",
				$term_id
			) ) )
			&&
			( $value = unserialize( $value[0] ) )
		) {
			$wpdb->delete( $old_table_name, array( 'slz_term_id' => $term_id ), array( '%d' ) );

			update_term_meta( $term_id, 'slz_options', $value );

			return true;
		} else {
			return false;
		}
	}

	protected function _after_set($item_id, $option_id, $sub_keys, $old_value, array $extra_data = array()) {
		/**
		 * @since 2.6.0
		 */
		do_action('slz_term_options_update', array(
			'term_id' => $item_id,
			'taxonomy' => $extra_data['taxonomy'],
			/**
			 * Option id
			 * First level multi-key
			 * For e.g. if $option_id is 'hello/world/7' this will be 'hello'
			 */
			'option_id' => $option_id,
			/**
			 * The remaining sub-keys
			 * For e.g.
			 * if $option_id is 'hello/world/7' this will be array('world', '7')
			 * if $option_id is 'hello' this will be array()
			 */
			'sub_keys' => explode('/', $sub_keys),
			/**
			 * Old option(s) value
			 */
			'old_value' => $old_value
		));
	}

	protected function _init() {
		/**
		 * Get term option value from the database
		 *
		 * @param int $term_id
		 * @param string $taxonomy
		 * @param string|null $option_id Specific option id (accepts multikey). null - all options
		 * @param null|mixed $default_value If no option found in the database, this value will be returned
		 * @param null|bool $get_original_value REMOVED https://github.com/ThemeFuse/Unyson/issues/1676
		 *
		 * @return mixed|null
		 */
		function slz_get_db_term_option( $term_id, $taxonomy, $option_id = null, $default_value = null, $get_original_value = null ) {
			if ( ! taxonomy_exists( $taxonomy ) ) {
				return null;
			}

			return SLZ_Db_Options_Model::_get_instance('term')->get(intval($term_id), $option_id, $default_value, array(
				'taxonomy' => $taxonomy
			));
		}

		/**
		 * Set term option value in database
		 *
		 * @param int $term_id
		 * @param string $taxonomy
		 * @param string|null $option_id Specific option id (accepts multikey). null - all options
		 * @param mixed $value
		 *
		 * @return null
		 */
		function slz_set_db_term_option( $term_id, $taxonomy, $option_id = null, $value ) {
			if ( ! taxonomy_exists( $taxonomy ) ) {
				return null;
			}

			SLZ_Db_Options_Model::_get_instance('term')->set(intval($term_id), $option_id, $value, array(
				'taxonomy' => $taxonomy
			));
		}

		add_action( 'switch_blog', array( __CLASS__, '_action_switch_blog' ) );
		add_action( 'delete_term', array( __CLASS__, '_action_slz_delete_term' ) );
	}
}
new SLZ_Db_Options_Model_Term();

// Extensions Settings Options
class SLZ_Db_Options_Model_Extension extends SLZ_Db_Options_Model {
	protected function get_id() {
		return 'extension';
	}

	protected function get_values($item_id, array $extra_data = array()) {
		return SLZ_WP_Option::get( 'slz_ext_settings_options:' . $item_id, null, array() );
	}

	protected function set_values($item_id, $values, array $extra_data = array()) {
		SLZ_WP_Option::set( 'slz_ext_settings_options:' . $item_id, null, $values );
	}

	protected function get_options($item_id, array $extra_data = array()) {
		return slz_ext($item_id)->get_settings_options();
	}

	protected function get_slz_storage_params($item_id, array $extra_data = array()) {
		return array(
			'extension' => $item_id,
		);
	}

	protected function _init() {
		/**
		 * Get extension's settings option value from the database
		 *
		 * @param string $extension_name
		 * @param string|null $option_id
		 * @param null|mixed $default_value If no option found in the database, this value will be returned
		 * @param null|bool $get_original_value REMOVED https://github.com/ThemeFuse/Unyson/issues/1676
		 *
		 * @return mixed|null
		 */
		function slz_get_db_ext_settings_option( $extension_name, $option_id = null, $default_value = null, $get_original_value = null ) {
			if ( ! ( $extension = slz_ext( $extension_name ) ) ) {
				trigger_error( 'Invalid extension: ' . $extension_name, E_USER_WARNING );
				return null;
			}

			return SLZ_Db_Options_Model::_get_instance('extension')->get($extension_name, $option_id, $default_value);
		}

		/**
		 * Set extension's setting option value in database
		 *
		 * @param string $extension_name
		 * @param string|null $option_id
		 * @param mixed $value
		 */
		function slz_set_db_ext_settings_option( $extension_name, $option_id = null, $value ) {
			if ( ! slz_ext( $extension_name ) ) {
				trigger_error( 'Invalid extension: ' . $extension_name, E_USER_WARNING );

				return;
			}

			SLZ_Db_Options_Model::_get_instance('extension')->set($extension_name, $option_id, $value);
		}
	}
}
new SLZ_Db_Options_Model_Extension();

// Customizer Options
class SLZ_Db_Options_Model_Customizer extends SLZ_Db_Options_Model {
	protected function get_id() {
		return 'customizer';
	}

	protected function get_values($item_id, array $extra_data = array()) {
		return get_theme_mod('slz_options', array());
	}

	protected function set_values($item_id, $values, array $extra_data = array()) {
		set_theme_mod('slz_options', $values);
	}

	protected function get_options($item_id, array $extra_data = array()) {
		return slz()->theme->get_customizer_options();
	}

	protected function get_slz_storage_params($item_id, array $extra_data = array()) {
		return array(
			'customizer' => true
		);
	}

	protected function _after_set($item_id, $option_id, $sub_keys, $old_value, array $extra_data = array()) {
		/**
		 * @since 2.6.0
		 */
		do_action('slz_customizer_options_update', array(
			/**
			 * Option id
			 * First level multi-key
			 * For e.g. if $option_id is 'hello/world/7' this will be 'hello'
			 */
			'option_id' => $option_id,
			/**
			 * The remaining sub-keys
			 * For e.g.
			 * if $option_id is 'hello/world/7' this will be array('world', '7')
			 * if $option_id is 'hello' this will be array()
			 */
			'sub_keys' => explode('/', $sub_keys),
			/**
			 * Old option(s) value
			 */
			'old_value' => $old_value
		));
	}

	/**
	 * @internal
	 */
	public function _reset_cache() {
		SLZ_Cache::del($this->get_main_cache_key());
	}

	protected function _init() {
		/**
		 * Get a customizer framework option value from the database
		 *
		 * @param string|null $option_id Specific option id (accepts multikey). null - all options
		 * @param null|mixed $default_value If no option found in the database, this value will be returned
		 *
		 * @return mixed|null
		 */
		function slz_get_db_customizer_option( $option_id = null, $default_value = null ) {
			return SLZ_Db_Options_Model::_get_instance('customizer')->get(null, $option_id, $default_value);
		}

		/**
		 * Set a theme customizer option value in database
		 *
		 * @param null $option_id Specific option id (accepts multikey). null - all options
		 * @param mixed $value
		 */
		function slz_set_db_customizer_option( $option_id = null, $value ) {
			SLZ_Db_Options_Model::_get_instance('customizer')->set(null, $option_id, $value);
		}

		// Fixes https://github.com/ThemeFuse/Unyson/issues/2053
		add_action('customize_preview_init', array($this, '_reset_cache'),
			1 // Fixes https://github.com/ThemeFuse/Unyson/issues/2104
		);
	}
}
new SLZ_Db_Options_Model_Customizer();

{
	/**
	 * Get user meta set by specific extension
	 *
	 * @param int $user_id
	 * @param string $extension_name
	 * @param string $keys
	 *
	 * If the extension doesn't exist or is disabled, or meta key doesn't exist, returns null,
	 * else returns the meta key value
	 *
	 * @return mixed|null
	 */
	function slz_get_db_extension_user_data( $user_id, $extension_name, $keys = null ) {
		if ( ! slz()->extensions->get( $extension_name ) ) {
			trigger_error( 'Invalid extension: ' . $extension_name, E_USER_WARNING );

			return null;
		}
		$data = get_user_meta( $user_id, 'slz_data', true );

		if ( is_null( $keys ) ) {
			return slz_akg( $extension_name, $data );
		}

		return slz_akg( $extension_name . '/' . $keys, $data );
	}

	/**
	 * @param int $user_id
	 * @param string $extension_name
	 * @param mixed $value
	 * @param string $keys
	 *
	 * In case the extension doesn't exist or is disabled, or the value is equal to previous, returns false
	 *
	 * @return bool|int
	 */
	function slz_set_db_extension_user_data( $user_id, $extension_name, $value, $keys = null ) {
		if ( ! slz()->extensions->get( $extension_name ) ) {
			trigger_error( 'Invalid extension: ' . $extension_name, E_USER_WARNING );

			return false;
		}
		$data                    = get_user_meta( $user_id, 'slz_data', true );

		if ( $keys == null ) {
			slz_aks( $extension_name, $value, $data );
		} else {
			slz_aks( $extension_name . '/' . $keys, $value, $data );
		}

		return slz_update_user_meta( $user_id, 'slz_data', $data );
	}
}

/**
 * Extensions Data
 *
 * Used by extensions to store custom data in database.
 * By using these functions, extension prevent database spam with wp options for each extension,
 * because these functions store all data in one wp option.
 */
{
	/**
	 * Get extension's data from the database
	 *
	 * @param string $extension_name
	 * @param string|null $multi_key The key of the data you want to get. null - all data
	 * @param null|mixed $default_value If no option found in the database, this value will be returned
	 * @param null|bool $get_original_value REMOVED https://github.com/ThemeFuse/Unyson/issues/1676
	 *
	 * @return mixed|null
	 */
	function slz_get_db_extension_data( $extension_name, $multi_key = null, $default_value = null, $get_original_value = null ) {
		if ( ! slz()->extensions->get( $extension_name ) ) {
			trigger_error( 'Invalid extension: ' . $extension_name, E_USER_WARNING );

			return null;
		}

		if ( $multi_key ) {
			$multi_key = $extension_name . '/' . $multi_key;
		} else {
			$multi_key = $extension_name;
		}

		return SLZ_WP_Option::get( 'slz_extensions', $multi_key, $default_value, $get_original_value );
	}

	/**
	 * Set some extension's data in database
	 *
	 * @param string $extension_name
	 * @param string|null $multi_key The key of the data you want to set. null - all data
	 * @param mixed $value
	 */
	function slz_set_db_extension_data( $extension_name, $multi_key = null, $value ) {
		if ( ! slz()->extensions->get( $extension_name ) ) {
			trigger_error( 'Invalid extension: ' . $extension_name, E_USER_WARNING );

			return;
		}

		if ( $multi_key ) {
			$multi_key = $extension_name . '/' . $multi_key;
		} else {
			$multi_key = $extension_name;
		}

		SLZ_WP_Option::set( 'slz_extensions', $multi_key, $value );
	}
}
