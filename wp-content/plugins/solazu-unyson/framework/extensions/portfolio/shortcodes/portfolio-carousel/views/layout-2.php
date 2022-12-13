<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }
$style = !empty($model->attributes['layout_style_2']) ? $model->attributes['layout_style_2'] : 'style-1';
$layout = !empty($model->attributes['layout']) ? $model->attributes['layout'] : 'layout-1';
$html_options = array(
	'excerpt_format' => '%s',
	'image_format'   => '<a href="%2$s" class="link">%1$s</a>',
);
$html_options = $model->set_default_options( $html_options );
$row_count = 0;
$thumb_size = 'large';

//carousel
$slick_json = $model->get_atts_option_slick_slide($model->attributes);
$cls_style = $style;
if( $style == 'style-3' ) {
	$cls_style = 'style-2';
}

?>

<div class="slz-carousel-wrapper slz-project-carousel <?php echo esc_attr($layout)?>">
	<div class="carousel-overflow">
		<div class="slz-carousel portfolio_slide_slick slz-block-slide-slick" data-slick-json="<?php echo esc_attr($slick_json)?>">
		<?php
			while ( $model->query->have_posts() ) {
				$model->query->the_post();
				$model->loop_index();?>
				<div class="item <?php echo esc_attr($model->get_post_class())?> ">
					<?php if( $style == 'style-3' && $f_image = $model->get_featured_image( $html_options, $thumb_size, false, false ) ): ?>
						<div class="feature-image"><?php echo wp_kses_post($f_image);?></div>
					<?php endif;?>
					<div class="slz-block-item-03 portfolio-item <?php echo esc_attr($cls_style)?>">
						<?php if( $image = $model->get_thumbnail( $html_options, $thumb_size, false, false ) ): ?>
							<div class="block-image">
								<?php echo wp_kses_post($image);?>
								<a class="link-preview" href="<?php echo esc_url($model->permalink)?>"><?php echo esc_html__('live review', 'slz')?></a>
							</div>
						<?php endif;?>
						<div class="block-content">
							<div class="block-content-wrapper">
								<?php $model->get_title( $html_options, true )?>
								<?php echo wp_kses_post($model->get_term_current_taxonomy())?>
								<div class="clearfix"></div>
								<?php $model->get_rating( $model->post_id, true )?>
								<?php $model->get_button_readmore(true)?>
							</div>
						</div>
						<?php if( $desc = $model->get_meta_description() ) :?>
						<?php echo '<div class="block-text">'.$desc.'</div>';?>
						<?php endif;?>
					</div>
				</div><?php
				$row_count++;
			}//end while
			$model->reset();?>
		</div>
	</div>
</div>