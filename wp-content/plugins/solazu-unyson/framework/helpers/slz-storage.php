<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Process the `slz-storage` option parameter

/**
 * @param string $id
 * @param array $option
 * @param mixed $value
 * @param array $params
 *
 * @return mixed
 *
 * @since 2.5.0
 */
function slz_db_option_storage_save($id, array $option, $value, array $params = array()) {
	if (
		!empty($option['slz-storage'])
		&&
		($storage = is_array($option['slz-storage'])
			? $option['slz-storage']
			: array('type' => $option['slz-storage'])
		)
		&&
		!empty($storage['type'])
		&&
		($storage_type = slz_db_option_storage_type($storage['type']))
	) {
		$option['slz-storage'] = $storage;
	} else {
		return $value;
	}

	/** @var SLZ_Option_Storage_Type $storage_type */

	return $storage_type->save($id, $option, $value, $params);
}

/**
 * @param string $id
 * @param array $option
 * @param mixed $value
 * @param array $params
 *
 * @return mixed
 *
 * @since 2.5.0
 */
function slz_db_option_storage_load($id, array $option, $value, array $params = array()) {
	if (
		!empty($option['slz-storage'])
		&&
		($storage = is_array($option['slz-storage'])
			? $option['slz-storage']
			: array('type' => $option['slz-storage'])
		)
		&&
		!empty($storage['type'])
		&&
		($storage_type = slz_db_option_storage_type($storage['type']))
	) {
		$option['slz-storage'] = $storage;
	} else {
		return $value;
	}

	/** @var SLZ_Option_Storage_Type $storage_type */

	return $storage_type->load($id, $option, $value, $params);
}

/**
 * @param null|string $type
 * @return SLZ_Option_Storage_Type|SLZ_Option_Storage_Type[]|null
 * @since 2.5.0
 */
function slz_db_option_storage_type($type = null) {
	static $types = null;

	if (is_null($types)) {
		$dir = slz_get_framework_directory('/includes/option-storage');

		if (!class_exists('SLZ_Option_Storage_Type')) {
			require_once $dir .'/class-slz-option-storage-type.php';
		}
		if (!class_exists('_SLZ_Option_Storage_Type_Register')) {
			require_once $dir .'/class--slz-option-storage-type-register.php';
		}

		$access_key = new SLZ_Access_Key('slz:option-storage-register');
		$register = new _SLZ_Option_Storage_Type_Register($access_key->get_key());

		{
			require_once $dir .'/type/class-slz-option-storage-type-post-meta.php';
			$register->register(new SLZ_Option_Storage_Type_Post_Meta());

			require_once $dir .'/type/class-slz-option-storage-type-wp-option.php';
			$register->register(new SLZ_Option_Storage_Type_WP_Option());
		}

		do_action('slz:option-storage-types:register', $register);

		$types = $register->_get_types($access_key);
	}

	if (empty($type)) {
		return $types;
	} elseif (isset($types[$type])) {
		return $types[$type];
	} else {
		return null;
	}
}
