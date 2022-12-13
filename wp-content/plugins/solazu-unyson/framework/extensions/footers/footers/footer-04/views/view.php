<?php

$logo_class = 'float-none';
$menu_class = 'float-none';
$page_options = slz_get_db_post_option( get_the_ID(), 'page-footer-style' );

if(slz_akg('footer-style', $page_options, '') != 'default'){

    $footer_top = slz_akg('footer_04/footer-top/status', $page_options, '');
    $footer_top_widget = slz_akg('footer_04/footer-top/enable/widget-area-more', $page_options, '');
    $footer_main = slz_akg('footer_04/footer-main/status', $page_options, '');
    $footer_widget = slz_akg('footer_04/footer-main/enable/widget-area-more', $page_options, '');
    $footer_bottom = slz_akg('footer_04/footer-bottom/status', $page_options, '');

}else{

    $footer_top = slz_akg('footer-top/status', $options, '');
    $footer_top_widget = slz_akg('footer-top/enable/top-widget', $options, '');
    $footer_main = slz_akg('footer-main/footer-main-enable', $options, '');
    $footer_widget = slz_akg('footer-main/enable/widget-area-more', $options, '');
    $footer_bottom = slz_akg('footer-bottom/status', $options, '');

}
$footer_class = slz_akg('footer-main/enable/styling', $options, '');
$footer_top_align = slz_akg('footer-top/enable/styling/text-align', $options, '');
?>
<footer>
    <div class="slz-wrapper-footer style-04 <?php echo esc_attr($footer_class);?> slz-widgets">
        <?php if ( $footer_top == 'enable' ): ?>
        <div class="slz-footer-top">
            <div class="container">
                <div class="row">
                <?php
                 
                    if(!empty($footer_top_widget)){
                        $arr_column = array(
                            '1' => 'col-sm-12',
                            '2' => 'col-sm-6',
                            '3' => 'col-md-4 col-sm-6'
                        );
                        $cls_column = $arr_column[count($footer_top_widget)];
                        $ft_wrap_cls = slz_ext( 'footers' )->get_config('footer_top_wrapper_cls');
                        foreach($footer_top_widget as $k=>$v){
                            echo '<div class="'.esc_attr($cls_column).' '.$footer_top_align.'">';
                            if( $ft_wrap_cls ) {
                                echo '<div class="'.esc_attr($ft_wrap_cls ).'">';
                            }
                            if ( is_active_sidebar( $v ) ){
                                dynamic_sidebar( $v );
                            }
                            if( $ft_wrap_cls ) {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }
                ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if( $footer_main == 'enable' ) : ?> 
        <div class="slz-footer-main">
            <div class="container">
                <div class="row">
                    <?php
                       
                        if(!empty($footer_widget)){
                            $arr_column = array(
                                '1' => 'col-sm-12',
                                '2' => 'col-sm-6',
                                '3' => 'col-md-4 col-sm-6',
                                '4' => 'col-md-3',
                                '5' => 'col-md-5',
                                '6' => 'col-md-2'
                            );
                            if(count($footer_widget) <= 6){
                                $cls_column = $arr_column[count($footer_widget)];
                            }else{
                                $cls_column = 'col-sm-12';
                            }
                            foreach($footer_widget as $k=>$v){
                                echo '<div class="'.esc_attr($cls_column).'">';
                                if ( is_active_sidebar( $v ) ){
                                    dynamic_sidebar( $v );
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php endif; ?>

        <?php if ( $footer_bottom == 'enable' ): ?>
        <div class="slz-footer-bottom">
            <div class="container">
                <!-- left area -->
                <?php 
                $area_arr = array('left','center','right');
                foreach ($area_arr as $key) {
                    if( slz_akg('footer-bottom/enable/area-'.$key, $options, '') == 'show'){?>
                        <div class="item-wrapper item-<?php echo esc_attr( $key );?>">
                              <!--Text-->
                            <?php if(slz_akg('footer-bottom/enable/copyright-'.$key, $options, '')):?>
                                <div class="item">
                                    <div class="slz-name"><?php echo nl2br(wp_kses_post( slz_akg('footer-bottom/enable/copyright-'.$key, $options, '') ) ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                             <!--Social-->
                            <?php if ( slz_akg('footer-bottom/enable/social-'.$key, $options, '') == 'show' ) : ?>
                                <div class="item">
                                    <?php if ( function_exists('slz_get_socials')) {
                                        echo slz_get_socials('social');
                                    } ?>
                                </div>
                            <?php endif; ?>

                             <!--navigation-->
                           <?php if ( slz_akg('footer-bottom/enable/navigation-'.$key, $options, '') == 'show' ) : ?>
                                <div class="item">
                                    <?php slz_theme_bottom_menu(); ?>
                                </div>
                            <?php endif; ?>

                             <!--Image--> 
                            <?php if ( slz_akg('footer-bottom/enable/image-'.$key.'/data/icon', $options, '') ) : ?>
                                <div class="item">
                                    <img src="<?php echo esc_url(slz_akg('footer-bottom/enable/image-'.$key.'/data/icon', $options, '') );?> " title="logo" alt="" class="img-responsive">
                                </div>
                            <?php endif; ?>

                           <!--Button-->
                            <?php
                            $btn_link = slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/btn-link', $options, '');
                            $btn_text = slz_akg('footer-bottom/enable/btn-'.$key.'/show/custom/btn-text', $options, '');
                            if ( slz_akg('footer-bottom/enable/btn-'.$key.'/btn-enable', $options, '') == 'show' && !empty( $btn_link ) ) : ?>
                                <div class="item">
                                   <a href="<?php echo esc_url( $btn_link );?>" class="slz-btn "><span class="btn-text"><?php echo esc_attr( $btn_text );?></span></a>
                                </div>
                            <?php endif; ?>
                             <!--End Option-->
                        </div><?php
                    }
                }?>
                <!-- <div class="clearfix"></div> -->
            </div>
        </div>
        <?php endif; ?>
    </div>
</footer>