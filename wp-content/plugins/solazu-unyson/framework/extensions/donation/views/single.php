<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php
/**
 * The template for displaying the service detail content
 *
 * @package WordPress
 * @subpackage solazu-core
 * @since 1.0
 */


get_header();
$slz_container_css = slz_extra_get_container_class();
$ext = slz()->extensions->get( 'donation' );
$html_render = array();
$html_format = '
	<div class="slz-block-item-06 style-3">
		%1$s
		<div class="block-content">
			<div class="block-content-wrapper">
				%2$s
				<ul class="block-info">
					%13$s
					%11$s
					%12$s
				</ul>
				%10$s
				%7$s
				<div
					class="row">
					<div class="col-left">
						%6$s
						<div class="raise-goal-block">
							%5$s
							%4$s
						</div>
					</div>
					<div class="col-right">
						%14$s
					</div>
					<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
	';
?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-blog-detail slz-causes <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								$id = get_the_ID();
					
								$image_size = array(
									'large'				=> 'full',
									'no-image-large'	=> 'full',
								);
								$defaults = $ext->get_config('default_values');
								$args = array(
									'post_id'    => array( $id ),
									'image_size' => $image_size,
								);
								$args = array_merge( $defaults, $args );
								$model = new SLZ_Causes();
								$model->init( $args );
								
								$html_render['html_format'] = $html_format;
								$html_render['thumb_class'] = 'img-full';
								$html_render['remain_time_format'] = '<li><span class="link remaining-time"><span class="title">%2$s</span><span class="text">%1$s'. esc_html__( ' days left', 'slz' ) .'</span></span></li>';
								
								echo ( $model->render_causes_block( $html_render ) );
					?>
							<div class="causes-detail-wrapper">
								<div class="entry-content">
									<?php
										the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
														get_permalink(),
														esc_html__( 'Read more', 'slz' )
												) );
												
										
									?>
								</div>
								<footer class="entry-footer">
									<?php edit_post_link( __( 'Edit', 'slz' ), '<span class="edit-link">', '</span>' ); ?>
								</footer>
							</div>
							<div class="slz-post-footer">
								<div class="entry-meta">
									<div class="cat-social-wrapper">
										<?php slz_donation_post_categories_meta();?>
										<?php slz_donation_extra_get_social_share();?>
									</div>
								<?php slz_donation_get_post_navigation(); ?>
								</div>
							</div>
								<?php
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
								?>
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