<?php
$style_class = $slick_json = '';
$html_format = '
	<div class="item">
		<div class="block-image-1 block-image">
			<a href="javascript:void(0)" class="link"><img src="%3$s" alt="" class="img-slider-item"></a>
		</div>
		<div class="image-title">%2$s</div>
	</div>';

if( $data['model']->attributes['layout_02_style'] == 'style-1' ){
	$ext  = slz()->extensions->get( 'gallery' );
	$image_upload  = $ext->locate_URI('/static/img/iphone-mockup.png');
}else{
	$image_upload = wp_get_attachment_url($data['model']->attributes['image-upload']);
	if(empty($data['model']->attributes['image-upload'])){
		$html_format = '
			<div class="item">
				<div class="block-image-1 block-image">
					<a href="%1$s" class="link fancybox-thumb"><img src="%3$s" alt="" class="img-slider-item"></a>
				</div>
				<div class="image-title">%2$s</div>
			</div>';
		$data['block_cls'] .= ' no-frame';
	}
}
$html_render['html_format'] = $html_format;

?>
<div id="<?php echo esc_attr( $data['uniq_id'] ); ?>" class="slz-shortcode sc_gallery_carousel <?php echo esc_attr( $data['block_cls'] ); ?> no-text-arrows" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<div class="slz-image-carousel  slz-carousel-mockup <?php echo $data['model']->attributes['layout_02_style']?> ">
		<div class="carousel-overflow">
			<div class="slz-slick-slider-mockup  sc_gallery_carousel_mockup" 
					data-arrowshow="<?php echo esc_attr( $data['slide_arrows'] )?>"
					data-dotshow="<?php echo esc_attr( $data['slide_dots'] )?>"
					data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ) ?>"
					data-infinite="<?php echo esc_attr( $data['slide_infinite'] ) ?>">
				<?php
					$data['model']->render_gallery_carousel( $html_render, 'layout-2' );
				?>
			</div>
			<?php if(!empty($image_upload)){
				echo '<div class="slider-mockup"><img src="'.esc_url($image_upload).'" alt=""></div>'; 
			}?>
		</div>
	</div>
</div>
<!-- custom css -->
<?php 
$custom_css = '';
 
if ( !empty( $data['model']->attributes['color_slide_arrow'] ) ) {
	$css = '
		.%1$s.sc_gallery_carousel .slick-arrow i:before{
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
		.%1$s.sc_gallery_carousel .slick-arrow:hover i:before{
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