<?php

$logo_class = 'float-none';
$menu_class = 'float-none';

$footer_class = slz_akg('footer-main/enable/styling', $options, '');
$footer_top_align = slz_akg('footer-top/enable/styling/text-align', $options, '');
?>
<footer>
    <div class="slz-wrapper-footer style-03 <?php echo esc_attr($footer_class);?> slz-widgets">
        <?php if ( slz_akg('footer-top/status', $options, '') == 'enable' ): ?>
        <div class="slz-footer-top">
            <div class="container">
                <div class="row">
                <?php
                    $footer_top_widget = slz_akg('footer-top/enable/top-widget', $options, '');
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
        
        <?php if( slz_akg('footer-main/footer-main-enable', $options, '') == 'enable' ) : ?> 
        <div class="slz-footer-main">
            <?php
                if ( is_active_sidebar( slz_akg('footer-main/enable/widget-01', $options, '') ) )
                    dynamic_sidebar( slz_akg('footer-main/enable/widget-01', $options, '') );
            ?>
        </div>
        <?php endif; ?>

        <?php if ( slz_akg('footer-bottom/status', $options, '') == 'enable' ): ?>
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