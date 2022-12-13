<?php
$class_style = '';
$css = $custom_css = '';
$link_arr = array();
$param_default = array(
	'img'    => '',
	'link'   => '',
);
if( $data['style'] == '2' ){
	$class_style = 'style-2';
}elseif( $data['style'] == '3' ){
	$class_style = 'style-3';
}else{
	$class_style = '';
}

$items = (array) vc_param_group_parse_atts( $data['img_slider'] );
if ( !empty( $items ) ) {
	echo '<div class="slz-image-carousel '.esc_attr( $class_style ).'">';
		echo '<div class="carousel-overflow">';
			echo '<div class="slz-carousel" 
					data-slidestoshow="'. esc_attr( $data['slidetoshow'] ) .'"
					data-arrowshow="'.esc_attr( $data['arrow'] ).'" 
					data-dotshow="'. esc_attr( $data['dots'] ) .'" 
					data-autoplay="'. esc_attr( $data['slide_autoplay'] ) .'"
					data-infinite="'. esc_attr( $data['slide_infinite'] ) .'" >';

				foreach ($items as $item) {
					$item = array_merge( $param_default, $item );
					$url = wp_get_attachment_url($item['img']);
					echo '
						<div class="item">
							<div class="block-image">';
								if( !empty( $item['link'] ) ) {

									if ( !empty( $item['link'] ) ) {
										$link_arr = SLZ_Util::parse_vc_link( $item['link'] );
									}

									if ( !empty( $link_arr['url'] ) ) {
										echo '<a href="'. esc_url( $link_arr['url'] ) .'" '. esc_attr( $link_arr['other_atts'] ) .' class="link"></a>';
									}else{
										echo '<a href="'.esc_url($url).'" data-fancybox-group="group-image-carousel-'. esc_attr( $data['id'] ) .'" class="link fancybox-thumb"></a>';
									}

								}else{
									
									echo '<a href="'.esc_url($url).'" data-fancybox-group="group-image-carousel-'. esc_attr( $data['id'] ) .'" class="link fancybox-thumb"></a>';
								}
								$image = wp_get_attachment_image( $item['img'], $data['image_options'], false, array('class' => 'img-responsive img-full') );
								echo wp_kses_post( $image );
								echo '
								<span class="dh-overlay"> </span>
							</div>
						</div>
					';
				}// end for each

			echo '</div>';
		echo '</div>';
	echo '</div>';
}

/***** CUSTOM CSS *****/
if ( !empty( $data['dots_color'] ) ) {
	$css = '
		.%1$s .slick-dots li.slick-active button:before{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $data['dots_color'] ) );
}

if ( !empty( $data['arrow_text_color'] ) ) {
	$css = '
		.%1$s button.slick-arrow{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $data['arrow_text_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}