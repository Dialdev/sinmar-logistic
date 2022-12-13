<?php

$btn_content = '';
if(!empty($data['btn_content'])){
    $btn_content = '<a class="read-more link" href="%9$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_render = array();
$html_format = '
		<div class="slz-block-team-07">
			%1$s
			<div class="team-content">
				<div class="team-content-wrapper">
					<div class="sub-content">
						%6$s
					</div>
					<div class="main-content">
						%2$s
						%3$s
						%4$s
						%5$s
						'. $btn_content .'
					</div>
				</div>
			</div>
		</div>
	';
$html_render['html_format']  = $html_format;
$html_render['thumb_class']  = 'img-responsive img-full';
$html_render['image_format'] =
    '<div class="team-image">%1$s
	</div>';
$html_render['position_format'] = '<div class="team-position">%1$s</div>';
$html_render['excerpt_format']  = '<p class="team-text mCustomScrollbar">%1$s</p>';
$html_render['social_format']   = '<a href="%2$s" class="social-item"><i class="icons %1$s fa fa-%1$s"></i></a>';
?>

<div class="layout-7  slz-shortcode sc_team_carousel <?php echo esc_attr( $data['block_cls'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
    <div class="team-center-slick slider"
        <?php echo '
                data-arrowshow="'.esc_attr( $data['slide_arrows'] ).'"
                data-dotshow="'. esc_attr( $data['slide_dots'] ) .'"
                data-autoplay="'. esc_attr( $data['slide_autoplay'] ) .'"
                data-infinite="'. esc_attr( $data['slide_infinite'] ) .'"
            ';?>
    >
    <?php echo  $data['model']->render_team_list_sc( $html_render );?>
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
		.%1$s .social-list a i {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_social'] ) );
}

if( !empty( $data['model']->attributes['color_social_hv'] ) ) {
    $css = '
		.%1$s .social-list a:hover i {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_social_hv'] ) );
}

if( !empty( $data['model']->attributes['color_position'] ) ) {
    $css = '
		.%1$s .main-content .team-position {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_position'] ) );
}
if( !empty( $data['model']->attributes['color_description'] ) ) {
    $css = '
		.%1$s .main-content .team-text {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_description'] ) );
}
if( !empty( $data['model']->attributes['color_slide_dots'] ) ) {
    $css = '
		.%1$s .slick-dots li.slick-active button:before {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_slide_dots'] ) );
}
if( !empty( $data['model']->attributes['color_slide_dots'] ) ) {
    $css = '
		.%1$s .slick-dots li.slick-active button:before {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_slide_dots'] ) );
}
if( !empty( $data['model']->attributes['color_slide_arrow'] ) ) {
    $css = '
		.%1$s .slick-arrow {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_slide_arrow'] ) );
}
if( !empty( $data['model']->attributes['color_slide_arrow_hv'] ) ) {
    $css = '
		.%1$s .slick-arrow:hover {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_slide_arrow_hv'] ) );
}

if( !empty( $data['model']->attributes['color_slide_arrow_bg'] ) ) {
    $css = '
		.%1$s .slick-arrow {
			background-color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_slide_arrow_bg'] ) );
}
if( !empty( $data['model']->attributes['color_slide_arrow_bg_hv'] ) ) {
    $css = '
		.%1$s .slick-arrow:hover {
			background-color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_slide_arrow_bg_hv'] ) );
}
if( !empty( $data['model']->attributes['color_info'] ) ) {
    $css = '
		.%1$s .slz-info-block a {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_info'] ) );
}
if( !empty( $data['model']->attributes['color_hv_info'] ) ) {
    $css = '
		.%1$s .slz-info-block a:hover {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $id ), esc_attr( $data['model']->attributes['color_hv_info'] ) );
}
if ( !empty( $custom_css ) ) {
    do_action('slz_add_inline_style', $custom_css);
}
