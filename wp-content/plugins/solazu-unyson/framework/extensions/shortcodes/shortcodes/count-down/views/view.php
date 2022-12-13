<?php
$uniq_id = 'slz-count-down-'.SLZ_Com::make_id();
$custom_css = '';
?>
<div class="sc-count-down <?php echo esc_attr($uniq_id).' '.esc_attr($data['extra_class'])?>">
    <div class="coming-soon slz-count-down" data-expire="<?php echo esc_attr( esc_attr( $data['date'] ) ); ?>">
        <div class="main-count-wrapper">
            <div class="circle-line"></div>
            <div class="main-count">
                <div class="time days flip">
                    <span class="count curr top">00</span>
                </div>
                <div class="count-height"></div>
                <div class="stat-label"><?php echo esc_html__( 'days', 'slz' );?></div>
            </div>
        </div>
        <div class="main-count-wrapper">
            <div class="circle-line"></div>
            <div class="main-count">
                <div class="time hours flip">
                    <span class="count curr top">00</span>
                </div>
                <div class="count-height"></div>
                <div class="stat-label"><?php echo esc_html__( 'hours', 'slz' )?></div>
            </div>
        </div>
        <div class="main-count-wrapper">
            <div class="circle-line"></div>
            <div class="main-count">
                <div class="time minutes flip">
                    <span class="count curr top">00</span>
                </div>
                <div class="count-height"></div>
                <div class="stat-label"><?php echo esc_html__( 'mins', 'slz' );?></div>
            </div>
        </div>
        <div class="main-count-wrapper">
            <div class="circle-line"></div>
            <div class="main-count">
                <div class="time seconds flip">
                    <span class="count curr top">00</span>
                </div>
                <div class="count-height"></div>
                <div class="stat-label"><?php echo esc_html__( 'secs', 'slz' );?></div>
            </div>
        </div>
    </div>
</div>
<?php

if( !empty($data['number_color']) ){
    $custom_css .= sprintf('.%1$s .coming-soon .main-count-wrapper .time{color:%2$s;} ', $uniq_id, esc_attr( $data['number_color'] ));
}
if( !empty($data['title_color']) ){
    $custom_css .= sprintf('.%1$s .coming-soon .main-count-wrapper .main-count .stat-label{color:%2$s;} ', $uniq_id, esc_attr( $data['title_color'] ));
}
if( !empty($data['bg_color']) ){
    $custom_css .= sprintf('.%1$s .coming-soon .main-count-wrapper{background-color:%2$s;} ', $uniq_id, esc_attr( $data['bg_color'] ));
}

if ( !empty( $custom_css ) ) {
    do_action('slz_add_inline_style', $custom_css);
}
?>

