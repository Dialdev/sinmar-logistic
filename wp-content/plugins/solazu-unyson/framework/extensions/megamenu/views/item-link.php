<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var WP_Post $item
 * @var string $title
 * @var array $attributes
 * @var object $args
 * @var int $depth
 */
$icon_class = '';
$icon_dropdown_class = '';
if( isset($attributes['class'])) {
	$icon_dropdown_class = $attributes['class'];
}
if (
	slz()->extensions->get('megamenu')->show_icon()
	&&
	($icon = slz_ext_mega_menu_get_meta($item, 'icon'))
) {
	$icon_class = '<i class="icon-dropdown ' . trim( $icon_dropdown_class . " $icon" ) . '"></i>';
}

echo $args->before;
echo '<a ' . slz_attr_to_html( $attributes ) . '>' . $title . $icon_class . '</a>';
echo $args->after;