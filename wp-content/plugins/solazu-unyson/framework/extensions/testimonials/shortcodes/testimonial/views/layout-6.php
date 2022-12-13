<?php

// 1$ - title, 2$ - position, 3$ - desc, 4$ - post class, 5$ - image
$top_desc_format = '
		<div class="%4$s">
			%5$s
			<div class="info-wrapper">
				%1$s
				%2$s
			</div>
			%3$s
		</div>';
// 1$ - image, 2$ - post class
$bottom_format = '
			<div class="item %2$s">
				<div class="client-item">
					%1$s
				</div>
			</div>';
$thumb_size = 'large';
$html_render['description_format'] = '<div class="description">%1$s</div>';
$html_render['thumbnail_format'] = $html_render['feature_image_format'] = '%1$s';
$html_render['image_format'] = '<div class="img-wrapper">%1$s</div>';

$model = $data['model'];
$output = array(
	'top' => '',
	'top_desc' => '',
	'bottom'   => '',
);
$model->html_format = $model->set_default_options( $html_render );
$model->attributes['show_thumbnail'] = 'yes';
if( $model->query->have_posts() ) {
	while ( $model->query->have_posts() ) {
		$model->query->the_post();
		$model->loop_index();
		$post_class = $model->get_post_class();
		$meta_image = '';
		if( $data['show_image_1'] == '2')
			$meta_image = $model->get_featured_image();
		else if($data['show_image_1'] == '1')
			$meta_image = $model->get_meta_icon();
		else if($data['show_image_1'] == '0')
			$meta_image = $model->get_meta_image_upload( $thumb_size );

		$output['top_desc'] .= sprintf($top_desc_format,
				$model->get_title(),
				$model->get_meta_position(),
				$model->get_content_format(),
				$post_class,
				$meta_image
		);
		$output['bottom'] .= sprintf($bottom_format,
				$meta_image,
				$post_class
		);
	}
	$model->reset();
}
?>
<div class="slz-testimonial slz-testimonial-01 layout-06 slz-shortcode <?php echo esc_attr($data['block_cls'])?>" 
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
	<?php
	echo '<div data-slidestoscroll="1" data-nav="true" class="quote-wrapper">'. $output['top_desc'] .'</div>';
	echo '<div data-slidestoshow="1" data-slidestoscroll="1" class="client-wrapper">'. $output['bottom'] .'</div>';
	?>
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
		.%1$s.slz-testimonial .description{
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['description_color'] ) );
}

if ( !empty( $data['dots_color'] ) ) {
    $css = '
        .%1$s  .slick-dots li button:before{
            color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['dots_color'] ) );
}
if ( !empty( $data['icon_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial .icons{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['icon_color'] ) );
}
if ( !empty( $data['arrows_color'] ) ) {
    $css = '
        .%1$s.slz-testimonial .btn-prev i:before,
		.%1$s.slz-testimonial .btn-next i:before{
            color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_color'] ) );
}

if ( !empty( $data['arrows_hv_color'] ) ) {
    $css = '
        .%1$s.slz-testimonial .btn-prev:hover i:before,
		.%1$s.slz-testimonial .btn-next:hover i:before{
            color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_hv_color'] ) );
}

if ( !empty( $data['arrows_bg_color'] ) ) {
    $css = '
        .%1$s.slz-testimonial .btn{
            background-color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_bg_color'] ) );
}

if ( !empty( $data['arrows_bg_hv_color'] ) ) {
    $css = '
        .%1$s.slz-testimonial .btn:hover,
		.%1$s.slz-testimonial .btn:hover{
            background-color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_bg_hv_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}