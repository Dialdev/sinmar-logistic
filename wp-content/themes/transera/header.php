<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
<meta name="yandex-verification" content="098ba2ae8ee6ddf2" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" href="/wp-content/themes/transera/favicon (3).ico" type="image/x-icon">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="page" class="body-wrapper">

		<!-- WRAPPER CONTENT-->
		<div class="slz-wrapper-content">

			<?php

				if ( transera_check_extension('headers') ) {

					if ( is_page( ) ) {

						$transera_selected_header = slz_get_db_post_option( get_the_ID(), 'page-header-style' );

						if ( $transera_selected_header == 'default' )
							unset ( $transera_selected_header );

					}

					if ( empty ( $transera_selected_header ) && slz_get_db_settings_option('slz-header-style-group/slz-header-style', false) ){

						$transera_selected_header = slz_get_db_settings_option('slz-header-style-group/slz-header-style', '');

					}
					SLZ_Live_Setting::get_header_style($transera_selected_header);
					if ( !empty ( $transera_selected_header ) ) {

						$transera_header = slz_ext('headers')->get_header( $transera_selected_header );

						if ( !empty ( $transera_header ) )
							$transera_header->render();

					}

				}
				else
					get_template_part('default-templates/header');
				?>

				<!-- show slider and page title-->
				<?php transera_show_slider_area();?>
				<?php transera_setting_woocommerce(true);?>

