<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Forbidden' );
}

$block_class = 'newsletter-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
$out = '';
$form = '';
$css = $custom_css = '';
$class_style = 'slz-shortcode-send-mail';
$email_placeholder = '';
$name_placeholder = '';
$text_button = '';
if ( $data['style'] == '2' ) {
	$class_style = 'slz-shortcode-send-mail2';
}else{
	$class_style = 'slz-shortcode-send-mail';
}
if( !empty( $data['input_email_placeholder'] ) ){
	$email_placeholder = $data['input_email_placeholder'];
}
if( !empty( $data['button_text'] ) ) {
	$text_button = $data['button_text'];
}
if( !empty( $data['show_input_name'] ) && $data['show_input_name'] == 'yes' ) {
	$block_cls .= ' has-name';
}

$out .= '<div class="slz-shortcode sc_newsletter '. esc_attr( $block_cls ) .'">';
	$out .= '<div class="'. esc_attr( $class_style ) .'">';
	if( !empty( $data['title'] ) ) {
		$out .= '<div class="slz-title-shortcode">'. esc_html( $data['title'] ) .'</div>';
	}
		$out .= '<div class="sc-newsletter-content">';
		if( !empty( $data['description'] ) ) {
			$out .= '<div class="sc-newslettter-des">'. wp_kses_post( nl2br( $data['description'] ) ) .'</div>';
		}
			$form = NewsletterSubscription::instance()->get_form_javascript();
			$form .= '<form action="' . esc_url(home_url('/')) . '?na=s" onsubmit="return newsletter_check(this)" method="post">';
				$form .= '<input type="hidden" name="nr" value="widget"/>';
				if( $data['style'] == '2' ) {
					$form .= '<div class="slz-input-group">';
					if( $data['show_input_name'] == 'yes' ) {
						if( !empty( $data['input_name_placeholder'] ) ) {
							$name_placeholder = $data['input_name_placeholder'];
						}
						$form .= '<input class="form-control sc-newsletter-input" type="text" required name="nn" placeholder="'.esc_attr( $name_placeholder ).'" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/>';
					}
						$form .= '<input class="form-control sc-newsletter-input" type="email" required name="ne" placeholder="'.esc_attr( $email_placeholder ).'" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/>';
						$form .= '<span class="input-group-button">';
							$form .= '
								<button type="submit" class="btn sc-newsletter-btn">
									<span class="btn-text">'. esc_html( $text_button ) .'</span>
									<span class="btn-icon fa fa-arrow-right"></span>
								</button>';
						$form .= '</span>';
					$form .= '</div>';
				}else{
					if( $data['show_input_name'] == 'yes' ) {
						if( !empty( $data['input_name_placeholder'] ) ) {
							$name_placeholder = $data['input_name_placeholder'];
						}
						$form .= '<input class="form-control sc-newsletter-input" type="text" required name="nn" placeholder="'.esc_attr( $name_placeholder ).'" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/>';
					}
					$form .= '<input class="form-control sc-newsletter-input" type="email" required name="ne" placeholder="'.esc_attr( $email_placeholder ).'" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/>';
					$form .= '<button type="submit" class="slz-btn sc-newsletter-btn">'.esc_html( $text_button ).'</button>';
				}
				
			$form .= '</form>';
			$out .= $form;
		$out .= '</div>';
	$out .= '</div>';
$out .= '</div>';
echo ( $out );

 /*
  * CUSTOM CSS
  */
if( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s .sc-newslettter-des {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['title_color'] ) );
}
if( !empty( $data['description_color'] ) ) {
	$css = '
		.%1$s .sc-newslettter-title {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['description_color'] ) );
}
if( !empty( $data['color_input'] ) ) {
	$css = '
		.%1$s .sc-newsletter-input.form-control {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_input'] ) );
}
if( !empty( $data['color_button'] ) ){
	$css = '
		.%1$s .sc-newsletter-btn {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_button'] ) );
}
if( !empty( $data['color_button_hv'] ) ){
	$css = '
		.%1$s .sc-newsletter-btn:hover {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_button_hv'] ) );
}
if( !empty( $data['color_button_bg'] ) ){
	$css = '
		.%1$s .sc-newsletter-btn {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_button_bg'] ) );
}
if( !empty( $data['color_button_bg_hv'] ) ){
	$css = '
		.%1$s .sc-newsletter-btn:hover {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_button_bg_hv'] ) );
}
if( !empty( $data['color_button_border'] ) ){
	$css = '
		.%1$s .sc-newsletter-btn {
			border-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_button_border'] ) );
}
if( !empty( $data['color_button_border_hv'] ) ){
	$css = '
		.%1$s .sc-newsletter-btn:hover {
			border-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['color_button_border_hv'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}