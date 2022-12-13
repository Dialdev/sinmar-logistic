<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;
  	echo wp_kses_post($title);?>

    <div class="widget-ctf-wrapper slz-widget-contact-form-<?php echo esc_attr( $unique_id ); ?>">
    <?php
  
    if(!empty($ctf)){
        echo do_shortcode('[contact-form-7 id="'.$ctf.'"]');
    }
    ?>
    </div>
    
<?php echo $after_widget;?>