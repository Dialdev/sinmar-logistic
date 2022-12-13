<div id="post-<?php echo esc_attr($module->post_id); ?>" <?php post_class('item');?>>
	<div class="slz-block-item-01 style-1 slz-article article-04">
		<?php if( ! is_search() ):?>
			<?php slz_theme_sticky_ribbon();?>
			<?php if ( $module->has_post_thumbnail() ) : ?>
			<div class="block-image">
				<a href="<?php echo esc_url($module->get_url()); ?>" class="link">
					<?php echo $module->get_featured_image(); ?>
				</a>
				<?php echo $module->get_ribbon_date();?>
			</div>
			<?php endif; ?>
		<?php endif; // is search?>

		<div class="block-content">

			<?php the_title( sprintf( '<h2><a href="%s" class="block-title" rel="bookmark">', esc_url( $module->get_url() ) ), '</a></h2>' ); ?>

			<?php if( get_post_type() == 'post' ) :?>
				<ul class="block-info">
					<?php echo $module->get_block_info();?>
				</ul>
			<?php endif;?>

			<div class="block-text entry-content">
				<?php if( is_search() ):?>
					<?php echo $module->get_excerpt();?>
				<?php else:?>
					<?php the_content( sprintf( '<a href="%s" class="continue-reading">%s<i class="fa fa-angle-right"></i></a>',
								esc_url( get_permalink() ),
								esc_html__( 'Continue reading', 'slz' )
						) );
					?>
				<?php endif;?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'slz' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
			</div>
			<?php if( get_post_type() == 'post' ) :?>
			<div class="entry-meta">
				<?php echo $module->get_categories_meta();?>
				<?php echo $module->get_tags_meta();?>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>