<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */

get_header();
?>
<div class="slz-main-content padding-bottom-100 " style="padding-top:0;">
	<!-- slider -->
	<div class="container">

		<?php
			get_template_part( 'default-templates/page' );
		?>

	</div>

</div>

<?php get_footer(); ?>
