<?php 

class SLZ_Header_Header_02 extends SLZ_Header {

	public function render( $echo = true )
	{

		$this->enqueue_static();

		$options = slz_get_db_settings_option('slz-header-style-group/header_02', '');

		$palette_color = SLZ_Com::get_palette_color();

		if ( !empty ( $options ) ) {

			$topbar = $options['enable-header-top-bar'];

			$bg_color = $custom_css = $search_style = '';

			$header_style = $options['header-styling'];

			$bg_color = SLZ_Com::get_palette_selected_color( $header_style['header-bg-color'] );

			if ( !empty ( $bg_color ) ) {

				$custom_css .= '.slz-header-wrapper { background-color: ' . esc_attr( $bg_color ) . ' }';

				$custom_css .= '.slz-header-topbar { background-color: transparent }';

				$custom_css .= '.slz-header-main { background-color: transparent }';

			}

			if ( !empty ( $header_style['header-bg-image'] ) ){

				if ( !empty ( $header_style['header-bg-image']['url'] ) ) {

					$custom_css .= '.slz-header-wrapper { background-image: url(' . esc_attr( $header_style['header-bg-image']['url'] ) . ') }';

					$custom_css .= '.slz-header-topbar { background-color: transparent }';

					$custom_css .= '.slz-header-main { background-color: transparent }';

				}

			}
			if ( !empty ( $header_style['header-bg-attachment'] ) ){

				$custom_css .= '.slz-header-wrapper {background-attachment: ' . esc_attr( $header_style['header-bg-attachment']) . '}';
			}
			if ( !empty ( $header_style['header-bg-size'] ) ){

				$custom_css .= '.slz-header-wrapper {background-size: ' . esc_attr( $header_style['header-bg-size']) . '}';
			}
			if ( !empty ( $header_style['header-bg-position'] ) ){

				$custom_css .= '.slz-header-wrapper {background-position: ' . esc_attr( $header_style['header-bg-position']) . '}';
			}

			$text_color = SLZ_Com::get_palette_selected_color( $header_style['header-text-color'] );

			if ( !empty ( $text_color ) ) {

				$custom_css .= '.slz-header-wrapper { color: ' . esc_attr( $text_color ) . ' }';

				$custom_css .= '.slz-topbar-list .icons { color: ' . esc_attr( $text_color ) . ' }';

				$custom_css .= '.slz-header-topbar .social a { color: ' . esc_attr( $text_color ) . ' }';

			}

			// sub header

			$subheader_styling = slz_akg( 'enable-subheader/show/subheader-styling', $options, '' );
			$subheader_color = '';
			if(isset($subheader_styling['menu-item-color'])){
				$subheader_color = SLZ_Com::get_palette_selected_color( $subheader_styling['menu-item-color'] );
			}
			if ( !empty ( $subheader_color ) ){
				$custom_css .= '.slz-sub-header a:before ,.slz-sub-header a:hover,a.slz-menu-icon span{ color: '.esc_attr($subheader_color).'!important;}';
				$custom_css .= 'a.slz-menu-icon span{ background-color: '.esc_attr($subheader_color).'!important;}';
			}


			//topbar
			if ( !empty ( $topbar ) && $topbar['selected-value'] == 'yes' ){

				$topbar_style = $topbar['yes']['styling'];

				if ( !empty ( $topbar_style ) ){

					$bg_color = SLZ_Com::get_palette_selected_color( $topbar_style['bg-color'] );

					if ( !empty ( $bg_color ) )
						$custom_css .= '.slz-header-topbar { background-color: ' . esc_attr( $bg_color ) . ' !important}';

					if ( !empty ( $topbar_style['bg-image'] ) ){

						if ( !empty ( $topbar_style['bg-image']['url'] ) ) {

							$custom_css .= '.slz-header-topbar { background-image: url(' . esc_attr( $topbar_style['bg-image']['url'] ) . ') }';

						}

					}

					if ( !empty ( $topbar_style['bg-attachment'] ) ){

						$custom_css .= '.slz-header-topbar  {background-attachment: ' . esc_attr( $topbar_style['bg-attachment']) . '}';
					}

					if ( !empty ( $topbar_style['bg-size'] ) ){

						$custom_css .= '.slz-header-topbar {background-size: ' . esc_attr( $topbar_style['bg-size']) . '}';
					}
					
					if ( !empty ( $topbar_style['bg-position'] ) ){

						$custom_css .= '.slz-header-topbar {background-position: ' . esc_attr( $topbar_style['bg-position']) . '}';
					}


					$border_color = SLZ_Com::get_palette_selected_color( $topbar_style['border-color'] );

					if ( !empty ( $border_color ) ) {

						$custom_css .= '.slz-header-topbar { border-bottom-color: ' . esc_attr( $border_color ) . ' !important}';

					}

					$text_color = SLZ_Com::get_palette_selected_color( $topbar_style['text-color'] );

					if ( !empty ( $text_color ) ) {

						$custom_css .= '.slz-topbar-list .social .text { color: ' . esc_attr( $text_color ) . ' }';

						$custom_css .= '.slz-topbar-list .icons { color: ' . esc_attr( $text_color ) . ' }';

					}

					$social_color = SLZ_Com::get_palette_selected_color( $topbar_style['social-color'] );

					if ( !empty ( $social_color ) ) {

						$custom_css .= '.slz-topbar-list .social a i { color: ' . esc_attr( $social_color ) . ' }';

					}

					$social_hover_color = SLZ_Com::get_palette_selected_color( $topbar_style['social-hover-color'] );

					if ( !empty ( $social_hover_color ) ) {

						$custom_css .= '.slz-topbar-list .social i:hover { color: ' . esc_attr( $social_hover_color ) . ' }';

					}

					if ( !empty ( $topbar_style['social-icon-size'] ) && is_numeric( $topbar_style['social-icon-size'] ) ) {

						$custom_css .= '.slz-topbar-list .social i { font-size: ' . esc_attr( $topbar_style['social-icon-size'] ) . 'px }';

					}

				}

			}

			if( !empty ( $options['enable-search'] ) && $options['enable-search'] == 'yes' ){

				$search_style = $options['search-group-styling'];

				if ( !empty ( $search_style ) ) {

					$bg_color = SLZ_Com::get_palette_selected_color( $search_style['bg-color'] );

					if ( !empty ( $bg_color ) ){

						$custom_css .= 'header .nav-search { background-color: ' . esc_attr( $bg_color ) . ' }';

						$custom_css .= 'header .nav-search:before { color: ' . esc_attr( $bg_color ) . ' }';

					}

					$text_color = SLZ_Com::get_palette_selected_color( $search_style['text-color'] );

					if ( !empty ( $bg_color ) ){

						$custom_css .= '.nav-search form input[type=\'text\'], .nav-search form input[type="search"]{ color: ' . esc_attr( $text_color ) . ' }';

					}

				}

			}

			// menu

			$menu_styling = $options['menu-styling'];
			
			$menu_color = SLZ_Com::get_palette_selected_color( $menu_styling['menu-item-color'] );
			$menu_hv_color = SLZ_Com::get_palette_selected_color( $menu_styling['menu-item-active-color'] );
			$menu_border_color = SLZ_Com::get_palette_selected_color( $menu_styling['menu-border-color'] );
			$menu_align =  $menu_styling['dropdown-align'];

			if ( !empty ( $menu_color ) ){
				$custom_css .= '.slz-menu-wrapper > li.menu-item > a,.slz-menu-wrapper .sub-menu > li > a ,.slz-menu-wrapper .mega-menu-row .mega-menu-col > a,.slz-menu-wrapper .mega-menu .link{ color: ' . esc_attr( $menu_color ) . ' }';

			}
			
			if ( !empty ( $menu_hv_color  ) ){
				$custom_css .= '.slz-menu-wrapper > li > a:hover, .slz-menu-wrapper .sub-menu > li:hover > a ,.slz-menu-wrapper .mega-menu .link:hover,.slz-menu-wrapper .current-menu-item > a{ color: ' . esc_attr( $menu_hv_color ) . ' }';

			}
			
			if ( !empty ( $menu_border_color ) ){
				$custom_css .= '.slz-menu-wrapper .sub-menu,.mega-menu{ border-color: ' . esc_attr( $menu_border_color ) . ' }';

			}
			
			if ( $menu_align == 'left' ){
				$custom_css .= '.slz-header-main .slz-main-menu .sub-menu .sub-menu{right: 100%;left: auto;}';
			}


			do_action('slz_add_inline_style', $custom_css);

			$results = slz_render_view( $this->locate_path('/views/view.php'), compact( 'topbar', 'options', 'search_style' ) );
			if( ! $echo ) {
				return $results;
			}
			echo $results;
		}

		return;
	}
}
