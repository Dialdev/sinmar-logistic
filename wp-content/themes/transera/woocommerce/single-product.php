<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$transera_container = transera_get_container_class( );

get_header( 'shop' ); ?>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-blog-detail <?php echo esc_attr( $transera_container['sidebar_layout_class'] ); ?>">
			<div class="row slz-woocommerce">
				<div id="page-content" class="<?php echo esc_attr( $transera_container['content_class'] ); ?> slz-content-column">
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

						<?php
							/**
							 * woocommerce_before_main_content hook.
							 *
							 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
							 * @hooked woocommerce_breadcrumb - 20
							 */
							do_action( 'woocommerce_before_main_content' );
						?>
					
							<?php while ( have_posts() ) : the_post(); ?>
					
								<?php wc_get_template_part( 'content', 'single-product' ); ?>
					
							<?php endwhile; // end of the loop. ?>
					
						<?php
							/**
							 * woocommerce_after_main_content hook.
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action( 'woocommerce_after_main_content' );
						?>
					</div>
				</div>
				<?php if( $transera_container['show_sidebar'] ):?>
				<div id='page-sidebar' class="slz-sidebar-column slz-widgets sidebar sidebar-widget <?php echo esc_attr( $transera_container['sidebar_class'] ); ?>">
					<?php transera_get_sidebar($transera_container['sidebar']);?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>

<?php get_footer( 'shop' ); ?>
