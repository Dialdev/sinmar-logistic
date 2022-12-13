<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @deprecated
 * @param $post
 * @param $key
 * @param null $default
 * @return mixed
 */
function slz_mega_menu_get_meta($post, $key, $default = null) {
	return slz_ext_mega_menu_get_meta($post, $key, $default);
}

/**
 * @deprecated
 * @param $post
 * @param array $array
 * @return mixed
 */
function slz_mega_menu_update_meta($post, array $array) {
	return slz_ext_mega_menu_update_meta($post, $array);
}

/**
 * @deprecated
 * @param $post
 * @param $key
 * @return string
 */
function slz_mega_menu_name_meta($post, $key) {
	return _slz_ext_mega_menu_admin_input_name($post, $key);
}

/**
 * @deprecated
 * @param $post
 * @return array
 */
function slz_mega_menu_request_meta($post) {
	return _slz_ext_mega_menu_admin_input_POST_values($post);
}

/**
 * @deprecated
 * @param $post
 * @param $key
 * @param null $default
 * @param bool $write
 * @return mixed
 */
function _slz_mega_menu_meta($post, $key, $default = null, $write = false) {
	return _slz_ext_mega_menu_meta($post, $key, $default, $write);
}