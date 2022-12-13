<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('counterv2');
if( !empty($data['counter_items']) ) {
	foreach( $data['counter_items'] as $counter_group ) {
		if( $counter_group ){
			$icon_html = $show_line = $suffix = $title = '';
			$counter_group = array_merge( $data['counter_group'], $counter_group );
			if( empty($counter_group['title']) && empty($counter_group['number'] ) ){
				continue;
			}
			// icon or image
			if ( !empty( $counter_group['icon_type'] ) && $counter_group['icon_type'] == '02' ) {
				if ( !empty( $counter_group['img_up'] ) ) {
					$img_url = wp_get_attachment_url( absint( $counter_group['img_up'] ) );
					if( $img_url ) {
						$icon_html = '<div class="img-cell"><img src="'.esc_url($img_url).'" alt="" class="slz-icon-img"></div>';
					}
				}
			}else{
				$format = '<div class="icon-cell">
							<div class="wrapper-icon"><i class="slz-icon %1$s"></i></div>
						   </div>';
				$icon_html = $shortcode->get_icon_library_views( $counter_group, $format );
			}
			//check number
			if( !is_numeric($counter_group['number']) ){
				$counter_group['number'] = 0;
			}
			// animation
			if(!empty($data['animation'])){
				$number_start= 0;
			}else{
				$number_start = $counter_group['number'];
			}
			// show line
			if(!empty($data['show_line'])){
				$show_line = '<div class="line"></div>';
			}
			if(!empty($counter_group['suffix'])){
				$suffix = '<span class="suffix">'.esc_attr($counter_group['suffix']).'</span>';
			}
			if( !empty($counter_group['title']) ){
				$title = '<div class="title">'.esc_html($counter_group['title']).'</div>';
			}
			$number_html = '
				<div class="content-cell">
					<div class="content-number">
						<div data-from="'.esc_attr($number_start).'" data-to="'. esc_attr($counter_group['number']).'" data-speed="3000" class="number ">
							'.$counter_group['number'].'
						</div>'.
						$suffix.'
					</div>'.
					$show_line.
					$title.'
				</div>';
			echo '
				<div class="item">
				<div class="slz-counter-item-1 layout-2 '. esc_attr( $data['alignment'] ) .'">'.
					$number_html . 
					$icon_html .'
				</div></div>';
		}
	}
	// custom css
	$css = $custom_css = '';
	if ( !empty( $data['title_color'] ) ) {
		$css = '.%1$s .slz-counter-item-1 .content-cell .title{color: %2$s;}';
		$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['title_color']) );
	}
	if ( !empty( $data['number_color'] ) ) {
		$css = '.%1$s .slz-counter-item-1 .content-cell .number{color: %2$s;}';
		$css .= '.%1$s .slz-counter-item-1 .content-cell .suffix{color: %2$s;}';
		$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['number_color']) );
	}
	if ( !empty( $data['icon_color'] ) ) {
		$css = '.%1$s  .slz-counter-item-1 .wrapper-icon .slz-icon{color: %2$s;}';
		$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['icon_color']) );
	}
    if ( !empty( $data['icon_bg_color'] ) ) {
        $css = '.%1$s .slz-counter-item-1 .wrapper-icon {background-color: %2$s;}';
        $custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['icon_bg_color']) );
    }
	if ( !empty($data['show_line']) && !empty( $data['line_color'] ) ) {
		$css = '.%1$s  .slz-counter-item-1 .line{background-color: %2$s;}';
		$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['line_color']) );
	}
	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}
}