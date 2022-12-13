<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Recruitment();
$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;

if( ! $model->query->have_posts() ) {
    return;
}

$html_format = '<div class="slz-template-01">
                    <div class="slz-recent-post">
                        <div class="media">
                            <div class="media-left">
                                %1$s
                                %3$s
                            </div>
                            <div class="media-right">
                                %2$s 
                                <ul class="block-info">
                                    %4$s
                                    %5$s
                                    %8$s
                                </ul>
                                <div class="description">%6$s</div>
                                %7$s
                            </div>
                        </div>
                    </div>    
                </div>';

$html_render['image_format'] = '<a href="%2$s" class="wrapper-image">%1$s</a>';
$html_render['html_format'] = $html_format;

$uniq_id = $model->attributes['uniq_id'];
$html_options = $model->set_default_options($html_render);

list($filter_tab, $output_grid,$array_cat ) = $model->render_filter_tab($model->attributes, $html_render,$uniq_id );


?>
<div class="slz-shortcode slz-tab-vertical sc-recruitment-style-tab <?php echo esc_attr( $block_cls ); ?>" data-json="<?php echo esc_attr(json_encode($data));?>" data-options="<?php echo esc_attr(json_encode($html_options));?>">
    <div class="slz-cv-wrapper">
        <div class="cv-navigation tab-list-wrapper">
            <?php 
                printf('<div class="slz-isotope-nav">
                    <ul class=" tab-title tab-list">%1$s</ul></div>',
                        $filter_tab);
            ?>
        </div>  
        <div class="tab-content" data-cats='<?php echo json_encode($array_cat);?>'>
            <?php printf($output_grid);?>
        </div>
    </div>
</div>


<?php 
$custom_css = '';

if( !empty( $model->attributes['active_color'] ) ) {
    $custom_css .= sprintf('.%1$s .slz-cv-wrapper .tab_item { background-color: %2$s;}',
        $uniq_id, $model->attributes['active_color']
    );
}

if( !empty( $model->attributes['ribbon_color'] ) ) {
    $custom_css .= sprintf('.%1$s .slz-cv-wrapper .ribbon-box .text{ background-color: %2$s;}',
        $uniq_id, $model->attributes['ribbon_color']
    );
}

if( !empty( $model->attributes['button_color'] ) ) {
    $custom_css .= sprintf('.%1$s .slz-cv-wrapper .block-read-more { color: %2$s;}',
        $uniq_id, $model->attributes['button_color']
    );
}

if( !empty( $model->attributes['button_hv_color'] ) ) {
    $custom_css .= sprintf('.%1$s .slz-cv-wrapper .block-read-more:hover { color: %2$s;}',
        $uniq_id, $model->attributes['button_hv_color']
    );
}
if( $custom_css ) {
    do_action('slz_add_inline_style', $custom_css);
}

