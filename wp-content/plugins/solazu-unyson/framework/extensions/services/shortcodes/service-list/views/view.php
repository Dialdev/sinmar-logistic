<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Service();
$model->init( $data );
$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;

// 1$ - icon, 2$ - title, 3$ - description, 4$ - button
//show icon, image, feature-image
$class_show = '';
if (  $data['show_icon'] == 'icon' ){
    $class_show = 'slz-class-icon';
}
else if (  $data['show_icon'] == 'image' ){
    $class_show = 'slz-class-image';
}else if ( $data['show_icon'] == 'feature-image'){
    $class_show = 'slz-class-feature-image';
}

$html_format = '
    <div class="item">
        <div class="icon-box-item slz-icon-box-1 '. esc_attr( $class_show) .' '.$model->attributes['style'] .' '. $data['align'].' ">
            <div class="icon-cell">
                %1$s
            </div>
            <div class="content-cell">
                <div class="wrapper-info">
                    %2$s
                    %3$s
                    %4$s
                </div>
            </div>
        </div>
    </div>
';
if( $model->attributes['layout'] == 'layout-2' ){
    $html_format = '
        <div class="item">
            <div class="slz-icon-box-2 icon-box-item">
                <div class="icon-cell">
                    %1$s
                    %2$s
                </div>
                <div class="content-cell">
                    <div class="wrapper-info">
                        %3$s
                        %4$s
                    </div>
                </div>
            </div>
        </div>
    ';
}

$html_render =  array( 'html_format' => $html_format);

//check show number
if(!empty($model->attributes['show_number'])){
    $number_class = 'has_number';
}else{
    $number_class = '';
}
// content html

if( !empty($data['is_carousel']) && $data['is_carousel'] == 'yes' ) {

    printf('<div class="slz-shortcode sc-service-list slz-carousel-wrapper %1$s %2$s">
                <div class="carousel-overflow">', esc_attr( $block_cls ), esc_attr($number_class));
            printf('<div class="slz-carousel"
                    data-slidestoshow="%1$s"
                    data-arrow="%2$s"
                    data-dots="%3$s"
                    data-autoplay="%4$s"
                    data-infinite="%5$s"
                    data-speed="%6$s">',
                    esc_attr( $data['column'] ),
                    esc_attr( $data['show_arrows'] ),
                    esc_attr( $data['show_dots'] ),
                    esc_attr( $data['slide_autoplay'] ),
                    esc_attr( $data['slide_infinite'] ),
                    esc_attr( absint($data['slide_speed']) )
                );
                        $model->render_list( $html_render );
            print(' </div>');
    print('     </div>
            </div>');
}
else{ 
    printf( '<div class="slz-shortcode sc-service-list slz-list-block %1$s %2$s %3$s">',
                esc_attr( $block_cls ),
                esc_attr($model->attributes['responsive-class']),
                esc_attr($number_class)
            );
             $model->render_list( $html_render );
    print('</div>');
}