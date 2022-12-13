<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * @var string $id
 * @var  array $option
 * @var  array $data
 * @var  array $data_palette
 * @var  array $custom_choice_key
 */
$html = '<div id="slz-option-color-palette-predefined" class="slz-option slz-option-type-radio">';

$the_core_count = 0;
foreach ( $option['choices'] as $id => $color ) {
	++$the_core_count;
	$choice_id = $option['attr']['id'] . '-' . $id;

	if ( ! empty( $color ) && ( $id != $custom_choice_key ) ) {
		//add border class for white color
		$border = ( $color == '#ffffff' || $color == '#fff' ) ? 'slz-palette-border-white' : '';

		$html .= '<div class="slz-palette-color-'.$the_core_count.'">' . '<label for="' . esc_attr( $choice_id ) . '">
			<span class="slz-palette"><span class="slz-palette-inner ' . $border . '" style="background-color: ' . $color . ';"></span></span>
			<input type="radio" ' . 'name="' . esc_attr( $option['attr']['name'] ) . '[id]" ' . 'value="' . esc_attr( $id ) . '" ' . 'id="' . esc_attr( $choice_id ) . '" ' . ( $option['value'] == $id ? 'checked="checked" ' : '' ) . '></label></div>';
	} elseif ( $id == $custom_choice_key ) {
		$html .= '<div>' .
			'<label for="' . esc_attr( $choice_id ) . '">
				<input type="radio" ' . 'name="' . esc_attr( $option['attr']['name'] ) . '[id]" ' . 'value="' . esc_attr( $id ) . '" ' . 'id="' . esc_attr( $choice_id ) . '" ' . ( $option['value'] == $id ? 'checked="checked" ' : '' ) . '>' .
			'</label>' .
		'</div>';
	}
}

$html .= '</div>';

echo $html;