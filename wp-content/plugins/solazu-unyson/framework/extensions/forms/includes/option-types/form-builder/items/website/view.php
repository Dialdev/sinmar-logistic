<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $item
 * @var array $attr
 */

$options = $item['options'];
?>
<div class="<?php echo esc_attr(slz_ext_builder_get_item_width('form-builder', $item['width'] .'/frontend_class')) ?>">
	<div class="field-text">
		<label for="<?php echo esc_attr($attr['id']) ?>"><?php echo slz_htmlspecialchars($item['options']['label']) ?>
			<?php if ($options['required']): ?><sup>*</sup><?php endif; ?>
		</label>
		<input <?php echo slz_attr_to_html($attr) ?>>
		<?php if ($options['info']): ?>
			<p><em><?php echo $options['info'] ?></em></p>
		<?php endif; ?>
	</div>
</div>