<?php
$container_class = slz_extra_get_container_class();
?>

<div class="slz-blog-detail layout-5 <?php echo esc_attr( $container_class['sidebar_layout_class'] ); ?>">
	<div class="row">
		<div id="page-content" class="<?php echo esc_attr( $container_class['content_class'] ); ?> slz-posts col-sm-12 slz-content-column single-posts-05">
			<?php
			while ( have_posts() ) : the_post();
			?>

				<div class="blog-detail-wrapper">
					<?php $module = new SLZ_Block_Module( get_post(), $post_instance->get_data()); ?>
					<?php $module->get_post_format_post_view(); ?>
					<?php the_title( '<h1 class="title">', '</h1>' ); ?>

					<?php echo slz_render_view( $post_instance->locate_path('/views/info.php'), compact('module')); ?>

					<div class="entry-content">
						<?php
							the_content( sprintf(
								esc_html__( 'Read more %s', 'slz' ),
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );

							wp_link_pages( array(
								'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'slz' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
						?>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="slz-post-footer">
					<div class="entry-meta">
						<?php slz_post_categories_meta();?>
						<div class="meta-content">
							<?php slz_post_tags_meta() ?>
							<?php slz_extra_get_social_share();?>
						</div>
						<?php slz_post_nav();?>
					</div>
					<?php
						if ( is_single() && get_the_author_meta( 'description' ) && slz_get_db_settings_option('blog-post-author-box', '' ) == 'yes' ) :
							get_template_part( 'default-templates/author-bio' );
						endif;
					?>
					<?php if( !empty( $related_post ) && $related_post->have_posts() ) :?>

					<div class="slz-carousel-wrapper slz-related-post slz_single_relate_post">

						<div class="related-title"><?php echo esc_html__('Related Articles', 'slz'); ?></div>

						<div class="carousel-overflow">

							<div data-slidestoshow="<?php echo esc_attr($related_post->related_args['related_columns']);?>" class="slz-carousel">
								<?php
								$posts = $related_post->posts;
								foreach($posts as $post) {

									$module = new SLZ_Block_Module( $post, $related_post->related_args );

									echo slz_render_view( $post_instance->locate_path('/views/related_item.php'), compact( 'module' ) );
									
								} ?>
							</div>

						</div>

					</div>

					<?php  endif; ?>

				</div>

				<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; ?>

		</div>

		<?php if ( $container_class['show_sidebar'] ): ?>

			<div id="page-sidebar" class="<?php echo esc_attr($container_class['sidebar_class'])?> slz-sidebar-column slz-widgets">
			
				<?php slz_extra_get_sidebar($container_class['sidebar']);?>

			</div>
		<?php endif; ?>

		<div class="clearfix"></div>

	</div>
	
</div>