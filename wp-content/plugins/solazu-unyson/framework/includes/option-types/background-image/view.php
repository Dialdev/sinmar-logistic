<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
/**
 * @var string $id
 * @var  array $option
 * @var  array $data
 */

{
	$wrapper_attr = $option['attr'];

	unset(
	$wrapper_attr['value'],
	$wrapper_attr['name']
	);
}

if ( empty( $option['choices'] ) ) {
	$option['choices'] = array();
}

if (empty( $option['choices'] )) {
	$wrapper_attr['class'] .= ' no-choices';
}

?>
<div <?php echo slz_attr_to_html($wrapper_attr) ?>>
	<div class="type">
		<?php
		echo slz()->backend->option_type( 'radio' )->render(
			'type',
			array(
				'type'    => 'radio',
				'value'   => 'predefined',
				'choices' => array(
					'predefined' => __( 'Predefined images', 'slz' ),
					'custom'     => __( 'Custom image', 'slz' )
				),
			),
			array(
				'value'       => $data['value']['type'],
				'id_prefix'   => $data['id_prefix'] . $id . '-',
				'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
			)
		);
		?>
	</div>

	<?php
	// Predefined
	$choices = array();
	foreach ( $option['choices'] as $choice_key => $choice_value ) {
		$choices[ $choice_key ] = array(
			'small' => array(
				'src' => $choice_value['icon'],
				'height' => 50
			),
			'data' => array(
				'css' => $choice_value['css']
			)
		);
	}
	?>
	<div class="predefined" <?php if ($data['value']['type'] === 'custom'): ?>style="display: none;"<?php endif; ?>>
		<?php
		echo slz()->backend->option_type( 'image-picker' )->render(
			'predefined',
			array(
				'type'    => 'image-picker',
				'value'   => $option['value'],
				'choices' => $choices
			),
			array(
				'value'       => ( $data['value']['type'] === 'predefined' ) ? $data['value']['predefined'] : $option['value'],
				'id_prefix'   => $data['id_prefix'] . $id . '-',
				'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
			)
		);
		?>
	</div>

	<div class="custom" <?php if ($data['value']['type'] !== 'custom'): ?>style="display: none;"<?php endif; ?>>
		<?php
		echo slz()->backend->option_type( 'upload' )->render(
			'custom',
			array(
				'type'  => 'upload'
			),
			array(
				'value'       => ( $data['value']['type'] === 'custom' )
									? array('attachment_id' => $data['value']['custom'])
									: '',
				'id_prefix'   => $data['id_prefix'] . $id . '-',
				'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
			)
		);
		?>
	</div>
</div>