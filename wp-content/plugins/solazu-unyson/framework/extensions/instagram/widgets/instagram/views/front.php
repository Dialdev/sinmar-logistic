<?php

echo wp_kses_post($before_widget);
?>

<div class="slz-widget-gallery instagram-<?php echo esc_attr( $unique_id ); ?>">
    <?php echo wp_kses_post( $block_title );?>

    <div class="widget-content">
        <ul class="list-unstyled list-inline <?php if ( $column == 3 ) echo 'three-column'; ?>">
        	<?php 
				if($media != false)
				{

					$count = 0;

					foreach ($media as $node) {

						if($count >= $limit_image)
							break;


						$url = $node['thumbnail_src'];

						$url2 = str_replace(array('/s150x150/', '/s640x640/', '/s1080x1080/'), array('/s320x320/', '/s320x320/', '/s320x320/'), $url);

						echo 	'<li>
									<a href="' . esc_url( $url ) . '" data-fancybox-group="gallery-' . esc_attr ( $unique_id ) . '"  class="thumb fancybox fancybox-thumb">
										<img src="' . esc_url( $url2 ) . '" alt="" class="img-gallery" />
									</a>
								</li>';

						$count++;
					}
				}
			?>
        </ul>
    </div>
</div>

<?php 
echo wp_kses_post( $after_widget );

?>