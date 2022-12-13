<?php 

class SLZ_Footer_Footer_01 extends SLZ_Footer {

	public function render( $echo = true)
	{

		$this->enqueue_static();

		$options = slz_get_db_settings_option('slz-footer-style-group/footer_01', array());

		$palette_color = SLZ_Com::get_palette_color();

		if ( !empty ( $options ) ) {

			$custom_css = '';

            //footer
            $styling = slz_akg('styling', $options, '');
            if( !empty( $styling ) ) {
                $bg_color = SLZ_Com::get_palette_selected_color( $styling['bg-color'] );
                if ( !empty ( $bg_color ) ) {
                    $custom_css .= '.slz-footer-top, .slz-footer-main, .slz-footer-bottom 
                                    { background-color:' . esc_attr( $bg_color ). '; }';
                }
                if ( !empty ( $styling['bg-image'] ) ) {
                    if ( !empty ( $styling['bg-image']['url'] ) ) {
                        $custom_css .= '.slz-footer-top, .slz-footer-main, .slz-footer-bottom                   
                                        { background-image: url(' . esc_attr( $styling['bg-image']['url'] ) . ') ; }';
                    }
                }
                if ( !empty( $styling['bg-attachment'] ) ) {
                    $custom_css .= '.slz-footer-top, .slz-footer-main, .slz-footer-bottom  
                                    { background-attachment:' . esc_attr( $styling['bg-attachment'] ) . '; }';
                }
                if( !empty( $styling['bg-size'] ) ) {
                    $custom_css .= '.slz-footer-top, .slz-footer-main, .slz-footer-bottom 
                                    { background-size:' .  esc_attr( $styling['bg-size'] ). '; }';
                }
                if( !empty( $styling['bg-position'] ) ) {
                    $custom_css .= '.slz-footer-top, .slz-footer-main, .slz-footer-bottom 
                                    { background-position:' . esc_attr( $styling['bg-position'] ). '; }';
                }

                $text_color = SLZ_Com::get_palette_selected_color( $styling['text-color'] );
                if ( !empty ( $text_color ) ) {
                    $custom_css .= '.slz-wrapper-footer { color: ' . esc_attr( $text_color ) . ' }';
                    $custom_css .= '.slz-wrapper-footer .navbar-footer a { color: ' . esc_attr( $text_color ) . ' !important }';
                }
            }

			//footer main
			$footer_bg = slz_akg('footer-main/enable/custom-style/ft-background/data/css/background-image', $options, '');
			
			if( !empty( $footer_bg ) ){
				$custom_css .= '.slz-footer-main { background-image:' .$footer_bg. '; }';
			}
			if( slz_akg('footer-main/enable/custom-style/ft-bg-color', $options, '') ){
				$custom_css .= '.slz-footer-main { background-color:' .slz_akg('footer-main/enable/custom-style/ft-bg-color', $options, ''). '; }';
			}
			if( slz_akg('footer-main/enable/custom-style/ft-bg-attachment', $options, '')  ){
				$custom_css .= '.slz-footer-main { background-attachment:' .
				esc_attr(slz_akg('footer-main/enable/custom-style/ft-bg-attachment', $options, '') ). '; }';
			}

			if( slz_akg('footer-main/enable/custom-style/ft-bg-size', $options, '')  ){
				$custom_css .= '.slz-footer-main { background-size:' .
				esc_attr(slz_akg('footer-main/enable/custom-style/ft-bg-size', $options, '') ). '; }';
			}

			if( slz_akg('footer-main/enable/custom-style/ft-bg-position', $options, '')  ){
				$custom_css .= '.slz-footer-main { background-position:' .
				esc_attr(slz_akg('footer-main/enable/custom-style/ft-bg-position', $options, '') ). '; }';
			}
			
			// footer top
			$styling = slz_akg('footer-top/enable/styling', $options, '');
			if ( !empty ( $styling ) ) {

				if ( !empty ( $styling['bg-image'] ) ){

					if ( !empty ( $styling['bg-image']['url'] ) ) {

						$custom_css .= '.slz-footer-top { background-image: url(' . esc_attr( $styling['bg-image']['url'] ) . ') ; }';

					}

				}

				$bg_color = SLZ_Com::get_palette_selected_color( $styling['bg-color'] );

				if ( !empty ( $bg_color ) ) {

					$custom_css .= '.slz-footer-top { background-color: ' . esc_attr( $bg_color ) . ' !important; }';

				}
				if(  !empty($styling['bg-attachment'])  ){
					$custom_css .= '.slz-footer-top { background-attachment:' .
						esc_attr($styling['bg-attachment'] ). '; }';
				}

				if( !empty($styling['bg-size']) ){
					$custom_css .= '.slz-footer-top { background-size:' .
					esc_attr( $styling['bg-size'] ). '; }';
				}

				if( !empty($styling['bg-position']) ){
					$custom_css .= '.slz-footer-top { background-position:' .
					esc_attr( $styling['bg-position'] ). '; }';
				}

				if ( !empty ( $styling['border-color'] ) ){
					$custom_css .= '.slz-footer-top{ border-bottom:1px solid '.esc_attr($styling['border-color']).'}';
				}

				$text_color = SLZ_Com::get_palette_selected_color( $styling['text-color'] );

				if ( !empty ( $text_color ) ) {

					$custom_css .= '.slz-footer-top { color: ' . esc_attr( $text_color ) . ' }';

					$custom_css .= '.slz-footer-top .navbar-footer a { color: ' . esc_attr( $text_color ) . ' !important }';

				}

			}

			// footer bottom

			$styling = slz_akg('footer-bottom/enable/styling', $options, '');

			if ( !empty ( $styling ) ) {

				if ( !empty ( $styling['bg-image'] ) ){

					if ( !empty ( $styling['bg-image']['url'] ) ) {

						$custom_css .= '.slz-footer-bottom { background-image: url(' . esc_attr( $styling['bg-image']['url'] ) . ') }';

					}
				}
				if ( !empty ( $styling['border-color'] ) ){
					$custom_css .= '.slz-footer-bottom .container:before{ background-color: '.esc_attr($styling['border-color']).'}';
				}
				if(  !empty($styling['bg-attachment'])  ){
					$custom_css .= '.slz-footer-bottom { background-attachment:' .
						esc_attr($styling['bg-attachment'] ). '; }';
				}

				if( !empty($styling['bg-size']) ){
					$custom_css .= '.slz-footer-bottom { background-size:' .
					esc_attr( $styling['bg-size'] ). '; }';
				}

				if( !empty($styling['bg-position']) ){
					$custom_css .= '.slz-footer-bottom { background-position:' .
					esc_attr( $styling['bg-position'] ). '; }';
				}

				$bg_color = SLZ_Com::get_palette_selected_color( $styling['bg-color'] );

				if ( !empty ( $bg_color ) ) {

					$custom_css .= '.slz-footer-bottom { background-color: ' . esc_attr( $bg_color ) . ' !important; }';

				}

				$text_color = SLZ_Com::get_palette_selected_color( $styling['text-color'] );

				if ( !empty ( $text_color ) ) {

					$custom_css .= '.slz-footer-bottom { color: ' . esc_attr( $text_color ) . ' }';

					$custom_css .= '.slz-footer-bottom .slz-name { color: ' . esc_attr( $text_color ) . ' !important }';

				}

				$social_color = SLZ_Com::get_palette_selected_color( $styling['social-color'] );

				if ( !empty ( $social_color ) ) {

					$custom_css .= '.slz-footer-bottom .social i { color: ' . esc_attr( $social_color ) . ' }';

				}

				$social_hover_color = SLZ_Com::get_palette_selected_color( $styling['social-hover-color'] );

				if ( !empty ( $social_hover_color ) ) {

					$custom_css .= '.slz-footer-bottom .social i:hover { color: ' . esc_attr( $social_hover_color ) . ' }';

				}

				if ( !empty ( $styling['social-icon-size'] ) && is_numeric( $styling['social-icon-size'] ) ) {

					$custom_css .= '.slz-footer-bottom .social i { font-size: ' . esc_attr( $styling['social-icon-size'] ) . 'px }';

				}

			}
			
			$area_arr = array('left','center','right');
            foreach ($area_arr as $key) {

            	$bg_color = SLZ_Com::get_palette_selected_color( slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/bg-color', $options, '') );
            	$bg_hv_color = SLZ_Com::get_palette_selected_color( slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/bg-hv-color', $options, '') );
            	$text_color = SLZ_Com::get_palette_selected_color( slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/text-color', $options, '') );
            	
            	$text_hv_color = SLZ_Com::get_palette_selected_color( slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/text-hv-color', $options, '') );
            	$bd_color = SLZ_Com::get_palette_selected_color( slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/border-color', $options, '') );
            	$bd_hv_color = SLZ_Com::get_palette_selected_color( slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/border-hv-color', $options, '') );

            	if( !empty( $bg_color ) ){
            		$custom_css .= '.slz-footer-bottom .item-'.$key.' .slz-btn  { background-color: ' . esc_attr( $bg_color ) . ' }';
            	}
            	if( !empty( $bg_hv_color ) ){
            		$custom_css .= '.slz-footer-bottom .item-'.$key.' .slz-btn:hover  { background-color: ' . esc_attr( $bg_hv_color ) . ' }';
            	}
            	if( !empty( $text_color ) ){
            		$custom_css .= '.slz-footer-bottom .item-'.$key.' .slz-btn  { color: ' . esc_attr( $text_color ) . ' }';
            	}
            	if( !empty( $text_hv_color ) ){
            		$custom_css .= '.slz-footer-bottom .item-'.$key.' .slz-btn:hover  { color: ' . esc_attr( $text_hv_color ) . ' }';
            	}
            	if( !empty( $bd_color ) ){
            		$custom_css .= '.slz-footer-bottom .item-'.$key.' .slz-btn  { border-color: ' . esc_attr( $bd_color ) . ' }';
            	}
            	if( !empty( $bd_hv_color ) ){
            		$custom_css .= '.slz-footer-bottom .item-'.$key.' .slz-btn:hover { border-color: ' . esc_attr( $bd_hv_color ) . ' }';
            	}
            }

             // do action
			do_action('slz_add_inline_style', $custom_css);

			$results = slz_render_view( $this->locate_path('/views/view.php'), compact( 'options' ) );

			if( ! $echo ) {
				return $results;
			}
			echo $results;
		}

		return;
	}
}
