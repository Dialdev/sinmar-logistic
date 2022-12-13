<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }
$model = new SLZ_Event();
$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$has_image = 'has-image';
if( $data['image_display'] != 'show' ) {
    $has_image = '';
}
$model->attributes['has_image'] = $has_image;
$model->attributes['show_searchbar'] = $data['show_searchbar'];
?>
<div class="slz-shortcode sc_event_block <?php echo esc_attr( $block_cls ); ?>">
    <?php if( !empty( $data['title'] ) ): ?>
        <div class="slz-title-shortcode"><?php echo esc_html( $data['title'] ); ?></div>
    <?php endif; ?>
    <?php

    switch ( $model->attributes['layout'] ) {
        case 'layout-1':
            echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('model'));
            break;
        case 'layout-2':
            echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('model'));
            break;

        case 'layout-3':
            echo slz_render_view( $instance->locate_path('/views/layout-3.php'), compact('model'));
            break;

        default:
            echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('model'));
            break;
    }

    $custom_css = '
        .slz-shortcode.sc_event_block  {
            z-index: inherit;
        }
    ';
    if ( !empty( $custom_css ) ) {
        do_action('slz_add_inline_style', $custom_css);
    }
    ?>
</div>