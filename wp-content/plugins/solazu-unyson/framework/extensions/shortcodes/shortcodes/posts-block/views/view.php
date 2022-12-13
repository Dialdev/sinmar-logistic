<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
$block = new SLZ_Block($data);
$block_cls = $block->attributes['extra_class'] . ' ' . $block->attributes['block-class'];

echo '<div class="slz-shortcode sc_block_posts '. esc_attr( $block_cls ) . (!empty( $block->attributes['category_filter'] ) ? 'has-category-filter' : '') .'">';
	if ($block->attributes['block_title'] != '') {
		echo '<div class="' . esc_attr( $block->attributes['block_title_class'] ) . '">' . esc_html($block->attributes['block_title']) . '</div>';
	}
echo ( $block->render_category_tabs() );

	switch ( $block->attributes['layout'] ) {
		case 'layout-1':
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('block', 'view_path', 'instance') );
			break;
		case 'layout-2':
			echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('block', 'view_path', 'instance') );
			break;
		case 'layout-3':
			echo slz_render_view( $instance->locate_path('/views/layout-3.php'), compact('block', 'view_path', 'instance') );
			break;
		case 'layout-4':
			echo slz_render_view( $instance->locate_path('/views/layout-4.php'), compact('block', 'view_path', 'instance') );
			break;
		default:
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('block', 'view_path', 'instance') );
			break;
	}

echo ( $block->get_pagination() );
echo '</div>';