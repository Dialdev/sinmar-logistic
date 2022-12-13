<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$dir = dirname(__FILE__);


require $dir .'/text/class-slz-option-type-form-builder-item-text.php';
require $dir .'/textarea/class-slz-option-type-form-builder-item-textarea.php';
require $dir .'/number/class-slz-option-type-form-builder-item-number.php';
require $dir .'/checkboxes/class-slz-option-type-form-builder-item-checkboxes.php';
require $dir .'/radio/class-slz-option-type-form-builder-item-radio.php';
require $dir .'/select/class-slz-option-type-form-builder-item-select.php';
require $dir .'/email/class-slz-option-type-form-builder-item-email.php';
require $dir .'/website/class-slz-option-type-form-builder-item-website.php';
require $dir .'/recaptcha/class-slz-option-type-form-builder-item-recaptcha.php';

if (apply_filters('slz:ext:forms:builder:load-item:form-header-title', true)) {
	require $dir . '/form-header-title/class-slz-option-type-form-builder-item-form-header-title.php';
}