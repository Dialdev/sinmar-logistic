<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }
$html_render = array();
$has_image = 'has-image';
if( $data['image_display'] != 'show' ) {
	$has_image = '';
}
$html_format = '
	<div class="item">
		<div class="slz-block-item-05 '. esc_attr( $has_image ) .' style-1">
		    <div class="block-date">
		        %1$s
		    </div>
		    %2$s
		    <div class="block-content">
		        <div class="block-content-wrapper">
		            %3$s
		            %4$s
		            %10$s
		        </div>
		    </div>
		    <div class="clearfix"></div>
			%5$s
		</div>
	</div>
';
$html_render['html_format'] = $html_format;
?>
<div class="slz-carousel-wrapper">
	<div class="carousel-overflow">
		<div class="slz-carousel" data-slidestoshow="1" data-autoplay="<?php echo esc_html( $data['slide_autoplay'] ); ?>" data-isdot="<?php echo esc_html( $data['slide_dots'] ); ?>" data-isarrow="<?php echo esc_html( $data['slide_arrows'] ); ?>" data-infinite="<?php echo esc_html( $data['slide_infinite'] ); ?>" data-speed="<?php echo esc_html( $data['slide_speed'] ); ?>">
			<?php $model->render_event_carousel_01( $html_render ); ?>
		</div>
	</div>
</div>
