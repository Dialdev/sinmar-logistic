<?php
$style_class = '';
$html_format = '
    <div class="item">
        <div class="block-image">
            <a href="%1$s" class="link fancybox-thumb"></a>
        	<img src="%3$s" alt="" class="img-responsive img-full"/>
        	<span class="dh-overlay"></span>
    	</div>
    </div>';
$html_render['html_format'] = $html_format;
?>
<div id="<?php echo esc_attr( $data['uniq_id'] ); ?>" class="slz-shortcode sc_gallery_carousel <?php echo esc_attr( $data['block_cls'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<div class="slz-image-carousel <?php echo esc_attr($data['style'])?>">
		<div class="carousel-overflow">
			<div class="slz-carousel slz-gallery-slide-slick" 
					data-slidestoshow="<?php echo esc_attr( $data['slidetoshow'] )?>"
					data-arrowshow="<?php echo esc_attr( $data['slide_arrows'] )?>"
					data-dotshow="<?php echo esc_attr( $data['slide_dots'] )?>"
					data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ) ?>"
					data-infinite="<?php echo esc_attr( $data['slide_infinite'] ) ?>" >
				<?php
					$data['model']->render_gallery_carousel( $html_render, 'layout-1' ); 
				?>
			</div>
		</div>
	</div>
</div>

<!-- custom css -->
<?php
$custom_css = '';
/* arrows color */
if ( !empty( $data['model']->attributes['color_slide_arrow'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow i,.%1$s.sc_gallery_carousel .slick-arrow 
		span{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow'] ) );
}
/* arrows bg color */
if ( !empty( $data['model']->attributes['color_slide_arrow_bg'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow_bg'] ) );
}
/* arrows hover color */
if ( !empty( $data['model']->attributes['color_slide_arrow_hv'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow:hover i,.%1$s.sc_gallery_carousel .slick-arrow:hover span{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow_hv'] ) );
}
/* arrows bakcground hover color */
if ( !empty( $data['model']->attributes['color_slide_arrow_bg_hv'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow:hover{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_arrow_bg_hv'] ) );
}
/* arrows dot color */
if ( !empty( $data['model']->attributes['color_slide_dots'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-dots li button:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['model']->attributes['color_slide_dots'] ) );
}
/* arrows dot active color */
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
