<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$style = !empty($model->attributes['style']) ? $model->attributes['style'] : 'style-1';
$layout = !empty($model->attributes['layout']) ? $model->attributes['layout'] : 'layout-1';

$html_options = array(
	'excerpt_format' => '%s',
	'image_format'   => '<a href="%2$s" class="link">%1$s</a>',
	'date_format'    => '<a href="%2$s" class="link date">%1$s</a>',
);
$html_options = $model->set_default_options( $html_options );
$row_count = 0;
$thumb_size = 'large';

//carousel
$slick_json = $model->get_atts_option_slick_slide($model->attributes);
?>


<div class="slz-carousel-wrapper slz-project-carousel <?php echo esc_attr($layout)?>">
	<div class="carousel-overflow">
		<div class="slz-carousel portfolio_slide_slick slz-block-slide-slick" data-slick-json="<?php echo esc_attr($slick_json)?>">
		<?php
			while ( $model->query->have_posts() ) {
				$model->query->the_post();
				$model->loop_index();?>
				<div class="item <?php echo esc_attr($model->get_post_class())?>">
					<div class="slz-block-item-01 portfolio-list <?php echo esc_attr($style)?>">
						<?php if( $f_image = $model->get_post_image( $html_options, $thumb_size, false, true ) ): ?>
							<div class="block-image"><?php echo wp_kses_post($f_image);?></div>
						<?php endif;?>
						<div class="block-content">
							<div class="block-content-wrapper">
								<?php echo wp_kses_post($model->get_term_current_taxonomy())?>
								<?php $model->get_title( $html_options, true )?>
								<?php if(!empty($model->attributes['show_meta_info']) && $model->attributes['show_meta_info']=='yes' ):
									echo wp_kses_post( $model->get_date() ); ?>
									<ul class="block-info">
										<?php echo wp_kses_post( $model->get_author() ); ?>
									</ul>
								<?php endif;?>
								<?php if( $desc = $model->get_meta_description() ) :?>
								<?php echo '<div class="block-text">'.$desc.'</div>';?>
								<?php endif;?>
								<?php $model->get_button_readmore(true)?>
							</div>
						</div>
					</div>
				</div><?php
				$row_count++;
			}//end while
			$model->reset();?>
		</div>
	</div>
</div>
