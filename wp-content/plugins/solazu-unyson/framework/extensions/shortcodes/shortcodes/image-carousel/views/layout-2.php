<?php
$item_default = array(
	'img'    => '',
	'link'   => '',
);
$out = '';
$link_arr = array();

$items = (array) vc_param_group_parse_atts( $data['img_slider'] );
if ( !empty( $items ) ) {
	foreach ( $items as $item ) {
		$item = array_merge( $item_default, $item );
		if( empty( $item['img'] ) ) {
			continue;
		}
		$url = wp_get_attachment_url($item['img']);
		$image = wp_get_attachment_image( $item['img'], $data['image_options'], false, array('class' => 'img-slider-item') );
		$out .= '<div class="item">';
			$out .= '<div class="block-image block-image-1">';
				if( !empty( $item['link'] ) ){
					$link_arr = SLZ_Util::parse_vc_link( $item['link'] );
					if( !empty( $link_arr['url'] ) ) {
						$out .= '<a href="'. esc_url( $link_arr['url'] ) .'" '. esc_attr( $link_arr['other_atts'] ) .'>';
					}else{
						$out .= '<a href="'.esc_url($url).'" class="link fancybox-thumb">';
					}
				}else{
					$out .= '<a href="'.esc_url($url).'" class="link fancybox-thumb">';
				}
					$out .= $image;
				$out .= '</a>';
			$out .= '</div>';
		$out .= '</div>';
	}// end foreach
	
	// image mockup
	$image_mockup = '';
	$mockup_class = 'style-2';
	if( $data['mobile_img_2'] == 'yes' ) {
		if( !empty( $data['upload_mobile_img_2'] ) ) {
			$image_mockup = wp_get_attachment_image( $data['upload_mobile_img_2'], 'full' );
			$mockup_class = '';
		}
	}
?>
	<div class="slz-image-carousel slz-carousel-mockup <?php echo esc_attr($mockup_class) ?>" 
			data-arrowshow="<?php echo esc_attr( $data['arrow'] )?>"
			data-dotshow="<?php echo esc_attr( $data['dots'] )?>"
			data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ) ?>"
			data-infinite="<?php echo esc_attr( $data['slide_infinite'] ) ?>"
			data-slidestoshow="3" >
		<div class="carousel-overflow">
			<div class="slz-slick-slider-mockup">
				<?php echo ( $out ); ?>
			</div>
			<?php if( !empty($image_mockup) ) :
					echo '<div class="slider-mockup">' . $image_mockup . '</div>';
				endif;
			?>
		</div>
	</div>
<?php
}//end if