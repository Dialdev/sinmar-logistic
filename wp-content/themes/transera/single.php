<?php
/**
 * The template for displaying the blog detail content
 *
 * Displays all of the head element and everything up until the "slz-blog-detail" div.
 *
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */

get_header(); ?>

<div class="slz-main-content" style="padding: 60px 0;">

	<div class="container">

		<?php
			if( $transera_template = transera_check_post_layout('posts', 'blog-layout')){
				$transera_template->render();
			}
			else
				get_template_part('default-templates/single');

		?>

	</div>

</div>

<?php get_footer(); ?>
