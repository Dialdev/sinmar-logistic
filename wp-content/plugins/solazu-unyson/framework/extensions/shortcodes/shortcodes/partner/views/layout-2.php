<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); } ?>
<?php 
$slick_json = SLZ_Custom_Posttype_Model::get_atts_option_slick_slide($data);
$custom_css = '';
if( !empty($data['color_slide_arrow']) ) {
    $custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow { color: %2$s;}',
                        $data['uniq_id'], $data['color_slide_arrow']
                    );
}
if( !empty($data['color_slide_arrow_hv']) ) {
    $custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow:hover { color: %2$s;}',
                        $data['uniq_id'], $data['color_slide_arrow_hv']
                    );
}
if( !empty($data['color_slide_arrow_bg']) ) {
    $custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow { background-color: %2$s;}',
                        $data['uniq_id'], $data['color_slide_arrow_bg']
                    );
}
if( !empty($data['color_slide_arrow_bg_hv']) ) {
    $custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow:hover { background-color: %2$s;}',
                        $data['uniq_id'], $data['color_slide_arrow_bg_hv']
                    );
}
if( !empty($data['color_slide_dots']) ) {
    $custom_css .= sprintf('.%1$s .slick-dots li button:before { color: %2$s; opacity: 0.8; }',
                        $data['uniq_id'], $data['color_slide_dots']
                    );
}
if( !empty($data['color_slide_dots_at']) ) {
    $custom_css .= sprintf('.%1$s .slick-dots li.slick-active button:before, .%1$s .slick-dots li button:hover:before { color: %2$s;}',
                        $data['uniq_id'], $data['color_slide_dots_at']
                    );
}

if ( !empty( $custom_css ) ) {
    do_action('slz_add_inline_style', $custom_css);
}
?>

<div class="slz-carousel-wrapper slz-partner-carousel">
    <div class="carousel-overflow">
        <div class="slz-partner-slide-slick slz-block-slide-slick" data-slick-json="<?php echo esc_attr($slick_json)?>">
            <?php SLZ_Shortcode_Partner::render_partner_item_sc($data); ?>
        </div>
    </div>
</div>