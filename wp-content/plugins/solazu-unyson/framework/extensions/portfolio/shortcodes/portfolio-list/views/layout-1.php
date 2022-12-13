<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$style = !empty($model->attributes['style']) ? $model->attributes['style'] : 'style-1';
$column = !empty($model->attributes['column']) ? 'slz-column-'.$model->attributes['column'] : 'slz-column-2';

$html_options = array(
	'excerpt_format' => '%s',
	'image_format'   => '<a href="%2$s" class="link">%1$s</a>',
	'date_format'    => '<a href="%2$s" class="link date">%1$s</a>',
);
$html_options = $model->set_default_options( $html_options );
$row_count = 0;
$thumb_size = 'large';
?>

<div class="slz-list-block <?php echo esc_attr( $column ); ?>">
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
								echo ( $model->get_date()); ?>
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
		$model->reset();
		$model->pagination();
	?>
</div>