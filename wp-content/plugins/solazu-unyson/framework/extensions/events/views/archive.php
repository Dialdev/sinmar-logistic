<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php
/**
 * The template for displaying the event archive content
 *
 *
 * @package WordPress
 * @subpackage solazu-core
 * @since 1.0
 */

get_header();
// get sidebar
$slz_container_css = slz_extra_get_container_class();

$ext = slz()->extensions->get( 'events' );
$taxonomy = $ext->get_taxonomy_name();
//check exists taxonomy
$slz_category_slug = '';
if( is_tax( $taxonomy ) ){
	$queried_object   = get_queried_object();
	$slz_category_slug =  $queried_object->slug;
}

$limit_post = get_option('posts_per_page');
?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-events-archive <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<div class="event-archive-wrapper">
						<?php
						$format = '[slz_event_block category_slug="%1$s" pagination="yes" limit_post="%2$s"]';
						$slz_shortcode = sprintf($format,
								esc_attr( $slz_category_slug ),
								esc_attr( $limit_post )
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
<?php get_footer();