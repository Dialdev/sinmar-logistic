<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $id
 * @var  array $option
 * @var  array $data
 * @var  array $controls
 * @var string $move_img_src
 */

$attr = $option['attr'];
unset($attr['name']);
unset($attr['value']);

if ($option['sortable']) {
	$attr['class'] .= ' is-sortable';
}

?>
<div <?php echo slz_attr_to_html($attr) ?>>
	<table class="slz-option-type-addable-option-options" width="100%" cellpadding="0" cellspacing="0" border="0">
	<?php $i = 1; ?>
	<?php if(is_array($data['value'])):?>
	<?php foreach($data['value'] as $option_value): ?>
		<tr class="slz-option-type-addable-option-option">
			<td class="td-move">
				<img src="<?php echo esc_attr($move_img_src); ?>" width="7" />
			</td>
			<td class="td-option slz-force-xs">
			<?php
			echo slz()->backend->option_type($option['option']['type'])->render(
				$i,
				$option['option'],
				array(
					'value'       => $option_value,
					'id_prefix'   => $data['id_prefix'] . $id .'--option-',
					'name_prefix' => $data['name_prefix'] .'['. $id .']',
				)
			);

			$i++;
			?>
			</td>
			<td class="td-remove">
				<a href="#" onclick="return false;" class="dashicons slz-x slz-option-type-addable-option-remove"></a>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php endif;?>
	</table>
	<br class="default-addable-option-template slz-hidden" data-template="<?php
		/**
		 * Place template in attribute to prevent it to be treated as html
		 * when this option will be used inside another option template
		 */

		/**
		 * This is a reference.
		 * Unset before replacing with new value
		 * to prevent changing value to what it refers
		 */
		unset($values);

		$values = array();

		// must contain characters that will remain the same after htmlspecialchars()
		$increment_placeholder = '###-addable-option-increment-'. slz_rand_md5() .'-###';

		echo slz_htmlspecialchars(
			'<tr class="slz-option-type-addable-option-option">
				<td class="td-move">
					<img src="'. $move_img_src .'" width="7" />
				</td>
				<td class="td-option slz-force-xs">'.
					slz()->backend->option_type($option['option']['type'])->render(
						$increment_placeholder,
						$option['option'],
						array(
							'id_prefix'   => $data['id_prefix'] . $id .'--option-',
							'name_prefix' => $data['name_prefix'] .'['. $id .']',
						)
					).
				'</td>
				<td class="td-remove">
					<a href="#" onclick="return false;" class="dashicons slz-x slz-option-type-addable-option-remove"></a>
				</td>
			</tr>'
		);
	?>">
	<div><?php
		echo slz_html_tag('button', array(
			'type' => 'button',
			'class' => 'button slz-option-type-addable-option-add',
			'onclick' => 'return false;',
			'data-increment' => $i,
			'data-increment-placeholder' => $increment_placeholder,
		), slz_htmlspecialchars($option['add-button-text']));
	?>
	</div>
</div>