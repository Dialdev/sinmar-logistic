<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $item
 * @var array $choices
 * @var array $attr
 * @var string $value
 */

$options = $item['options'];
?>
<?php if (empty($choices)): ?>
	<!-- select not displayed: no choices -->
<?php else: ?>
	<div class="<?php echo esc_attr(slz_ext_builder_get_item_width('form-builder', $item['width'] .'/frontend_class')) ?>">
		<div class="field-select select-styled">
			<label for="<?php echo esc_attr($attr['id']) ?>"><?php echo slz_htmlspecialchars($item['options']['label']) ?>
				<?php if ($options['required']): ?><sup>*</sup><?php endif; ?>
			</label>
			<select <?php echo slz_attr_to_html($attr) ?> >
				<?php foreach ($choices as $choice): ?>
					<option <?php echo slz_attr_to_html($choice) ?> ><?php echo $choice['value'] ?></option>
				<?php endforeach; ?>
			</select>
			<?php if ($options['info']): ?>
				<p><em><?php echo $options['info'] ?></em></p>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>