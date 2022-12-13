<div id="post-<?php the_ID(); ?>" <?php post_class('item');?> >
	<div class="slz-block-item-02 article-default">

		<?php if( ! is_search() ) :?>
			<?php transera_sticky_ribbon();?>
			<?php transera_post_thumbnail(); ?>
		<?php endif;?>

		<div class="block-content">
			<div class="sub-content">
				<?php transera_get_datetime();?>
				<ul class="block-info">
					<?php transera_entry_meta();?>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="main-content">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( transera_get_link_url() ) ), '</a></h2>' ); ?>
				<?php transera_get_author();?>
				<div class="entry-content">
					<?php if( is_search() ):?>

						<?php the_excerpt(); ?>

					<?php else:?>

						<?php the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
								esc_url( get_permalink() ),
								esc_html__( 'Read more', 'transera' )
						) );?>

					<?php endif;?>

					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'transera' ) . '</span>',
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>',
						) );
					?>
					
				</div>

				<?php if( get_post_type() == 'post' ) :?>
					<div class="entry-meta">
						<?php transera_categories_meta();?>
						<?php transera_tags_meta();?>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>