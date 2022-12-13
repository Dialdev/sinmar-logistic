<?php
$style_class = $slick_json = '';
$html_format = '
	<div class="item">
		<div class="block-image">
			<a href="%1$s" class="link  fancybox-thumb">
				<img src="%3$s" alt="" class="img-responsive img-full"/>
			</a>
		</div>
	</div>';
$html_render['html_format'] = $html_format;

?>
<div class="slz-carousel-centermode sc_gallery_carousel slz-image-carousel">
	<div class="carousel-overflow <?php echo esc_attr( $data['block_cls'] ); ?>" 
		data-arrowshow="<?php echo esc_attr( $data['slide_arrows'] )?>"
		data-dotshow="<?php echo esc_attr( $data['slide_dots'] )?>"
		data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ) ?>"
		data-infinite="<?php echo esc_attr( $data['slide_infinite'] ) ?>">
		<?php $data['model']->render_gallery_carousel( $html_render ); ?>
	</div>
</div>

<!-- custom css -->
<?php
$custom_css = '';
if ( !empty( $data['model']->attributes['color_slide_arrow'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow'] ) );
}
if ( !empty( $data['model']->attributes['color_slide_arrow_bg'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow_bg'] ) );
}
if ( !empty( $data['model']->attributes['color_slide_arrow_hv'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow:hover:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow_hv'] ) );
}
if ( !empty( $data['model']->attributes['color_slide_arrow_bg_hv'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow:hover{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow_bg_hv'] ) );
}
if ( !empty( $data['model']->attributes['color_slide_dots'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-dots li button:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_dots'] ) );
}
if ( !empty( $data['model']->attributes['color_slide_dots_at'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-dots li.slick-active button:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_dots_at'] ) );
}
if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}