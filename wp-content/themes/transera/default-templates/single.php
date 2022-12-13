<div class="slz-blog-detail slz-sidebar-left slz-posts">

	<div class="row">
		<div id="page-content" class="col-md-9 col-sm-12 slz-content-column">

			<?php
			while ( have_posts() ) : the_post();
			?>

				<div class="blog-detail-wrapper slz-posts single-default">
					<?php transera_post_detail_thumbnail(); ?>
					<div class="blog-detail-info">
						<div class="sub-content">
							<?php transera_get_datetime();?>
						</div>
						<div class="main-content">
							<?php the_title( '<h1 class="title">', '</h1>' ); ?>
							<?php transera_get_author();?>
							<ul class="block-info">
								<?php transera_entry_meta(); ?>
							</ul>
						</div>
					</div>
					<div class="entry-content">
						<?php
							the_content( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
											esc_url( get_permalink() ),
											esc_html__( 'Read more', 'transera' )
									);

							wp_link_pages( array(
								'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'transera' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
						?>
					</div>
					
					<div class="entry-meta">
						<?php transera_categories_meta();?>
						<?php transera_tags_meta();?>
						<?php transera_post_nav();?>
					</div>

					<?php
						if ( is_single() && get_the_author_meta( 'description' ) ) :
							get_template_part( 'author-bio' );
						endif;
					?>
					<?php
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				</div>

			<?php endwhile; ?>

		</div>
		<div id="page-sidebar" class="col-md-3 col-sm-12 slz-sidebar-column  slz-widgets">
			<?php dynamic_sidebar('transera-custom-sidebar'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>