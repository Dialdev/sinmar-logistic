<?php
$item_default = array(
	'img'    => '',
	'link'   => '',
);
$out1 = '';
$out2 = '';
$link_arr = array();

$items = (array) vc_param_group_parse_atts( $data['img_slider'] );
if ( !empty( $items ) ) {
	foreach ( $items as $item ) {
		$item = array_merge( $item_default, $item );
		if ( empty( $item['img'] ) ){
			continue;
		}
		$url = wp_get_attachment_url($item['img']);
		$image = wp_get_attachment_image( $item['img'], $data['image_options'], false, array('class' => 'img-responsive') );

		$out1 .= '<div class="item">';
			$out1 .= '<div class="thumbnail-image">';
				$out1 .= $image;
			$out1 .= '</div>';
		$out1 .= '</div>';
		
		$out2 .= '<div class="item">';
			$out2 .= '<div class="image-gallery-wrapper">';
				if ( !empty( $item['link'] ) ) {
					$link_arr = SLZ_Util::parse_vc_link( $item['link'] );
					if ( !empty( $link_arr['url'] ) ) {
						$out2 .= '<a href="'. esc_url( $link_arr['url'] ) .'" '. esc_attr( $link_arr['other_atts'] ) .' class="images">';
					}else{
						$out2 .= '<a href="'.esc_url($url).'" class="images link fancybox-thumb">';
					}
				}else{
					$out2 .= '<a href="'.esc_url($url).'" class="images link fancybox-thumb">';
				}
					$out2 .= $image;
				$out2 .= '</a>';
			$out2 .= '</div>';
		$out2 .= '</div>';
		
	}// end foreach
?>
	<div class="slz-image-carousel slz-carousel-syncing">
		<div class="slider-for" 
				data-arrowshow="<?php echo esc_attr( $data['arrow'] )?>"
				data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ) ?>" >
			<?php echo ( $out2 ); ?>
		</div>
		<div class="slider-nav" 
				data-slidestoshow="<?php echo esc_attr( $data['slidetoshow'] )?>"
				data-dotshow="<?php echo esc_attr( $data['dots'] )?>"
				data-infinite="<?php echo esc_attr( $data['slide_infinite'] ) ?>">
			<?php echo( $out1 ); ?>
		</div>
	</div>
<?php
}// end if