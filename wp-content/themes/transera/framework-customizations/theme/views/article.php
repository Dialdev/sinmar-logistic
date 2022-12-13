<div class="slz-block-item-02">

	<?php if( $module->post_type == 'post') :
		if( slz_ext('templates') ) {
			$module->get_post_format_post_view();
		}else{
			if ( $module->has_post_thumbnail() ) :
		?>
			<div class="block-image">
				<a href="<?php echo ( $module->get_url() ); ?>" class="link">
					<?php echo ( $module->get_featured_image() ); ?>
				</a>
			</div>
		<?php
			endif;
		}
	endif;
	?>
	<div class="block-content">
		<div class="sub-content">
			<div class="date-time">
				<a href="<?php echo esc_url( $module->get_url() ); ?>">
					<span class="day">
						<?php echo get_the_date('j'); ?>
					</span>
					<span class="month">
						<?php echo get_the_date('M'); ?>
					</span>
					<span class="year">
						<?php echo get_the_date('Y'); ?>
					</span>
				</a>
			</div>
			<ul class="block-info">
                <li>
                    <a href="javascript:void(0)" class="link user"> <?php echo ( $module->get_post_view() ); ?></a>
                </li>
                <li>
                    <?php echo ( $module->get_comments('<a href="%1$s" class="link comment">%2$s</a>') ); ?>
                </li>
                <?php if( slz_is_theme_share_on() ) : ?>
					<?php echo ( $module->get_shares('<li><a href="javascript:void(0)" class="link share">%1$s</a></li>') ); ?>
				<?php endif; ?>
			</ul>
		</div>
		<div class="main-content">
			<a href="<?php echo get_the_permalink(); ?>" class="block-title"><?php echo ( $module->get_title() ); ?></a>
			<ul class="block-info">
				<?php echo ( $module->get_meta_data( '', array( 'date', 'comment', 'view' ) ) ); ?>
			</ul>
			<p class="block-text entry-content">
				<?php echo ( $module->get_excerpt() ); ?>
			</p>
			<a href="<?php echo get_the_permalink(); ?>" class="read-more">
				<?php echo esc_html__('Read More', 'transera'); ?>
				<i class="fa fa-long-arrow-right"></i>
			</a>
		</div>
	</div>
</div>
