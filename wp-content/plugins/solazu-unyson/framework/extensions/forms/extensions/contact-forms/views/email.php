<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $form_values
 * @var array $shortcode_to_item
 */

?>

<table border="0" cellpadding="10">
	<tbody>
	<?php foreach ($form_values as $shortcode => $form_value): ?>
		<?php

		if ( ! isset( $shortcode_to_item[ $shortcode ] ) ) {
			continue;
		}

		$item = &$shortcode_to_item[$shortcode];

		if ( ! isset( $item['options'] ) ) {
			continue;
		}

		$item_options = &$item['options'];

		switch ($item['type']) {
			case 'checkboxes':
				$title = ( isset( $item_options['label'] ) ) ? slz_htmlspecialchars($item_options['label']) : '';

				if ( ! is_array( $form_value ) || empty( $form_value ) ) {
					break;
				}

				$value = implode(', ', $form_value);
				break;
			case 'textarea':
				$title = slz_htmlspecialchars($item_options['label']);
				$value = '<pre>'. slz_htmlspecialchars($form_value) .'</pre>';
				break;
			case 'recaptcha':
				continue 2;
			default:
				$title = slz_htmlspecialchars($item_options['label']);

				if (is_array($form_value)) {
					$value = '<pre>'. slz_htmlspecialchars( print_r($form_value, true) ) .'</pre>';
				} else {
					$value = slz_htmlspecialchars( $form_value );
				}
		}
		?>
		<tr>
			<td valign="top"><b><?php echo $title ?></b></td>
			<td valign="top"><?php echo $value ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>