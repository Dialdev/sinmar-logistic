<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'sc-contact-form-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
if(!empty($data['box_shadow'])){
    $block_cls = $block_class.' '.$data['extra_class']. ' ctf-box-shadow ';
}
?>

<div class="slz-shortcode sc-contact-form <?php echo esc_attr($block_cls)?>">
    <?php 
        if(!empty($data['ctf'])){
            echo do_shortcode('[contact-form-7 id="'.$data['ctf'].'"]');
        }
    ?>
   
</div>

<?php

$custom_css = $css = '';
if ( !empty( $data['padding_top'] ) ) {
    $css = '
        .%1$s .wpcf7{
            padding-top: %2$spx !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['padding_top'] ) );
}
if ( !empty( $data['padding_bottom'] ) ) {
    $css = '
        .%1$s .wpcf7{
            padding-bottom: %2$spx !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['padding_bottom'] ) );
}
if ( !empty( $data['padding_left'] ) ) {
    $css = '
        .%1$s .wpcf7{
            padding-left: %2$spx !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['padding_left'] ) );
}
if ( !empty( $data['padding_right'] ) ) {
    $css = '
        .%1$s .wpcf7{
            padding-right: %2$spx !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['padding_right'] ) );
}
if ( !empty( $data['bg_image'] ) ) {
    $url = wp_get_attachment_url($data['bg_image']);
    $css = '
        .%1$s {
            background-image: url(%2$s)!important;
            background-size: cover !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_url( $url ) );
}
if ( !empty( $data['bg_color'] ) ) {
    $css = '
        .%1$s {
            background-color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['bg_color'] ) );
}
if ( !empty( $data['btn_bg_color'] ) ) {
    $css = '
        .%1$s .wpcf7-submit{
            background-color: %2$s !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['btn_bg_color'] ) );
}
if ( !empty( $data['btn_bg_color_hover'] ) ) {
    $css = '
        .%1$s .wpcf7-submit:hover{
            background-color: %2$s !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['btn_bg_color_hover'] ) );
}
if ( !empty( $data['btn_color'] ) ) {
    $css = '
        .%1$s .wpcf7-submit{
            color: %2$s !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['btn_color'] ) );
}
if ( !empty( $data['btn_color_hover'] ) ) {
    $css = '
        .%1$s .wpcf7-submit:hover{
            color: %2$s !important;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['btn_color_hover'] ) );
}
if ( !empty( $custom_css ) ) {
    do_action('slz_add_inline_style', $custom_css);
}
