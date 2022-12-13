<?php
/**
 * Template Name: Custom Template
 * This is the template displayed content with custom view
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */

get_header();
?>
<div class="slz-main-content page-custom padding-top-100 padding-bottom-100 ">
	<!-- slider -->
	<div class="container">

		<?php
			get_template_part( 'default-templates/page' );
		?>

	</div>

</div>

<?php get_footer(); ?>
