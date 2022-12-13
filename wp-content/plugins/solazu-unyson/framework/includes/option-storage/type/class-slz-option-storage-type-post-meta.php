<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * array(
 *  'post-id' => 3 // optional // hardcoded post id
 *  'post-meta' => 'hello_world' // optional (default: 'slz:opt:{option_id}')
 *  'key' => 'option_id/sub_key' // optional @since 2.5.3
 * )
 */
class SLZ_Option_Storage_Type_Post_Meta extends SLZ_Option_Storage_Type {
	public function get_type() {
		return 'post-meta';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _save( $id, array $option, $value, array $params ) {
		if ($post_id = $this->get_post_id($option, $params)) {
			$meta_id = $this->get_meta_id($id, $option, $params);

			if (isset($option['slz-storage']['key'])) {
				$meta_value = get_post_meta($post_id, $meta_id, true);

				slz_aks($option['slz-storage']['key'], $value, $meta_value);

				slz_update_post_meta($post_id, $meta_id, $meta_value);

				unset($meta_value);
			} else {
				slz_update_post_meta($post_id, $meta_id, $value);
			}

			return slz()->backend->option_type($option['type'])->get_value_from_input(
				array('type' => $option['type']), null
			);
		} else {
			return $value;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _load( $id, array $option, $value, array $params ) {
		if ($post_id = $this->get_post_id($option, $params)) {
			$meta_id = $this->get_meta_id($id, $option, $params);
			$meta_value = get_post_meta($post_id, $meta_id, true);

			if ($meta_value === '' && is_array($value)) {
				return $value;
			}

			if (isset($option['slz-storage']['key'])) {
				return slz_akg($option['slz-storage']['key'], $meta_value, $value);
			} else {
				return $meta_value;
			}
		} else {
			return $value;
		}
	}

	private function get_post_id($option, $params) {
		$post_id = null;

		if (!empty($option['slz-storage']['post-id'])) {
			$post_id = $option['slz-storage']['post-id'];
		} elseif (!empty($params['post-id'])) {
			$post_id = $params['post-id'];
		}

		$post_id = intval($post_id);

		if ($post_id > 0) {
			return $post_id;
		} else {
			return false;
		}
	}

	private function get_meta_id($id, $option, $params) {
		return empty($option['slz-storage']['post-meta'])
			? 'slz:opt:'. $id
			: $option['slz-storage']['post-meta'];
	}
}
