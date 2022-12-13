<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Forbidden' );
}

$block_class = 'banner-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
$css = $custom_css = '';
$vc_link_arr = array();
$link_arr_default = array(
			'link'        => '',
			'url_title'   => '',
			'target'      => '',
		);

$class_style = '';
if ( $data['style'] == '2' ){
	$class_style = 'style-2';
}else {
	$class_style = '';
}
$img_url = '';
if( !empty( $data['ads_img'] ) ) {
	$img_url = wp_get_attachment_url( $data['ads_img'] );
}
$link_cover_arr = array();
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'banner' );
?>

<div class="slz-shortcode sc_banner <?php echo esc_attr( $block_cls ); ?>">
	<div class="slz-banner-01 <?php echo esc_attr( $class_style ); ?>">
		<?php 
		if( $data['number_btn'] == '' && !empty( $data['cover_link'] ) ) :
			$link_cover_arr = SLZ_Util::parse_vc_link( $data['cover_link'] );
			if( !empty( $link_cover_arr['url'] ) ) {
				echo '<a href="'. esc_url( $link_cover_arr['url'] ) .'" '. esc_attr( $link_cover_arr['other_atts'] ) .' class="link" ></a>';
			}else{
				echo '<a href="javascript:void()" '. esc_attr( $link_cover_arr['other_atts'] ) .' class="link"></a>';
			}
		?>
			
		<?php
		endif; 
		?>
		<?php
		if( !empty( $img_url ) ) :
		?>
			<img src="<?php echo esc_url( $img_url ); ?>" alt="" class="img-bg">
		<?php
		endif;
		?>
		<div class="content-wrapper">
			<?php
			if( !empty( $data['title'] ) ) :
			?>
				<h2 class="title"><?php echo esc_html( $data['title'] ); ?></h2>
			<?php
			endif;
			?>
			<?php
			if( isset( $data['content'] ) && !empty( $data['content'] ) ) :
			?>
				<div class="description"><?php echo wp_kses_post( $data['content'] ); ?></div>
			<?php
			endif;
			?>
			<?php
			if( $data['number_btn'] == '2' || $data['number_btn'] == '1' ) {
				$format = '<span class="btn-icon %1$s"></span>';
			?>
				<div class="slz-group-btn">
					<?php 
					for( $i = 1 ; $i <= $data['number_btn']; $i++ ){
					?>
						<?php
						$vc_link_arr = array();
						if( !empty( $data['button_text_'.$i] ) ) :
							if ( !empty( $data['btn_link_'.$i] ) ) {
								$vc_link_arr = SLZ_Util::get_link( $data['btn_link_'.$i] );
							}
							$vc_link_arr = array_merge( $link_arr_default, $vc_link_arr );
						?>
							<a href="<?php echo esc_url( $vc_link_arr['link'] ); ?>" <?php echo esc_attr( $vc_link_arr['target'] ); ?> <?php echo esc_attr( $vc_link_arr['url_title'] ); ?> class="slz-btn sc-banner-btn-<?php echo esc_attr( $i ); ?>">
								<?php
								$icon = '';
								if( isset($data['show_icon_'.$i]) && $data['show_icon_'.$i] != 'no' ) {
									if($i == 1){
										$icon = $shortcode->get_icon_library_views( $data, $format );
									}
									else{
										$icon = $shortcode->get_icon_library_views( $data, $format, '_2' );	
									}
								}
								if( $data['icon_align_'.$i] == 'left' ){
								?>
									<?php echo wp_kses_post( $icon ); ?>
									<span class="btn-text sc-banner-btn-text-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $data['button_text_'.$i] ); ?></span>
								<?php
								}elseif( $data['icon_align_'.$i] == 'right' ) {
								?>
									<span class="btn-text sc-banner-btn-text-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $data['button_text_'.$i] ); ?></span>
									<?php echo wp_kses_post( $icon ); ?>
								<?php
								}
								?>
							</a>
						<?php
						endif;
						?>
					<?php
						/* custom css - btn */
						if ( !empty( $data['btn_text_color_'.$i] ) ) {
							$css = '
								.%1$s a .sc-banner-btn-text-%2$s,.%1$s .sc-banner-btn-%2$s .btn-icon{
									color: %3$s;
								}
							';
							$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_text_color_'.$i] ) );
						}
						if ( !empty( $data['btn_text_hover_color_'.$i] ) ) {
							$css = '
								.%1$s a:hover .sc-banner-btn-text-%2$s,.%1$s .sc-banner-btn-%2$s .btn-icon{
									color: %3$s;
								}
							';
							$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_text_hover_color_'.$i] ) );
						}
						if ( !empty( $data['btn_background_color_'.$i] ) ) {
							$css = '
								.%1$s a.sc-banner-btn-%2$s{
									background-color: %3$s;
								}
							';
							$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_background_color_'.$i] ) );
						}
						if ( !empty( $data['btn_background_hover_color_'.$i] ) ) {
							$css = '
								.%1$s a.sc-banner-btn-%2$s:hover {
									background-color: %3$s;
								}
							';
							$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_background_hover_color_'.$i] ) );
						}
						if ( !empty( $data['btn_border_color_'.$i] ) ) {
							$css = '
								.%1$s a.sc-banner-btn-%2$s {
									border-color: %3$s;
								}
							';
							$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_border_color_'.$i] ) );
						}
						if ( !empty( $data['btn_border_hover_color_'.$i] ) ) {
							$css = '
								.%1$s a.sc-banner-btn-%2$s:hover {
									border-color: %3$s;
								}
							';
							$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_border_hover_color_'.$i] ) );
						}

					}// end for
					?>
				</div>
			<?php 
			}
			?>
		</div>
	</div>
</div>

<?php
if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s .title {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['title_color'] ) );
}
if( !empty($data['background_color'])) {
	$css = '
		.%1$s .slz-banner-01{
			background-color: %2$s !important;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['background_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}