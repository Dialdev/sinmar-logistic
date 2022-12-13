<?php
$html_render1 = array();
$html_render2 = array();
$html_format1 = '';
$html_format2 = '';

$html_format1 = '
		<div class="item">
			<div class="team-img">%1$s</div>
		</div>
	';

$html_render1['html_format'] = $html_format1;
$html_render1['thumb_class'] = ' ';

$btn_content = '';
if(!empty($data['btn_content'])){
	$btn_content = '<a class="read-more link" href="%11$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_format2 = '
	<div class="item">
		<div class="team-info">
			<div class="main-info">
				%2$s
				%3$s
			</div>
			%5$s
			%10$s
			%6$s
			'. $btn_content .'
		</div>
	</div>
';
$html_render2['html_format']= $html_format2;
$html_render2['title_format'] = '<div class="name">%1$s</div>';
?>

<div class="layout-6 slz-shortcode sc_team_list <?php echo esc_attr( $data['block_cls'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<div class="slz-carousel-wrapper-02">
		<div class="carousel-overflow">
			<div class="slz-carousel-img-wrapper">
				<div class="slz-carousel-img">
					<?php $data['model']->render_team_carousel_sc( $html_render1 ); ?>
				</div>
			</div>
			<div class="slz-carousel-info-wrapper">
				<div class="slz-carousel-info">
					<?php $data['model']->render_team_carousel_sc( $html_render2 ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
/* CUSTOM CSS */
$css = '';
$custom_css = '';
$id = $data['model']->attributes['uniq_id'];
if( !empty( $data['model']->attributes['color_title'] ) ) {
	$css = '
		.%1$s .team-info .name {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_title'] ) );
}

if( !empty( $data['model']->attributes['color_title_hv'] ) ) {
	$css = '
		.%1$s .team-info .name:hover {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_title_hv'] ) );
}

if( !empty( $data['model']->attributes['color_info'] ) ) {
	$css = '
		.%1$s .team-info .info-title {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_info'] ) );
}

if( !empty( $data['model']->attributes['color_hv_info'] ) ) {
	$css = '
		.%1$s .team-info .info-title:hover {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_hv_info'] ) );
}

if( !empty( $data['model']->attributes['color_description'] ) ) {
	$css = '
		.%1$s .team-info .info-description {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_description'] ) );
}

if( !empty( $data['model']->attributes['color_social'] ) ) {
	$css = '
		.%1$s .team-info .info-social a i {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_social'] ) );
}

if( !empty( $data['model']->attributes['color_social_hv'] ) ) {
	$css = '
		.%1$s .team-info .info-social a:hover i {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_social_hv'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}
