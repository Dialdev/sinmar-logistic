<?php if ( ! defined( 'SLZ' ) ) die( 'Forbidden' ); ?>
<?php
/**
 * The template for displaying the team archive content
 * 
 */

get_header();
// get sidebar
$slz_container_css = slz_extra_get_container_class();

$ext = slz()->extensions->get( 'teams' );
$taxonomy = $ext->get_taxonomy_name();
//check exists taxonomy
$slz_category_slug = '';
if( is_tax( $taxonomy ) ){
	$queried_object   = get_queried_object();
	$slz_category_slug =  $queried_object->slug;
}

$limit_post = get_option('posts_per_page');
$cfg_columns = $ext->get_config('archive_columns');
$column = $cfg_columns['has_sidebar'];
if ( ! $slz_container_css['show_sidebar'] ){
	$column = $cfg_columns['no_sidebar'];
}
?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-teams-archive <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<div class="team-archive-wrapper">
						<?php
						$slz_shortcode = sprintf('[slz_team_list category_slug="%1$s" pagination="yes" column="%2$s"  limit_post="%3$s"]',
								esc_attr( $slz_category_slug ),
								esc_attr( $column ),
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