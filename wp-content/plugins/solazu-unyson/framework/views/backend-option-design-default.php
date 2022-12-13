<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $id
 * @var  array $option
 * @var  array $data
 */

{
	if (!isset($option['label'])) {
		$option['label'] = slz_id_to_title($id);
	}

	if (!isset($option['desc'])) {
		$option['desc'] = '';
	}
}

{
	$help = false;

	if (!empty($option['help'])) {
		$help = array(
			'icon'  => 'info',
			'html'  => '{undefined}',
		);

		if (is_array($option['help'])) {
			$help = array_merge($help, $option['help']);
		} else {
			$help['html'] = $option['help'];
		}

		switch ($help['icon']) {
			case 'info':
				$help['class'] = 'dashicons dashicons-info';
				break;
			case 'video':
				$help['class'] = 'dashicons dashicons-video-alt3';
				break;
			default:
				$help['class'] = 'dashicons dashicons-smiley';
		}
	}
}

{
	try {
		$responsive_classes = SLZ_Cache::get(
			$cache_key = 'slz:backend-option-view:responsive-classes'
		);
	} catch (SLZ_Cache_Not_Found_Exception $e) {
		SLZ_Cache::set(
			$cache_key,
			$responsive_classes = apply_filters('slz:backend-option-view:design-default:responsive-classes', array(
				'label' => 'slz-col-xs-12 slz-col-sm-3 slz-col-lg-2',
				'input' => 'slz-col-xs-12 slz-col-sm-9 slz-col-lg-10',
			))
		);
	}

	$classes = array(
		'option' => array(
			'slz-backend-option',
			'slz-backend-option-design-default',
			'slz-backend-option-type-'. $option['type'],
			'slz-row'
		),
		'label' => array(
			'slz-backend-option-label',
			'responsive' => $responsive_classes['label'],
		),
		'input' => array(
			'slz-backend-option-input',
			'slz-backend-option-input-type-'. $option['type'],
			'responsive' => $responsive_classes['input'],
		),
		'desc' => array(
			'slz-backend-option-desc',
			'responsive' => 'slz-col-xs-12 slz-col-sm-offset-3 slz-col-sm-9 slz-col-lg-offset-2 slz-col-lg-10',
		),
	);

	/** Additional classes for option div */
	{
		if ($help) {
			$classes['option'][] = 'with-help';
		}

		if ($option['label'] === false) {
			$classes['label']['hidden'] = 'slz-hidden';
			unset($classes['label']['responsive']);

			$classes['input']['responsive'] = 'slz-col-xs-12';
			$classes['desc']['responsive']  = 'slz-col-xs-12';
		}

		$hide_bottom_border = slz_akg( 'hide-bottom-border', $option, false );
		if( $hide_bottom_border ) {
			$classes['option'][] = 'slz-bottom-border-hidden';
		}
	}

	/** Additional classes for input div */
	{
		$width_type = slz()->backend->option_type($option['type'])->_get_backend_width_type();

		if (!in_array($width_type, array('auto', 'fixed', 'full'))) {
			$width_type = 'auto';
		}

		$classes['input']['width-type'] = 'width-type-'. $width_type;
	}

	foreach ($classes as $key => $_classes) {
		$classes[$key] = implode(' ', $_classes);
	}
	unset($key, $_classes);
}
?>
<div class="<?php echo esc_attr($classes['option']) ?>" id="slz-backend-option-<?php echo esc_attr($data['id_prefix'] . $id) ?>">
	<?php if ($option['label'] !== false): ?>
		<div class="<?php echo esc_attr($classes['label']) ?>">
			<div class="slz-inner">
				<label for="<?php echo esc_attr($data['id_prefix']) . esc_attr($id) ?>"><?php echo slz_htmlspecialchars($option['label']) ?></label>
				<?php if ($help): ?><div class="slz-option-help slz-option-help-in-label slz-visible-xs-block <?php echo esc_attr($help['class']) ?>" title="<?php echo esc_attr($help['html']) ?>"></div><?php endif; ?>
				<div class="slz-clear"></div>
			</div>
		</div>
	<?php endif; ?>
	<div class="<?php echo esc_attr($classes['input']) ?>">
		<div class="slz-inner slz-pull-<?php echo is_rtl() ? 'right' : 'left'; ?>">
			<?php if ($help): ?><div class="slz-option-help slz-option-help-in-input slz-pull-right slz-hidden-xs <?php echo esc_attr($help['class']) ?>" title="<?php echo esc_attr($help['html']) ?>"></div><?php endif; ?>
			<div class="slz-inner-option">
				<?php echo slz()->backend->option_type($option['type'])->render($id, $option, $data) ?>
			</div>
			<div class="slz-clear"></div>
		</div>
		<div class="slz-clear"></div>
	</div>
	<div class="slz-clear"></div>
	<?php if ($option['desc']): ?>
		<div class="<?php echo esc_attr($classes['desc']) ?>">
			<div class="slz-inner"><?php echo ($option['desc'] ? $option['desc'] : '') ?></div>
		</div>
	<?php endif; ?>
	<div class="slz-clear"></div>
</div>