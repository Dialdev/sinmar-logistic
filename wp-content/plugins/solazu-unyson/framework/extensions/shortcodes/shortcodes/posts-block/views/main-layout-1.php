<div class="slz-block-item-01 style-1">
	<?php $module->get_post_format_post_view(); ?>
	<div class="block-content">
		<div class="block-content-wrapper">
			<?php echo ( $module->get_category() ); ?>
			<?php echo ( $module->get_title() ); ?>
			<ul class="block-info">
				<?php echo ( $module->get_meta_data() ); ?>
			</ul>
			<?php
			if( ( $module->attributes['main_show_excerpt'] == 'yes' && $module->attributes['layout'] == 'layout-1' ) || ( $module->attributes['layout'] == 'layout-2' && $module->attributes['main_show_excerpt_2'] == 'yes' ) ) {

				if( $excerpt_str = $module->get_excerpt() ){?>
					<div class="block-text"><?php echo wp_kses_post( nl2br( $excerpt_str ) ); ?></div>
				<?php }?>
				
			<?php
			}
			?>
			<?php 
			if( ( $module->attributes['main_show_read_more'] == 'yes' && $module->attributes['layout'] == 'layout-1' ) || ( $module->attributes['layout'] == 'layout-2' && $module->attributes['main_show_read_more_2'] == 'yes' ) ) {
			?>
				<a href="<?php echo esc_url( $module->permalink ); ?>" class="block-read-more"><?php echo esc_html__( 'Read More', 'slz' ); ?><i class="fa fa-angle-double-right"></i></a>
			<?php
			}
			?>
		</div>
	</div>
</div>