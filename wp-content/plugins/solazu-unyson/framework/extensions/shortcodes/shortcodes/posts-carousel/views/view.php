<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
$block = new SLZ_Block($data);
$block_cls = $block->attributes['extra_class'] . ' ' . $block->attributes['block-class'];

$show_dots     = 1;
$show_arrows   = 1;
$autoplay      = 1;
$infinite      = 1;

if ( !empty($data['show_dots']) && $data['show_dots'] != 'yes' ) {
	$show_dots = 0;
}
if ( !empty($data['show_arrows']) && $data['show_arrows'] != 'yes' ) {
	$show_arrows = 0;
}
if ( !empty($data['slide_autoplay']) && $data['slide_autoplay'] != 'yes' ) {
	$autoplay = 0;
}
if ( !empty($data['slide_infinite']) && $data['slide_infinite'] != 'yes' ) {
	$infinite = 0;
}
if ( empty($data['slide_speed']) ) {
	$data['slide_speed'] = 600;
}
if( empty($data['animation'])) {
	$data['animation'] = 0;
}
?>

<div data-block-class="<?php echo esc_attr( $block->attributes['block-class'] ); ?>" class="slz-shortcode sc_carousel_posts <?php echo esc_attr($block_cls) . ' ' . (!empty( $block->attributes['category_filter'] ) ? 'has-category-filter' : '') ?>"
	data-dots="<?php echo esc_attr( $show_dots ); ?>"
	data-arrow="<?php echo esc_attr( $show_arrows ); ?>"
	data-speed="<?php echo esc_attr( $data['slide_speed'] ); ?>"
	data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
	data-infinite="<?php echo esc_attr( $infinite ); ?>"
	data-animation="<?php echo esc_attr( $data['animation'] ); ?>" >

<?php

if ($block->attributes['block_title'] != '') {
	echo '<div class="' . esc_attr( $block->attributes['block_title_class'] ) . '">' . esc_html($block->attributes['block_title']) . '</div>';
}

echo ( $block->render_category_tabs() );
if( file_exists( $instance->locate_path( '/views/template_' . $block->attributes['template'] . '.php' ) ) ) {
	echo slz_render_view( $instance->locate_path( '/views/template_' . $block->attributes['template'] . '.php' ), compact('block', 'instance'));
}
echo ( $block->get_pagination() );
?>
</div>
