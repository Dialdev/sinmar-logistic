<?php

echo wp_kses_post($before_widget);
?>

<div class="slz-widget-gallery-carousel instagram-<?php echo esc_attr( $unique_id ); ?>">
    <?php echo wp_kses_post( $block_title );?>

    <div class="widget-content">
        <div class="slz-carousel-photos">
        	<div data-slidestoshow="<?php echo $number_items; ?>" class="slz-carousel slz-carousel-global">
	        	<?php 
					if($media != false)
					{

						$count = 0;

						foreach ($media as $node) {

							if($count >= $limit_image)
								break;


							$url = $node['thumbnail_src'];

							$url2 = str_replace(array('/s150x150/', '/s640x640/', '/s1080x1080/'), array('/s320x320/', '/s320x320/', '/s320x320/'), $url);

							echo 	'<div class="item">
                                        <a href="' . esc_url( $url ) . '" data-fancybox-group="gallery-' . esc_attr ( $unique_id ) . '" class="thumb fancybox"><img src="' . esc_url( $url2 ) . '" alt="" class="img-responsive"><span class="dh-overlay"></span></a>
                                    </div>
									';

							$count++;
						}
					}
				?>
			</div>
        </div>
    </div>
</div>

<?php 
echo wp_kses_post( $after_widget );

?>