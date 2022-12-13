<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
	return;
}

$uniq_id = 'sc-contact-'.SLZ_Com::make_id();

$block_cls = $uniq_id.' '.$data['extra_class']. ' ';

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'contact' );

$info_default  = $shortcode->get_config( 'default_info' );

$main_info_default =  $shortcode->get_config( 'default_main_info' );

$sub_info_default = $shortcode->get_config( 'default_sub_info' );

/*----------content html----------*/

$data['array_info']  =  vc_param_group_parse_atts( $data['array_info'] );

$column = $data['column'];

$class_col = '';
if(  $column == 1 ){
    $class_col = 'slz-column-1';
}
else if(  $column == 2 ){
    $class_col = 'slz-column-2';
}
else if(  $column == 3 ){
    $class_col = 'slz-column-3';
}
else if(  $column == 4 ){
    $class_col = 'slz-column-4';
}

$col_info = array_chunk( $data['array_info'], $column );
?>
<div class="slz-shortcode sc_contact <?php echo esc_attr( $block_cls );?>">
	<?php foreach ( $col_info as  $block_info ): ?>
    <div class="slz-list-block slz-list-contact-01 slz-list-column <?php echo esc_attr( $class_col ); ?>">
        <?php foreach ( $block_info as $info ): ?>
            <?php $info = array_merge($info_default, $info); ?>
            <div class="item">
                <div class="slz-contact-01">
                    <div class="contact-title main-item">
                        <?php
                        if ( ! empty( $info['array_info_item'] ) ) {
                            $info['array_info_item'] = vc_param_group_parse_atts( $info['array_info_item'] );
                            foreach ($info['array_info_item'] as $item) {
                                $item = array_merge($main_info_default, $item);
                                if( ! empty( $item['title'] ) ) {
                        ?>
                                <div class="contact-item">
                                    <i class="slz-icon <?php echo esc_attr( $shortcode->get_icon_library_views( $item, '%1$s' ) ); ?>"></i>
                                    <div class="text"><?php echo wp_kses_post( nl2br( $item['title'] ) ); ?></div>
                                </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="contact-content sub-item">
                        <?php
                        if ( ! empty( $info['array_sub_info_item'] ) ) {
                            $info['array_sub_info_item'] = vc_param_group_parse_atts( $info['array_sub_info_item'] );
                            foreach ( $info['array_sub_info_item'] as $item ) {
                                $item = array_merge($sub_info_default, $item);
                                if( ! empty( $item['sub_info'] ) ) {
                        ?>
                                <div class="contact-item">
                                    <i class="slz-icon <?php echo esc_attr( $shortcode->get_icon_library_views( $item, '%1$s' ) ); ?>"></i>
                                    <div class="text"><?php echo wp_kses_post( nl2br( $item['sub_info'] ) ); ?></div>
                                </div>
                        <?php
                                }
                            }
                        }
                        if ( ! empty( $info['description'] ) ) {
                        ?>
                            <div class="blur"><?php echo wp_kses_post( nl2br( $info['description'] ) ); ?></div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>


<?php

/*------Custom Css--------*/

$css =  $custom_css = '';

if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s .contact-title {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['title_color'] ) );
}

if ( !empty( $data['info_color'] ) ) {
	$css = '
		.%1$s .contact-content {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['info_color'] ) );
}

if ( !empty( $data['main_bg_color'] ) ) {
    $css = '
        .%1$s .contact-title {
            background-color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['main_bg_color'] ) );
}

if ( !empty( $data['main_icon_color'] ) ) {
    $css = '
        .%1$s .contact-title .slz-icon {
            color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['main_icon_color'] ) );
}

if ( !empty( $data['sub_icon_color'] ) ) {
    $css = '
        .%1$s .contact-content .slz-icon {
            color: %2$s;
        }
    ';
    $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['sub_icon_color'] ) );
}

if ( !empty( $data['border_color'] ) ) {
	$css = '
		.%1$s .slz-list-contact-01 .item + .item:before {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['border_color'] ) );
}

if ( !empty( $data['bg_color'] ) ) {
	$css = '
		.%1$s .slz-list-contact-01 {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['bg_color'] ) );
}

if ( !empty( $data['des_color'] ) ) {
    $css = '
		.%1$s .slz-list-contact-01 .blur{
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['des_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action( 'slz_add_inline_style', $custom_css );
}
?>