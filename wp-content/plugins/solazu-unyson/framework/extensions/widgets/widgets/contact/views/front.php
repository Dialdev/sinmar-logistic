<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;?>
    <div class="slz-widget-contact-info">
        <?php echo wp_kses_post($title); ?>
        <div class="widget-content">
            <?php 
            if(!empty($address)){
                echo '<div class="item"><i class="icons fa fa-map-marker"></i>';
                echo '<div class="contact-info">';
                if( !empty( $address_title ) ) {
                	echo '<div class="contact-title">'. esc_html( $address_title ) .'</div>';
                } 
                echo '<div class="text">'.wp_kses_post(nl2br($address)).'</div>';
                echo '</div>';
                echo '</div>';
            }
            if(!empty($phone)){
                echo '<div class="item"><i class="icons fa fa-phone"></i>';
                echo '<div class="contact-info">';
                if( !empty( $phone_title ) ) {
                	echo '<div class="contact-title">'. esc_html( $phone_title ) .'</div>';
                } 
                echo '<div class="text">'.wp_kses_post(nl2br($phone)).'</div>';
                echo '</div>';
                echo '</div>';
            }
            if(!empty($mail)){
                echo '<div class="item"><i class="icons fa fa-envelope"></i>';
                echo '<div class="contact-info">';
                if( !empty( $mail_title ) ) {
                	echo '<div class="contact-title">'. esc_html( $mail_title ) .'</div>';
                } 
                $arr_email  = preg_split ( '/[\s,;\/]+/', $mail );
                foreach($arr_email as $value){?>
                    <div class="text">
                        <a href="mailto:<?php echo esc_attr($value)?>"><?php echo nl2br( esc_textarea( $value ) ); ?>
                        </a>
                    </div>
                <?php
                }
                echo '</div>';
                echo '</div>';
            }
            if(!empty($website)){
                echo '<div class="item"><i class="icons fa fa-globe"></i>';
                echo '<div class="contact-info">';
                if( !empty( $website_title ) ) {
                    echo '<div class="contact-title">'. esc_html( $website_title ) .'</div>';
                } 
                echo '<div class="text"><a href="'.esc_url($website).'">'.esc_attr($website).'</a></div>';
                echo '</div>';
                echo '</div>';
            }?>
        </div>
    </div>
<?php echo $after_widget;?>