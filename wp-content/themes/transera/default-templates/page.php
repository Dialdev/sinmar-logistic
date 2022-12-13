<?php
$transera_container = transera_get_container_class( );
?>

<div class="slz-blog-detail slz-posts <?php echo esc_attr( $transera_container['sidebar_layout_class'] ); ?>">
	<div class="row">
		<div id="page-content" class="<?php echo esc_attr( $transera_container['content_class'] ); ?> slz-content-column">
			<?php
			while ( have_posts() ) : the_post();
			?>

				<div class="page-detail-wrapper">

					<?php transera_post_detail_thumbnail(); ?>

					<div class="entry-content">
						<?php
							the_content( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
											esc_url( get_permalink() ),
											esc_html__( 'Read more', 'transera' ) );

							wp_link_pages( array(
								'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'transera' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
						?>
					</div>

					<footer class="entry-footer">
						<?php edit_post_link( esc_html__( 'Edit', 'transera' ), '<span class="edit-link">', '</span>' ); ?>
					</footer>
				</div>

				<?php
					if ( comments_open() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; ?>

		</div>

		<?php if ( $transera_container['show_sidebar'] ): ?>

			<div id="page-sidebar" class="<?php echo esc_attr( $transera_container['sidebar_class'] ); ?> slz-sidebar-column  slz-widgets">

				<?php transera_get_sidebar($transera_container['sidebar']);?>

			</div>
		<?php endif; ?>

		<div class="clearfix"></div>

	</div>

</div>