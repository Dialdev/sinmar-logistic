<?php if ( ! defined( 'ABSPATH' ) ) {
	die('Forbidden');
}
/**
 * @var  string $id
 * @var  array $option
 * @var  array $data
 * @var  array $fonts
 */

{
	$wrapper_attr = $option['attr'];

	unset(
	$wrapper_attr['value'],
	$wrapper_attr['name']
	);
}

{
	$option['value'] = array_merge(array(
		'size'   => 12,
		'family' => 'Arial',
		'style'  => '400',
		'color'  => '#000000',
	), (array)$option['value']);

	$data['value'] = array_merge($option['value'], is_array($data['value']) ? $data['value'] : array());
}
?>
<div <?php echo slz_attr_to_html($wrapper_attr) ?>>

	<div class="slz-option-typography-option slz-option-typography-option-size slz-border-box-sizing slz-col-sm-2" style="display: <?php echo (!isset($option['components']['size']) || $option['components']['size'] != false) ? 'block' : 'none' ?>;">
		<select data-type="size" name="<?php echo esc_attr($option['attr']['name']) ?>[size]" class="slz-option-typography-option-size-input">
		<?php for ($i = 9; $i <= 70; $i++): ?>
			<option value="<?php echo esc_attr($i) ?>" <?php echo $data['value']['size'] === $i ? ' selected="selected" ' : ''; ?>><?php echo $i ?>px</option>
		<?php endfor; ?>
		</select>
	</div>

	<div class="slz-option-typography-option slz-option-typography-option-family slz-border-box-sizing slz-col-sm-5"
	     style="display: <?php echo ( ! isset( $option['components']['family'] ) || $option['components']['family'] != false ) ? 'block' : 'none'; ?>;">
		<select data-type="family" data-value="<?php echo esc_attr($data['value']['family']); ?>"
		        name="<?php echo esc_attr( $option['attr']['name'] ) ?>[family]"
		        class="slz-option-typography-option-family-input"></select>
	</div>

	<div class="slz-option-typography-option slz-option-typography-option-style slz-border-box-sizing slz-col-sm-3" style="display: <?php echo (!isset($option['components']['family']) || $option['components']['family'] != false) ? 'block' : 'none'; ?>;">
		<select data-type="style" name="<?php echo esc_attr($option['attr']['name']) ?>[style]" class="slz-option-typography-option-style-input">
		<?php if (in_array($data['value']['family'], $fonts['standard'])): ?>
		<?php foreach (
			array(
				'300'       => 'Thin',
				'300italic' => 'Thin/Italic',
				'400'       => 'Normal',
				'400italic' => 'Italic',
				'700'       => 'Bold',
				'700italic' => 'Bold/Italic',
			)
			as $key => $style): ?>
				<option value="<?php echo esc_attr($key) ?>" <?php if ($data['value']['style'] === $key): ?>selected="selected"<?php endif; ?>><?php echo slz_htmlspecialchars($style) ?></option>
		<?php endforeach; ?>
		<?php else: ?>
			<?php if (!empty($fonts['google'][$data['value']['family']]['variants'])):?>
			<?php foreach ($fonts['google'][$data['value']['family']]['variants'] as $variant): ?>
				<option value="<?php echo esc_attr($variant) ?>" <?php if ($data['value']['style'] === $variant): ?>selected="selected"<?php endif; ?>><?php echo slz_htmlspecialchars(ucfirst($variant)) ?></option>
			<?php endforeach; ?>
			<?php endif;?>
		<?php endif; ?>
		</select>
	</div>

	<div class="slz-option-typography-option slz-option-typography-option-color slz-border-box-sizing slz-col-sm-2" data-type="color" style="display: <?php echo (!isset($option['components']['color']) || $option['components']['color'] != false) ? 'block' : 'none' ?>;">
	<?php
	echo slz()->backend->option_type('color-picker')->render(
		'color',
		array(
			'label' => false,
			'desc'  => false,
			'type'  => 'color-picker',
			'value' => $option['value']['color']
		),
		array(
			'value' => $data['value']['color'],
			'id_prefix' => 'slz-option-' . $id . '-typography-option-',
			'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
		)
	)
	?>
	</div>

</div>
