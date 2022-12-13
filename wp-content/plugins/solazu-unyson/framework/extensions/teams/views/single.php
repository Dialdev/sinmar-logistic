<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php
/**
 * The template for displaying the team detail content
 *
 * @since 1.0
 */

get_header();
$slz_container_css = slz_extra_get_container_class();
$ext = slz()->extensions->get( 'teams' );
$html_options['social_format'] =
		'<li><a href="%2$s" class="link %1$s">
				<i class="fa fa-%1$s"></i>
		</a></li>';
?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-blog-detail slz-team-detail <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<?php if ( have_posts() ) : 
							while ( have_posts() ) : the_post();
								$post_id = get_the_ID();
								$defaults = $ext->get_config('default_values');
								$args = array(
									'show_description' => 'yes',
									'show_contact_info'=> 'yes'
								);
								$args = array_merge( $defaults, $args );
								$model = new SLZ_Team();
								$model->init( $args );
								$thumb_size = 'large';
								$model->get_single_post($post_id);
								$model->html_format = $model->set_default_options( $html_options );
					?>
							<div class="teams-detail-wrapper">
								<div class="slz-about-me-02 style-02">
									<div class="block-wrapper">
										<?php if( $image = $model->get_featured_image( $html_options, $thumb_size ) ):?>
										<div class="image-wrapper"><?php echo wp_kses_post($image)?></div>
										<?php endif;?>
										<div class="content-wrapper">
											<div class="heading-wrapper">
												<div class="heading-left">
												<?php if( $model->title ):?>
													<a href="<?php echo esc_url( $model->permalink );?>" class="name"><?php echo esc_attr( $model->title )?></a>
												<?php endif;?>
												<?php if( $position = $model->get_meta_position() ):?>
													<div class="info-wrapper">
														<?php echo wp_kses_post($position);?>
													</div>
													<?php endif;?>
												</div>
												<?php if( $social = $model->get_meta_social()):?>
												<div class="heading-right">
													<ul class="social-wrapper social-list">
														<?php echo ( $social ); ?>
													</ul>
												</div>
												<?php endif;?>
												<div class="clearfix"></div>
											</div>
											<?php echo ( $model->get_meta_description() );?>
											<?php 
												$mail = $model->get_email();
												$phone = $model->get_phone()
											?>
											<?php if( !empty($mail) || !empty($phone) ):?>
												<?php echo '<div class="info-description contact-info">'.$mail.$phone .'</div>';?>
											<?php endif;?>
										</div>
									</div>
								</div>
								<div class="entry-content">
									<?php
										the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
														get_permalink(),
														esc_html__( 'Read more','lawplus' )
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
					<div class="slz-sidebar-column slz-widgets <?php echo esc_attr( $slz_container_css['sidebar_class'] ); ?>">
						<?php slz_extra_get_sidebar( $slz_container_css['sidebar'] ); ?>
					</div>
				<?php endif; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>