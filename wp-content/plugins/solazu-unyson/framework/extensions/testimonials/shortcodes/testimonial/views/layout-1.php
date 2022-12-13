<?php 
$html_render1 = array();
$html_render2 = array();
$meta_image = '%1$s<div class="info-wrapper">';
if($data['show_image_1'] == '1')
	$meta_image = '<div class="info-wrapper">%1$s';
// 1$ - image, 2$ - title, 3$ - position, 4$ - post class
$html_format_top = '
<div class="item %4$s">
	<div class="client-item">
		'.$meta_image.'
			%2$s
			%3$s
		</div>
	</div>
</div>
';
// 1$ - desc, 2$ - post class, 3$ - rating
if ($data['show_ratings'] == 'yes') {
	$html_format_bottom = '
			<div class="%2$s">
				%3$s
				%1$s
			</div>
';
} else {
	$html_format_bottom = '
			<div class="%2$s">
				%1$s
			</div>
	';	
}


$thumb_size = 'large';
$html_top = $html_bottom = '';
$model = $data['model'];
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

		$html_top .= sprintf( $html_format_top,
				$meta_image,
				$model->get_title(),
				$model->get_meta_position(),
				$post_class
		);
		//right
		$html_bottom .= sprintf( $html_format_bottom,
				$model->get_content_format(),
				$post_class,
				$model->get_ratings()
		);
	}
	$model->reset();
}
?>


<div class="slz-testimonial slz-testimonial-01 layout-01 slz-shortcode <?php echo esc_attr( $data['block_cls'] ); ?>"
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
		echo '<div data-slidestoscroll="1" data-nav="true" class="client-wrapper">' . $html_top . '</div>';
	?>

	<?php
		echo '<div data-slidestoshow="1" data-slidestoscroll="1" class="quote-wrapper">'.$html_bottom.'</div>';
	?>
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
		.%1$s.slz-testimonial .item{
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
if ( !empty( $data['quote_icon_color'] ) ) {
	$css = '
		.%1$s.slz-testimonial-01 .quote-wrapper .description:before{
			color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['quote_icon_color'] ) );
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