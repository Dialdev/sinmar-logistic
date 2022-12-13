<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
echo 'ID';
slz_print($id);
echo 'OPTION';
slz_print($option);
echo 'DATA';
slz_print($data);
echo 'JSON';
slz_print($json);
 */

$wrapper_attr = array(
	'class' => $option['attr']['class'] . ' slz-icon-v2-preview-' . $option['preview_size'],
	'id'    => $option['attr']['id'],
	'data-slz-modal-size' => $option['popup_size']
);

unset($option['attr']['class'], $option['attr']['id']);

?>

<div <?php echo slz_attr_to_html($wrapper_attr) ?>>
	<input <?php echo slz_attr_to_html($option['attr']) ?> type="hidden" />
</div>

