<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$style = !empty($model->attributes['style']) ? $model->attributes['style'] : 'style-1';
$column = !empty($model->attributes['column']) ? 'slz-column-'.$model->attributes['column'] : 'slz-column-2';

$html_options = array(
	'excerpt_format' => '%s',
	'image_format'   => '<a href="%2$s" class="link">%1$s</a>',
);
$html_options = $model->set_default_options( $html_options );
$row_count = 0;
$thumb_size = 'large';

?>
<!-- max 3 columm -->
<div class="slz-list-block <?php echo esc_attr( $column ); ?>">
	<?php
		while ( $model->query->have_posts() ) {
			$model->query->the_post();
			$model->loop_index();?>
			<div class="item <?php echo esc_attr($model->get_post_class())?>">
				<div class="slz-block-item-04 portfolio-item <?php echo esc_attr($style)?>">
					<div class="block-image-wrapper">
						<?php if( $f_image = $model->get_featured_image( $html_options, $thumb_size, false, false ) ): ?>
							<div class="block-image"><?php echo wp_kses_post($f_image);?></div>
						<?php endif;?>
						<?php if( $image = $model->get_thumbnail( $html_options, 'small', false, false ) ): ?>
							<div class="block-sub-image-wrapper">
								<div class="block-sub-image">
									<?php echo wp_kses_post($image);?>
								</div>
							</div>
						<?php endif;?>
					</div>
					<div class="block-content">
						<div class="block-content-wrapper">
							<?php $model->get_title( $html_options, true )?>
							<?php echo wp_kses_post($model->get_term_current_taxonomy())?>
							<div class="clearfix"></div>
							<?php $model->get_rating( $model->post_id, true )?>
							<?php $model->get_button_readmore(true)?>
							<?php if( $desc = $model->get_meta_description() ) :?>
							<?php echo '<div class="block-text">'.$desc.'</div>';?>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div><?php
			$row_count++;
		}//end while
		$model->reset();
		$model->pagination();
	?>
</div>

