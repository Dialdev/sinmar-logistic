<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

$model = new SLZ_Portfolio($instance);

foreach ( $check_box as $key => $value ) {
	if( empty( $instance[$key] ) ){
		$instance[$key] = 'no';
	}else{
		$instance[$key] = 'yes';
	}
}
if( !empty( $instance['cat_id'] ) ){
	$post_type = 'slz-portfolio';
	$arr_cat_id = explode( ',', rtrim( $instance['cat_id'], ',' ) );
	$category_slug = array();
	foreach( $arr_cat_id as $value ){
		if( !empty( $value ) ){
			$term = SLZ_Com::get_tax_options_by_id( $value, $post_type . '-cat' );
			if( $term ){
				$category_slug[] = $term->slug;
			}
		}
	}
	if( !empty( $category_slug ) ){
		$instance['method'] = 'cat';
		$instance['category_slug'] = $category_slug;

	}
}
if( $instance['show_image'] == 'yes'){
	if( $instance['image_type'] == 'thumbnail') {
		$instance['show_thumbnail'] = $instance['image_type'];
	} else {
		$instance['show_thumbnail'] = '';
	}
} else {
	$instance['show_thumbnail'] = 'none';
}
$model->init($instance);
$btn = $thumbnail =  '';

$style = 'style-2';
$html_options = array(
	'excerpt_format' => '%s',
	'image_format'   => '<a href="%2$s" class="link">%1$s</a>',
);
$html_options = $model->set_default_options( $html_options );
$row_count = 0;
$thumb_size = 'large';

echo wp_kses_post($before_widget);?>

	<?php
	echo wp_kses_post( $title );
	if($model->query->have_posts() ):
	?>
		<div class="widget-content">
			<div class="slz-list-block slz-column-1">
				<?php 
					while ( $model->query->have_posts() ):
						$model->query->the_post();
						$model->loop_index();?>
						<div class="item <?php echo esc_attr($model->get_post_class())?>">
							<div class="slz-block-item-03 portfolio-item <?php echo esc_attr($style)?>">
								<?php if( $image = $model->get_post_image( $html_options, $thumb_size, false, false ) ): ?>
									<div class="block-image"><?php echo wp_kses_post($image);?></div>
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
					endwhile;
				$model->reset();?>
			</div>
		</div><?php 
	endif;
echo wp_kses_post($after_widget);?>

