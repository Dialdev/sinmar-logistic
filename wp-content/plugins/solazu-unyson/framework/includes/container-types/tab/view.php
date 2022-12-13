<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $tabs
 * @var array $values
 * @var array $options_data
 */

$global_lazy_tabs = slz()->theme->get_config('lazy_tabs');

?>
<div class="slz-options-tabs-wrapper">
	<div class="slz-options-tabs-list">
		<ul>
			<?php foreach ($tabs as $tab_id => &$tab): ?>
				<li <?php echo isset($tab['li-attr']) ? slz_attr_to_html($tab['li-attr']) : ''; ?> >
					<a href="#slz-options-tab-<?php echo esc_attr($tab_id) ?>" class="nav-tab slz-wp-link" ><?php
						echo htmlspecialchars($tab['title'], ENT_COMPAT, 'UTF-8') ?></a>
				</li>
			<?php endforeach; unset($tab); ?>
		</ul>
		<div class="slz-clear"></div>
	</div>
	<div class="slz-options-tabs-contents metabox-holder">
		<div class="slz-inner">
			<?php
			foreach ($tabs as $tab_id => &$tab):
				// prepare attributes
				{
					$attr = isset($tab['attr']) ? $tab['attr'] : array();

					$lazy_tabs = isset($tab['lazy_tabs']) ? $tab['lazy_tabs'] : $global_lazy_tabs;

					$attr['id'] = 'slz-options-tab-'. esc_attr($tab_id);

					if (!isset($attr['class'])) {
						$attr['class'] = 'slz-options-tab';
					} else {
						$attr['class'] = 'slz-options-tab '. $attr['class'];
					}

					if ($lazy_tabs) {
						$attr['data-slz-tab-html'] = slz()->backend->render_options(
							$tab['options'], $values, $options_data
						);
					}
				}
				?><div <?php echo slz_attr_to_html($attr) ?>><?php
					echo $lazy_tabs ? '' : slz()->backend->render_options($tab['options'], $values, $options_data);
				?></div><?php
				unset($tabs[$tab_id]); // free memory after printed and not needed anymore
			endforeach;
			unset($tab);
			?>
		</div>
	</div>
	<div class="slz-clear"></div>
</div>
