<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_cls = $block->attributes['extra_class'] . ' ' . $block->attributes['block-class'];
$post_count = 0;
$isotope_class = '';
$isotope_class_arr = array(
	'0'  => '',
	'1'  => '',
	'2'  => '',
	'3'  => '',
	'4'  => 'grid-item-width-2 grid-item-height-1',
	'5'  => '',
	'6'  => '',
	'7'  => '',
);
?>

<div class="slz-shortcode sc_posts_mansory slz-posts-mansory slz-post-mansory-<?php echo esc_attr( $block->attributes['layout'] ); ?> <?php echo esc_attr($block_cls) . ' ' . (!empty( $block->attributes['category_filter'] ) ? 'has-category-filter' : '') ?>">

<?php
if ($block->attributes['block_title'] != '') {
	echo '<div class="' . esc_attr( $block->attributes['block_title_class'] ) . '">' . esc_html($block->attributes['block_title']) . '</div>';
}

echo ( $block->render_category_tabs() );
if( $block->attributes['layout'] == 'layout-2' ) {
	echo '<div class="slz-isotope-grid-2 column-3">';
}else{
	echo '<div class="slz-isotope-grid column-' . esc_attr ( $block->attributes['column'] ) . '">';
}

if ( !empty( $block->query->posts ) ) {
	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		switch ( $block->attributes['layout'] ) {
			case 'layout-1':
				echo slz_render_view( $instance->locate_path( '/views/layout-1.php' ), compact( 'module' ) );
				break;
			case 'layout-2':
				$isotope_class = isset($isotope_class_arr[$post_count])? $isotope_class_arr[$post_count] : '';
				echo slz_render_view( $instance->locate_path( '/views/layout-2.php' ), compact( 'module', 'isotope_class' ) );
				break;
			default:
				echo slz_render_view( $instance->locate_path( '/views/layout-1.php' ), compact( 'module' ) );
				break;
		}// end switch case
		
		$post_count++;
	}// end foreach
}// end if

echo '</div>';
echo ( $block->get_pagination() );

echo '</div>';
wp_reset_postdata();
