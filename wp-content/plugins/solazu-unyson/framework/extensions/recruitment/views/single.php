<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php
/**
 * The template for displaying the recruitment detail content
 *
 */


get_header();
$slz_container_css = slz_extra_get_container_class();
?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-blog-detail slz-recruitments <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post();
					?>
							<div class="recruitment-detail-wrapper">
								<?php 
									printf( '<div class="slz-featured-block"><a href="%s">%s</a></div>',
											esc_url( get_permalink() ),
											get_the_post_thumbnail( get_the_ID(), 'post-thumbnail' )
									);
									the_title( '<h1 class="title">', '</h1>' );
									
									// meta info
									$model = new SLZ_Recruitment();
									$model->get_custom_post( get_the_ID() );
									$model->html_format['recruit_type_format'] = '<li class="time"><i class="fa fa-hourglass"></i> %1$s</li>';
									printf( '<ul class="block-info">%1$s %2$s %3$s %4$s</ul>',
											 $model->get_recruit_type(),
											 $model->get_expired_date(),
											 $model->get_salary(),
											 $model->get_location()
										);
									if( $more_info = $model->get_more_info() ) {
										printf( '<ul class="block-info">%1$s</ul>',
												$more_info
										);
									}
								?>
								<div class="entry-content">
									<?php
										the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
														get_permalink(),
														esc_html__( 'Read more', 'slz' )
												) );

										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'slz' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									?>
								</div>
								<?php
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
								?>
							</div>

					<?php 
							endwhile;
							wp_reset_postdata();
						else: 
							get_template_part( 'default-templates', 'no-content' );  
						endif; // have_posts
					?>

				</div>
				<?php if ( $slz_container_css['show_sidebar'] ) :?>
					<div id='page-sidebar' class="slz-sidebar-column slz-widgets <?php echo esc_attr( $slz_container_css['sidebar_class'] ); ?>">
						<?php dynamic_sidebar( $slz_container_css['sidebar'] ); ?>
					</div>
				<?php endif; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>