<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$style = !empty($model->attributes['layout_style_2']) ? $model->attributes['layout_style_2'] : 'style-1';
$column = !empty($model->attributes['column']) ? 'slz-column-'.$model->attributes['column'] : 'slz-column-2';

$html_options = array(
	'excerpt_format' => '%s',
	'image_format'   => '<a href="%2$s" class="link">%1$s</a>',
);
$html_options = $model->set_default_options( $html_options );
$row_count = 0;
$thumb_size = 'large';

?>
<!-- max 6 column -->
<div class="slz-list-block <?php echo esc_attr( $column ); ?>">
	<?php
		while ( $model->query->have_posts() ) {
			$model->query->the_post();
			$model->loop_index();?>
			<div class="item <?php echo esc_attr($model->get_post_class())?>">
				<div class="slz-block-item-03 portfolio-item <?php echo esc_attr($style)?>">
					<?php if( $image = $model->get_post_image( $html_options, $thumb_size, false, false ) ): ?>
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
		$model->reset();
		$model->pagination();
	?>
</div>
