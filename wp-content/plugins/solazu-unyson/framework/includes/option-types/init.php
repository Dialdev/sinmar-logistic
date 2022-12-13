<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$dir = dirname(__FILE__);

require $dir . '/simple.php';

require $dir . '/icon/class-slz-option-type-icon.php';
require $dir . '/image-picker/class-slz-option-type-image-picker.php';
require $dir . '/upload/class-slz-option-type-upload.php';
require $dir . '/color-picker/class-slz-option-type-color-picker.php';
require $dir . '/gradient/class-slz-option-type-gradient.php';
require $dir . '/background-image/class-slz-option-type-background-image.php';
require $dir . '/multi/class-slz-option-type-multi.php';
require $dir . '/switch/class-slz-option-type-switch.php';
require $dir . '/typography/class-slz-option-type-typography.php';
require $dir . '/multi-upload/class-slz-option-type-multi-upload.php';
require $dir . '/multi-picker/class-slz-option-type-multi-picker.php';
require $dir . '/wp-editor/class-slz-option-type-wp-editor.php';
require $dir . '/date-picker/class-slz-option-type-wp-date-picker.php';
require $dir . '/addable-option/class-slz-option-type-addable-option.php';
require $dir . '/addable-box/class-slz-option-type-addable-box.php';
require $dir . '/addable-popup/class-slz-option-type-addable-popup.php';
require $dir . '/map/class-slz-option-type-map.php';
require $dir . '/datetime-range/class-slz-option-type-datetime-range.php';
require $dir . '/datetime-picker/class-slz-option-type-datetime-picker.php';
require $dir . '/radio-text/class-slz-option-type-radio-text.php';
require $dir . '/popup/class-slz-option-type-popup.php';
require $dir . '/slider/class-slz-option-type-slider.php';
require $dir . '/slider/class-slz-option-type-short-slider.php';
require $dir . '/range-slider/class-slz-option-type-range-slider.php';
require $dir . '/rgba-color-picker/class-slz-option-type-rgba-color-picker.php';
require $dir . '/typography-v2/class-slz-option-type-typography-v2.php';
require $dir . '/oembed/class-slz-option-type-oembed.php';
require $dir . '/color-palette/class-slz-color-palette-new.php';
require $dir . '/code-editor/class-slz-option-type-code-editor.php';
require $dir . '/slz-import/class-slz-option-type-slz-import.php';
require $dir . '/slz-export/class-slz-option-type-slz-export.php';
require $dir . '/slz-cache/class-slz-option-type-slz-cache.php';
require $dir . '/slz-minify/class-slz-option-type-slz-minify.php';

if (!class_exists('SLZ_Option_Type_Multi_Select')) {
  require $dir . '/multi-select/class-slz-option-type-multi-select.php';
}

if (!class_exists('SLZ_Option_Type_Icon_v2')) {
  require_once $dir . '/icon-v2/class-slz-option-type-icon-v2.php';
}

if (!class_exists('SLZ_Option_Type_Select_Link')) {
    require_once $dir . '/slz-select-link/class-slz-option-type-select-link.php';
}
