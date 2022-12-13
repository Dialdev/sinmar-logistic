<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'tags-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$css = $custom_css = '';
?>

<div class="slz-tag tags-links sc_tags slz-shortcode <?php echo esc_attr( $block_cls ); ?>">
	<?php
	if( !empty( $data['block_title'] ) ) {
		echo '<div class="slz-title-shortcode" >'. esc_html( $data['block_title'] ) .'</div>';
	}
	?>
	<?php
	if( !empty( $data['number'] ) && is_numeric( $data['number'] ) && $data['number'] != 0 ) {
		$tags = get_tags(array('number'=>$data['number'],'orderby' =>'term_id', 'order' => 'DESC'));
		echo '<ul class="list-unstyled list-inline">';
			if( !empty( $tags ) ) {
				foreach ( $tags as $tag ) {
					$tag_link = get_tag_link( $tag->term_id );
					echo '<li><a href="'. esc_url( $tag_link ) .'" class="tag">'. esc_html( $tag->name ) .'</a></li>';
				}
			}
		echo '</ul>';
	}
	?>
</div>

<?php
if( !empty( $data['block_title_color'] ) ) {
	$css = '
		.%1$s .slz-title-shortcode {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['block_title_color'] ) );
}
/* text */
if( !empty( $data['tag_text_color'] ) ) {
	$css = '
		.%1$s.slz-tag .tag {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['tag_text_color'] ) );
}
if( !empty( $data['tag_text_hover_color'] ) ) {
	$css = '
		.%1$s.slz-tag .tag:hover {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['tag_text_hover_color'] ) );
}
/* end text */

/* background */
if( !empty( $data['tag_bg_color'] ) ) {
	$css = '
		.%1$s.slz-tag .tag {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['tag_bg_color'] ) );
}
if( !empty( $data['tag_bg_hover_color'] ) ) {
	$css = '
		.%1$s.slz-tag .tag:hover {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['tag_bg_hover_color'] ) );
}
/* end background */

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}