<?php

	$transera_search_icon = 'fa fa-search';

	$transera_search_placeholder = esc_html__('Search', 'transera');

	if ( defined ( 'SLZ' ) ){

		if ( is_page( ) ) {

			$transera_selected_header = slz_get_db_post_option( get_the_ID(), 'page-header-style' );

			if ( $transera_selected_header == 'default' )
				unset ( $transera_selected_header );

		}

		if ( empty ( $transera_selected_header ) && slz_get_db_settings_option('slz-header-style-group/slz-header-style', false) ){

			$transera_selected_header = slz_get_db_settings_option('slz-header-style-group/slz-header-style', '');

		}

		if ( !empty ( $transera_selected_header ) ) {

			$transera_key = 'slz-header-style-group/' . $transera_selected_header . '/search-group-styling';

			$transera_search_options = slz_get_db_settings_option( $transera_key, '');

			if ( !empty ( $transera_search_options ) ){


				if ( !empty ( $transera_search_options['icon-class'] ) ) {

				    $transera_search_icon = $transera_search_options['icon-class'];

				}

				if ( !empty ( $transera_search_options['placeholder'] ) ) {

				    $transera_search_placeholder = $transera_search_options['placeholder'];

				}


			}

		}

	}

?>

<form action="<?php echo esc_url( home_url( '/' ) ) ?>" method="get" accept-charset="utf-8" class="search-form">

	<input type="search" placeholder="<?php echo esc_attr($transera_search_placeholder); ?>" class="search-field" name="s" value="<?php echo get_search_query(); ?>" />

	<button type="submit" class="search-submit">
        <i class="icons fa fa-search"></i>
	</button>
</form>
