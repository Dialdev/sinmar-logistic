<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $label
 * @var array $item
 * @var array $attr
 */
?>
<div class="<?php echo esc_attr(slz_ext_builder_get_item_width('form-builder', $item['width'] .'/frontend_class')) ?>">
	<div class="field-recaptcha">
		<label><?php echo slz_htmlspecialchars($item['options']['label']) ?></label>
		<input type="hidden" name="<?php echo esc_attr($item['shortcode']); ?>">
		<div <?php echo slz_attr_to_html($attr); ?>></div>
	</div>
</div>