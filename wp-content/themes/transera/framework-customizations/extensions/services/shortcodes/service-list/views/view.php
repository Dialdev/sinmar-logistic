<?php if ( ! defined( 'SLZ' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Service();
$model->init( $data );
$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$class_addition = '';
$read_more_btn = '';

if( ( $model->attributes['style'] == 'style-3' || $model->attributes['style'] == 'style-4' ) && $model->attributes['btn_more'] == 'no' ) {
    $read_more_btn = 'no-readmore-btn';
}

// 1$ - icon, 2$ - title, 3$ - description, 4$ - button
$html_format = '

    <div class="item">
        <div class="slz-icon-box-1 '. esc_attr( $model->attributes['style'] ) .' '. esc_attr( $data['align'] ) .'">
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
    if( $model->attributes['show_icon'] == 'icon' ) {
        $class_addition = 'icon-option';
    }

    $html_format = '
        <div class="item">
            <div class="slz-icon-box-2 theme-'. esc_attr( $model->attributes['style'] ) .' '. esc_attr( $read_more_btn ) .'">
                <div class="icon-cell '. esc_attr( $class_addition ) .'">
                    %1$s
                </div>';
            if( $model->attributes['style'] == 'style-3' || $model->attributes['style'] == 'style-4' ) {
                $html_format .= '<div class="service-content-wrap">';
            }
    $html_format .= '
                <div class="content-cell">
                    %2$s
                    <div class="wrapper-info">
                        %3$s
                        %4$s
                    </div>
                </div>';
            if( $model->attributes['style'] == 'style-3' || $model->attributes['style'] == 'style-4' ) {
                $html_format .= '</div>';
            }
    $html_format .= '
            </div>
        </div>
    ';
}

$block_cls .= ' seperator-'.$model->attributes['style'];

$html_render =  array( 'html_format' => $html_format );
if( !empty($data['is_carousel']) && $data['is_carousel'] == 'yes' ) {
    printf('<div class="slz-shortcode sc-service-list slz-carousel-wrapper %1$s">
                <div class="carousel-overflow">
                    <div data-slidestoshow="%2$s" class="slz-carousel">', esc_attr( $block_cls ), esc_attr( $data['column'] ) );
                        $model->render_list( $html_render );
    print('         </div>
                </div>
            </div>');
}
else{
    printf( '<div class="slz-shortcode sc-service-list slz-list-block %1$s %2$s">',
                esc_attr( $block_cls ),
                esc_attr($model->attributes['responsive-class'])
            );
             $model->render_list( $html_render );
    print('</div>');
}