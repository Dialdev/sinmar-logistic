<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}


$block_cls = $block->attributes['extra_class'] . ' ' . $block->attributes['block-class'];
$class_position = '';
if( !empty( $block->attributes['position'] ) ) {
	if( $block->attributes['position'] == 'right' ) {
		$class_position = 'right';
	}
}

echo '<div class="sc_block_grid slz-shortcode '. esc_attr( $block_cls ) .'">';
	if( !empty( $block->attributes['block_title'] ) ) {
		echo '<div class="' . esc_attr( $block->attributes['block_title_class'] ) . '">' . esc_html($block->attributes['block_title']) . '</div>';
	}
	switch ( $block->attributes['style'] ) {
		case 'style-1':
			echo slz_render_view( $instance->locate_path( '/views/style-1.php' ), compact('block', 'instance', 'class_position') );
			break;
		case 'style-2':
			echo slz_render_view( $instance->locate_path( '/views/style-2.php' ), compact('block', 'instance', 'class_position') );
			break;
		case 'style-3':
			echo slz_render_view( $instance->locate_path( '/views/style-3.php' ), compact('block', 'instance', 'class_position') );
			break;
		case 'style-4':
			echo slz_render_view( $instance->locate_path( '/views/style-4.php' ), compact('block', 'instance', 'class_position') );
			break;
		case 'style-5':
			echo slz_render_view( $instance->locate_path( '/views/style-5.php' ), compact('block', 'instance', 'class_position') );
			break;
		case 'style-6':
			echo slz_render_view( $instance->locate_path( '/views/style-6.php' ), compact('block', 'instance', 'class_position') );
			break;
		case 'style-7':
			echo slz_render_view( $instance->locate_path( '/views/style-7.php' ), compact('block', 'instance', 'class_position') );
			break;
		default:
			echo esc_html__( 'Please choose another style to show', 'slz' );
			break;
	}
echo '</div>';
wp_reset_postdata();
