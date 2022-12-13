<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @var array $option
 * @var array $data
 * @var string $id
 * @var array $set
 */

$wrapper_attr = array(
	'class' => $option['attr']['class'],
	'id'    => $option['attr']['id'],
);
unset($option['attr']['class'], $option['attr']['id']);

$icons = &$set['icons'];

// build $groups array based on $icons
$groups = array();
$font = array();
foreach ($icons as $icon_tab) {
	if(isset($icon_tab['group'])){
		$group_id = $icon_tab['group'];
		$groups[$group_id] = $set['groups'][$group_id];
	};
	$font = $set['font-type'];
}

ksort($icons);
ksort($groups);

?>
<div <?php echo slz_attr_to_html($wrapper_attr) ?>>

	<input <?php echo slz_attr_to_html($option['attr']) ?> type="hidden" />

	<div class="js-option-type-icon-container">

		<?php if (count($groups) > 1): ?>
		<div class="slz-backend-option-fixed-width">
			<select class="js-option-type-icon-dropdown">
				<?php

					foreach ( $font as $font_id => $font_title ) {
						$selected = (!isset($set['icons'][$data['value']]['group']) && isset($set['icons'][$data['value']]['group_id']) && $set['icons'][$data['value']]['group_id'] === $font_id);
						echo slz_html_tag('option', array('value' => $font_id,'selected' => $selected), esc_html($font_title));
						foreach ( $groups as $group_id => $group_info ) {
							if( isset($group_info['font-type']) && $group_info['font-type'] == $font_id ){

								$selected = (isset($set['icons'][$data['value']]['group']) && $set['icons'][$data['value']]['group'] === $group_id);

								echo slz_html_tag('option', array('value' => $group_id, 'selected' => $selected), htmlspecialchars($group_info['label']));
							}
						}
					}
				?>
			</select>
		</div>
		<?php endif; ?>

		<div class="slz-icon-toolbar">
			<input type="text" placeholder="<?php esc_html_e('Search Icon', 'slz'); ?>" class="js-option-type-icon-search"/>
		</div>

		<div class="option-type-icon-list js-option-type-icon-list <?php echo esc_attr($set['container-class']) ?>">
			<?php
				foreach ($icons as $icon_id => $icon_tab) {
					if( !isset( $icon_tab['group'] ) ){
						$icon_tab['group'] = '';
					}
					$active = ($data['value'] == $icon_id) ? 'active' : '';
					echo slz_html_tag('i', array(
						'class' => "$icon_id js-option-type-icon-item $active",
						'data-value' => $icon_id,
						'data-group-id' => $icon_tab['group_id'],
						'data-group' => $icon_tab['group']
					), true);
				}
			?>
		</div>

	</div>

</div>
