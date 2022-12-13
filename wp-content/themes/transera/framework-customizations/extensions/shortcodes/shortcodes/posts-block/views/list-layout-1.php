<div class="slz-block-item-01 style-1">
	<div class="slz-block-item-02">
		<?php $module->get_post_format_post_view(); ?>
		<div class="block-content">
			<div class="sub-content">
				<div class="date-time">
					<a href="<?php echo esc_url( $module->get_url() ); ?>">
						<span class="day">
							<?php echo get_the_date('j',$module->post_id); ?>
						</span>
						<span class="month">
							<?php echo get_the_date('M',$module->post_id); ?>
						</span>
						<span class="year">
							<?php echo get_the_date('Y',$module->post_id); ?>
						</span>
					</a>
				</div>
				<ul class="block-info">
					<?php echo ( $module->get_views( '<li><a href="%1$s" class="link view">%2$s</a></li>' ) ); ?>
					<?php echo ( $module->get_comments('<li><a href="%1$s" class="link comment">%2$s</a></li>') ); ?>
					<?php echo ( $module->get_shares('<li><a href="javascript:void(0)" class="link share">%1$s</a></li>') ); ?>
				</ul>
			</div>
			<div class="main-content">
				<?php echo ($module->get_title()); ?>
				<ul class="block-info">
					<?php echo ( $module->get_meta_data( '', array( 'date', 'comment', 'view' ) ) ); ?>
				</ul>
				<?php if($module->attributes['list_show_excerpt'] == 'yes' && $module->get_excerpt() ): ?>
					<div class="block-text"><?php echo ( $module->get_excerpt() ); ?></div>
				<?php endif; ?>
				<?php if( $module->attributes['list_show_read_more_3'] == 'yes' ) : ?>
				<a href="<?php echo ( $module->get_url() ); ?>" class="read-more">
					<?php echo esc_html( $module->attributes['list_read_more_text_3'] ); ?>
					<i class="fa fa-long-arrow-right"></i>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>