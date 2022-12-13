<?php
$html_format = '
	<div class="item">
		<div class="description">
			%4$s
		</div>
		<div class="info-wrapper">%2$s%3$s</div>
	</div>';

$html_render['html_format'] = $html_format;
$html_render['description_format'] = '%1$s';
$html_render['title_format'] = '<span class="name">%1$s</span>';
$html_render['position_format'] = '<span class="position">%1$s</span>';

?>
<div class=" slz-testimonial slz-testimonial-02 layout-05 slz-shortcode <?php echo esc_attr($data['block_cls'])?>" 
	data-id="<?php echo esc_attr( $data['uniq_id'] ); ?>" 
	data-show-arrow="<?php echo esc_attr( $data['show_arrows'] ); ?>" 
	data-dots="<?php echo esc_attr( $data['show_dots'] ); ?>" 
	data-speed="<?php echo esc_attr( $data['slide_speed'] ); ?>" 
	data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ); ?>" 
	data-infinite="<?php echo esc_attr( $data['slide_infinite'] ); ?>"
	data-animation="<?php echo esc_attr( $data['animation'] ); ?>"
	data-slidestoshow="<?php echo esc_attr( $data['slidesToShow'] ); ?>">
	<?php if(!empty($data['sc_title'])): ?>
		<h2 class="slz-title-shortcode"><?php echo esc_html($data['sc_title']); ?></h2>
	<?php endif; ?>
	<div class="slick-wrapper">
		<?php $data['model']->render_testimonial_slider_sc( $html_render ); ?>
	</div>

</div>

<?php 

/* custom inline css */
 $custom_css = '';
if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .name{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['title_color'] ) );
}
if ( !empty( $data['sc_title_color'] ) ) {
	$css = '
		.%1$s .slz-title-shortcode{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['sc_title_color'] ) );
}
if ( !empty( $data['position_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .position{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['position_color'] ) );
}
if ( !empty( $data['description_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .item{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['description_color'] ) );
}
if ( !empty( $data['icon_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .icons{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['icon_color'] ) );
}
if ( !empty( $data['quote_icon_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .description:before{
			color: %2$s ;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['quote_icon_color'] ) );
}
if ( !empty( $data['dots_color'] ) ) {
	$css = '
		.%1$s  .slick-dots li button:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['dots_color'] ) );
}
if ( !empty( $data['arrows_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn-prev i:before,
		.%1$s.slz-testimonial .btn-next i:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_color'] ) );
}

if ( !empty( $data['arrows_hv_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn-prev:hover i:before,
		.%1$s.slz-testimonial .btn-next:hover i:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_hv_color'] ) );
}

if ( !empty( $data['arrows_bg_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_bg_color'] ) );
}

if ( !empty( $data['arrows_bg_hv_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn:hover,
		.%1$s.slz-testimonial .btn:hover{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_bg_hv_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}
