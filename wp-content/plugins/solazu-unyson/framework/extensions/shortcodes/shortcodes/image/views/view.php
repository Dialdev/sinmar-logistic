<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$image = $image_title = $image_alt = '';
$block_class = 'sc-image-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';

$html_image = '';
if( !empty( $data['img'] ) ){
    $image  = wp_get_attachment_url( $data['img'] );
    $image_title =get_the_title( $data['img'] );
    $image_alt = get_post_meta( $data['img'] , '_wp_attachment_image_alt', true );
    $format_tag_image = ' <img src="%1$s" title="%2$s" alt="%3$s" class="img-responsive">';
    if ( !empty($image) ) {
        $html_image = sprintf( $format_tag_image, esc_attr($image), esc_attr($image_title), esc_attr($image_alt) );
    }
}?>

<div  data-wow-delay="<?php echo esc_attr($data['delay_animation']);?>" class="slz-shortcode sc-image <?php echo esc_attr($block_cls); echo esc_attr($data['image_animation']);?> wow ">
    <?php echo $html_image; ?>
</div>

<?php
$custom_css = $css = '';
if ( !empty( $data['image_position'] ) ) {
    $css .= '
        .%1$s img {
            position: %2$s;
        }
    ';
    if(!empty($data['top'] )){
        $css .= '
            .%1$s img {
                top: %3$spx;
            }
        ';
    }
    if(!empty($data['right'] )){
        $css .= '
            .%1$s img {
                right: %4$spx;
            }
        ';
    }
     if(!empty($data['left'] )){
        $css .= '
            .%1$s img {
                left: %5$spx;
            }
        ';
    }
     if(!empty($data['bottom'] )){
        $css .= '
            .%1$s img {
                bottom: %6$spx;
            }
        ';
    }
    $custom_css .= 
    sprintf( $css, esc_attr( $block_class ), esc_attr( $data['image_position'] ), esc_attr( $data['top'] ), esc_attr( $data['right'] ), esc_attr( $data['left'] ), esc_attr( $data['bottom'] ));
}
if ( !empty( $custom_css ) ) {
    do_action('slz_add_inline_style', $custom_css);
}