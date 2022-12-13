<?php

$post_format = '';
$format = get_post_format( $module->post_id );
if( !empty( $format ) ) {
	$post_format = 'slz-format-'.$format;
}else{
	$post_format = '';
}

?>
<div class="item <?php echo esc_attr($post_format); ?>">
	<div class="slz-block-item-01 <?php echo esc_attr( $item_class ); ?>">
		<div class="block-image">
			<a href="<?php echo esc_url( $module->permalink ); ?>" class="link">
				<?php echo ( $module->get_featured_image() ); ?>
				<?php
					if( !empty( $format ) ) {
						echo '<i class="icons-'. esc_attr( $format ) .'"></i>';
					}
				?>
			</a>
		</div>
			<div class="block-content">
				<div class="block-content-wrapper">
					<?php echo ( $module->get_title() ); ?>
					<ul class="block-info">
						<?php echo ( $module->get_meta_data() ); ?>
					</ul>
					<?php if ( $module->attributes['excerpt'] == 'show' ) : ?>
						<div class="block-text"><?php echo esc_html( $module->get_excerpt(true, false) ); ?></div>
					<?php endif; ?>

					<?php if ( $module->attributes['readmore'] == 'show' ) : ?>
						<a href="<?php echo ( $module->get_url() ); ?>" class="block-read-more">
							<?php echo esc_html__('Read More', 'slz'); ?>
							<i class="fa fa-angle-double-right"></i>
						</a>
					<?php endif; ?>
				</div>
			</div>
	</div>
</div>