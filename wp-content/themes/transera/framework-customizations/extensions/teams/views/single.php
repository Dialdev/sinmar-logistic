<?php if ( ! defined( 'SLZ' ) ) die( 'Forbidden' ); ?>
<?php
/**
 * The template for displaying the team detail content
 */

get_header();
$slz_container_css = slz_extra_get_container_class();
$ext = slz()->extensions->get( 'teams' );
$social_arr = SLZ_Params::get( 'params_social' );
?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-blog-detail slz-teams <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								$post_id = get_the_ID();
								$team_options = slz_get_db_post_option( $post_id );
								$img_url = get_the_post_thumbnail_url($post_id);
								if(!$img_url) {
									$img_url = slz_get_framework_directory_uri('/static/img/no-image/600x600.png');
								}
					?>
					<div class="teams-detail-wrapper">
						<div class="slz-about-me-02">
                            <div class="block-wrapper">
                                <div class="image-wrapper"><img src="<?php echo esc_url($img_url); ?>" alt="" class="img-responsive"></div>
                                <div class="content-wrapper">
                                    <div class="heading-wrapper">
                                        <div class="heading-left name">
                                        	<?php the_title(); ?>
                                        </div>
                                        <div class="heading-right">
                                            <div class="social-wrapper">
                                                <ul class="slz-list-inline social-list">
                                                <?php
                                                	foreach($social_arr as $k=>$v){
                                                		if(!empty($team_options[$k])){
                                                			printf('<li><a href="%1$s" class="link %2$s"><i class="fa fa-%2$s"></i></a></li>',
                                                				esc_url($team_options[$k]),
                                                				esc_attr($k)
                                                			);
                                                		}
                                                	}
                                                ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="content-text">
                                    <?php
                                    	echo wp_kses_post(nl2br($team_options['description']));
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="entry-content">
							<?php
								the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
												get_permalink(),
												esc_html__( 'Read more', 'transera' )
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