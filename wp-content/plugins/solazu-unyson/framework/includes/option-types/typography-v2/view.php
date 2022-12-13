<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
/**
 * @var  SLZ_Option_Type_Typography_v2 $typography_v2
 * @var  string $id
 * @var  array $option
 * @var  array $data
 * @var array $defaults
 */

{
	$wrapper_attr = $option['attr'];

	unset(
		$wrapper_attr['value'],
		$wrapper_attr['name']
	);
}

{
	$option['value'] = array_merge( $defaults['value'], (array) $option['value'] );
	$data['value']   = array_merge( $option['value'], is_array($data['value']) ? $data['value'] : array() );
	$google_font     = $typography_v2->get_google_font( $data['value']['family'] );

}

$components = (isset($option['components']) && is_array($option['components'])) ? array_merge($defaults['components'], $option['components']) : $defaults['components'];
?>
<div <?php echo slz_attr_to_html( $wrapper_attr ) ?>>
	<?php if ( $components['family'] ) : ?>
		<div class="slz-option-typography-v2-option slz-option-typography-v2-option-family slz-border-box-sizing slz-col-sm-5">
			<select data-type="family" data-value="<?php echo esc_attr($data['value']['family']); ?>"
			        name="<?php echo esc_attr( $option['attr']['name'] ) ?>[family]"
			        class="slz-option-typography-v2-option-family-input">
			</select>

			<div class="slz-inner"><?php _e('Font face', 'slz'); ?></div>
		</div>

		<div class="slz-option-typography-v2-option slz-option-typography-v2-option-style slz-border-box-sizing slz-col-sm-3"
		     style="display: <?php echo ( $google_font ) ? 'none' : 'inline-block'; ?>;">
			<select data-type="style" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[style]"
			        class="slz-option-typography-v2-option-style-input">
				<?php foreach (
					array(
						'normal'  => __('Normal', 'slz'),
						'italic'  => __('Italic', 'slz'),
						'oblique' => __('Oblique', 'slz')
					)
					as $key => $style
				): ?>
					<option value="<?php echo esc_attr( $key ) ?>"
					        <?php if ($data['value']['style'] === $key): ?>selected="selected"<?php endif; ?>><?php echo slz_htmlspecialchars( $style ) ?></option>
				<?php endforeach; ?>
			</select>

			<div class="slz-inner"><?php _e( 'Style', 'slz' ); ?></div>
		</div>

		<div class="slz-option-typography-v2-option slz-option-typography-v2-option-weight slz-border-box-sizing slz-col-sm-3"
		     style="display: <?php echo ( $google_font ) ? 'none' : 'inline-block'; ?>;">
			<select data-type="weight" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[weight]"
			        class="slz-option-typography-v2-option-weight-input">
				<?php foreach (
					array(
						100 => 100,
						200 => 200,
						300 => 300,
						400 => 400,
						500 => 500,
						600 => 600,
						700 => 700,
						800 => 800,
						900 => 900
					)
					as $key => $style
				): ?>
					<option value="<?php echo esc_attr( $key ) ?>"
					        <?php if ($data['value']['weight'] == $key): ?>selected="selected"<?php endif; ?>><?php echo slz_htmlspecialchars( $style ) ?></option>
				<?php endforeach; ?>
			</select>

			<div class="slz-inner"><?php _e( 'Weight', 'slz' ); ?></div>
		</div>
		<?php if ( !empty($components['subset']) ) : ?>
		<div class="slz-option-typography-v2-option slz-option-typography-v2-option-subset slz-border-box-sizing slz-col-sm-2"
		     style="display: <?php echo ( $google_font ) ? 'inline-block' : 'none'; ?>;">
			<select data-type="subset" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[subset]"
			        class="slz-option-typography-v2-option-subset">
				<?php if ( $google_font ) {
					foreach ( $google_font['subsets'] as $subset ) { ?>
						<option value="<?php echo esc_attr( $subset ) ?>"
						        <?php if ($data['value']['subset'] === $subset): ?>selected="selected"<?php endif; ?>><?php echo slz_htmlspecialchars( $subset ); ?></option>
					<?php }
				}
				?>
			</select>

			<div class="slz-inner"><?php _e( 'Script', 'slz' ); ?></div>
		</div>
		<?php endif;?>
		<div
			class="slz-option-typography-v2-option slz-option-typography-v2-option-variation slz-border-box-sizing slz-col-sm-2"
			style="display: <?php echo ( $google_font ) ? 'inline-block' : 'none'; ?>;">
			<select data-type="variation" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[variation]"
			        class="slz-option-typography-v2-option-variation">
				<?php if ( $google_font ) {
					foreach ( $google_font['variants'] as $variant ) { ?>
						<option value="<?php echo esc_attr( $variant ) ?>"
						        <?php if ($data['value']['variation'] == $variant): ?>selected="selected"<?php endif; ?>><?php echo slz_htmlspecialchars( $variant ); ?></option>
					<?php }
				}
				?>
			</select>

			<div class="slz-inner"><?php _e( 'Style', 'slz' ); ?></div>
		</div>
	<?php endif; ?>

	<?php if ( $components['size'] ) : ?>
		<div class="slz-option-typography-v2-option slz-option-typography-v2-option-size slz-border-box-sizing slz-col-sm-2">
			<input data-type="size" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[size]"
			       class="slz-option-typography-v2-option-size-input" type="text"
			       value="<?php echo esc_attr($data['value']['size']); ?>">

			<div class="slz-inner"><?php _e( 'Size', 'slz' ); ?></div>
		</div>
	<?php endif; ?>

	<?php if ( $components['line-height'] ) : ?>
		<div
			class="slz-option-typography-v2-option slz-option-typography-v2-option-line-height slz-border-box-sizing slz-col-sm-2">
			<input data-type="line-height" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[line-height]"
			       value="<?php echo esc_attr($data['value']['line-height']); ?>"
			       class="slz-option-typography-v2-option-line-height-input" type="text">

			<div class="slz-inner"><?php _e( 'Line height', 'slz' ); ?></div>
		</div>
	<?php endif; ?>

	<?php if ( $components['letter-spacing'] ) : ?>
		<div
			class="slz-option-typography-v2-option slz-option-typography-v2-option-letter-spacing slz-border-box-sizing slz-col-sm-2">
			<input data-type="letter-spacing" name="<?php echo esc_attr( $option['attr']['name'] ) ?>[letter-spacing]"
			       value="<?php echo esc_attr($data['value']['letter-spacing']); ?>"
			       class="slz-option-typography-v2-option-letter-spacing-input" type="text">

			<div class="slz-inner"><?php _e( 'Letter spacing', 'slz' ); ?></div>
		</div>
	<?php endif; ?>

	<?php if ( $components['color'] ) : ?>
		<div class="slz-option-typography-v2-option slz-option-typography-v2-option-color slz-border-box-sizing slz-col-sm-2"
		     data-type="color">
			<?php
			echo slz()->backend->option_type( 'color-picker' )->render(
				'color',
				array(
					'label' => false,
					'desc'  => false,
					'type'  => 'color-picker',
					'value' => $option['value']['color']
				),
				array(
					'value'       => $data['value']['color'],
					'id_prefix'   => 'slz-option-' . $id . '-typography-v2-option-',
					'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
				)
			)
			?>
			<div class="slz-inner"><?php _e( 'Color', 'slz' ); ?></div>
		</div>
	<?php endif; ?>

</div>
