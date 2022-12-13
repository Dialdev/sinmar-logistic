<?php
$model = $data['model'];
$html_format_l = '
		<div class="item %2$s">
			<div class="client-item">
				%1$s
			</div>
		</div>';
$html_format_r = '
		<div class="content-item %4$s">
			%5$s
			%3$s
			<div class="info-wrapper">
				%1$s
				%2$s
			</div>
		</div>';

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
		$html_right .= sprintf( $html_format_r,
				$model->get_title(),
				$model->get_meta_position(),
				$model->get_content_format(),
				$post_class,
				$model->get_ratings()
		);
	}
	$model->reset();
}
?>
<div class="slz-testimonial slz-testimonial-01 layout-04 slz-shortcode <?php echo esc_attr($data['block_cls'])?>" 
	data-id="<?php echo esc_attr( $data['uniq_id'] ); ?>" 
	data-show-arrow="<?php echo esc_attr( $data['show_arrows'] ); ?>" 
	data-slidestoshow="<?php echo esc_attr( $data['slidesToShow'] ); ?>" 
	data-dots="<?php echo esc_attr( $data['show_dots'] ); ?>"
	data-speed="<?php echo esc_attr( $data['slide_speed'] ); ?>"
	data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ); ?>"
	data-infinite="<?php echo esc_attr( $data['slide_infinite'] ); ?>"
	data-animation="<?php echo esc_attr( $data['animation'] ); ?>">
	<?php if(!empty($data['sc_title'])): ?>
		<h2 class="slz-title-shortcode"><?php echo esc_html($data['sc_title']); ?></h2>
	<?php endif; ?>
	<div class="client-wrapper">
		<?php echo wp_kses_post($html_left); ?>
	</div>
	<div class="quote-wrapper">
		<?php echo wp_kses_post($html_right); ?>
	</div>
</div>

<?php 

/* custom inline css */
 $custom_css = '';
if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .name{
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
		.%1$s.slz-testimonial .position{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['position_color'] ) );
}
if ( !empty( $data['description_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .item{
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
if ( !empty( $data['dots_color'] ) ) {
	$css = '
        .%1$s  .slick-dots li button:before{
            color: %2$s;
        }
    ';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['dots_color'] ) );
}
if ( !empty( $data['arrows_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn-prev i:before,
		.%1$s.slz-testimonial .btn-next i:before
		{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_color'] ) );
}

if ( !empty( $data['arrows_bg_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn
		{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_bg_color'] ) );
}

if ( !empty( $data['arrows_hv_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn-prev:hover i:before,
		.%1$s.slz-testimonial .btn-next:hover i:before
		{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_hv_color'] ) );
}

if ( !empty( $data['arrows_bg_hv_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .btn:hover,
		.%1$s.slz-testimonial .btn:hover
		{
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_bg_hv_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}