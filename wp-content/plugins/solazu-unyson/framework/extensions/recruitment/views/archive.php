<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php
/**
 * The template for displaying the recruitment archive content
 *
 *
 * @package WordPress
 * @subpackage solazu-core
 * @since 1.0
 */

get_header();
// get sidebar
$slz_container_css = slz_extra_get_container_class();

$ext = slz()->extensions->get( 'recruitment' );

$limit_post = get_option('posts_per_page');
$cfg_image = $ext->get_config('image_size');

?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-recruitments-archive <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<div class="recruitment-archive-wrapper">
						<?php
						$attrs = array();
						$attrs['limit_post'] = $limit_post;
						$attrs['image_size'] = array (
							'large'	=> '550x350'
						);
						$model = new SLZ_Recruitment();
						$attrs['thumb-size'] = SLZ_Util::get_thumb_size( $cfg_image );
						$model->init($attrs);

						$html_format = '
							<div class="slz-template-01">
			                    <div class="slz-recent-post">
			                        <div class="media">
			                            <div class="media-left">
			                               %1$s
			                               %3$s
			                            </div>
			                            <div class="media-right">
			                                %2$s 
			                                <ul class="block-info">
			                                    %4$s
			                                    %5$s
			                                    %8$s
			                                </ul>
			                                <div class="description">%6$s</div>
			                                %7$s
			                            </div>
			                        </div>
			                    </div>    
			                </div>';
						?>
						<div class="sc-recruitment-style-tab">
							<?php
								if( $model->query->have_posts() ) {
									while ( $model->query->have_posts() ) {
										$model->query->the_post();
										$model->loop_index();
										$html_options = $model->html_format;
										printf( $html_format,
											$model->get_featured_image($html_options),
											$model->get_title($html_options),
											$model->get_recruit_type(),
											$model->get_expired_date(),
											$model->get_salary(),
											$model->get_description(),
											$model->get_apply_button(),
											$model->get_location()
										);
									}
									$model->reset();
								}
							?>
						</div>
					</div>
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
<?php get_footer();