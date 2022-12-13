<?php
$data = slz_get_db_post_option( $module->post_id, 'feature-gallery-images', '' );
if( $data ):
	$thumb_url = array();
	if( get_post_thumbnail_id( $module->post_id ) ) {
		$thumb_id = get_post_thumbnail_id( $module->post_id );
		$thumb_url[] = array('attachment_id'=>$thumb_id);
	}
	$gallery_arr = array_merge($data,$thumb_url);
	$image_large = 'full';
	if( isset( $module->attributes['thumb-size']['large'] ) ) {
		$image_large = $module->attributes['thumb-size']['large'];
	}
	if( $gallery_arr ):
		$img_link = array();
		foreach ( $gallery_arr as $item ) {
			$img = wp_get_attachment_image($item['attachment_id'], $image_large);
			if( $img ) {
				$img_link[$item['attachment_id']] = '
					<div class="item">
					    <div class="featured-carousel-item">
					        <div class="wrapper-image">' . $img .
					'		</div>
					    </div>
					</div>';
			}
		}
		if( $img_link):
?>
			<div class="block-image has-gallery">
				<?php echo ( $module->get_ribbon_date() );?>
				<div class="slz-gallery-format slz-image-carousel">
					<div class="carousel-overflow">
						<div class="slz-carousel">
						<?php echo implode('', $img_link);?>
						</div>
					</div>
				</div>
			</div>
<?php endif;//img_link
	endif;//gallery
endif; // data?>