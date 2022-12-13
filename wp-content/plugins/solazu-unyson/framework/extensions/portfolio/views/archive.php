<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php
/**
 * The template for displaying the service archive content
 *
 *
 * @package WordPress
 * @subpackage solazu-core
 * @since 1.0
 */

get_header();
$slz_container_css = slz_extra_get_container_class();

$slz_currentObject = get_queried_object();
$slz_term_slug = is_tax() && !empty($slz_currentObject) ? $slz_currentObject->slug : '';

$slz_category_sc = '';
if ( !empty($slz_term_slug) ) {
	$slz_category_slug[] = array( 'category_slug' => $slz_term_slug );
	$slz_category_sc = urlencode(json_encode($slz_category_slug));
}
$column = '2';
if ( ! $slz_container_css['show_sidebar'] ){
	$column = '3';
}
?>
<div class="slz-main-content portfolio-archive padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-portfolio-archive <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<div class="service-archive-wrapper">
						<?php
						$slz_shortcode = sprintf('[slz_portfolio_list method="cat" list_category="%1$s" pagination="yes" column="%2$s" layout="layout-1" style="style-1" description_length="30" button_text="%3$s" limit_post="%4$s"]',
								esc_attr( $slz_category_sc ),
								esc_attr( $column ),
								esc_html__( 'Read More', 'slz' ),
								get_option('posts_per_page')
							);
						echo do_shortcode( $slz_shortcode ); ?>
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
<?php get_footer(); ?>