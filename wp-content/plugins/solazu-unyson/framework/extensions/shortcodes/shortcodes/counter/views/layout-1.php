<?php
$icon_html = $subfix = $number_start = $show_line ='' ;

//check number
    if(!is_numeric($data['number'])){
        $data['number'] = 0;
    }
// animation
    if(!empty($data['animation'])){
        $number_start= 0; 
    }else{
        $number_start = $data['number'];
    }

// show line
    if(!empty($data['show_line'])){
        $show_line = '<div class="line"></div>';
    }

// get icon
    if(is_numeric($data['icon'])){
        if(!empty($data['icon'])){
        	$data['icon'] = esc_url( wp_get_attachment_url($data['icon']));
        	$icon_html = '<div class="img-cell"><img src="'.esc_url($data['icon']).'" alt="" class="slz-icon-img"></div>';
        }
    }else{
        $icon = $data['icon_library'];
        if ( !empty( $data['icon_'.$icon] ) ) {
            SLZ_Util::slz_icon_fonts_enqueue($data['icon_library'] );
            $icon_html = 
            '<div class="icon-cell">
              <div class="wrapper-icon"><i class="slz-icon fa '.esc_attr($data['icon_'.$icon]).'"></i></div>
            </div>';
        }
        
    }

// custom css
    $css = $custom_css = '';
    if ( !empty( $data['title_color'] ) ) {
        $css = '.%1$s .slz-counter-item-1 .content-cell .title {color: %2$s;}';
        $custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['title_color']) );
    }
    if ( !empty( $data['number_color'] ) ) {
        $css = '.%1$s .slz-counter-item-1 .content-cell .number{color: %2$s;}';
        $css .= '.%1$s .slz-counter-item-1 .content-cell .suffix{color: %2$s;}';
        $custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['number_color']) );
    }
    if ( !empty( $data['icon_color'] ) ) {
        $css = '.%1$s  .slz-counter-item-1 .wrapper-icon .slz-icon{color: %2$s;}';
        $custom_css .= sprintf( $css, esc_attr( $data['block_class'] ),esc_attr($data['icon_color']) );
    }
    if ( !empty( $custom_css ) ) {
        do_action('slz_add_inline_style', $custom_css);
    }

?>
<div class="slz-counter-item-1 <?php echo esc_attr( $data['alignment'] ); ?> ">
    <?php echo wp_kses_post($icon_html);?>
    <div class="content-cell">
    	<div class="content-number">
	        <div data-from="<?php echo esc_attr($number_start);?>" data-to="<?php echo esc_attr($data['number']);?>" data-speed="3000" class="number ">
	        	<?php echo esc_attr($data['number']);?>
	        </div>
	        <?php if(!empty($data['suffix'])){
	            echo '<span class="suffix">'.esc_attr($data['suffix']).'</span>';
	        }?>
        </div>
        <?php 
            echo wp_kses_post($show_line);
        ?>
        <div class="title"><?php echo esc_html($data['title']);?></div>
    </div>
</div>