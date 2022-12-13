<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $type
 * @var string $html
 */

{
	$classes = array(
		'option' => array(
			'form-field',
			'slz-backend-container',
			'slz-backend-container-type-'. $type
		),
		'content' => array(
			'slz-backend-container-content',
		),
	);

	foreach ($classes as $key => $_classes) {
		$classes[$key] = implode(' ', $_classes);
	}
	unset($key, $_classes);
}

?>
<tr class="<?php echo esc_attr($classes['option']) ?>">
	<td colspan="2" class="<?php echo esc_attr($classes['content']) ?>"><?php echo $html ?></td>
</tr>