<?php
$model = $data['model'];
$html_format_l = '
	<div class="client-item %2$s">
		%1$s
	</div>';
$html_format_r = '
	<div class="item %4$s">
		%3$s
		<div class="info-wrapper">
			%1$s
			%2$s
		</div>
	</div>';

$description_format = '<div class="description">%1$s</div>';
$thumb_size = 'large';
$html_left = $html_right = '';
if( $model->query->have_posts() ) {
	while ( $model->query->have_posts() ) {
		$model->query->the_post();
		$model->loop_index();
		$post_class = $model->get_post_class();
		//left
		$meta_image = '';
		if( $data['show_image_1'] == '2')
			$meta_image = $model->get_featured_image();
		else if($data['show_image_1'] == '1')
			$meta_image = $model->get_meta_icon();
		else if($data['show_image_1'] == '0')
			$meta_image = $model->get_meta_image_upload( $thumb_size );

		$html_left .= sprintf( $html_format_l,
				$meta_image,
				$post_class
		);
		//right
		$model->html_format['description_format'] = $description_format;
		$html_right .= sprintf( $html_format_r,
			$model->get_title(),
			$model->get_meta_position(),
			$model->get_content_format(),
			$post_class
		);
	}
	$model->reset();
}
?>
<div class="slz-testimonial slz-testimonial-03 layout-03 slz-shortcode <?php echo esc_attr($data['block_cls'])?>" data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ); ?>" data-animation="<?php echo esc_attr( $data['animation'] ); ?>">
	<?php if(!empty($data['sc_title'])): ?>
		<h2 class="slz-title-shortcode"><?php echo esc_html($data['sc_title']); ?></h2>
	<?php endif; ?>
	<div data-slidestoshow="<?php echo esc_attr($data['slidesToShow']);?>" data-slidestoscroll="1" class="client-wrapper">
		<?php echo wp_kses_post($html_left); ?>
	</div>
	<div data-slidestoshow="1" data-slidestoscroll="1" class="quote-wrapper">
		<?php echo wp_kses_post($html_right);?>
	</div>
	
</div>

<?php
/* custom inline css */
 $custom_css = '';
if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s .info-wrapper .name{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['title_color'] ) );
}
if ( !empty( $data['sc_title_color'] ) ) {
	$css = '
		.%1$s .slz-title-shortcode{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['sc_title_color'] ) );
}
if ( !empty( $data['position_color'] ) ) {
	$css = '
		.%1$s .info-wrapper .position{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['position_color'] ) );
}
if ( !empty( $data['description_color'] ) ) {
	$css = '
		.%1$s  .description{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['description_color'] ) );
}
if ( !empty( $data['icon_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .icons{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['icon_color'] ) );
}
if ( !empty( $data['quote_icon_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial-03 .description:before{
			color: %2$s ;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['quote_icon_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}