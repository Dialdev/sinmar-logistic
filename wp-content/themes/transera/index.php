<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */

$transera_container = transera_get_container_class( 'main-blog-article-style' );

get_header();?>

	<div class="slz-main-content">

		<div class="container">

			<div class="slz-blog-detail slz-block-index <?php echo esc_attr( $transera_container['sidebar_layout_class'] ); ?> margin-top-100 margin-bottom-100">

				<div class="row">

					<div id="page-content" class="<?php echo esc_attr( $transera_container['content_class'] ); ?> slz-posts slz-content-column">

						<?php if ( have_posts() ) : ?>

							<div class="slz-list-block <?php echo esc_attr( $transera_container['block_class'] ); ?>">

								<?php
									if ( $transera_template = transera_check_article_layout('articles', 'main-blog-article-style') ) {
										while ( have_posts() ) : the_post();

											$transera_template->render( $post );

										endwhile;

									}
									else{

										while ( have_posts() ) : the_post();

											get_template_part( 'default-templates/article' );

										endwhile;

									}

								?>

							</div>

							<?php transera_posts_pagination();?>

						<?php

						else :
							get_template_part( 'default-templates/no-content' );

						endif;
						?>
						
					</div>

					<?php if( $transera_container['show_sidebar'] ):?>

						<div id="page-sidebar" class="<?php echo esc_attr( $transera_container['sidebar_class'] ); ?> slz-sidebar-column slz-widgets">

							<?php transera_get_sidebar($transera_container['sidebar']);?>

						</div>

					<?php endif; ?>

					<div class="clearfix"></div>

				</div>

			</div>

		</div>

	</div>

<?php get_footer(); ?>
